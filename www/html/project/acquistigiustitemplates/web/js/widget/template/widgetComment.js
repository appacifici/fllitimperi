/**
 * Classe per la gestione dei commenti
 */
var WidgetComment = function () {
    var that = this;
    this.initListeners();
};

/**
 * Metodo che gestisce l'inserimento del commento e la consecutiva stampa in pagina
 */
WidgetComment.prototype.addComment = function ( ) {
    // Recupero l'id dell'articolo
    var articleId = $('[data-id]').attr('data-id');
    var text = $('[data-msg="1"]').val();
    
    var request = $.ajax ({
            url: "/ajax/addComment/"+articleId+"/"+text,
            type: "GET",
            async: true,
            dataType: "html"        
         });
         request.done( function( resp ) {
            if ( $('[data-msg="1"]').hasClass('redBorder') )
                $('[data-msg="1"]').removeClass('redBorder');
             
            $('[data-msg="1"]').val('');
            if ( resp != 0 ) {
                var totComment = $('.widget_Comment').find('.post-comments').find('span').text();
                if ( totComment != "" ) {
                    $('.widget_Comment').find('.post-comments').find('span').text(parseInt(totComment)+1);
                    
                    $('.widget_Comment').find('.post-comments').removeClass('tot_0');
                    $('.widget_Comment').find('.post-comments').addClass('tot_1');
                }
                $( '.comments' ).prepend( resp );
            }
        });
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetComment.prototype.initListeners = function () {
    var that = this;       
    
    // al click faccio partire il flusso per i commenti
    $( 'body' ).on( 'click', '[data-submitcomment="1"]', function ( e ) {
        if ( $('[data-msg="1"]').val() == "" ) {
            $('[data-msg="1"]').addClass('redBorder');
            return false;
        }
        
        if (widgetUser.isLogged() != 1) {
            widgetUser.openPopupLogin();
        } else {
            if( $('[data-msg="1"]').hasClass('redBorder') )
                $('[data-msg="1"]').removeClass('redBorder');
            
            that.addComment();
        }
        
    });
};

var widgetComment   = null;
widgetComment       = new WidgetComment();