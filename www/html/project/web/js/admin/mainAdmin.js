mainAdmin = null;
$(function () {
    mainAdmin = new MainAdmin();
});

/**
 * Classe per la gestione della homepage
 */
var MainAdmin = function () {
    this.speakEnabled = 1;
    this.initListeners();
    
        if( typeof SpeechSynthesisUtterance == 'function' ) {
        var msg = new SpeechSynthesisUtterance();
        var voices = window.speechSynthesis.getVoices();
        
        msg.voice = voices[21]; // Note: some voices don't support altering params
        msg.voiceURI = 'native';
        msg.volume = 0.5; // 0 to 1
        msg.rate = 10; // 0.1 to 10
        msg.pitch = 0; //0 to 2
        msg.text = 'buongiorno a tutti totti a smesso di giocare a pallone';
        msg.lang = 'it-IT';                             
    }

};

/**
 * Apre la lista dei prodotti del modello corrente di idealo
 * @returns {undefined}
 */
MainAdmin.prototype.openModelProductsIde = function ( sender ) {   
    var urlId = $( '#form_nameUrlProductIde' ).val();
    
    
    if( urlId == '' ) {
        alert( 'INSERISCI LA URL SPECIFICA PER IL RECUPERO DEI PRODOTTI CON SPESE DI SPEDIZIONE IDEALO');
        $( '[data-overlaybutton]' ).hide();
        return false;
    }
    
    $( '[data-overlaybutton]' ).show();
    
    var modelId    = $( sender ).attr( 'data-buttonModelProductsIde' );
    
    var request = $.ajax ({
        url: "/admin/getModelProductsFromIde?urlIde="+encodeURIComponent(urlId)+"&modelId="+modelId,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {
        $( '[data-overlaybutton]').html( resp );
        
        $('[data-listmodelproductside] textarea').each( function() {
            var textareatext = $( this ).html().replace(/(\&shy;|­|&#173;)/gi, "");
            $( this ).html( textareatext );
        });                
    });
};



/*metodo che apre e chiude la login  */
MainAdmin.prototype.rediscliFlushDb = function(sender) {
    var request = $.ajax({
        url: '/admin/redisflushall',
        type: "GET",
        async: true,
        dataType: "html"
    });
    request.done(function (resp) {
        var parameters = new Array();   
        parameters['type'] = resp != 1 ? 'error' : 'success';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp != 1 ? 'Errore in cancellazione redis' : 'Cancellazione redis avvenuta con successo';
        classNotyfy.openNotyfy( parameters );      
        
    });
};

MainAdmin.prototype.parseHtmlEntities = function ( str ) {
    return str.replace(/&#([0-9]{1,3});/gi, function(match, numStr) {
        var num = parseInt(numStr, 10);
        return String.fromCharCode(num);
    });
};

MainAdmin.prototype.speakSite = function ( speak ) {
    if( this.speakEnabled != 1 && this.speakEnabled != null )
        return false;
    
    if( typeof speak == 'undefined' )
        return false;
    
    speechSynthesis.cancel();
    
    speak = speak.toLowerCase();
    
    speak = this.parseHtmlEntities(  speak.replace( /<.*?>/g, '' ));
    speak = speak
            .replace( '&agrave', 'à' )
            .replace( '&eacute', 'é' )
            .replace( '&egrave', 'è' )
            .replace( '&igrave', 'ì' )
            .replace( '&ograve', 'ò' )
            .replace( '&ugrave', 'ù' )
            .replace( 'clicca qui per continuare a leggere', '' )
            .replace( '-', ',' )
            .replace( '/', ',' )
            .replace( '?', '?,' )
            .replace(/&nbsp;/gi,'')
            .replace(/\./g,',')
            .replace(/\//g,',')
            .replace(/\-/g,',');

    if( typeof SpeechSynthesisUtterance == 'function' ) {
       
        setTimeout( function() {
             var msg = new SpeechSynthesisUtterance();
            var voices = window.speechSynthesis.getVoices();
            msg.voice =  voices.filter(function(voice) { return voice.name == 'Luca'; })[0];

//            msg.voice = voices[21]; // Note: some voices don't support altering params
            msg.voiceURI = 'native';
            msg.volume = 0.5; // 0 to 1
            msg.rate = 10; // 0.1 to 10
            msg.pitch = 0; //0 to 2
            msg.text = speak;
            msg.lang = 'it-IT';       
            speechSynthesis.speak(msg);
        },500 );
    }
}
    
/**
 * Metodo che avvia gli ascoltatori
 */
MainAdmin.prototype.initListeners = function () {
    var that = this;
    
    $('body').on('click', '[data-BtnProduct]', function() {
        that.createProduct( this );
    });
    
    $('body').on('click', '[data-rediscliFlushDb]', function() {
        that.rediscliFlushDb();
    });
    
    $('body').on( 'click', '.copyClipboard', function () {        
        that.copyToClipboard(this);
    });    
    
    $('body').on( 'click', '[data-linkModelTp]', function () {       
        $( this ).html( 'Attendi check...');
        setTimeout ( function() {
            that.checkModelinfo(this);
        }.bind(this), 500 );
        
    });    
    
    //Recupero prodotti presenti per il modello su idealo
    $( '[data-buttonModelProductsIde]' ).click(function() {
        that.openModelProductsIde( this );
//        that.blockScroll();
    });
        
    $('body').on( 'click', '[data-closeOverlay]', function () {        
        $( '[data-overlaybutton]' ).hide();
    });    
    
    //Gestione selezione prodotti da importare di idealo
    $('body').on( 'click', '[data-listModelProductsIde] tr[data-item]', function () {        
        $( this ).toggleClass( 'selected' );
    });    
    
    //Gestione selezione prodotti da importare di idealo
    $('body').on( 'click', '[data-sendinsertmodelproductside] ', function () {                
        $( '[data-wait]' ).html('Attendi');
        setTimeout(function() {
            that.insertProductToModelIde();
        },1000 );        
    });    
    
    $('body').on( 'click', '[data-listModelProductsIde] input[type="checkbox"]', function () {        
        $('body').on( 'click', '[data-listModelProductsIde] tr[data-item]').each(function() {
            $( this ).remove( 'selected' );
        });
        
        var checkbox = this;
        $('[data-listModelProductsIde] tr[data-item]').each(function() {
            if( $( checkbox ).is(":checked") ) 
                $( this ).addClass( 'selected' );
            else
                $( this ).removeClass( 'selected' );
        });
        
    });    
    
    $('body').on( 'click', '.footable', function () {        
        $('.footable-row-detail .copyClipboard').unbind();
        $('.footable-row-detail .copyClipboard').click(function () {
//            that.copyToClipboard(this);
        });
    });    
    
    $('.fa-reorder').click(function () {
        that.toggleMenu();
    });
    $('.fa-table').click(function () {
        that.iconeMenu();
    });
    $('body').on('click', '#toTop, .toTop', function () {
        // Al click sull'icona, torno ad inizio pagina con movenza fluida        
            $("html,body").animate({scrollTop: 0}, 500, function () {});        
//        that.scroolTop();
    });
    this.hoverForm();
    
//    $("div[data-submit='1']").click(function() {
//        $("div[data-divForm='1']").find('form').submit();
//    });
    
//    $("div[data-reset='1']").click(function() {
//        $("div[data-divForm='1']").find('form')[0].reset();
//        mainAdmin.speakSite( 'Form resettato con successo?' );
//    });
    
    
    //Sposta il campo in cima al form
    var cloneTecnical = $( '#form_tecnicalTemplate' ).closest('.form-group'); 
    $( cloneTecnical ).insertAfter( $( '#form_nameUrlIde' ).closest('.form-group') );
    
    $('#form_save' ).closest('.form-group').remove();

    $('body').on('click', '[data-schedaPagomeno]', function ( e ) {
        var params = { 
            type: 'custom', 
            title: '',
            callbackModals: '\
            <div class="row row-icons widget_PleaseWait">\
                <div class="innerLR">\
                    <h5 class="innerAll margin-none border-bottom bg-primary">CREAZIONE SCHEDA TECNICA IN CORSO</h5>\
                    <div class="floatL col-md-2 mr10">\
                        <i class="fa fa-gears"></i>\
                    </div>\
                    <div class="floatL col-md-9" style="margin-top:10px;text-align:center;">\
                        <h4>Attendi il completamento, questo box si chiudera in automatico una volta terminato!</h4>\
                        <img src="/images/loading1.gif" width="100px" />\
                    </div>\
                </div>\
            </div>'
        };        
        
        if( $('#form_tecnicalTemplate').val() == '' ) {
            alert('SCEGLI TEMPLATE SCHEDA TECNICA CRETINO!!!');
            return false;
        } else {       
            
            
            
            classModals.openModals( params );
            var copyThis = this;
            setTimeout( function() {
                that.getInfosModel( copyThis, 'schedaPagomeno', e );
            }, 1000 );    
        }
    });
    $('body').on('click', '[data-bulletsPagomeno]', function ( e ) {
        that.getInfosModel( this, 'bulletsPagomeno', e);
    });
    $('body').on('click', '[data-bulletsIdealo]', function ( e ) {
        that.getInfosModel( this, 'bulletsIdealo', e);
    });
    $('body').on('click', '[data-amazonAsinReview]', function ( e ) {
        that.getInfosModel( this, 'amazonAsinReview', e);
    });
    
    $('body').on('click', '[data-VideoYouTube]', function () {
        that.getVideoYouTube( this, 'VideoYouTube');
    });
    $('#getImagesFromGoogle').click(function () {
        $('[data-insertimagesselectedgoogle]').show();
        if( $( '#form_imagesGallery' ).val() != '' ) {
            that.modifyImagesGalleryModel( this );
        } else {
            that.getImagesGoogle( this, 'imagesFromGoogle');
        }
    });
    
    $('body').on('click', '[data-sendModifyImagesModel]', function () {
        that.sendModifyImagesModel( this );
    });
    
    $('body').on('click', '[data-imageUrl]', function () {
        $( this ).toggleClass('active');
    });
    $('body').on('click', '[data-insertImagesSelectedGoogle]', function () {
        that.insertImagesGoogle( this );
    });
    
    $('body').on('click', '[data-changeTableModels]', function () {
        that.changeTableModels( this );
    });
    
    $('body').on('click', '[data-youtubeId]', function () {
        $( '#form_video' ).val( $( this ).attr( 'data-youtubeId' ) );
        $( ".overlayModelResponse" ).hide();        
    });
    
    
    $('body').on('click', '.closeOverlayModelResponse', function () {
        $( ".overlayModelResponse" ).hide();        
    });


    $( '[data-speak]').click(function() {
        that.setSpeak( this );
    });
    this.initSpeak();
    
};

/**
 * Funzione che avvia la chiamata per l'inserimento dei prodotti di idealo sul modello
 * @param {type} sender
 * @returns {undefined}
 */
MainAdmin.prototype.insertProductToModelIde = function ( sender ) {
    var products = new Array();            
    
    var modelId = $( '[data-buttonModelProductsIde]').attr('data-buttonModelProductsIde');
    
    $('[data-listModelProductsIde] tr[data-item].selected').each(function() {
        var obj = new Object();
                
        obj['img'] = $( this ).find( '[data-img]' ).attr( 'src' );
        obj['title'] = $( this ).find( '[data-title]' ).val().replace( '€&nbsp;', '' );
        obj['link'] = $( this ).find( '[data-link]' ).html().replace( '€&nbsp;', '' );
        obj['price'] = $( this ).find( '[data-price]' ).html().replace( '€&nbsp;', '' );
        obj['productId'] = $( this ).find( '[data-productId]' ).html();
        obj['shopName'] = $( this ).find( '[data-shop]' ).html();
        products.push( obj );
    });   
    
    var request = $.ajax ({
        url: "/admin/insertProductToModelIde?modelId="+modelId,
        type: "POST",
        async: false,
        dataType: "json",
        data: { productsIde : JSON.stringify(products )}
        
    });
    request.done( function( resp ) {       
        alert( 'Prodotti inseriti: '+resp.success+' - Prodotti non inseriti:'+ resp.error);
        $( '[data-wait]' ).html('');
    });
};

/**
 * Cambia la tabella di attartenenza dei modelli
 * @param {type} sender
 * @returns {undefined}
 */
MainAdmin.prototype.changeTableModels = function ( sender ) {
    var id = $( sender ).attr( 'data-changeTableModels' );
    var newTable = $( sender ).attr( 'data-newTable' );
   
    
    var request = $.ajax ({
        url: "/admin/changeTableModels/"+newTable+"?modelId="+id,
        type: "GET",
        async: false,
        dataType: "json"        
    });
    request.done( function( resp ) {       
        if( resp == 1 ) {
            $( sender ).closest( 'tr' ).remove();
        }
    });
};

MainAdmin.prototype.insertImagesGoogle = function ( sender ) {
    var items = new Array();
    $( '.overlayModelResponse .item.active' ).each( function() {
        items.push( $( this ).attr( 'data-imageurl' ) );
    });
    
    var modelName = $( sender ).attr( 'data-modelName' ); 
    var modelId = $( sender ).attr( 'data-modelId' );         
    var remoteUrls = $( '#remoteUrls' ).val();
    
    if( items.length == 0 && remoteUrls == '' ) {
        return false;
    }
    
    var params = { 
        type: 'custom', 
        title: '',
        callbackModals: '\
        <div class="row row-icons widget_PleaseWait">\
            <div class="innerLR">\
                <h5 class="innerAll margin-none border-bottom bg-primary">CARICAMENTO IMMAGINI IN CORSO</h5>\
                <div class="floatL col-md-2 mr10">\
                    <i class="fa fa-gears"></i>\
                </div>\
                <div class="floatL col-md-9" style="margin-top:10px;text-align:center;">\
                    <h4>Attendi il completamento, questo box si chiudera in automatico una volta terminato!</h4>\
                    <img src="/images/loading1.gif" width="100px" />\
                </div>\
            </div>\
        </div>'
    };
    classModals.openModals( params );
    $('[data-insertimagesselectedgoogle]').hide();
    
    var request = $.ajax ({
        url: "/admin/insertImagesGoogle?modelName="+modelName+"&modelId="+modelId,
        type: "POST",
        async: true,
        dataType: "html",
        data: {'images':JSON.stringify( items ), 'remoteUrls':remoteUrls}
    });
    
//     var request = $.ajax ({
//        url: "/admin/insertImagesGoogle",
//        type: "POST",
//        data: { 'productsNumber': '3434' },
//        dataType: "json"        
//    });
    
    request.done( function( resp ) {       
        if( resp != 0 ) {                        
            alert('IMMAGINI INSERITE');
            $( '#form_imagesGallery' ).val( resp );
            $( ".overlayModelResponse" ).hide();
        } else {
            alert('ERRORE ... IMMAGINI NON INSERITE');
        }
        bootbox.hideAll();
    });
};

/**
 * @param {type} sender
 * @param {type} type
 * @returns {undefined}Avvia la ricerca dei video di youtube
 */
MainAdmin.prototype.responseIframe = function ( resp ) {
    $( '#form_imagesGallery' ).val( resp );    
    if( resp != 0 ) {                        
        alert('IMMAGINI INSERITE');
        $( '#form_imagesGallery' ).val( resp );
        $( ".overlayModelResponse" ).hide();
    } else {
        alert('ERRORE ... IMMAGINI NON INSERITE');
    }
    bootbox.hideAll();
};

/**
 * Metodo che avvia l'interfaccia per la delle immagini di un modello
 * @param {type} sender
 * @param {type} type
 * @returns {Boolean}
 */
MainAdmin.prototype.modifyImagesGalleryModel = function ( sender ) {
    var modelName = $( sender ).attr( 'data-modelName' ); 
    var modelId = $( sender ).attr( 'data-modelId' );
    
    var images = jQuery.parseJSON( $( '#form_imagesGallery' ).val() );
    var htmlR = '<form id="myFormUploadModifyImgGallery" class="positionRelative" method="post" action="/admin/modifyGalleryModelImages" target="myIframe" enctype="multipart/form-data">'+
            '<input type="hidden" name="modelName" value="'+modelName+'"><input type="hidden" name="modelId" value="'+modelId+'">';
    
    $( images ).each(function( key, item ) {     
        console.info(item);
        
        var newSrc = item.src;
        var split = newSrc.split('_');
        newSrc = newSrc.replace( split[0]+'_', '' ).replace( '.jpg', '');
        
        var alt = typeof item.alt != 'undefined' ? item.alt : ( typeof item.title != 'undefined' ? item.title : ''  );
        htmlR += '\
        <div class="item2" style="height:210px;margin: 0.5%;">\
        <img src="/galleryImagesModel/'+item.src+'" height="100px"/><br>\n\
        <input data-titleImg style="width:100%!important;margin: 3px 0;" class="form-control" type="hidden" name="widthSmall[]" value="'+item.dim.width[0]+'" placeholder="Inserisci url immagine">\
        <input data-titleImg style="width:100%!important;margin: 3px 0;" class="form-control" type="hidden" name="heightSmall[]" value="'+item.dim.height[0]+'" placeholder="Inserisci url immagine">\
        <input data-titleImg style="width:100%!important;margin: 3px 0;" class="form-control" type="hidden" name="widthBig[]" value="'+item.dim.width[1]+'" placeholder="Inserisci url immagine">\
        <input data-titleImg style="width:100%!important;margin: 3px 0;" class="form-control" type="hidden" name="heightBig[]" value="'+item.dim.height[1]+'" placeholder="Inserisci url immagine">\
        <input data-titleImg style="width:100%!important;margin: 3px 0;" class="form-control" type="hidden" name="lastsrc[]" value="'+item.src+'" placeholder="Inserisci url immagine">\
        <input data-titleImg style="width:100%!important;margin: 3px 0;" class="form-control" type="text" name="src[]" value="'+newSrc+'" placeholder="Inserisci url immagine"><br>\
        <input data-altImg style="width:100%!important;margin: 3px 0;" class="form-control" type="text" name="alt[]" value="'+alt+'" placeholder="Inserisci titolo"></div>';           
    });
    htmlR += '<input type="button" data-sendModifyImagesModel class="pull-right buttonDefault buttonGreen" value="Carica Immagini" style="width:100%;margin-top:10px;color:#fff;margin:0 auto"></form>';
    
    $('.overlayModelResponse').html( htmlR );
    $('.overlayModelResponse').show();
    
    return false;
};

MainAdmin.prototype.sendModifyImagesModel = function ( sender ) {
    var errorTitle = false;
    var errorAlt = false;
    $( '[data-titleImg]' ).each( function( ) {
        if( $( this ).val() == '' ) {
            errorTitle = true;
        }
    });
    $( '[data-altImg]' ).each( function( ) {
        if( $( this ).val() == '' ) {
            errorAlt = true;
        }
    });
    
    if( errorAlt || errorTitle ) {
        alert( 'Inserisci tutti i title e le url delle immagini');
        return;
    }
    $( '#myFormUploadModifyImgGallery' ).submit();
};

/**
 * Metodo che avvia l'interfaccia per l'inserimento delle immagini
 * @param {type} sender
 * @param {type} type
 * @returns {Boolean}
 */
MainAdmin.prototype.getImagesGoogle = function ( sender, type ) {
    var modelName = $( sender ).attr( 'data-modelName' ); 
    var modelId = $( sender ).attr( 'data-modelId' );
    
    var htmlR = '<form id="myFormUploadImgGallery" class="positionRelative" method="post" action="/admin/insertGalleryModelImages" target="myIframe" enctype="multipart/form-data">'+
            '<input type="hidden" name="modelName" value="'+modelName+'"><input type="hidden" name="modelId" value="'+modelId+'">';
    for( var x = 0; x < 10; x++ ) {
            htmlR += '<div class="item2"><span>'+x+'</span><input type="file" name="src[]">\n\
    <input class="form-control" type="text" name="alt[]" placeholder="Inserisci titolo"></div>';
    }
    htmlR += '<input type="submit" class="pull-right buttonDefault buttonGreen" value="Carica Immagini" style="width:100%;margin-top:10px;color:#fff;margin:0 auto"></form>';
    
    $('.overlayModelResponse').html( htmlR );
    $('.overlayModelResponse').show();
    
    return false;
    
    
    //###########
    
    var keyword = $( "#searchImagesGoogle" ).val();
    var request = $.ajax ({
        url: "/admin/getImagesGoogleApi?keyword="+keyword,
        type: "GET",
        async: false,
        dataType: "json"        
    });
    request.done( function( resp ) {       
        var htmlR = '<textarea id="remoteUrls" style="background: #ffffff;margin: 1%;width: 90%;float: left;"></textarea><div class="clearB"></div>';
        $.each( resp, function( key, value ) {
            htmlR +=  "<div class='item' data-imageUrl='"+value.link+"'><h1>"+value.title+"</h1>\n\
            <img src='"+value.link+"' width='200'> </div>" ;
        });
        $('.overlayModelResponse').html( htmlR );
        $('.overlayModelResponse').show();
    });
};

/**
 * @param {type} sender
 * @param {type} type
 * @returns {undefined}Avvia la ricerca dei video di youtube
 */
MainAdmin.prototype.getVideoYouTube = function ( sender, type ) {
    var keyword = $( "#searchVideoYouTube" ).val();
    var request = $.ajax ({
        url: "/admin/getYouTubeVideo?keyword="+keyword,
        type: "GET",
        async: false,
        dataType: "json"        
    });
    request.done( function( resp ) {       
        var htmlR = '';
        $.each( resp, function( key, value ) {
            htmlR +=  "<div class='item' data-youtubeId='"+value.id+"'><h1>"+value.title+"</h1><h2>"+value.channelTitle+"</h2>\n\
            <iframe src='https://www.youtube.com/embed/"+value.id+"' allowfullscreen></iframe> </div>" ;
        });
        $('.overlayModelResponse').html( htmlR );
        $( ".overlayModelResponse" ).show();
    });
};


/**
 * Verifica se su trovaprezzi sono presenti le info
 * @param {type} sender
 * @returns {Boolean}
 */
MainAdmin.prototype.getInfosModel = function ( sender, type, e ) {
    var that = this;
    if( widgetLogin.isLogged() != 1 ) {  
        e.stopPropagation();
        e.preventDefault();  
        var callback = { 'call': that.getInfosModel, 'params': { '0': sender } };
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    
    var modelId = $( sender ).attr( 'data-modelId' );         
    var url = $( sender ).attr('data-'+type );            
    
    var request = $.ajax ({
        url: "/admin/getInfosModelExternalSite?modelId="+modelId+"&type="+type+"&urlTrovaprezzi="+$( '#form_nameUrlTp').val()+"&urlPagomeno="+$( '#form_nameUrlPm').val()+"&urlIdealo="+$( '#form_nameUrlIde').val()+"&tecnicalType="+$( '#form_tecnicalTemplate').val()+"&amazonAsinReview="+$( '#form_amazonAsinReview').val(),
        type: "GET",
        async: false,
        dataType: "html"        
    });
    request.done( function( resp ) {        
        switch( type ) { 
            case 'schedaPagomeno':
                resp = $.parseJSON( resp );
                var textTecnical = '';
                
                var p = resp.tecnical; 
                textTecnical = p.replace(/;/g, ';\n');

                console.info(textTecnical);
                $( '#form_technicalSpecifications' ).val( textTecnical );
                $( '#form_bulletPoints' ).val( resp.bullets );
                bootbox.hideAll();
            break;            
            case 'bulletsPagomeno':
                $( '#form_bulletPoints' ).val( resp );
            break;            
            case 'amazonAsinReview':
                $( '#form_amazonAsinReview' ).val( resp );
            break;            
        }
    });
    return true;
};

/**
 * Metodo che crea un prodotto face di amazon o ebay
 * @param {type} sender
 * @returns {Boolean}
 */
MainAdmin.prototype.createProduct = function ( sender ) {
    var type = $( sender ).closest( '[data-urlProduct]' ).attr( 'data-urlProduct' );
    var url = $( sender ).closest( '[data-urlProduct]' ).find( 'input' ).val();
        
    var request = $.ajax ({
            url: "/admin/createProduct?type="+type+"&url="+url,
        type: "GET",
        async: false,
        dataType: "json"        
     });
     request.done( function( resp ) {
        console.info( resp );
         $( '#form_name' ).val( resp.title );
         $( '#form_price' ).val( resp.price );
         $( '#form_deepLink' ).val( resp.deepLink );
         $( '#form_impressionLink' ).val( resp.impressTo );
         $( '#form_number' ).val( resp.ASIN );
         $( '#form_handlingCost' ).val( resp.shippingCost );
         $( '#form_ean' ).val( resp.ean );
     });
     return true;
};

/**
 * Verifica se su trovaprezzi sono presenti le info
 * @param {type} sender
 * @returns {Boolean}
 */
MainAdmin.prototype.checkModelinfo = function ( sender ) {
    
//    alert(2);
    var url = $( sender ).attr('data-linkModelTp');
    var request = $.ajax ({
            url: "/admin/checkModelinfo?url="+url,
        type: "GET",
        async: false,
        dataType: "html"        
     });
     request.done( function( resp ) {
         var msg = resp == 1 ? 'Info Presenti' : 'Info NON Presenti';
         var classs = resp == 1 ? 'Info Presenti' : 'Info NON Presenti';
         
        if( resp == 1 )
            $( sender ).html( '<span style="color:green"><b>Info Presenti</b></span>');
        else 
            $( sender ).html( '<span style="color:#ff0000"><b>Info NON Presenti</b></span>');
         
     });
     return true;
};

MainAdmin.prototype.initSpeak = function ( ) {
    this.speakEnabled = localStorage.getItem("speak");
    
    if(  this.speakEnabled == 0 || this.speakEnabled == '' ) {
        $( '[data-speak]').attr( 'class', 'fa fa-volume-off' );
        
    } else if( this.speakEnabled == null || this.speakEnabled == 1 ) {
        $( '[data-speak]').attr( 'class', 'fa fa-volume-up' );
    }
};

MainAdmin.prototype.setSpeak = function ( sender ) {
    this.speakEnabled = localStorage.getItem("speak");    
    
    if( this.speakEnabled == null ) {
        this.speakEnabled = 0;
        localStorage.setItem("speak", 0);
        $( sender ).attr( 'class', 'fa fa-volume-off' );
        
    } else if( this.speakEnabled == 0 ) {
        this.speakEnabled = 1;
        localStorage.setItem("speak", 1);
        $( sender ).attr( 'class', 'fa fa-volume-up' );
        
    } else if( this.speakEnabled == 1 ) {
        this.speakEnabled = 0;
        localStorage.setItem("speak", 0);
        $( sender ).attr( 'class', 'fa fa-volume-off' );
    }
        
};

MainAdmin.prototype.copyToClipboard = function (sender) {
    var aux = document.createElement("input");    
    aux.setAttribute("value", $(sender).closest('[data-urlArticle], .footable-row-detail-value ').find('.url').html());
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);

    var parameters = new Array();
    parameters['type'] = 'success';
    parameters['layout'] = 'top';
    parameters['mex'] = 'Copiato sulla tua clipboard';
    classNotyfy.openNotyfy(parameters);

};
MainAdmin.prototype.hoverForm = function () {

    $(this).closest('.form-group').find('label').hide();
    $('input,select,textarea').on('blur', function () {
        $(this).closest('.form-group').removeClass('active');
        if ($(this).val() == '') {
            $(this).closest('.form-group').find('label').removeClass('active');
            $(this).closest('.form-group').find('label').removeClass('colorLabelFormForce');
        } else {
            $(this).closest('.form-group').find('label').addClass('colorLabelFormForce');
        }
    });
    $('input,select,textarea').on('focus', function () {
        $( this ).closest( '.form-group' ).removeClass('has-error');
        $( this ).closest( '.form-group' ).find('.help-block' ).remove();
        $(this).closest('.form-group').addClass('active');
        $(this).closest('.form-group').find('label').addClass('active');
        $(this).closest('.form-group').find('label').removeClass('colorLabelFormForce');
    });


    $('input,select,textarea').each(function () {
        if ($(this).val() != '') {
            $(this).closest('.form-group').find('label').addClass('colorLabelFormForce').addClass('active');
        }
        $(this).closest('.form-group').find('label').show();
    });

};
MainAdmin.prototype.toggleMenu = function () {
    $(".structure_LeftColumn").toggleClass('closeMenu');
    $(".button-action").toggleClass('closeMenu');
    $(".structure_RightColumn").toggleClass('closeMenu');

};
MainAdmin.prototype.iconeMenu = function () {
    $(".structure_LeftColumn").toggleClass('iconeMenu');
    $(".button-action").toggleClass('iconeMenu');
    $(".structure_RightColumn").toggleClass('iconeMenu');
};

MainAdmin.prototype.scroolTop = function () {
    var that = this;



    // Intercetto lo scroll di pagina

    $(window).scroll(function () {
        // Se l'evento scroll si verifica, mostro l'icona (invisibile) con effetto dissolvenza
        if ($("#toTop").is(":hidden")) {
            $("#toTop").fadeIn(500);
        }
        // Se si verifica il ritorno ad inizio pagina, nascondo l'icona con effetto dissolvenza
//        if ($("body").scrollTop() == 0 && !$("#toTop").is(":hidden")){
//            $("#toTop").fadeOut(500);
//        }
    });
};
