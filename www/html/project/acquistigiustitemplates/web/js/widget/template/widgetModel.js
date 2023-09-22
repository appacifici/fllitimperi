
/**
 * Classe per la gestione della homepage
 */
var WidgetModel = function () {
    var that = this;
    this.initListeners();
};    

    
/**
 * Metodo che avvia gli ascoltatori
 */
WidgetModel.prototype.initListeners = function () {
    var that = this;       
    this.fixedElements();  
    
    
    $( '#disqus_thread_open' ).click( function() {
        $( '#disqus_thread' ).css('height', 'auto');
        $( '#disqus_thread_open' ).hide();
    });
    
    $( '[data-buttonComparisonModel]' ).click(function() {
        that.openComparisonListModel( this );
        that.blockScroll();
    });
    
    $( 'body' ).on( 'click', '[data-close]', function() {
        $( '[data-overlaybuttonListComparisonModel]' ).hide();
        $( '[data-op]' ).css( 'opacity', '1');
        $('html, body').css({
            overflow: 'auto',
            height: 'auto'
        });
    });
    
    
    
    $( 'body' ).on('click', '[data-overlaybuttonListComparisonModel] [data-itemModel]', function() {
        $( this ).toggleClass( 'selected' );
        $( this ).find('[data-activeItem]').toggle();
    });
    
    
    $( 'body' ).on('click', '[data-overlaybuttonListComparisonModel] [data-sendComparisonModels]', function() {
        var url = '';
        $( '[data-overlaybuttonListComparisonModel] .selected' ).each(function() {            
            url += $( this ).attr('data-itemModel')+',';
        });
        if( url == '' ) {
            alert( 'Seleziona i modelli da comparare' );
            return false;
        }
        window.location.href = '/comparazione/'+url.substr( 0, ( url.length -1 ) );
    });
    
};

WidgetModel.prototype.blockScroll = function ( sender ) {
    if( $( window ).width() >= 10 ) {
        if( $( '[data-buttonComparisonModel]' ).is(":visible") ) {
            $( '[data-op]' ).css( 'opacity', '0.3');
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

/**
 * Apre la lista dei modelli da comparare
 * @returns {undefined}
 */
WidgetModel.prototype.openComparisonListModel = function ( sender ) {   
    $( '[data-overlaybuttonListComparisonModel]' ).show();
    
    var subcategory = $( sender ).attr( 'data-subcategory' );
    var typology    = $( sender ).attr( 'data-typology' );
    
    var request = $.ajax ({
        url: "/openComparisonListModel?subcategory="+subcategory+"&typology="+typology,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {
        $( '[data-overlaybuttonListComparisonModel]').html( resp );
    });
};


/**
 * Metodo che fixa il menu delle ancora in posizione top allo scroll
 * @returns {undefined}
 */
WidgetModel.prototype.fixedElements = function () {   

    var navHeight = $('[data-model-price]').position().top ;
    var modeComparisonHeight = $('[data-modelComparisonPrices]').position().top + $('[data-modelComparisonPrices]').outerHeight() ;
    var id = false;
    
    
    
    window.onscroll = function (e) {            
        if( $( window ).width() > 500 || $('[data-modelComparisonPrices]').hasClass('groupingProduct') ) {
            if( $(window).scrollTop() > navHeight ) {
                $('[data-model-price]').addClass('fixed');            
                $('[data-model-price] [data-disabled]').html( $('[data-model-name]').html()+' <button>Vedi Offerta</button>' );

            } else if ( $(window).scrollTop() < navHeight ) {
                $('[data-model-price]').removeClass('fixed');
                $('[data-model-price] [data-disabled]').html( '' );            
            }    
        }

            //se non è la grafica raggruppata per modelli
            if( !$('[data-modelComparisonPrices]').hasClass('groupingProduct') ) {
                if( $(window).scrollTop() > modeComparisonHeight ) {            
                    $('[data-modelComparisonPrices]').addClass('fixed');
                } else if ( $(window).scrollTop() < navHeight ) {            
                    $('[data-modelComparisonPrices]').removeClass('fixed');
                }                               
            }
        
    };    
};

var widgetModel   = null;
widgetModel       = new WidgetModel();



//
///**
//*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
//*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
//
//var disqus_config = function () {
//this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
////this.page.identifier = ; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
//};
//
//setTimeout( function() {
//    (function() { // DON'T EDIT BELOW THIS LINE
//    var d = document, s = d.createElement('script');
//    s.src = 'https://acquistigiusti.disqus.com/embed.js';
//    s.setAttribute('data-timestamp', +new Date());
//    (d.head || d.body).appendChild(s);
//    })();
//}, 2000 );
//

                            
