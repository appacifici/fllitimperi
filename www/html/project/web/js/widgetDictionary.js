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
widgetDictionary       = new WidgetDictionary();