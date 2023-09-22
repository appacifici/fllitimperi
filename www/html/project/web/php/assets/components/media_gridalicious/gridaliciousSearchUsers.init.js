(function($){
	$(window).on('load', function(){
		setTimeout(function() { initGridalicious();	setSizeImg(); }, 200 );
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
})(jQuery);

$( window ).resize(function() {
    setTimeout(function() {
        setSizeImg();
    }, 250);
});

setSizeImg = function() {
    $( 'img' ).each( function() {
        $( this ).height( $( this ).attr( 'data-height' ) );
        $( this ).width( $( this ).attr( 'data-width' ) );
    });
};

initGridalicious = function () {
    $('[data-toggle*="gridalicious"]').each(function()
    {
        var $that = $(this);
        $(this).find('.loading').remove().end()
        .find('.loaded').removeClass('hide2').end()
        .gridalicious(
        {
            gutter: 21, 
            width: 167,
            //height: 400,
            selector: $that.attr('data-gridalicious-selector') || '.widget',
        });
    }); 
    setTimeout(function() { utility.lazy( ".widgetUsers" );
        
    }, 200 );
    
};