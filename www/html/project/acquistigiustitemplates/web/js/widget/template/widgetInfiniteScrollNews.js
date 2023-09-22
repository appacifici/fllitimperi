

/**
 * Classe per la gestione del widget ImageArticle
 */
var WidgetInfiniteScrollNews = function () {
//    this.widget            = $( ".widget_PostGrid" );
    this.widget            = $( ".widget_CategoriesHome, [data-infiniteScroll]" );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetInfiniteScrollNews.prototype.initListeners = function () {
    var that        = this;
    this.page       = typeof page != 'undefined' && page != '' ? parseInt(page)+1 : 2;
    this.pageScrollUp = this.page;
    this.pageScrollIndexes = new Array();
    this.lock       = false;
    this.lastScroll = 0;   
    this.scroll( 1000 );
    
    //determina il numero di link da spengre prima di quello attivo dalla variabile get page
    this.offsetLinkActive = isMobile ? 3 : 10;
    
    this.wItemsLi = 0; $( '.itemLinkPagination a' ).each(function() { that.wItemsLi+=$( this ).outerWidth(); });
    
    this.hideElement = false;
    if( this.wItemsLi > $( '.post-pagination' ).outerWidth()  ) {
        this.hideElement = true;
    }
    
    window.onpopstate = function (event) {
        if (event.state) {
          
        } else {                        
            that.lock = true;   
            
            var dataSearchPage = window.location.search;
            var dataSearch =  that.pageScrollIndexes[dataSearchPage.replace('?page=', '')];
            if( typeof dataSearch != 'undefined' ) {
                
                $('html, body').animate({
                    scrollTop: dataSearch['min']
                }, 1000, function() {
                    that.lock = false;  
                    console.info('sblocco');
                });                
            }
          
          
        }
    };
    
    
//    $( '.itemLinkPagination:not(".hideItem")' ).each(function( index ) { if(index < parseInt(page)-parseInt(that.offsetLinkActive) ) $( this ).addClass('hideItem') });
};

WidgetInfiniteScrollNews.prototype.scroll = function ( tollerance ) {
    var that = this;    
    var tollerance = typeof tollerance != 'undefined' ? tollerance : 400;
        
    $(window).scroll(function (event) {
        
        var scroll = $(window).scrollTop();
        
        if( that.lock )
            return false;
        
        console.info('event');
        
        if( ( $(window).scrollTop() + $(window).height() + tollerance > $(document).height() ) && $(document).height() != that.lastScroll ) {                     
            that.lastScroll = $(document).height();
            
            if( typeof that.pageScrollIndexes[that.page] == 'undefined' ) {
                that.pageScrollIndexes[that.page] = new Array();  
            }
            if( typeof that.pageScrollIndexes[that.page-1] == 'undefined' ) {
                that.pageScrollIndexes[that.page-1] = new Array();  
            }
            
            if( that.page == 2) {
                that.pageScrollIndexes[that.page-1]['min'] = 0;
            }
            
            that.pageScrollIndexes[that.page -1 ]['max'] = that.lastScroll -1;
            that.pageScrollIndexes[that.page]['min'] = that.lastScroll;            
            
            that.lock = true;
            $('.plaseWait').show();
            
            var searchUrl = window.location.search;            
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+[\&]/g,"");
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+/g,"");
            searchUrl = searchUrl.replace('?','');
            
            var pathNameUrl = window.location.pathname
            pathNameUrl = pathNameUrl.replace(/[\?\&]page=[0-9]+/g,"");
            
            
            
            if( searchUrl!= '' && searchUrl!= 0 )
                var urlAjax = "/news/getInfiniteScrollerListNews/page="+that.page+"?uri="+pathNameUrl+'&'+searchUrl;
            else
                var urlAjax = "/news/getInfiniteScrollerListNews/page="+that.page+"?uri="+pathNameUrl;
            
            var request = $.ajax ({
                url: urlAjax,
                type: "GET",
                async: true,
                dataType: "html"        
             });
            request.done( function( resp ) {                
                that.lock = false;
                
                $('.plaseWait').hide();
                if( resp == '' )
                    return;
                
                var reloadPage = that.page;
//                $('.widget_PostGrid:last-child').after( resp );
                $('[data-infiniteScroll]').last().after( resp );
                
                
                var reloadPage = that.page;
                                
                                
                if( typeof imagesLoaded == 'function' && !isMobile ) {   
                    var $masonry = $('.post-grid--masonry-page-'+reloadPage).imagesLoaded( function() {
                    $masonry.isotope({
                      itemSelector: '.post-grid__item',
                      layoutMode: 'masonry',
                      percentPosition: true,
                      masonry: {
                        columnWidth: '.post-grid__item'
                      }
                    }); });
                }
                
                if( searchUrl != '' && searchUrl != 0 )
                    window.history.pushState("", '', pathNameUrl+"?page="+that.page+"&"+searchUrl );
                else
                    window.history.pushState("", '', pathNameUrl+"?page="+that.page );      
                
                
                
                var maxPageHtml = parseInt( $( '.itemLinkPagination:nth-child('+$( '.itemLinkPagination' ).length+') a' ).html() ) +1 ;
                console.info( ( maxPageHtml  +'=='+ that.page ) );
                
                //Aggiunge il nuovo link alla paginazione runtime per l'utente
                if(  maxPageHtml == that.page && lastPagePagination > that.page) {
                    var newLinkPage = maxPageHtml + 1;
                    var newItem = $( '.itemLinkPagination:nth-child(2)' ).clone();                
                    
                    if( searchUrl != '' && searchUrl != 0 )
                        $( newItem ).find( 'a').attr( 'href', pathNameUrl+"?page="+newLinkPage+"&"+searchUrl );
                    else
                        $( newItem ).find( 'a').attr( 'href', pathNameUrl+"?page="+newLinkPage );
                    
                    $( newItem ).find( 'a' ).html( newLinkPage );
                    $( newItem ).removeClass('hideItem');
                    $( newItem ).insertBefore( '.post-pagination #pagination .nextPagination' );
                    
                    
                    that.wItemsLi = 0; $( '.itemLinkPagination a' ).each(function() { that.wItemsLi+=$( this ).outerWidth(); });                    
                    if( that.wItemsLi > $( '.post-pagination' ).outerWidth()  ) {
                        that.hideElement = true;
                    }
                }
                
                $( '.itemLinkPagination' ).removeClass( 'active' );
//                $( '.itemLinkPagination:nth-child('+(parseInt(that.page))+')' ).addClass('active');
                
                $( '.itemLinkPagination a' ).each(function( index ) { 
                    if( parseInt( $( this ).html()) == parseInt(that.page)) {   
                        $( this ).closest( '.itemLinkPagination').addClass('active') ;
                    }
                });   
                
                //Nasconde il prima link 
                if( that.hideElement ) {
                    $( '.itemLinkPagination:not(".hideItem")' ).each(function( index ) { if(index != 0) return false; $( this ).addClass('hideItem') });                
                }
                
                that.page++;
                that.pageScrollUp = that.page;                
            });                 
        } else if( $(window).scrollTop() + $(window).height() + tollerance < that.lastScroll ) {
            that.getPageUp( tollerance );
        }
        
    });
};

WidgetInfiniteScrollNews.prototype.getPageUp = function ( tollerance) {
    var that = this;
    var positionY = $(window).scrollTop() + $(window).height() + tollerance;    
    
    for( var key in that.pageScrollIndexes ) {
       var min = typeof that.pageScrollIndexes[key]['min'] != 'undefined' ? that.pageScrollIndexes[key]['min'] : 0;
       var max = typeof that.pageScrollIndexes[key]['max'] != 'undefined' ? that.pageScrollIndexes[key]['max'] : false;
       
        if( max && positionY > min && positionY < max) {        
            var searchUrl = window.location.search;            
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+[\&]/g,"");
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+/g,"");
            searchUrl = searchUrl.replace('?','');
            
            var pathNameUrl = window.location.pathname;
            pathNameUrl = pathNameUrl.replace(/[\?\&]page=[0-9]+/g,"");    
            
            if( window.location.search.indexOf( 'page='+key ) == '-1' ) {                
                
                 if( searchUrl != '' && searchUrl != 0 ) 
                    window.history.pushState("", '', pathNameUrl+"?page="+key+"&"+searchUrl );
                else
                    window.history.pushState("", '', pathNameUrl+"?page="+key );
//                
                $( '.itemLinkPagination' ).removeClass( 'active' );
                $( '.itemLinkPagination a' ).each(function( index ) { 
                    if( parseInt( $( this ).html()) == parseInt(key )) {   
                        $( this ).closest( '.itemLinkPagination').addClass('active') ;
                    }
                });   
                
                if( this.hideElement )
                    $( '.itemLinkPagination.hideItem' ).each(function( index ) { if(index == $( '.itemLinkPagination.hideItem' ).length-1 ) $( this ).removeClass('hideItem') });                
                
            }
        };
    }
};

String.prototype.replaceAt=function(index, replacement) {
    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
};


widgetInfiniteScrollNews = null;
WidgetInfiniteScrollNews = new WidgetInfiniteScrollNews();