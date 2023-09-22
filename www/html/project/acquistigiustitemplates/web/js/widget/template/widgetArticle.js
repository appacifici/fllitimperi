
/**
 * Classe per la gestione della homepage
 */
var WidgetArticle = function () {
    var that = this;
    this.initListeners();
};    

    
/**
 * Metodo che avvia gli ascoltatori
 */
WidgetArticle.prototype.initListeners = function () {
    var that                = this;       
    this.indexScroll        = 1;    
    this.indexScrollOrizontal        = 1;    
    this.lastIndexScroll    = 1;    
    this.scrollEnabled      = true;    
       
       
    var maxHeight = 0;
    $( '[data-bullets]' ).each(function() {
        if( $( this ).height() > maxHeight ) {
            maxHeight = $( this ).height();
        }
    });
    $( '[data-bullets]').height( maxHeight );  
       
    
    if( typeof $('[data-anchors-news]').position() == 'undefined' ) {
        return;
    }   
       
    $('[data-anchors-news] [data-anchor-key]').click( function() {
        that.scrollEnabled = false;
        $('[data-anchors-news] [data-anchor-key]').each(function() {
            $( this ).removeClass( 'active' );
        });
        var p = this;
        setTimeout(function() {
            $( p ).toggleClass( 'active' );
            that.lastIndexScroll = $( p ).attr('data-anchor-key');
            that.scrollEnabled = true;    
        }, 200 );        
    });
    
    
    this.anchors(); 
    
    $('[data-anchors-news] [data-anchor-action]' ).click( function() {
        that.scrollAnchors( this );
    });
        
       
};


/**
 * Metodo che effettua lo scroll orizzontale delle ancore al click sui botyoni + o -
 * @param {type} sender
 * @returns {undefined}
 */
WidgetArticle.prototype.scrollAnchors = function ( sender ) {            
    var type = $( sender ).attr('data-anchor-action');
    if( type == 'back' && this.indexScrollOrizontal == 1 )
        return;
    
    if( type == 'next' && this.indexScrollOrizontal == $('[data-anchors-news] [data-anchor-key]').length )
        return;            
        
    $('[data-anchors-news] [data-anchor-key]').removeClass('show');
    $('[data-anchors-news] [data-anchor-key]').addClass('hide');
    
    switch( type ) {
        case 'back':
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').removeClass('hide');
            this.indexScrollOrizontal--;
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').removeClass('hide');
            
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal-1)+'"]').addClass('show');
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal-1)+'"]').removeClass('hide');
        break;
        case 'next':
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').removeClass('hide');
            this.indexScrollOrizontal++;
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').removeClass('hide');
            
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal+1)+'"]').addClass('show');
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal+1)+'"]').removeClass('hide');
        break;
    }            
    
};


WidgetArticle.prototype.scrollAnchorsAuto = function () {      
//    console.info(this.lastIndexScroll+' '+this.indexScrollOrizontal);
    
    if( this.lastIndexScroll == this.indexScrollOrizontal ) {
        return;
    }
    var type = this.lastIndexScroll < this.indexScrollOrizontal ? 'next' : 'back';
    
    $('[data-anchors-news] [data-anchor-key]').removeClass('show');
    $('[data-anchors-news] [data-anchor-key]').addClass('hide');
                                    
    
    //Infamata per forzare attivazione prime 3 ancore quanto utente torna indietro  
    if( this.indexScrollOrizontal < 3 ) {
        $('[data-anchors-news] [data-anchor-key="1"]').addClass('show');
        $('[data-anchors-news] [data-anchor-key="2"]').addClass('show');
//        $('[data-anchors-news] [data-anchor-key="3"]').addClass('show');
        $('[data-anchors-news] [data-anchor-key="1"]').removeClass('hide');
        $('[data-anchors-news] [data-anchor-key="2"]').removeClass('hide');
//        $('[data-anchors-news] [data-anchor-key="3"]').removeClass('hide');        
    }     
    
    switch( type ) {
        case 'back':                       
//            console.info('eccomi: '+ this.lastIndexScroll+' <'+ this.indexScrollOrizontal);
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').removeClass('hide');
            
            this.indexScrollOrizontal--;
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').addClass('show');                        
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').removeClass('hide');            
            
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal-1)+'"]').addClass('show');
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal-1)+'"]').removeClass('hide');        
            
        break;
        case 'next':
//            console.info('eccomi2');
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+this.indexScrollOrizontal+'"]').removeClass('hide');
            this.indexScrollOrizontal++;
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').addClass('show');
            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal)+'"]').removeClass('hide');
            
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal+1)+'"]').addClass('show');
//            $('[data-anchors-news] [data-anchor-key="'+(this.indexScrollOrizontal+1)+'"]').removeClass('hide');
        break;      
    } 
};

/**
 * Metodo che fixa il menu delle ancora in posizione top allo scroll
 * @returns {undefined}
 */
WidgetArticle.prototype.anchors = function () {    
    var that = this;
    
    if( typeof $('[data-anchors-news]').position() == 'undefined' ) {
        return;
    }
    
    var navHeight = $('[data-anchors-news]').position().top + $('[data-anchors-news]').outerHeight() + 20;
    if( typeof $('[data-modelsRanking]').position() != 'undefined' ) {
        var modelsRankingHeight = $('[data-modelsRanking]').position().top + $('[data-modelsRanking]').outerHeight() - 50;
    } else {
        var modelsRankingHeight = 50000;
    }
    var id = false;
    window.onscroll = function (e) {      

        if( !that.scrollEnabled )
            return;    
    
        if( $(window).scrollTop() > navHeight ) {
            $('[data-anchors-news]').addClass('fixed');
        } else if ( $(window).scrollTop() < navHeight ) {
            $('[data-anchors-news]').removeClass('fixed');
        }
        
        if( $(window).width() > 1000 ) { 
            if( $(window).scrollTop() > modelsRankingHeight ) {
                $('[data-modelsRanking]').addClass('fixed');
            } else if ( $(window).scrollTop() < navHeight ) {
                $('[data-modelsRanking]').removeClass('fixed');
            }
        }                
        
        $('[data-anchors-news] li').each(function() {
            if( $( this ).find( 'a' ).attr( 'href' ) != id  )
                $( this ).removeClass( 'active' );
        });
        

            $( '.body h2, .body h3' ).each( function( index ) {            
                var isElementInView = Utils.isElementInView($( this), false);
                if( isElementInView ) {       
                    
                    
                    
                    id = '#'+$( this ).attr('id');                    
                    $('[href="'+id+'"]').closest( 'li' ).addClass( 'active' );
                    
                    
                    
                    that.indexScroll = ( $('[href="'+id+'"]').closest( 'li' ).attr('data-anchor-key') );   
//                    console.info(that.indexScroll+' '+id);
                    setScrollAuto = true;                   
                    
                    if( that.lastIndexScroll != that.indexScroll ) {
//                        console.info('entro');
//                        console.info('LASTindexScroll==>'+that.lastIndexScroll);
                        $('[data-anchors-news] [data-anchor-key="'+that.lastIndexScroll+'"]').removeClass( 'active' );
                        that.indexScrollOrizontal = that.indexScroll;
                        that.scrollAnchorsAuto();
                        that.lastIndexScroll = that.indexScroll;                        
                        
                    }
                                
                    return false;
                }                   
            });   


//        }, 250));
        
    };    
};

var widgetArticle   = null;
widgetArticle       = new WidgetArticle();




/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
//this.page.identifier = ; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

//setTimeout( function() {
//    (function() { // DON'T EDIT BELOW THIS LINE
//    var d = document, s = d.createElement('script');
//    s.src = 'https://acquistigiusti.disqus.com/embed.js';
//    s.setAttribute('data-timestamp', +new Date());
//    (d.head || d.body).appendChild(s);
//    })();
//}, 2000 );