
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
//});