widgetImageArticle = null;
$(function () {
    widgetImageArticle = new WidgetImageArticle();
});

/**
 * Classe per la gestione del widget ImageArticle
 */
var WidgetImageArticle = function () {
    this.widget                 = $( ".widget_ImageArticle" );
    this.widgetBody             = $( ".widget-body" );
    this.tabManageArticle       = $( '.tabManageArticle' );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetImageArticle.prototype.initListeners = function () {
    var that = this;
    this.page = 2;
    this.lastScroll = 0;
    this.lastResetLimit = false;
    
    this.scroll( 300 );

    // Ascoltatore sull' immagine della galleria
    $( 'body' ).on( 'click', '.widget-body img', function (e) {
        if ( $( this ).hasClass( 'priority' ) )
            $( this ).removeClass( 'priority' );
        
        $( this ).toggleClass( 'selected' ); 
    });
    
    // Ascoltatore sull'immagine del popup per selezionare l'immagine primaria
    $( 'body' ).on( 'click', '.priorityImgBox img', function (e) {
        $( '.priorityImgBox img' ).removeClass('selectPriorityImg');
        $( this ).toggleClass( 'selectPriorityImg' ); 
    });
    
    // Ascoltatore sul bottone per l'associazione dell'immagine all'articolo
    $( 'body' ).on( 'click', 'div[data-joinImg="1"]', function (e) {
        that.joinImgArticle();
        $( '.imgArticle').find('.selected' ).removeClass('selected');
    });
    
    // Ascoltatore sul bottone per la scelta dell'immagine prioritaria
    $( 'body' ).on( 'click', 'div[data-primary="1"]', function (e) {
        $( '.imgArticle').find('.selected' ).removeClass('selected');
        var imgs = '';
        $('.imgArticle').find('img').each(function(){
            imgs += this.outerHTML;
        });
        
        that.openPopup(imgs);
    });
    
    // Ascoltatore sul bottone per l'associazione dell'immagine all'articolo
    $( 'body' ).on( 'click', 'div[data-btnPrimary="1"]', function (e) {
        that.setPriority();
    });
    
    // Ascoltatore sul bottone per la rimozione dell'immagine all'articolo
    $( 'body' ).on( 'click', 'div[data-removeImg="1"]', function (e) {
        that.removeImgArticle();
        $( '.imgArticle').find('.selected' ).removeClass('selected');
    });
    
    
    $( 'div[data-resetSearch="1"]' ).click(function() {
        $( '.searchImgArticle').find('input').val('');
    });
    
    $( 'div[data-search="1"]').click(function() {
        that.lastScroll = 0;
        that.getImagesScroll( true );
    });
};

/**
 * Gestisce lo scroll completo della pagina e richiama le nuove immagini con ajax
 * @param {type} tollerance
 * @returns {undefined}
 */
WidgetImageArticle.prototype.scroll = function ( tollerance ) {
    var that = this;    
    var tollerance = typeof tollerance != 'undefined' ? tollerance : 300;
        
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        
//        console.info( ( $(window).scrollTop() + $(window).height() + tollerance ) +' > '+ $(document).height() +' && '+ $(document).height() +' != '+ that.lastScroll );        
        if( ( $(window).scrollTop() + $(window).height() + tollerance > $(document).height() ) && $(document).height() != that.lastScroll ) {                     
            that.lastScroll = $(document).height();
            
            $(that.widget).find('.plaseWait').css('visibility', 'visible');
            that.getImagesScroll( false );                                              
        }
    });
};

/**
 * Avvia la chiamata ajax per il recupero immagini
 * @param {type} $search
 * @returns {undefined}
 */
WidgetImageArticle.prototype.getImagesScroll = function ( resetLimit ) {
    var that = this;    
    
    var articleId = $( this.widget ).attr('data-article');
    var search = $( '.searchImgArticle' ).find( 'input' ).val() ;
    if( resetLimit ) {
        $( '.gallery').html('');
        that.page = 1;
    }
    
    this.lastResetLimit = resetLimit;
    
    var request = $.ajax ({
        url: "/admin/getInfiniteScroller/page="+that.page+"?articleId="+articleId+"&keywords="+search+"&resetLimit="+resetLimit,
        type: "GET",
        async: true,
        dataType: "html"        
     });
    request.done( function( resp ) {
        $( 'body' ).find( '.plaseWait').css( 'visibility', 'hidden');
        if( resp == '' )
            return;
        
        $( 'body' ).find( '.gallery').append( resp );
//        initGridalicious( '.widget', 'gridaliciousInfiniteScroll'+that.page );
        that.page++;
    });  
};

/**
 * Metodo che associale le immagini selezionate ad un articolo
 * @returns {undefined}
 */
WidgetImageArticle.prototype.joinImgArticle = function () {   
    var that = this;
    var articleId = $( this.widget ).attr('data-article');    
    var ids = '';
    // Recupero l'id di tutte le immagini selezionate
    $('.gallery img.selected').each(function(){
        ids += $( this ).attr('data-id') +',';
    });
    //Elimino la virgola dopo l'ultimo id
    ids = ids.substr( 0, ids.length -1 );    
    
    if( ids == '' )
        return false;    
    
    //Parte la chiamata ajax che aggiunge le img selezionate
    var request = $.ajax ({
        url: "/admin/addImageArticle/"+ids+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        var response = false;
        if( typeof resp.success != 'undefined' && resp.success.length > 0 ) {
            resp.success.forEach(function(item){
                $('.priority').removeAttr('data-priority');
                $('.priority').removeClass('priority');
                
                var clone = $( '.widget_ImageArticle .contentPriorityImage:last' ).clone();       
                $( clone ).find( 'img' ).attr( 'src', '/imagesArticleMedium/'+item.img ).attr( 'data-id', item.imgId );

                $('body').find('.widget_ImageArticle .imgArticle').prepend( clone );

                $('.widget_ImageArticle .contentPriorityImage div' ).addClass('hide');
                $('.widget_ImageArticle .imgArticle').find('img[data-id='+item.imgId+']').closest('.contentPriorityImage' ).find('div').removeClass('hide');
                $('.widget_ImageArticle .imgArticle').find('img[data-id='+item.imgId+']').closest('.contentPriorityImage' ).find('img').removeClass('hide');
                $('.widget_ImageArticle .imgArticle').find('img[data-id='+item.imgId+']').closest('.contentPriorityImage' ).removeClass('hide');
                
               
            });
            response = true;
        }
        
        
        var parameters = new Array();   
        parameters['mex'] = response ? 'Immagini associate correttamente' : 'Immagini già associate';
        parameters['layout'] = 'top';
        parameters['type'] =  response  ? 'success' : 'error';
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( parameters['mex'] );
        
        $('.gallery').find('.selected').removeClass('selected');
        
        
        // Se le immagini selezionate sono più di una apre una dialog per far saelezionare l'immagine prioritaria
        if ( typeof resp.success != 'undefined' && resp.success.length > 1 ) {
            var imgs = '';
            
            $('.imgArticle').find('img').each(function(){
                imgs += this.outerHTML;
            });
            
            that.openPopup(imgs);            
        }
    });
};

/**
 * Metodo che rimuove le immagini da un articolo
 * @returns {undefined}
 */
WidgetImageArticle.prototype.removeImgArticle = function () {
    var that = this;
    var parameters = new Array();
    this.prioprity = false;
    
    var img = $( '.imgArticle' ).find( 'img' ).size();
    
    if (img < 2) {
        parameters['mex'] = 'Non è possibile rimuovere la foto! Inserire prima l\'immagine sostitutiva' ;
        parameters['layout'] = 'top';
        parameters['type'] = 'error';
        classNotyfy.openNotyfy( parameters );
        return false;
    }
    
    var articleId = $( this.widget ).attr('data-article');
    
    var ids = '';
    // Recupero l'id di tutte le immagini selezionate
    $('.imgArticle img.selected').each(function(){            
        if($( this ).attr('data-priority') == 1 ) {
            parameters['mex'] = 'Si sta provando a rimuovere l\'immagine prioritaria. Selezionane prima un\' altra!' ;
            parameters['layout'] = 'top';
            parameters['type'] = 'error';
            classNotyfy.openNotyfy( parameters );
            $( this ).addClass('priority');
            return false;
        } else {
            ids += $( this ).attr('data-id') +',';
        }
    });
    
    //Elimino la virgola dopo l'ultimo id
    ids = ids.substr( 0, ids.length -1 );
        
    if( ids == '' )
        return false;
    
    
    //Parte la chiamata ajax che elimina le img selezionate
    var request = $.ajax ({
        url: "/admin/removeImageArticle/"+ids+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( resp.error ) {
            
        } else {
            if( resp.ids.length > 1 ) {
                resp.ids.forEach(function(item, index){ 
                    $('.imgArticle img[data-id='+item+']').remove();
                });
            } else {
                $('.imgArticle img[data-id='+resp.ids+']').remove();
            }
//            window.location.href = "/admin/manageArticle/"+articleId;
        }
        
        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( resp.msg );
    });
};

// Funzione che permette l'upload dell'immagine con l'iFrame come target
WidgetImageArticle.prototype.readResponseTargetIframe = function ( response, src, id ) { 
    var parameters = new Array();
    parameters['layout'] = 'top';
    
    if( response == 1 ) {
        parameters['type'] = 'success';
        parameters['mex'] = 'Immagine inserita correttamente';
        $('#myFormUploadImg')[0].reset();
        
        var clone = $( '.widget_ImageArticle .cloneImage' ).clone();
        
        $( clone ).find( 'img' ).attr( 'src', '/imagesArticleMedium/'+src ).attr( 'data-id', id );
        
//        $('body').find('.widget_ImageArticle .imgArticle').append('<img src="/imagesArticleMedium/'+src+'" data-id="'+id+'" alt="photo" />');
        
        console.info('eccomi');
        $('body').find('.widget_ImageArticle .imgArticle').prepend( clone );
        
        $('.widget_ImageArticle .contentPriorityImage div' ).addClass('hide');
        $('.widget_ImageArticle .imgArticle').find('img[data-id='+id+']').closest('.contentPriorityImage' ).removeClass('hide');
        $('.widget_ImageArticle .imgArticle').find('img[data-id='+id+']').closest('.contentPriorityImage' ).find('img').removeClass('hide');
        $('.widget_ImageArticle .imgArticle').find('img[data-id='+id+']').closest('.contentPriorityImage' ).find('div').removeClass('hide');
        
        
    } else if ( response == 2 ) {
        parameters['type'] = 'error';
        parameters['mex'] = 'Compilare tutti i campi';
    } else {
        parameters['type'] = 'error';
        parameters['mex'] = 'Errore durante il caricamento dell\'Immagine';
    }
    
    mainAdmin.speakSite( parameters['mex'] );
    classNotyfy.openNotyfy( parameters );    
    
};  

/**
 * Metodo che setta l'immagine prioritaria
 * @returns {undefined}
 */
WidgetImageArticle.prototype.setPriority = function () {
    var articleId = $( this.widget ).attr('data-article');
    var parameters = new Array();
    var id = null;
    $('.priorityImgBox img.selectPriorityImg').each(function(){
        id = $( this ).attr('data-id') +',';
    });
    
    if( id == null )
        return false;
    
    var request = $.ajax ({
        url: "/admin/setPriorityImageArticle/"+id+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
         var priorityId = null;
        if( typeof resp.success != 'undefined' )
            priorityId = resp.success.priorityId;
        
        bootbox.hideAll();
        
        
        if ( priorityId != null ) {
            $('.priority').removeAttr('data-priority');
            $('.priority').removeClass('priority');
            
            $('.imgArticle').find('img[data-id='+priorityId+']').addClass('priority');
            $('.imgArticle').find('img[data-id='+priorityId+']').attr('data-priority', 1);
            
            $('.contentPriorityImage div' ).addClass('hide');
            $('.imgArticle').find('img[data-id='+priorityId+']').closest('.contentPriorityImage' ).find('div').removeClass('hide');
        }

        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.success.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( parameters['mex'] );
    });
};

// Funzione che permette l'upload dell'immagine con l'iFrame come target
WidgetImageArticle.prototype.openPopup = function ( imgs ) { 
    var params = { 
            type: 'custom', 
            title: 'SCEGLI LA FOTO PRIMARIA' ,
            callbackModals: '\
            <div class="galleryPriority">\
                <div class="priorityImgBox">\
                    <div class="preview">'+ imgs + '</div>\
                    <div class="form-group">\
                        <div class="buttonDefault pull-right" data-btnPrimary="1">\
                            <div type="button" class="add" data-joinPrimary="1">Scegli Foto Prioritaria</div>\
                            <i class=" fa  fa-check-circle"></i>\
                        </div>\
                    </div>\
                </div>\
            </div>'
            };
    classModals.openModals( params );
            
    setTimeout( function() {
        $('.modal-dialog').css('width', '95%');
    } , 100 );
};