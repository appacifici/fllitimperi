jQuery.fn.extend({
    customSerialize: function() {
      var form =  '<form>'+$(this).html()+'</form>';
      return $( form ).serialize();
    },
    customSerializeArray: function() {
      var form =  '<form>'+$(this).html()+'</form>';
      return $( form ).serializeArray();
    }
});

//window.location.href = "http://m.alebrunch-chedonna.it/app_dev.php/news/3/care_mamme_lavoratrici_ecco_10_trucchi_per_organizzare_la_casa"
;

/**
 * Classe per la gestione del widget ImageArticle
 */
var ManagerLinks = function () {    
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
ManagerLinks.prototype.initListeners = function () {
    var that = this;
    $( 'body' ).on( 'click', '[data-action="urlCopy"]', function() {
        that.openCopyLink( this );
    });
    
    $( 'body' ).on( 'click', '[data-ln]', function() {
        that.openJsLink( this);
    });
    $( 'body' ).on( 'click', '[lgt]', function() {
        that.openJsLink( this);
    });
};

ManagerLinks.prototype.openJsLink = function ( sender ) {    
    
    var a = $( sender ).attr( 'lgt' ).substr( 5 );
    var b = a.substr( 0, ( a.length - 5 ) ); b;
    
    if( $( sender ).attr( 'target' ) == '_blank')
        window.open( atob( b ), '_blank');
    else
        window.location.href = atob( b );    
};

/**
 * Apre il link recuperandolo da un figlio de contenitore padre
 * @param {type} sender
 * @returns {undefined}
 */
ManagerLinks.prototype.openCopyLink = function ( sender ) {
    window.location.href = $( sender ).closest( '[data-urlCopyFather]' ).find( '[data-urlCopy]' ).attr( 'href' );
};


managerLinks = null;
managerLinks = new ManagerLinks();

;
var Core = null;

;
(function ($) {
    "use strict";

    $.fn.exists = function () {
        return this.length > 0;
    };

    var $template_var = $('body').attr('class'),
            $color_primary = '#ffdc11',
            $main_nav = $('.main-nav'),
            $post_fitRows = $('.post-grid--fitRows'),
            $post_masonry = $('.post-grid--masonry'),
            $post_masonry_filter = $('.post-grid--masonry-filter'),
            $slick_featured_slider = $('.posts--slider-featured'),
            $slick_featured_carousel = $('.featured-carousel'),
            $slick_video_carousel = $('.video-carousel'),
            $slick_team_roster = $('.team-roster--slider'),
            $slick_awards = $('.awards--slider'),
            $slick_player_info = $('.player-info'),
            $slick_product = $('.product__slider'),
            $slick_product_soccer = $('.product__slider-soccer'),
            $slick_team_roster_card = $('.team-roster--card-slider'),
            $slick_team_roster_case = $('.team-roster--case-slider'),
            $slick_hero_slider = $('.hero-slider'),
            $content_filter = $('.content-filter'),
            $marquee = $('.marquee')
            ;

    if ($template_var == 'template-soccer') {
        $color_primary = '#1892ed';
    } else if ($template_var == 'template-football') {
        $color_primary = '#f92552';
    }

    Core = {

        initialize: function () {
            var that = this;
            this.headerNav();//menu dx
            this.SlickCarousel();//carosello piccolo
            this.InitSearch();

            setTimeout(function () {
                that.isotope();
            }, 100);
            setTimeout(function () {
                that.InitHeroSlider();//carosello Grande
            }, 5000);

        },

        InitSearch: function () {
            $('.searchArticlesIcon').click(
                    function (event) {
                        $('.formSearchArticles').toggle();
                        event.preventDefault();
                        event.stopPropagation();
                    }
            );
            $('.searchArticlesInput, .searchArticleButton, .formSearchArticles select').click(
                    function (event) {
//                event.preventDefault();
                        event.stopPropagation();
                    }
            );


            $('body').click(
                    function () {
                        if ($('.formSearchArticles').css('display') == 'block')
                            $('.formSearchArticles').toggle();
                    }
            );
        },

        headerNav: function () {
            if ($main_nav.exists()) {

                var $top_nav = $('.nav-account'),
                        $top_nav_li = $('.nav-account > li'),
                        $social = $('.social-links--main-nav'),
                        $info_nav_li = $('.info-block--header > li'),
                        $wrapper = $('.site-wrapper'),
                        $nav_list = $('.main-nav__list'),
                        $nav_list_li = $('.main-nav__list > li'),
                        $toggle_btn = $('#header-mobile__toggle'),
                        $pushy_btn = $('.pushy-panel__toggle');

                if (isMobile) {
                    // Clone Search Form
                    var $header_search_form = $('.header-search-form').clone();
                    $('#header-mobile').append($header_search_form);

                    // Clone Shopping Cart to Mobile Menu
                    var $shop_cart = $('.info-block__item--shopping-cart > .info-block__link-wrapper').clone();
                    $shop_cart.appendTo($nav_list).wrap('<li class="main-nav__item--shopping-cart"></li>');

                    // Clone Top Bar menu to Main Menu
                    if ($top_nav.exists()) {
                        var children = $top_nav.children().clone();
                        $nav_list.append(children);
                    }

                    // Clone Header Logo to Mobile Menu
                    var $logo_mobile = $('.header-mobile__logo').clone();
                    $nav_list.prepend($logo_mobile);
                    $logo_mobile.prepend('<span class="main-nav__back"></span>');

                    // Clone Header Info to Mobile Menu
                    var header_info1 = $('.info-block__item--contact-primary').clone();
                    var header_info2 = $('.info-block__item--contact-secondary').clone();
                    $nav_list.append(header_info1).append(header_info2);

                    // Clone Social Links to Main Menu
                    if ($social.exists()) {
                        var social_li = $social.children().clone();
                        var social_li_new = social_li.contents().unwrap();
                        social_li_new.appendTo($nav_list).wrapAll('<li class="main-nav__item--social-links"></li>');
                    }

                    // Add arrow and class if Top Bar menu ite has submenu
                    $top_nav_li.has('ul').addClass('has-children');

                    // Add arrow and class if Info Header Nav has submenu
                    $info_nav_li.has('ul').addClass('has-children');

                    // Mobile Menu Toggle
                    $toggle_btn.on('click', function () {
                        $wrapper.toggleClass('site-wrapper--has-overlay');
                    });

                    $('.site-overlay, .main-nav__back').on('click', function () {
                        $wrapper.toggleClass('site-wrapper--has-overlay');
                    });
                }

                // Pushy Panel Toggle
                $pushy_btn.on('click', function (e) {
                    e.preventDefault();
                    $wrapper.toggleClass('site-wrapper--has-overlay-pushy');
                });

                $('.site-overlay, .pushy-panel__back-btn').on('click', function (e) {
                    e.preventDefault();
                    $wrapper.removeClass('site-wrapper--has-overlay-pushy site-wrapper--has-overlay');
                });

                // Add toggle button and class if menu has submenu
                $nav_list_li.has('.main-nav__sub').addClass('has-children').prepend('<span class="main-nav__toggle"></span>');
                $nav_list_li.has('.main-nav__megamenu').addClass('has-children').prepend('<span class="main-nav__toggle"></span>');

                $('.main-nav__toggle').on('click', function () {
                    $(this).toggleClass('main-nav__toggle--rotate')
                            .parent().siblings().children().removeClass('main-nav__toggle--rotate');

                    $(".main-nav__sub, .main-nav__megamenu").not($(this).siblings('.main-nav__sub, .main-nav__megamenu')).slideUp('normal');
                    $(this).siblings('.main-nav__sub').slideToggle('normal');
                    $(this).siblings('.main-nav__megamenu').slideToggle('normal');
                });

                // Add toggle button and class if submenu has sub-submenu
                $('.main-nav__list > li > ul > li').has('.main-nav__sub-2').addClass('has-children').prepend('<span class="main-nav__toggle-2"></span>');
                $('.main-nav__list > li > ul > li > ul > li').has('.main-nav__sub-3').addClass('has-children').prepend('<span class="main-nav__toggle-2"></span>');

                $('.main-nav__toggle-2').on('click', function () {
                    $(this).toggleClass('main-nav__toggle--rotate');
                    $(this).siblings('.main-nav__sub-2').slideToggle('normal');
                    $(this).siblings('.main-nav__sub-3').slideToggle('normal');
                });

                // Mobile Search
                $('#header-mobile__search-icon').on('click', function () {
                    $(this).toggleClass('header-mobile__search-icon--close');
                    $('.header-mobile').toggleClass('header-mobile--expanded');
                });
            }
        },

        isotope: function () {

            if ($post_masonry.exists() && !isMobile) {
                var $masonry = $post_masonry.imagesLoaded(function () {
                    // init Isotope after all images have loaded
                    $masonry.isotope({
                        itemSelector: '.post-grid__item',
                        layoutMode: 'masonry',
                        percentPosition: false,

                        masonry: {
                            columnWidth: '.post-grid__item'
                        }
                    });
                    $('.widget_PostGrid .col-sm-4').css('paddingLeft', '10px');

                });
            }

            if ($post_masonry_filter.exists()) {
                var $masonry_grid = $post_masonry_filter.imagesLoaded(function () {

                    var $filter = $('.js-category-filter');

                    // init Isotope after all images have loaded
                    $masonry_grid.isotope({
                        filter: '*',
                        itemSelector: '.post-grid__item',
                        layoutMode: 'masonry',
                        masonry: {
                            columnWidth: '.post-grid__item'
                        }
                    });

                    // filter items on button click
                    $filter.on('click', 'button', function () {
                        var filterValue = $(this).attr('data-filter');
                        $filter.find('button').removeClass('category-filter__link--active');
                        $(this).addClass('category-filter__link--active');
                        $masonry_grid.isotope({
                            filter: filterValue
                        });
                    });
                });
            }

        },

        SlickCarousel: function () {


            // Featured News Slider
            if ($slick_featured_slider.exists()) {

                $slick_featured_slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: false
                            }
                        }
                    ]
                });
            }




        },

        InitHeroSlider: function () {
            // Hero Slider
            if ($slick_hero_slider.exists()) {

                $slick_hero_slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    autoplay: true,
                    centerMode: true,
                    autoplaySpeed: 5000,
                    asNavFor: '.hero-slider-thumbs',

                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                fade: false,
                            }
                        }
                    ]
                });
                $('.hero-slider-thumbs').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: $slick_hero_slider,
                    focusOnSelect: true,
                });
            }
            ;
        },

        ResetHeroSlider: function () {

        },

        ContentFilter: function () {

            if ($content_filter.exists()) {
                $('.content-filter__toggle').on('click', function (e) {
                    e.preventDefault();
                    $(this).toggleClass('content-filter__toggle--active');
                    $('.content-filter__list').toggleClass('content-filter__list--expanded');
                });
            }

        }

    };

})(jQuery);


function initIsoTop() {
    Core.initialize();
}

initIsoTop()
;
main = null;
/**
 * Classe per la gestione della homepage
 */ 
var Main = function() {   
    this.initListeners();        
};

/**
 * Metodo che avvia gli ascoltatori
 */
Main.prototype.initListeners = function() {
    var that = this;
        
    if( getReserverMsg == 1 ) {
        var params = { 
            type: 'custom', 
            title: 'Benvenuto su IlDemolitore.it' ,
            callbackModals: '\
            <div class="containerMsg">\
                <div class="containerMsg">\
                    <div>\
                        <label>Siamo spiacenti, ma la sezione da te scelta è accessibile solo agli utenti registratri!</label>\
                    </div>\
                </div>\
                    <div class="containerForm">\
                    <form id="formLogin" class="login-form" data-formLogin>\
                        <div class="form__row">\
                            <div>\
                                <input id="loginEmail" class="form__input-text form__input-text--m-top" type="email" name="loginEmail" placeholder="E-mail" value="">\
                            </div>\
                            <div>\
                                <input id="loginPassword" class="form__input-text form__input-text--m-top" type="password" name="loginPassword" placeholder="Password" value="">\
                            </div>\
                            <label class="lblForgotPwd" data-forgotPwd="1" >Hai dimenticato la password?</label>\
                            <div class="form__row form__row--m-login">\
                                <div>\
                                    <input id="button-login" class="button button--fill button--big" type="submit" data-defaultLogin value="Accedi">\
                                </div>\
                                <label class="lblRegister" data-register="1" >Non sei ancora registrato?</label>\
                            </div>\
                        </div>\
                    </form>\
                </div>\
                <div>\
                    <input class="facebookLogin button button--fill button--big" data-FbLogin type="submit" value="Accedi con Fb">\
                </div>\
                <div>\
                    <input class="googleLogin button button--fill button--big" data-GoogleLogin type="submit" value="Accedi con Google">\
                </div>\
            </div>'
            };
        classModals.openModals( params );    
    }
    if( getReserverMsg == 2 ) {
        var params = { 
            type: 'custom', 
            title: 'Benvenuto su IlDemolitore.it' ,
            callbackModals: '\
            <div class="containerMsg">\
                <div class="containerMsg">\
                    <div>\
                        Siamo spiacenti, ma la sezione da te scelta è accessibile solo agli utenti autorizzati dal Demolitore!\
                    </div>\
                    <br>\
                    <br>\
                    <div class="containerEmail">\
                        <div>Contatta Il Demolitore a questa email <label class="demoMail"> '+ demoEmail +'</label></div>\
                    </div>\
                </div>\
            </div>'
            };
        classModals.openModals( params );    
    }
//    this.trackGAClickEvent( 'totalViews', versionSite, page );
}; 


/**
 * Metodo che traccia gli eventi su analytics
 */
Main.prototype.trackGAClickEvent = function ( category, action, opt_label, optValue ) {
	if ( typeof category == "undefined" || typeof action == "undefined" || typeof opt_label == "undefined" ) {
		return false;
	}
    
	if ( typeof ga == "undefined" ) {
		return false;
	}
    

	if ( typeof( ga ) != 'undefined' && category != null && action ) {
        ga('send', 'event', category, action, opt_label, 4);
        console.info( typeof( ga )  );
	}
	return true;
};


/**
 * Metodo che avvia il lazy sulle immagini
 * @param {string} container
 * @returns {void}
 */
Main.prototype.lazy = function ( container ) {
    if( typeof container == 'undefined' )
        container = '';
    
    if( typeof unveil != 'undefined' ) {
        $( container + " .lazy" ).unveil( 300, function() {
            $( this ).load( function() {
                this.style.opacity = 1;
            });
        });
    }
};

Main.prototype.appDownload = function (sender, type) {
    
    var millisec = 24*60*60*1000;
    if (type == 'close') {
        $(sender).closest(".widget_TopAppDownload").slideUp('slow');    
        this.setCookie("appDownload", 1, millisec);
    } else  {
        var uagent = navigator.userAgent.toLowerCase();
        this.setCookie("appDownload", 1, millisec);
        
        if (uagent.search( "iphone" ) > -1) {   
            window.location.href = encodeURI(urlIosStore);

        } else if (uagent.search( "android" ) > -1) {  
            window.location.href = urlPlayStore;
        }  
    }
};


Main.prototype.setCookie = function ( name,value,millisec ) {
    if (millisec) {
        var date = new Date();
        date.setTime(date.getTime()+(millisec));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
};

Main.prototype.getCookie = function (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
};

Main.prototype.unsetCookie = function (name) {
    this.setCookie(name,"",-1);
};


Main.prototype.openDataIntLink = function (url) {
    window.location.href = url;
};


/**
 * Controlla se il dispositivo è un mobile, e se l'utente rispre il broswer che era andato in standby ricarica la pagina per
 * prendere gli aggiornamento che sono passati mentre ilmobile era in blocco
 * @param {type} $
 * @returns {undefined}
 */
(function($){$.winFocus||($.extend({winFocus:function(){var a=!0,b=[];$(document).data("winFocus")||$(document).data("winFocus",$.winFocus.init());for(x in arguments)"object"==typeof arguments[x]?(arguments[x].blur&&$.winFocus.methods.blur.push(arguments[x].blur),arguments[x].focus&&$.winFocus.methods.focus.push(arguments[x].focus),arguments[x].blurFocus&&$.winFocus.methods.blurFocus.push(arguments[x].blurFocus),arguments[x].initRun&&(a=arguments[x].initRun)):"function"==typeof arguments[x]?b.push(arguments[x]):
"boolean"==typeof arguments[x]&&(a=arguments[x]);b&&(1==b.length?$.winFocus.methods.blurFocus.push(b[0]):($.winFocus.methods.blur.push(b[0]),$.winFocus.methods.focus.push(b[1])));if(a)$.winFocus.methods.onChange()}}),$.winFocus.init=function(){$.winFocus.props.hidden in document?document.addEventListener("visibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden="mozHidden")in document?document.addEventListener("mozvisibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden=
"webkitHidden")in document?document.addEventListener("webkitvisibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden="msHidden")in document?document.addEventListener("msvisibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden="onfocusin")in document?document.onfocusin=document.onfocusout=$.winFocus.methods.onChange:window.onpageshow=window.onpagehide=window.onfocus=window.onblur=$.winFocus.methods.onChange;return $.winFocus},$.winFocus.methods={blurFocus:[],blur:[],focus:[],
exeCB:function(a){$.winFocus.methods.blurFocus&&$.each($.winFocus.methods.blurFocus,function(b,c){"function"==typeof this&&this.apply($.winFocus,[a,!a.hidden])});a.hidden&&$.winFocus.methods.blur&&$.each($.winFocus.methods.blur,function(b,c){"function"==typeof this&&this.apply($.winFocus,[a])});!a.hidden&&$.winFocus.methods.focus&&$.each($.winFocus.methods.focus,function(b,c){"function"==typeof this&&this.apply($.winFocus,[a])})},onChange:function(a){var b={focus:!1,focusin:!1,pageshow:!1,blur:!0,
focusout:!0,pagehide:!0};if(a=a||window.event)a.hidden=a.type in b?b[a.type]:document[$.winFocus.props.hidden],$(window).data("visible",!a.hidden),$.winFocus.methods.exeCB(a);else try{$.winFocus.methods.onChange.call(document,new Event("visibilitychange"))}catch(c){}}},$.winFocus.props={hidden:"hidden"});})(jQuery);

$(function() {    
    if ( /Mobi/.test( navigator.userAgent ) ) {
	$.winFocus( function( event, isVisible ) {		
            if( isVisible == true ) {
//                window.location.reload(1);
//                window.location.href = window.location.href;
            }		
            
	}, false );   
    }
});

var main = null;
main = new Main();

;


/**
 * Classe per la gestione del widget ImageArticle
 */
var WidgetInfiniteScrollNews = function () {
//    this.widget            = $( ".widget_PostGrid" );
    this.widget = $(".widget_CategoriesHome, [data-infiniteScroll]");
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetInfiniteScrollNews.prototype.initListeners = function () {
    var that                = this;
    this.page               = typeof page != 'undefined' && page != '' ? parseInt(page) + 1 : 2;
    this.pageScrollUp       = this.page;
    this.pageScrollIndexes  = new Array();
    this.lastDataSearchPage = 1;
    this.lock               = false;
    this.lastScroll         = 0;
    this.scroll(1000);

    //determina il numero di link da spengre prima di quello attivo dalla variabile get page
    this.offsetLinkActive = isMobile ? 3 : 10;

    //Determina la larghezza di tutti i link affiancati della paginazione
    this.wItemsLi = 0;
    $('.itemLinkPagination a').each(function () {
        that.wItemsLi += $(this).outerWidth();
    });

    //Se i link entrano tutti nel contenitore pafre, disabilita la rimozione quanto si cambiano le pagine
    this.hideElement = false;
    if (this.wItemsLi > $('.post-pagination').outerWidth()) {
        this.hideElement = true;
    }

    //Quando l'utente usa le sfreccie di stato del browser gestisco la history
    window.onpopstate = function (event) {
        if (event.state) {

        } else {
            that.lock = true;
            var dataSearchPage = window.location.search;
            var keyDataSearch = dataSearchPage.replace('?page=', '');
            var dataSearch = that.pageScrollIndexes[keyDataSearch];

            if (that.lastDataSearchPage < keyDataSearch) {
                that.getForward(keyDataSearch);
            } else {
                that.getBack(keyDataSearch);
            }

            if (typeof dataSearch != 'undefined') {
                $('html, body').animate({
                    scrollTop: dataSearch['min']
                }, 1000, function () {
                    that.lock = false;
                    that.lastDataSearchPage = keyDataSearch;
                });
            }
        }
    };
};

/**
 * Funziona con ascoltatore sull'evento scroll che gestisce il recupero delle pagine successive in ajax
 * @param {type} tollerance
 * @returns {undefined}
 */
WidgetInfiniteScrollNews.prototype.scroll = function (tollerance) {
    var that = this;
    var tollerance = typeof tollerance != 'undefined' ? tollerance : 400;

    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();

        if (that.lock)
            return false;

        //controlla che sia arrivato al punto esatto dello scroll per caricare un altra pagina
        if (($(window).scrollTop() + $(window).height() + tollerance > $(document).height()) && $(document).height() != that.lastScroll) {
            that.lastScroll = $(document).height();

            if (typeof that.pageScrollIndexes[that.page] == 'undefined') {
                that.pageScrollIndexes[that.page] = new Array();
            }
            if (typeof that.pageScrollIndexes[that.page - 1] == 'undefined') {
                that.pageScrollIndexes[that.page - 1] = new Array();
            }

            if (that.page == 2) {
                that.pageScrollIndexes[that.page - 1]['min'] = 0;
            }

            that.pageScrollIndexes[that.page - 1 ]['max'] = that.lastScroll - 1;
            that.pageScrollIndexes[that.page]['min'] = that.lastScroll;

            that.lock = true;
            $('.plaseWait').show();

            //Splitta i paremetri dopo il ? di una rul
            var searchUrl = window.location.search;
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+[\&]/g, "");
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+/g, "");
            searchUrl = searchUrl.replace('?', '');

            var pathNameUrl = window.location.pathname
            pathNameUrl = pathNameUrl.replace(/[\?\&]page=[0-9]+/g, "");

            if (searchUrl != '' && searchUrl != 0)
                var urlAjax = "/news/getInfiniteScrollerListNews/page=" + that.page + "?uri=" + pathNameUrl + '&' + searchUrl;
            else
                var urlAjax = "/news/getInfiniteScrollerListNews/page=" + that.page + "?uri=" + pathNameUrl;

            var request = $.ajax({
                url: urlAjax,
                type: "GET",
                async: true,
                dataType: "html"
            });
            request.done(function (resp) {
                that.lock = false;

                $('.plaseWait').hide();
                if (resp == '')
                    return;

                var reloadPage = that.page;
                //Appende la nuova pagina al bode
                $('[data-infiniteScroll]').last().after(resp);

                var reloadPage = that.page;
                if (typeof imagesLoaded == 'function' && !isMobile) {
                    var $masonry = $('.post-grid--masonry-page-' + reloadPage).imagesLoaded(function () {
                        $masonry.isotope({
                            itemSelector: '.post-grid__item',
                            layoutMode: 'masonry',
                            percentPosition: true,
                            masonry: {
                                columnWidth: '.post-grid__item'
                            }
                        });
                    });
                }

                //Gestisce la scrittura delle history api
                if (searchUrl != '' && searchUrl != 0)
                    window.history.pushState("", '', pathNameUrl + "?page=" + that.page + "&" + searchUrl);
                else
                    window.history.pushState("", '', pathNameUrl + "?page=" + that.page);

                //Aggiunge il nuovo link alla paginazione runtime per l'utente
                var maxPageHtml = parseInt($('.itemLinkPagination:nth-child(' + $('.itemLinkPagination').length + ') a').html()) + 1;                
                if (maxPageHtml == that.page && lastPagePagination > that.page) {
                    var newLinkPage = maxPageHtml + 1;
                    var newItem = $('.itemLinkPagination:nth-child(2)').clone();

                    if (searchUrl != '' && searchUrl != 0)
                        $(newItem).find('a').attr('href', pathNameUrl + "?page=" + newLinkPage + "&" + searchUrl);
                    else
                        $(newItem).find('a').attr('href', pathNameUrl + "?page=" + newLinkPage);

                    $(newItem).find('a').html(newLinkPage);
                    $(newItem).removeClass('hideItem');
                    $(newItem).insertBefore('.post-pagination #pagination .nextPagination');


                    that.wItemsLi = 0;
                    $('.itemLinkPagination a').each(function () {
                        that.wItemsLi += $(this).outerWidth();
                    });
                    if (that.wItemsLi > $('.post-pagination').outerWidth()) {
                        that.hideElement = true;
                    }
                }

                $('.itemLinkPagination').removeClass('active');
//                $( '.itemLinkPagination:nth-child('+(parseInt(that.page))+')' ).addClass('active');

                $('.itemLinkPagination a').each(function (index) {
                    if (parseInt($(this).html()) == parseInt(that.page)) {
                        $(this).closest('.itemLinkPagination').addClass('active');
                    }
                });

                //Nasconde il prima link 
                if (that.hideElement) {
                    $('.itemLinkPagination:not(".hideItem")').each(function (index) {
                        if (index != 0)
                            return false;
                        $(this).addClass('hideItem')
                    });
                }

                that.page++;
                that.pageScrollUp = that.page;
                that.lastDataSearchPage = that.page;
            });
        } else if ($(window).scrollTop() + $(window).height() + tollerance < that.lastScroll) {
            that.getPageUp(tollerance);
        }

    });
};

/**
 * Metodo che avvia la navigazione all'indietro
 * @param {int} tollerance
 * @returns {undefined}
 */
WidgetInfiniteScrollNews.prototype.getPageUp = function (tollerance) {
    var that = this;
    var positionY = $(window).scrollTop() + $(window).height() + tollerance;

    for (var key in that.pageScrollIndexes) {
        var min = typeof that.pageScrollIndexes[key]['min'] != 'undefined' ? that.pageScrollIndexes[key]['min'] : 0;
        var max = typeof that.pageScrollIndexes[key]['max'] != 'undefined' ? that.pageScrollIndexes[key]['max'] : false;

        if (max && positionY > min && positionY < max) {
            var searchUrl = window.location.search;
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+[\&]/g, "");
            searchUrl = searchUrl.replace(/[\?\&]page=[0-9]+/g, "");
            searchUrl = searchUrl.replace('?', '');

            var pathNameUrl = window.location.pathname;
            pathNameUrl = pathNameUrl.replace(/[\?\&]page=[0-9]+/g, "");

            if (window.location.search.indexOf('page=' + key) == '-1') {

                if (searchUrl != '' && searchUrl != 0)
                    window.history.pushState("", '', pathNameUrl + "?page=" + key + "&" + searchUrl);
                else
                    window.history.pushState("", '', pathNameUrl + "?page=" + key);
//                
                $('.itemLinkPagination').removeClass('active');
                $('.itemLinkPagination a').each(function (index) {
                    if (parseInt($(this).html()) == parseInt(key)) {
                        $(this).closest('.itemLinkPagination').addClass('active');
                    }
                });

                if (this.hideElement)
                    $('.itemLinkPagination.hideItem').each(function (index) {
                        if (index == $('.itemLinkPagination.hideItem').length - 1)
                            $(this).removeClass('hideItem')
                    });

            }
        }
        ;
    }
};


/**
 * Torna indietro nella paginazione se l'utente fa click sulla history back del browser
 * @param {type} page
 * @returns {undefined}
 */
WidgetInfiniteScrollNews.prototype.getBack = function (page) {
    var that = this;
    $('.itemLinkPagination').removeClass('active');
    $('.itemLinkPagination a').each(function (index) {
        if (parseInt($(this).html()) == parseInt(page)) {
            $(this).closest('.itemLinkPagination').addClass('active');
        }
    });

    if (this.hideElement)
        $('.itemLinkPagination.hideItem').each(function (index) {
            if (index == $('.itemLinkPagination.hideItem').length - 1)
                $(this).removeClass('hideItem')
        });
};


/**
 * Torna avanti nella paginazione se l'utente fa click sulla history forward del browser
 * @param {type} page
 * @returns {undefined}
 */
WidgetInfiniteScrollNews.prototype.getForward = function (page) {
    var that = this;
    $('.itemLinkPagination').removeClass('active');

    $('.itemLinkPagination a').each(function (index) {
        if (parseInt($(this).html()) == parseInt(page)) {
            $(this).closest('.itemLinkPagination').addClass('active');
        }
    });

    //Nasconde il prima link 
    if (that.hideElement) {
        $('.itemLinkPagination:not(".hideItem")').each(function (index) {
            if (index != 0)
                return false;
            $(this).addClass('hideItem')
        });
    }
};

String.prototype.replaceAt = function (index, replacement) {
    return this.substr(0, index) + replacement + this.substr(index + replacement.length);
};


widgetInfiniteScrollNews = null;
widgetInfiniteScrollNews = new WidgetInfiniteScrollNews()
;
/**
 * Classe per la gestione dei moduli del sito
 */
var Modules = function() {
    this.aModules = new Array();    
};

Modules.prototype.add = function ( widget, core, loadType, limit, category, varAttrAjax ) {
    this.aModules[widget] = {'widget':widget, 'core':core, 'loadType':loadType, 'limit':limit, 'category':category, 'varAttrAjax': varAttrAjax };     
};

/**
 * Ritorna i dati del modulo richiesto
 * @param {type} widget
 * @returns {Array|Boolean}
 */
Modules.prototype.getDataModule = function ( widget ) {
    if( typeof this.aModules[widget] == 'undefined' )
        return false; 
    return this.aModules[widget];
};

/**
 * Recupera il modulo da caricare
 * @param {type} module
 * @returns {undefined}
 */
Modules.prototype.load = function () {
    var that = this;        
    for ( item in this.aModules ) {        
        if( this.aModules[item]['loadType'] == 1 ) { 
            that.getAsync( that.aModules[item]['widget'], that.aModules[item]['core'], that.aModules[item]['limit'], that.aModules[item]['category'], that.aModules[item]['varAttrAjax'] );
        }
    }    
};

/**
 * Recupera il widget in modalita asicrona
 * @param {type} widget
 * @param {type} core
 * @returns {undefined}
 */
Modules.prototype.getAsync = function ( widget, core, limit, category, varAttrAjax ) {
    var that = this;
    var id = idNews;
    
    setTimeout( function() {
        that.getModule( widget, core, id, false, false, limit, category, varAttrAjax );
    }, 100 );
};

/**
 * Metodo che fa il replace con il contenuto del modulo
 * @param {type} module 
 * @returns {undefined}
 */
Modules.prototype.getModule = function ( widget, core, id, paramsExtra, callback, limit, category, varAttrAjax ) {
    var that = this;   

    if( typeof id == 'undefined' )
        id = '';
        
    if( typeof paramsExtra == 'undefined' )
        paramsExtra ='';
        
//    if( widget != 'widget_LiveScoreMatch' )
//        $( '.'+widget ).find( '.widget-body' ).replaceWith( '<div class="text-center"><img widht="64" heidth="64" src="/images/loader.gif"></div>');
//    
    //Determina se bisogna differenziare la url avvinche la versione desktop e la versione mobile sia cachate in modo differente
    var changeUrlForCacheIfIsMobile = '';
    
    $( '['+varAttrAjax+']' ).hide();
    
    var params = "widget="+widget+"&cores="+core+"&limit="+limit+"&category="+category+"&id="+id+paramsExtra+changeUrlForCacheIfIsMobile;
    var request = $.ajax({
        url: ajaxCallPath + "widget?"+params, 
        type: "GET",
        async: true,
        dataType: "html"
    });

    request.done( function( html ) {
        //Setta che il widget è gia stato caricato per bloccare la chiamata ajax successivamente
        if( typeof that.aModules[widget] != 'undefined' && widget != 'widget_CommentsMatch' )
            that.aModules[widget]['open'] = id;        
//       

        $( '[dataReplaceWidget="'+varAttrAjax+'"]' ).replaceWith( html );
//       
//        
//        if( typeof callback != 'undefined' ) {
//            if( typeof callback.params != 'undefined' )
//                callback.call( callback.params[0] );
//            else
//                callback.call();
//        }
//                
//        
        
        setTimeout( function() {
            $( '[dataReplaceWidget]' ).show();
        },500);
//        
        
        
        var calls = $( '.'+widget ).attr( 'data-callFunctions' );
        if( typeof calls != 'undefined' && calls == 1 ) {
            that.getCallDataFunctionWidget( calls, params );
        } 
//        else if( typeof calls != 'undefined' ) {
//            alert( calls);
//            switch( calls ) {
//                case 'getFormationsFieldLastMatchTeam':
//                    that.getFormationsFieldLastMatchTeam();
//                break;
//            }
//        }
    });
};

//Modules.prototype.getFormationsFieldLastMatchTeam = function (  ) {
//    alert(lastFeedMatchIdTeam);
//    this.getCallDataFunctionWidget();
//};

/**
 * Lancia la funzione da chiamare settata nel data attribute data-callFunctions del widget appena caricato
 * @param {type} widget
 * @param {type} core
 * @param {type} id
 * @returns {undefined}
 */
Modules.prototype.getCallDataFunctionWidget = function ( call, params ) {
    var that = this;
        
    var request = $.ajax({
        url: ajaxCallPath + "dataWidget?"+params,
        type: "GET",
        async: true,
        dataType: "html"
    });

    request.done( function( html ) { 
        socketClient.eachData( jQuery.parseJSON( html ) );
    });
};

modules = null;
modules = new Modules();

;
