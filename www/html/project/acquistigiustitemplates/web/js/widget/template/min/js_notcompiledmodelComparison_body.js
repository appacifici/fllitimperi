
/**
 * Classe per la gestione del widget ImageArticle
 */
var ManagerLinks = function () {    
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
ManagerLinks.prototype.initListeners = function () {
    var that = this;
    
    $( 'body' ).on( 'click', '[data-action="urlCopy"]', function() {
        that.openCopyLink( this );
    });
    
    $( 'body' ).on( 'click', '[data-ln]', function() {
        that.openJsLink( this);
    });
    
    $( 'body' ).on( 'click', '[data-lgt]', function() {
        that.openJsLink( this);
    });
    $( 'body' ).on( 'click', '[data-href]', function() {
        that.dataOpenHref( this);
    });
    $( 'body' ).on( 'click', '[data-modelComparisonPrices] [data-viewMoreProducts]', function() {
        var p = this;
        var block = false;
        $( this ).closest( '[data-modelComparisonPrices]').find( 'table tr[data-ViewMoreProductsItem]').toggle( function() {
            if( !block ) {
                if( $( p ).find( 'span').html() == '+ Mostra più prodotti' )
                    $( p ).find( 'span').html('- Mostra meno prodotti');
                else
                    $( p ).find( 'span').html('+ Mostra più prodotti');
                block = true;
            }
        });
    });
};


ManagerLinks.prototype.viewMoreProducts = function ( sender ) { 
    window.open( $( sender ).attr( 'data-href' ), '_blank');
//    window.location.href =  $( sender ).attr( 'data-href' );
};

ManagerLinks.prototype.dataOpenHref = function ( sender ) { 
    window.open( $( sender ).attr( 'data-href' ), '_blank');
//    window.location.href =  $( sender ).attr( 'data-href' );
};

ManagerLinks.prototype.openJsLink = function ( sender ) {       
    var a = $( sender ).attr( 'data-lgt' ).substr( 5 );
    var b = a.substr( 0, ( a.length - 5 ) ); b;
        
    if( $( sender ).attr( 'data-target' ) == 'blank') {
        window.open( atob( b ), '_blank');
    } else {
        window.location.href = atob( b );    
    }
};

/**
 * Apre il link recuperandolo da un figlio de contenitore padre
 * @param {type} sender
 * @returns {undefined}
 */
ManagerLinks.prototype.openCopyLink = function ( sender ) {
    var url = $( sender ).closest( '[data-urlCopyFather]' ).find( '[data-urlCopy]' ).attr( 'href' );
    var target = $( sender ).closest( '[data-urlCopyFather]' ).find( '[data-urlCopy]' ).attr( 'target' );
    
    if( target == '_blank')
        window.open( url, '_blank');        
    else    
        window.location.href = url;
        
};


managerLinks = null;
managerLinks = new ManagerLinks();

;
main = null;
/**
 * Classe per la gestione della homepage
 */
var Main = function() {
    this.isOpenLogin = false;
    this.charLoader = false;
    this.initListeners(); 
};

/**
 * Metodo che avvia gli ascoltatori
 */
Main.prototype.initListeners = function() {
    var that = this;
    $('body').on('click', '[data-widgetOpenLogin], [data-widgetCloseLogin]', function() {
        that.manageBoxLogin ();
    });
    
    $( '#openSearch').click( function() {
        $( this ).closest( '.header' ).toggleClass( 'open' );
        $( this ).closest( '.header' ).find('.btnSearch').toggle();
    });   
   
    $( '#micro-section-header span').click( function() {
        $( this ).toggleClass( 'auto' );        
    });   
    
    $('body').on('click', '[data-boxPaymentsOpen]', function() {
        that.boxPaymentsOpen( this );
    });    
    $('body').on('click', '[data-closeoverlay]', function() {
        $( '#boxOverlay' ).hide();
    });    
    $('body').on('click', '[data-pOff]', function() {
        that.offProduct( this );
    });    
    
    $('body').on('click', '[data-CreateProducteInit]', function() {
        that.createProducteInit( this );
    });    
    
    $('body').on('click', '[data-SendNewsletters] span.newslettersIcon', function() {
        that.sendNewsletters( this );
    });    
   
    
    $('body').on('click', '[data-expandTecnical]', function() {        
        $( '.widget-model-detail .tecnical-info').toggleClass('closed');
        
        if( !$( '.widget-model-detail .tecnical-info').hasClass('closed') ) {
//            $( '.widget-model-detail .tecnical-info').css('overflow', 'visible');
            $( '[data-expandTecnical]').html( '- Leggi meno' );
        } else {
//            $( '.widget-model-detail .tecnical-info').css('overflow', 'hidden');
            $( '[data-expandTecnical]').html( '+ Leggi tutto' );
        }


    });    
    
    $('body').on('click', '[data-thumbYouTube]', function() {
        $( this ).html( '<iframe width="100%" height="300px" src="https://www.youtube.com/embed/'+$( this ).attr('data-thumbYouTube')+'?autoplay=1" allowfullscreen></iframe>' )
    });    
    
    
    
    if( this.getCookie( 'externalUserCode' ) != null ) {
        $( '[data-widgetOpenLogin] .btnLogin' ).removeClass( 'btnLogin' ).addClass( 'btnLogout' );
        $( '[data-widgetOpenLogin] .btnLogout' ).html('Logout');
        $( '[data-widgetOpenLogin]' ).removeAttr('data-widgetOpenLogin');
        $('.buttonsHeader .user').click( function() {
            window.location.href = '/extUser/logout';
        }); 
    }                 
};

/**
 * Avvia la registrazione alla newsletters
 * @param {type} sender
 * @returns {undefined}
 */
Main.prototype.sendNewsletters = function(sender) {
    var input = $( sender ).closest( '[data-SendNewsletters]' ).find( 'input' );
    
    $.get( "/ajax/sendNewsletters?email="+input.val(), function( response ) {
        var type = 'error';
       
        if ( response == 1 ) {
            var msg   = 'Iscrizione alla newsletters avvenuta con successo';
            var type = 'success';                        
            $( sender ).closest( '[data-SendNewsletters]' ).html( msg ).addClass( type );
            return true;
        }  
        
        if ( response == 0 ) {            
            var msg = 'Questo indirizzo email è già iscritto alla newsletters!';            
        }
        
        if ( response == 2 ) {
            var msg = 'Spiacenti, non è stato possibile iscriverti alla newsletters';       
        }
        
        if ( response == 3 ) {
            var msg = 'Inserisci un indirizzo email valido!';       
        }
        $( sender ).closest( '[data-SendNewsletters]' ).find('div').html( msg ).addClass( type ).show();
    });
};

Main.prototype.createProducteInit = function(sender) {
    var id = $( sender ).attr( 'data-CreateProducteInit' );
    var modelId = $( sender ).attr( 'data-ModelId' );
    $.get( "/admin/insertFakeProduct/"+id+"/"+modelId, function( data ) {
        if( data > 0 ) {
            alert('Creato');
        } else { 
            alert('Problemi');
        }
    });
};

Main.prototype.offProduct = function(sender) {
    var id = $( sender ).attr( 'data-pOff' );
    $.get( "/admin/offProduct?id="+id, function( data ) {
        if( data == 1 ) {
            alert('Eliminato');
        } else {
            alert('Problemi');
        }
    });
};


/*metodo che apre e chiude la login  */
Main.prototype.manageBoxLogin = function(sender) {    
    var that = this;
    if( !this.isOpenLogin ) {

        that.appendJs ( '//connect.facebook.net/it_IT/sdk.js' );        
        that.appendJs ( 'https://apis.google.com/js/api:client.js' );        
        that.appendJs ( '/js/facebook.init.js' );        
        that.appendJs ( '/js/google.init.js' );        

        $.get( "/ajax/getLoginHtml", function( data ) {
            $('body').append(data);
            $ ('[data-widgetLogin], [data-boxLogin]').show();  
            that.isOpenLogin = true;
        });        
    }
    
    if( $('[data-widgetLogin]').is(":hidden") ) {
        $ ('[data-widgetLogin], [data-boxLogin]').show();    
    } else {
        $ ('[data-widgetLogin], [data-boxLogin]').hide();    
    } 
};
 
/**
 * Metodo che appende un file
 * @param {type} file
 * @returns {undefined}
 */
Main.prototype.appendJs = function( file ) {
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.defer = true;
    script.async = true;        
    script.src = file;
    head.appendChild(script);
};

/*metodo che apre e chiude la login  */
Main.prototype.boxPaymentsOpen = function(sender) {
    $( sender ).closest( '[data-boxPayments]' ).find( '[data-boxPaymentsItems]' ).show();
    $( sender ).hide();        
};




/**
 * Metodo che avvia il lazy sulle immagini
 * @param {string} container
 * @returns {void}
 */
Main.prototype.lazy = function(container) {
    if (typeof container == 'undefined')
        container = '';

    if (typeof unveil != 'undefined') {
        $(container + " .lazy").unveil(300, function() {
            $(this).load(function() {
                this.style.opacity = 1;
            });
        });
    }
};


Main.prototype.setCookie = function(name, value, millisec) {
    if (millisec) {
        var date = new Date();
        date.setTime(date.getTime() + (millisec));
        var expires = "; expires=" + date.toGMTString();
    }
    else
        var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
};


Main.prototype.trackGAClickEvent = function(category, action, opt_label, optValue) {
    if (typeof category == "undefined" || typeof action == "undefined" || typeof opt_label == "undefined") {
        return false;
    }
    if (typeof ga == "undefined") {
        return false;
    }
    if (typeof (ga) != 'undefined' && category != null && action) {
        ga('send', 'event', category, action, opt_label, 4);
        console.info(typeof (ga));
    }
    return true;
};

Main.prototype.getCookie = function(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
};

Main.prototype.unsetCookie = function(name) {
    this.setCookie(name, "", -1);
};


Main.prototype.openDataIntLink = function(url) {
    window.location.href = url;
};

var main = null;
main = new Main();


/**
 * Classe per determinare se un elemento è visibile o no nello schermo
 * @returns {Utils}
 */
function Utils() {}
Utils.prototype = {
    constructor: Utils,
    isElementInView: function (element, fullyInView) {
        var pageTop = $(window).scrollTop();
        var pageBottom = pageTop + $(window).height();
        var elementTop = $(element).offset().top;
        var elementBottom = elementTop + $(element).height();

        if (fullyInView === true) {
            return ((pageTop < elementTop) && (pageBottom > elementBottom));
        } else {
            return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
        }
    }
};

var Utils = new Utils()
;

/**
 * Classe per la gestione del widget ImageArticle
 */
var MobileSlider = function () {    
    this.index = 1;
    this.totalLi = $( '[data-galleryImages] [data-photo-display]' ).length;
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
MobileSlider.prototype.initListeners = function () {
    var that = this;        
    $( 'body' ).on( 'click', '[data-big-images] img', function() {
        that.openGallryoverlay( this );
    });
    
    $(document).keyup(function(e) {
        if (e.key === "Escape") { // escape key maps to keycode `27`
            $( '#boxOverlay').hide();
        }
    });
      
    $( 'body' ).on( 'click', '[data-galleryImages] [data-btn-prev]', function() {
        clearInterval( that.interval );
        that.changeSlider('-');
//        that.initInterval();
    });
    $( 'body' ).on( 'click', '[data-galleryImages] [data-btn-next]', function() {
        clearInterval( that.interval );
        that.changeSlider('+');
//        that.initInterval();
    });
    
//    this.initInterval();
};

/**
 * Apre il popuo overlay delle foto 
 * @returns {undefined}
 */
MobileSlider.prototype.openGallryoverlay = function ( sender ) {
    var src = $( sender ).attr('src').replace( 'Small','');
    $( '#boxOverlay .content' ).html( "<span data-closeoverlay class='close'>X</span><img src='"+src+"'>");
    $( '#boxOverlay').show();
};

MobileSlider.prototype.initInterval = function () {
    var that = this;
    clearInterval( this.interval );
    this.interval = setInterval( function() {
        that.changeSlider();
    }, 5000 );
};

MobileSlider.prototype.changeSlider = function ( type ) {
    $( '[data-galleryImages] [data-photo-display]' ).hide();
        
    if( typeof type == 'undefined' || type == '+' ) {
        this.index = this.index+1 > this.totalLi ? 1 : this.index+1;
    } else {
        this.index = this.index-1 <= 0 ? this.totalLi : this.index-1;
    }
    var src = $( '[data-galleryImages] [data-photo-display]:nth-child('+this.index+')' ).find('img').attr( 'data-imageSrc');    
    $( '[data-galleryImages] [data-photo-display]:nth-child('+this.index+')' ).find('img').attr( 'src', src);
    $( '[data-galleryImages] [data-photo-display]:nth-child('+this.index+')' ).show();
};


mobileSlider = null;
mobileSlider = new MobileSlider();

;
/**
 * Classe per la gestione dei commenti
 */
var WidgetDictionary = function () {
    var that = this;
    this.initListeners();
    
    var openTimeout = false;
    var closeTimeout = false;
    
    var isOpen = false;
    var lastOpenItem = 0;
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetDictionary.prototype.initListeners = function () {
    var that = this;       
    
    // al click faccio partire il flusso per i commenti
    $( 'body' ).on( 'mouseover', '[data-dictionary]', function ( e ) {
        var itemId = $( this ).attr( 'data-dictionary' );
        if( that.lastOpenItem != itemId )
            that.isOpen = false;
        
        clearTimeout(that.closeTimeout);
        if( !that.isOpen ) {
            that.openTimeout = setTimeout( function() {
                that.getItemDictionary( this );
                that.isOpen = true;
            }.bind( this ), 500 );
        }
        
    });
    
    $( 'body' ).on( 'mouseout', '[data-dictionary]', function ( e ) {
        clearTimeout(that.openTimeout);
        
        that.closeTimeout = setTimeout( function() {
            that.closeItemDictionary( this );
            that.isOpen = false;
        }.bind( this ), 500 );        
    });    
};

/**
 * 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetDictionary.prototype.getItemDictionary = function ( sender ) {
    var itemId = $( sender ).attr( 'data-dictionary' );
    this.lastOpenItem = itemId;
    
    var request = $.ajax({
        url:  "/dictionary/getItem/"+itemId, 
        type: "GET",
        async: true,
        dataType: "json"
    });

    request.done( function( resp ) {        
        var position = $( '[data-dictionary="'+itemId+'"]').position();
        
        $( '[data-overlayDictionary' ).css( 'top', position.top + 24  );
        $( '[data-overlayDictionary' ).css( 'left', position.left  );
                
        $( '[data-overlayDictionary' ).html( '<div class="freccia"></div><span class="name">'+resp.name+'</span><span class="desc">'+resp.body+'</span>' );
        $( '[data-overlayDictionary' ).show();
        if( $( window ).width() < 700 ) {
            $( '[data-overlayDictionary] .freccia' ).css( 'left', position.left+'px'  );
        }
    });
};

WidgetDictionary.prototype.closeItemDictionary = function ( sender ) {
    $( '[data-overlayDictionary' ).hide();
};

var widgetDictionary   = null;
widgetDictionary       = new WidgetDictionary()
;

/**
 * Classe per la gestione dei commenti
 */
var WidgetSearchFilterProduct = function () {
    this.currentItemSuggestion = 0;
    this.widgetSearchFilterProduct = $('[data-widgetSearchFilterProduct]');
    this.searchFilterProductForm = $('[data-widgetSearchFilterProduct]').find( '#searchFilterProductForm');
    this.initListeners();
};


/**
 * Metodo che avvia gli ascoltatori
 */
WidgetSearchFilterProduct.prototype.initListeners = function () {
    var that = this;       
    $('[data-widgetSearchFilterProduct] [data-submitbtn]' ).click( function() {
        that.sendSearch( this );
    });
    
    $( 'body' ).click(function() {
        setTimeout(function() {
            $( '[data-responseSuggestionModel]').hide();
        },500);
    });
    
    this.enabledSuggestion = true;
    $('[data-widgetSearchFilterProduct] .inputSearchBox').keyup(function (e) {
        if( e.which == 38 || e.which == 40 ) {
            that.selectItemSuggestion( e.which );
        }
        
        if (e.which == 13) {
            that.currentItemSuggestion=0;
            that.sendSearch( this );
            return false;
            
        } else if( e.which != 38 && e.which != 40 )  {
            that.getTimeoutSuggestion( this );
        }
    });    
    
    $('#searchFilterProductForm [data-submitFilters]').click(function() {
        that.getSearchFilters();
    });
    $('#searchFilterProductForm [data-activeFilter]').click( function(){
        var value = $( this ).attr( 'data-activeFilter' ) == 1 ? '' : 1;
        $( this ).attr( 'data-activeFilter', value );
    })
    
    $('[data-sorting]').change( function() {
        that.setOrder();
    });
    
};

WidgetSearchFilterProduct.prototype.getSearchFilters = function ( key ) {
    var str = '?';
    
//    minPrice=10&maxPrice
    var minPrice = $('#searchFilterProductForm #minPrice').val() != '' ? 'minPrice='+$('#searchFilterProductForm #minPrice').val()+'&' : '';
    var maxPrice = $('#searchFilterProductForm #maxPrice').val() != '' ? 'maxPrice='+$('#searchFilterProductForm #maxPrice').val()+'&' : '';
    
    var search = $('#searchFilterProductForm #searchFilter').val() != '' ? 'search='+$('#searchFilterProductForm #searchFilter').val()+'&' : '';
    
    
    
    $('#searchFilterProductForm [data-activeFilter="1"]').each(function() {
       str += $( this ).attr( 'data-field')+'[]='+$( this ).attr( 'data-value')+'&';       
    });
    
    window.location.href = str+minPrice+maxPrice+search; 
};

WidgetSearchFilterProduct.prototype.setOrder = function () {
    var value = $('[data-sorting]').val();
    value = value.toLowerCase();
    
    window.location.href = '?order='+value;
};

/**
 * Metodo che gestisce la selezione delle suggestionb
 * @param {type} key
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.selectItemSuggestion = function ( key ) {
    var tot = $( '[data-responseSuggestionModel] [data-item]' ).length;

    if( key == 40 )
        this.currentItemSuggestion++;
    else
        this.currentItemSuggestion--;    
    
    if( this.currentItemSuggestion > tot )
        this.currentItemSuggestion = 1;
    
    if( this.currentItemSuggestion < 1 )
        this.currentItemSuggestion = tot;
    
    $( '[data-responseSuggestionModel] [data-item]').removeClass('selected');          
    $( '[data-responseSuggestionModel] [data-item="'+this.currentItemSuggestion+'"]').addClass( 'selected' );  
    var currentValue = $( '[data-responseSuggestionModel] [data-item="'+this.currentItemSuggestion+'"]').val();
    
    $( '[data-responseSuggestionModel] .inputSearchBox').val(currentValue);
  
};

/**
 * Metodo che avvia il timeout per la suggestiojn
 * @param {type} sender
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.getTimeoutSuggestion = function ( sender ) {
    var that = this;
    
    if( typeof this.suggestionTimeout != 'undefined' )
        clearTimeout( this.suggestionTimeout );
    
    this.suggestionTimeout = setTimeout(function() {
        that.getSuggestion( sender );
    }, 150 );   
}

/**
 * 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.getSuggestion = function ( sender ) {
    
    var urlAjax = "/suggestion/model?search="+$( sender ).val();

    var request = $.ajax ({
        url: urlAjax,
        type: "GET",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {             
        $( '[data-responseSuggestionModel]').html( resp );
        if( resp != '' )
            $( '[data-responseSuggestionModel]').show();
        else 
            $( '[data-responseSuggestionModel]').hide();
    });
     
};


/**
 * Metodo che avvia la ricerca
 * @param {type} sender
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.sendSearch = function ( sender ) {
    if( $( '[data-responseSuggestionModel] [data-item].selected').length == 1 ) {
        var url = $( '[data-responseSuggestionModel] [data-item].selected a').attr( 'href' );
        var target = $( '[data-responseSuggestionModel] [data-item].selected a').attr( 'target' );
        
        if( target == '_blank')
            window.open( url, '_blank');        
        else    
            window.location.href = url;
        return false;
    }
    
    var category = $( sender ).closest( '[data-widgetSearchFilterProduct]' ).find( '#category' ).val();
    var search   = $( sender ).closest( '[data-widgetSearchFilterProduct]' ).find( '#search' ).val();
    
    if( search.length < 2 ) {
        alert( 'Inserisci la parola da ricercare' );
        return false;
    }
    
    if( category == 0 ) {
//        alert('seleziona la categoria');
//        return false;        
    } else {
        category = category;
    }
        
    
    search = search.replace( / /g, '_' );     
    window.location.href = '/aSearch?category='+category+'&search='+search; 
};

var widgetSearchFilterProduct   = null;
widgetSearchFilterProduct       = new WidgetSearchFilterProduct()
;
coockie = null;
/**
 * Classe per la gestione della homepage
 */
var Coockie = function() {   
    this.initListeners(); 
};


/**
 * Metodo che avvia gli ascoltatori
 */
Coockie.prototype.initListeners = function() {
    var that = this;
    
    this.infoCoockie();
    $( '[data-block-prop]' ).click(function( event ) {
        event.stopPropagation();
    });
    $( '[data-accept-coockie]' ).click(function( event ) {
        that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
        $( '[data-info-coockie]' ).fadeOut();
    });
    
    if( window.location.pathname != "/info/coockie" ) {
        $( '[data-action="urlCopy"], [data-lgt], [data-placelogo], [data-hamburger], a:not([data-block-prop]), img, [data-btn-prev], [data-btn-next]' ).click(function() {
            that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
            $( '[data-info-coockie]' ).fadeOut();
        });

        $( '[data-widgetsearchfilterproduct] input' ).keypress(function() {
            that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
            $( '[data-info-coockie]' ).fadeOut();
        });
        $( window ).scroll(function() {
            that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
            $( '[data-info-coockie]' ).fadeOut();
        });
    }
};

/**
 * Apre il banner dell'informatica dei coockie se l'utente non lo ha ancora accettato
 * @returns {undefined}
 */
Coockie.prototype.infoCoockie = function() {
    if( this.getCookie( 'accept-info-coockie' ) != 'conditions_fully_accepted' ) {
        $( 'body' ).append('<div data-info-coockie class="info-coockie">Acquistigiusti.it utilizza cookie, di proprietà e di terze parti.\n\
         Se vuoi saperne di più o negare il consenso a tutti o ad alcuni cookie leggi <a data-block-prop href="/info/coockie">l’informativa cookie</a>.\n\
        Scorrendo la pagina, cliccando questo banner o qualsiasi elemento in pagina acconsenti all\'utilizzo dei coockie. \n\
        <span data-accept-coockie>OK</span>\n\
        </div>');
    }
};

/**
 * Effettua il settaggio di un coockie
 * @param {type} cname
 * @param {type} cvalue
 * @param {type} exdays
 * @returns {undefined}
 */
Coockie.prototype.setCookie = function( cname, cvalue, exdays ) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

/**
 * Effettua il recupero di un coockie per il suo nome
 * @param {type} name
 * @returns {unresolved}
 */
Coockie.prototype.getCookie = function(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
};

/**
 * Effettua la cancellazione del coockie
 * @param {type} name
 * @returns {undefined}
 */
Coockie.prototype.unsetCookie = function(name) {
    this.setCookie(name, "", -1);
};

coockie = new Coockie()
;
/**
 * Classe per la gestione dei moduli del sito
 */
var Modules = function() {
    this.aModules = new Array();    
};

Modules.prototype.add = function ( widget, core, loadType, limit, category, varAttrAjax, affiliation, trademark ) {
    this.aModules[widget] = {'widget':widget, 'core':core, 'loadType':loadType, 'limit':limit, 'category':category, 'varAttrAjax': varAttrAjax, 'affiliation':affiliation, 'trademark':trademark };     
};

/**
 * Ritorna i dati del modulo richiesto
 * @param {type} widget
 * @returns {Array|Boolean}
 */
Modules.prototype.getDataModule = function ( widget ) {
    if( typeof this.aModules[widget] == 'undefined' )
        return false; 
    return this.aModules[widget];
};

/**
 * Recupera il modulo da caricare
 * @param {type} module
 * @returns {undefined}
 */
Modules.prototype.load = function () {
    var that = this;        
    for ( item in this.aModules ) {        
        if( this.aModules[item]['loadType'] == 1 ) { 
            that.getAsync( 
                that.aModules[item]['widget'], 
                that.aModules[item]['core'],
                that.aModules[item]['limit'], 
                that.aModules[item]['category'], 
                that.aModules[item]['varAttrAjax'],
                that.aModules[item]['affiliation'],
                that.aModules[item]['trademark']
            );
        }
    }    
};

/**
 * Recupera il widget in modalita asicrona
 * @param {type} widget
 * @param {type} core
 * @returns {undefined}
 */
Modules.prototype.getAsync = function ( widget, core, limit, category, varAttrAjax, affiliation, trademark ) {
    var that = this;
    var id = idNews;
    
    setTimeout( function() {
        that.getModule( widget, core, id, false, false, limit, category, varAttrAjax, affiliation, trademark );
    }, 100 );
};

/**
 * Metodo che fa il replace con il contenuto del modulo
 * @param {type} module 
 * @returns {undefined}
 */
Modules.prototype.getModule = function ( widget, core, id, paramsExtra, callback, limit, category, varAttrAjax, affiliation, trademark ) {
    var that = this;   

    if( typeof id == 'undefined' )
        id = '';
        
    if( typeof paramsExtra == 'undefined' )
        paramsExtra ='';
        
//    if( widget != 'widget_LiveScoreMatch' )
//        $( '.'+widget ).find( '.widget-body' ).replaceWith( '<div class="text-center"><img widht="64" heidth="64" src="/images/loader.gif"></div>');
//    
    //Determina se bisogna differenziare la url avvinche la versione desktop e la versione mobile sia cachate in modo differente
    var changeUrlForCacheIfIsMobile = '';
    
    $( '['+varAttrAjax+']' ).hide();
    
    var params = "widget="+widget+"&cores="+core+"&limit="+limit+"&category="+category+"&affiliation="+affiliation+"&trademark="+trademark+"&id="+id+paramsExtra+changeUrlForCacheIfIsMobile;
    var request = $.ajax({
        url: ajaxCallPath + "widget?"+params, 
        type: "GET",
        async: true,
        dataType: "html"
    });

    request.done( function( html ) {
        //Setta che il widget è gia stato caricato per bloccare la chiamata ajax successivamente
        if( typeof that.aModules[widget] != 'undefined' && widget != 'widget_CommentsMatch' )
            that.aModules[widget]['open'] = id;        
//       

        $( '[dataReplaceWidget="'+varAttrAjax+'"]' ).replaceWith( html );
//       
//        
//        if( typeof callback != 'undefined' ) {
//            if( typeof callback.params != 'undefined' )
//                callback.call( callback.params[0] );
//            else
//                callback.call();
//        }
//                
//        
        
        setTimeout( function() {
            $( '[dataReplaceWidget]' ).show();
        },500);
//        
        
        
        var calls = $( '.'+widget ).attr( 'data-callFunctions' );
        if( typeof calls != 'undefined' && calls == 1 ) {
            that.getCallDataFunctionWidget( calls, params );
        } 
//        else if( typeof calls != 'undefined' ) {
//            alert( calls);
//            switch( calls ) {
//                case 'getFormationsFieldLastMatchTeam':
//                    that.getFormationsFieldLastMatchTeam();
//                break;
//            }
//        }
    });
};

//Modules.prototype.getFormationsFieldLastMatchTeam = function (  ) {
//    alert(lastFeedMatchIdTeam);
//    this.getCallDataFunctionWidget();
//};

/**
 * Lancia la funzione da chiamare settata nel data attribute data-callFunctions del widget appena caricato
 * @param {type} widget
 * @param {type} core
 * @param {type} id
 * @returns {undefined}
 */
Modules.prototype.getCallDataFunctionWidget = function ( call, params ) {
    var that = this;
        
    var request = $.ajax({
        url: ajaxCallPath + "dataWidget?"+params,
        type: "GET",
        async: true,
        dataType: "html"
    });

    request.done( function( html ) { 
        socketClient.eachData( jQuery.parseJSON( html ) );
    });
};

modules = null;
modules = new Modules();

;

/**
 * Classe per la gestione della homepage
 */
var WidgetMenu = function () {
    var that = this;
    this.initListeners();
    $( '[data-placeLogo]' ).html( '<img src="'+$( '.homeLogo img').attr('src')+'">' );
    
     
};    

    
/**
 * Metodo che avvia gli ascoltatori
 */
WidgetMenu.prototype.initListeners = function () {
    var that = this;       
         
    $( '[data-hamburger]' ).click( function() {                
        $( '[data-hamburger]' ).toggleClass( "hamburgerOpen" );
        $( '[data-menu]' ).toggle();   
        if( $( '[data-menu]' ).is(":visible") ) {
            $( '[data-op]' ).css( 'opacity', '0.1');                                                      
            $( '[data-placeLogo]' ).css( 'visibility', 'hidden');
            that.blockScroll();                                   
        } else {
            $( '[data-op]' ).css( 'opacity', '1');
            that.blockScroll();      
            $( '[data-placeLogo]' ).css( 'visibility', 'visible');
        }
    });    
    
    $( '[data-menu] [data-cat]' ).click( function() {
        that.hamburger( this );                
    });
    
    $( '[data-placeLogo]' ).click( function() {
        window.location.href = '/';              
    });
    
    if( $( window ).width() <= 1000 ) {
        $('[data-menu] [data-cat]').on('click', function() {  
            $('.widget-menu').animate({scrollTop: $(this).offset().top - 100}, 1000);
            return false;
        });
    }
};


WidgetMenu.prototype.blockScroll = function ( sender ) {
    if( $( window ).width() >= 10 ) {
        if( $( '[data-menu]' ).is(":visible") ) {
            $( '[data-op]' ).css( 'opacity', '0.1');
            $('html, body').css({
                overflow: 'hidden',
                height: '100%'
            });
        } else {
            $( '[data-op]' ).css( 'opacity', '1');
            $('html, body').css({
                overflow: 'auto',
                height: 'auto'
            });
        }
    } else {
        $('html, body').css({
            overflow: 'auto',
            height: 'auto'
        });
    }
};

WidgetMenu.prototype.hamburger = function ( sender ) {
    var id = $( sender ).attr( 'data-cat' );
    var blockChange = false;
    
    if( $( window ).width() <= 1000 ) {
        if( $( '[data-menu] [data-subMenuCat="'+id+'"]' ).is(":visible") ) {
            $( '[data-menu] [data-subMenuCat="'+id+'"]' ).hide();
            blockChange = true;
        } else {
            $( '[data-menu] [data-subMenuCat="'+id+'"]' ).show();
        }
    }
    
    
    $( '[data-menu] [data-subMenuCat]' ).hide();
    
    if( !blockChange ) {
        if( $( '[data-menu] [data-subMenuCat="'+id+'"]' ).is(":visible") ) {
            $( '[data-menu] [data-subMenuCat="'+id+'"]' ).hide();
        } else {
            $( '[data-menu] [data-subMenuCat="'+id+'"]' ).show();
        }
    }
    
};

var widgetModel   = null;
widgetModel       = new WidgetMenu();

//$('html, body').css({
//    overflow: 'hidden',
//    height: '100%'
//})
;

/**
 * Classe per la gestione dei commenti
 */
var WidgetUser = function () {
    this.initListeners();
};


/**
 * Metodo che avvia gli ascoltatori
 */
WidgetUser.prototype.initListeners = function () {
    var that = this;       
    
    
    $('body').on( 'click', '[data-logout]', function(e) {
        if (that.isLogged() == 1) {
           that.userLogout();
        }
    });
    
    // al click apro il popup per il reset della password
    $( 'body' ).on( 'click', '[data-forgotPwd="1"]', function ( e ) {
        bootbox.hideAll();
        that.openPopupForgotPwd();
    });
   
    // al click apro il popup per il reset della password
    $( 'body' ).on( 'click', '[data-resetPwd="1"]', function ( e ) {
        var pwd = $('#resetPwd').val();
        var confirmPwd = $('#confirmPwd').val();
        if ( pwd != confirmPwd) {
            e.stopPropagation();
            e.preventDefault(); 
            var params = { 
              type: 'custom', 
              title: 'Offerteprezzi.it' ,
              callbackModals: '\
              <div class="containerMsg">\
                  <div class="containerMsg">\
                      <div>\
                          <label>Le due password devono coincidere</label>\
                      </div>\
                  </div>\
              </div>'
              };
          classModals.openModals( params );
        }
    });
    
    // al click mando la mail per il reset della password
    $( 'body' ).on( 'click', '[data-sendMail="1"]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
        bootbox.hideAll();
        that.forgotPwd( this );
    });
    
    // al click parte il flusso per la registrazione
    $( 'body' ).on( 'click', '[data-defaultRegister]', function ( e ) {
        that.sendRegistration( this );       
    });
    
    // al click parte il flusso per il login
    $( 'body' ).on( 'click', '[data-defaultLogin]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();    
        that.sendLogin( this );
    }); 
    
    
};


/**
 * Metodo che controlla se l'utente è loggato
 */
WidgetUser.prototype.isLogged = function ( sender ) {
    var isLogged = 0;
    
    var request = $.ajax ({
        url: "/ajax/externalUser/Logged",
        type: "GET",
        async: false,
        dataType: "html"        
     });
     request.done( function( resp ) {
         isLogged = resp;
     });
     
     return isLogged;
};

/**
 * Metodo che gestisce il login
 */
WidgetUser.prototype.sendLogin = function ( sender ) {

    var that = this; 
    var login = 0;
    var data = $( sender ).closest( '[data-formLogin]' ).serialize();
    
    var loginEmail = $( sender ).closest( '[data-formLogin]' ).find( '#email' );
    var loginPassword = $( sender ).closest( '[data-formLogin]' ).find( '#password' );
    
    if ( loginPassword.val() == "" || loginEmail.val() == "") {
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( 'error' );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( 'Inserisci email e password');
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( 'error' );
        }, 5000 );
        
        return false;
    }
    
    var request = $.ajax ({
        url: "/ajax/externalUser/Login?"+data,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {
        login = resp;
        
        var parameters = new Array();   
        parameters['type'] = resp != 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = resp != 0 ? 'Login Effettuato con successo' : 'Login errato';
        
        
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( parameters['type'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( parameters['mex'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( parameters['type'] );
            if( resp != 0 ) {
                $ ('[data-widgetLogin], [data-boxLogin]').toggle();  
                window.location.href = '/';
            }
        }, 3000 );                         
        
    });
    
    return login;
};

/**
 * Metodo che gestisce la registrazione dell'utente
 */
WidgetUser.prototype.sendRegistration = function ( sender ) {
    var that = this;
    var error = 0;
    var data = $( sender ).closest( '[data-formRegistration]' ).serialize();
    
    var loginEmail = $( sender ).closest( '[data-formRegistration]' ).find( '#email2' );
    var loginPassword = $( sender ).closest( '[data-formRegistration]' ).find( '#password2' );
    var privacy = $( sender ).closest( '[data-formRegistration]' ).find( '#privacy' );
    
    if ( loginPassword.val() == "" || loginEmail.val() == "" || !privacy.is(':checked') ) {
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( 'error' );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( 'Inserisci email password, e consenso informativa privacy');
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( 'error' );
        }, 5000 );
        
        return false;
    }
    
    var request = $.ajax ({
        url: "/ajax/sendRegistration/externalUser?"+data,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( response ) {
        var type = 'error';
        
        if ( response == 1 ) {
            var msg = 'Registrazione avvenuta con successo';
            var type = 'success';                        
        }  
        
        if ( response == 0 ) {            
            var msg = 'Errore durante la Registrazione. Riprova!';            
        }
        
        if ( response == 2 ) {
            var msg = 'Errore durante la Registrazione. Indirizzo Mail già presente!'       
        }
        
        if ( response == 3 ) {
            var msg = 'Inserisci un indirizzo email valido!'       
        }
        
        var parameters = new Array();   
        parameters['type'] = type;
        parameters['layout'] = 'top';
        parameters['mex'] =  msg;
        
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( parameters['type'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( parameters['mex'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( parameters['type'] );
            if( resp == 1 ) {
                window.location.href = '/';
            }
        }, 3000 );           
//        if ( response == 1 ) {
//            setTimeout(function() {
//                bootbox.hideAll();    
//                window.location.href = '/';
//            }, 1500);
//        }
        
    });
};

/**
 * Metodo che apre il popUp per il login
 */
WidgetUser.prototype.openPopupLogin = function ( ) { 
    var params = { 
            type: 'custom', 
            title: 'ACCEDI' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formLogin" class="login-form" data-formLogin>\
                    <div class="form__row">\
                        <div>\
                            <input id="loginEmail" class="form__input-text form__input-text--m-top" type="email" name="loginEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div>\
                            <input id="loginPassword" class="form__input-text form__input-text--m-top" type="password" name="loginPassword" placeholder="Password" value="">\
                        </div>\
                        <label class="lblForgotPwd" data-forgotPwd="1" >Hai dimenticato la password?</label>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input id="button-login" class="button button--fill button--big" type="submit" data-defaultLogin value="Accedi">\
                            </div>\
                            <label class="lblRegister" data-register="1" >Non sei ancora registrato?</label>\
                        </div>\
                    </div>\
                </form>\
                <div>\
                    <input class="facebookLogin button button--fill button--big" data-FbLogin type="submit" value="Accedi con Fb">\
                </div>\
            </div>'
            };
    classModals.openModals( params );
    //
    //<div>\
    //    <input class="googleLogin button button--fill button--big" data-GoogleLogin type="submit" value="Accedi con Google">\
    //</div>\
};

/**
 * Metodo che apre il popUp per il reset della Pwd
 */
WidgetUser.prototype.openPopupForgotPwd = function ( ) { 
    var params = { 
            type: 'custom', 
            title: 'RESETTA PASSWORD' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formForgotPwd" class="reset-form" data-formForgotPwd>\
                    <div class="form__row">\
                        <div>\
                            <input id="resetEmail" class="form__input-text form__input-text--m-top" type="email" name="resetEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input id="button-reset" class="button button--fill button--big" type="submit" data-sendMail="1" value="Invia Mail">\
                            </div>\
                        </div>\
                    </div>\
                </form>\
            </div>'
            };
    classModals.openModals( params );
};

/**
 * Metodo che apre il popUp per la registrazione
 */
WidgetUser.prototype.openPopupRegistration = function ( teams ) {
    var option = '';
    var optionAge = '';
    
    if ( teams != null ) {
        $( teams ).each( function() {
            option+= '<option value="'+ this.id +'">'+this.name+'</option>';
        });
    }
    
    for( var x = 6; x < 100; x++ ) {
        optionAge+= '<option value="'+ x +'">'+x+'</option>';
    };
    
    var params = { 
            type: 'custom', 
            title: 'REGISTRATI' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formRegistration" onSubmit="return false" class="registration-form" data-formRegistration>\
                    <div class="form__row">\
                        <div>\
                            <input id="registrationName" type="text" name="registrationName" placeholder="Nome" required>\
                        </div>\
                        <div>\
                            <input id="registrationSurname" type="text" name="registrationSurname" placeholder="Cognome" value="">\
                        </div>\
                        <div>\
                            <input id="registrationEmail" type="email" name="registrationEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div>\
                            <input id="registrationPassword" type="password" name="registrationPassword" placeholder="Password" value="">\
                        </div>\
                        <div>\
                            <select id="registrationAge" class="selectIsTeam"  name="registrationAge">\
                            '+ optionAge +'\
                            </select>\
                        </div>\
                        <div>\
                            <input id="registrationCity" type="hidden" name="registrationCity" placeholder="Città" value="">\
                        </div>\
                        <div>\
                            <input id="registrationTeam" class="selectIsTeam" name="registrationTeam" value="0" type="hidden">\
                        </div>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input type="submit" id="button-registration" data-addUser="1" class="button button--fill button--big" value="Registrati">\
                            </div>\
                        </div>\
                    </div>\
                </form>\
            </div>'
            };
    classModals.openModals( params );
    $('.containerForm').closest('.modal-content').css('height', '600px');
};

/**
 * Metodo che riprende tutti i team per la scelta della sqadra per la registrazione
 */
WidgetUser.prototype.retrieveTeam = function () {
    var that = this;
    var request = $.ajax ({
            url: "/ajax/retrieve/team",
            type: "GET",
            async: true,
            dataType: "json"        
         });
         request.done( function( resp ) {
             if ( resp != null )
                that.openPopupRegistration(resp);             
        });
        return false;
};

/**
 * Metodo che permette il reset della pwd
 */
WidgetUser.prototype.forgotPwd = function ( sender ) {
    var that = this;
    var data = $( sender ).closest( '[data-formForgotPwd]' ).serialize();
    
    var request = $.ajax ({
            url: "/ajax/forgot/password?"+data,
            type: "POST",
            async: true,
            dataType: "json"        
         });
         request.done( function( resp ) {
             if ( resp != null ) {
                  var params = { 
                        type: 'custom', 
                        title: 'Calciomercato.it' ,
                        callbackModals: '\
                        <div class="containerMsg">\
                            <div class="containerMsg">\
                                <div>\
                                    <label>Ti abbiamo inviato una mail al tuo indirizzo</label>\
                                </div>\
                            </div>\
                        </div>'
                        };
                    classModals.openModals( params );        
            }
        });
        return false;
};

WidgetUser.prototype.userLogout = function ( sender ) {    
    
    var request = $.ajax ({
        url: "/logoutExternalUser",
        type: "POST",
        async: true,
        dataType: "html"        
        });
        request.done( function( resp ) {
            if (resp != false ) {
                window.location.href = '/';
            } else {
                return false;
            }

        });
        
    };

var widgetUser   = null;
widgetUser       = new WidgetUser()
;
