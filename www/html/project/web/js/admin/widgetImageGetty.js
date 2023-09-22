WidgetImageArticleGetty = null;
$(function () {
    WidgetImageArticleGetty = new WidgetImageArticleGetty();
});

/**
 * Classe per la gestione del widget ImageArticle
 */
var WidgetImageArticleGetty = function () {
    this.widgetGetty            = $( ".widget_ImageArticleGetty" );
    this.widgetBody             = $( ".widget-body" );
    this.tabManageArticle       = $( '.tabManageArticle' );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetImageArticleGetty.prototype.initListeners = function () {
    var that = this;
    this.page = 2;
    this.lastScroll = 0;

    this.tabManageArticle.on('click', function (){
        setTimeout( function() {
            initGridalicious();
        } , 100 );
    });
    
    $( 'body' ).on( 'click', '.widget-body img', function ( e ) {
//        $( e ).toggleClass( 'selected' );
        that.opeUrlGetty( e );
    });
    
    $( 'body' ).on( 'click', '.btnSearch', function ( e ) { 
        
        var searchString = $( this ).closest('.searchForm').find('.inputSearch').val();
        
        $( 'body').find( '.galleryGetty').html('');
        
        $( 'body' ).find('.plaseWaitGetty').css('visibility', 'visible');
        
        var request = $.ajax ({
                url: "/admin/getInfiniteScrollerGetty/page=0/"+searchString,
                type: "GET",
                async: true,
                dataType: "html"        
             });
            request.done( function( resp ) {
                $( 'body' ).find( '.plaseWaitGetty').css( 'visibility', 'hidden');
                $( 'body' ).find( '.fade' ).remove();
                if( resp == '' )
                    return;
                $( that.widgetGetty ).find( '.galleryGetty' ).html( resp );
                initGridalicious();
                that.page++;
            });
            
            e.preventDefault();
    });
    
    this.scroll();
    
//    $( 'body' ).on( 'click', '.btnAddGetty', function (e) {
//        that.insertImg();
//    });
};

WidgetImageArticleGetty.prototype.scroll = function ( tollerance ) {
    var that = this;    
    var tollerance = typeof tollerance != 'undefined' ? tollerance : 200;
    
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        
        if( ( $(window).scrollTop() + $(window).height() + tollerance > $(document).height() ) && $(document).height() != that.lastScroll ) {                     
            that.lastScroll = $(document).height();
            
            var searchString = $( 'body' ).find('.searchForm').find('.inputSearch').val();
            searchString = searchString != '' ? '/'+searchString : '';
            
            $('body').find('.plaseWaitGetty').css('visibility', 'visible');

            var request = $.ajax ({
                url: "/admin/getInfiniteScrollerGetty/page="+that.page+searchString,
                type: "GET",
                async: true,
                dataType: "html"        
             });
            request.done( function( resp ) {
                $( 'body' ).find( '.plaseWait').css( 'visibility', 'hidden');
                if( resp == '' )
                    return;
                $( 'body' ).find( '.galleryGetty').append( resp );
                initGridalicious( '.widget', 'gridaliciousInfiniteScroll'+that.page );
                that.page++;

            });                 
        } 
    });
};

WidgetImageArticleGetty.prototype.insertImg = function () {
    var data = [];
    var params = {}; 
    
    var x = 0;
    $('.widget_ImageArticleGetty img.selected').each(function(){
        params[x] = {};
        params[x].src = $( this ).attr('src');
        params[x].title = $( this ).attr('title');    
        x++;
    });
    
    data.push( { 'name' : 'img' , 'value' : JSON.stringify( params ) } );

    //Parte la chiamata ajax che inserisce nel DB le img selezionate
    var request = $.ajax ({
        url: "/admin/addImg",
        type: "POST",
        data: data,
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( resp.error ) {
            alert(resp.msg);
        } else {
            alert(resp.msg);
        }
    });
};

WidgetImageArticleGetty.prototype.joinImgArticle = function () {
    
    var articleId = $( this.widget ).attr('data-article');
    
    var ids = '';
    // Recupero l'id di tutte le immagini selezionate
    $('.widget_ImageArticleGetty img.selected').each(function(){
        ids += $( this ).attr('data-id') +',';
    });
    //Elimino la virgola dopo l'ultimo id
    ids = ids.substr( 0, ids.length -1 );
    //Parte la chiamata ajax che aggiunge le img selezionate
    var request = $.ajax ({
        url: "/admin/addImageArticle/"+ids+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( resp.error ) {
            alert(resp.msg);
        } else {
            alert(resp.msg);
            window.location.href = "/admin/manageArticle/"+articleId;
        }
    });
};


//Metodo che genera la url per fare il redirect su getty images
WidgetImageArticleGetty.prototype.opeUrlGetty = function ( sender ) {
    var src = sender.srcElement.src;
    var id = src.match( /(?:\d*\.)?\d+/g );
    //URL GETTY IMMAGINE PER DOWNLOAD
    //http://www.gettyimages.it/license/514350966
    var url = 'http://www.gettyimages.it/license/'+id[0];
    window.open(url, '_blank');
    
};