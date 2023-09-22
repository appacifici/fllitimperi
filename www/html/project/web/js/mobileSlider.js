
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
