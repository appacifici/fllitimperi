(function( $ ) {
	$( window ).on( 'load', function(){
		setTimeout( function() {
            initGridalicious();			   
            setSizeImg();
		}, 200 );
            if( isIE() == 9 ) {
                setTimeout(function() {
                    initGridalicious();			   
                    setSizeImg();
                }, 250 );
            }
            if( isIE() == 8 ) {
                $( '.gridalicious-item' ).addClass( 'noOpacity' );
            }
	});
})( jQuery );

$( window ).resize(function() {
    setTimeout(function() {
        setSizeImg();
    }, 201);
});

setSizeImg = function() {
    $( 'img').each( function() {
        $( this ).height( $( this ).attr( 'data-height' ) );
        $( this ).width( $( this ).attr( 'data-width' ) );
    });
};

initGridalicious = function ( widget, gridalicious ) {
    var gridalicious = typeof gridalicious == 'undefined' ? 'gridalicious' : gridalicious;
    var widget = typeof widget == 'undefined' ? '.widget' : widget;
    
    $('[data-toggle*="'+gridalicious+'"]').each(function()
    {
        var $that = $(this);
        $(this).find('.loading').remove().end()
        .find('.loaded').removeClass('hide2').end()
        .gridalicious(
        {
            gutter: $that.attr('data-gridalicious-gutter') ? parseInt($that.attr('data-gridalicious-gutter')) : 23, 
            width: $that.attr('data-gridalicious-width') ? parseInt($that.attr('data-gridalicious-width')) : 200,
            selector: $that.attr('data-gridalicious-selector') || widget
        });
    }); 
};