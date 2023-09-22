// IIFE with jQuery Wrapper
(function($) {
  'use strict';
  /*
   *----------------------------------
   * Document Ready
   *----------------------------------
   */
  $(document).ready(function() {

  	/*
		====================================
			Nav menu
		====================================
  	*/

    $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
    //Checks if li has sub (ul) and adds class for toggle icon - just an UI


    $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');
    //Checks if drodown menu's li elements have anothere level (ul), if not the dropdown is shown as regular dropdown, not a mega menu (thanks Luka Kladaric)

    $('.menu > ul').before('<a href=\'#\' class=\'menu-mobile\'> <i class=\'fa fa-bars\'></i></a>');

    //Adds menu-mobile class (for mobile toggle menu) before the normal menu
    //Mobile menu is hidden if width is more then 959px, but normal menu is displayed
    //Normal menu is hidden if width is below 959px, and jquery adds mobile menu
    //Done this way so it can be used with wordpress without any trouble

	$( '.menu > ul > li' )
	.on('mouseover', function() {
	    if ($(window).width() > 943) {
	        $(this).children('ul').css('display', 'block');
	    }
	})
	.on('mouseout', function() {
	    if ($(window).width() > 943) {
	        $(this).children('ul').css('display', 'none');
	    }
	});

    $('.menu-mobile').on('click', function (e) {
        $('.menu > ul').toggleClass('show-on-mobile');
        e.preventDefault();
    });

    $('.menu > ul > li').on('click', function(){
        $('li').removeClass('wd-nav-current');
        $(this).addClass('wd-nav-current');
    });

    //when clicked on mobile-menu, normal menu is shown as a list, classic rwd menu story (thanks mwl from stackoverflow)


  	/*
		====================================
			Home Page Slider Section
		====================================
  	*/

		$('#main-slider').owlCarousel({
		    loop:true,
		    nav:true,
		    items:1
		})

        $('#main-slider').on('translate.owl.carousel', function () {
            $('.slider-text').removeClass('fadeInUp animated').hide();
        });
        $('#main-slider').on('translated.owl.carousel', function () {
            $('.slider-text').addClass('fadeInUp animated').show();
        });

		$('#th-main-slider').owlCarousel({
		    loop:true,
		    margin:0,
		    items:1
		})

		$('#product-slider').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    dots: false,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:4
		        }
		    }
		})

		$('#product-slider-exta').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    dots: false,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:4
		        }
		    }
		})

		$('#product-trending').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    dots: false,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:4
		        }
		    }
		})

		$('#product-review').owlCarousel({
		    loop:true,
		    items:1,
		    dots: false,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    animateOut: 'fadeOut'
		})


		$('#product-view-model').owlCarousel({
		    loop:true,
		    nav:false,
		    dots: true,
            items:1
		})

  	/*
		====================================
			Home 01 02 Page Slider Section
		====================================
  	*/
		$('#product-slider-two').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    dots: false,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:4
		        },
		        1200:{
		            items:5
		        }
		    }
		})
		$('#product-trending-two').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    dots: false,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1024:{
		            items:4
		        },
		        1200:{
		            items:5
		        }
		    }
		})

  	/*
		====================================
			Home two Page Slider Section
		====================================
  	*/
		$( '#department-list .list-group-item' ).on( 'mouseover', function() {
			$( this ).addClass( 'wd-active' );
		}).on( "mouseout", function() {
		    $( this ).removeClass( 'wd-active' );
		});

	/*
		====================
		Sidebar Drowp Down
		====================
	*/
	$( '.sidebar-dropdown' ).on( 'mouseover', function() {
		$( '.dropdown-sub-menu' ).addClass( 'sidebar-dropdown-active' );
	}).on( 'mouseout', function() {
	    $( '.dropdown-sub-menu' ).removeClass( 'sidebar-dropdown-active' );
	});

		
  	/*
		====================================
			Shop Page Slider Section
		====================================
  	*/
		$('#shop-slider').owlCarousel({
		    loop:true,
		    nav:false,
		    dots: false,
		    items:1,
			autoplay:true,
			autoplayTimeout:5000,
			autoplayHoverPause:false,
			smartSpeed: 1000
		})

		$('.sidebar-slider').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa-angle-right\'></i>'],
		    dots: false,
		    items:1
		})

  	/*
		=============================================
			Product Details Page Slider Section
		=============================================
  	*/
		$('#lightSlider').lightSlider({
		    gallery: true,
		    item: 1,
		    loop:true,
		    slideMargin: 0,
		    thumbItem: 5
		});




		$('#related-product').owlCarousel({
		    loop:true,
		    nav:true,
		    navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
		    dots: false,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:4
		        }
		    }
		})
	/*
		Youtube Video Player
	*/
	$('#video').simplePlayer();



	/*
		Progress Bar
	*/

	$('.wd-since-month').circleProgress({
		value: 0.52,
		fill: {
		  gradient: ['#82b1ff', '#82b1ff'] // or color: '#3aeabb', or image: 'http://i.imgur.com/pT0i89v.png'
		},
	});
	$('.wd-since-day').circleProgress({
		value: 0.20,
		fill: {
		  gradient: ['#82b1ff', '#82b1ff'] // or color: '#3aeabb', or image: 'http://i.imgur.com/pT0i89v.png'
		},
	});
	$('.wd-since-year').circleProgress({
		value: 0.25,
		fill: {
		  gradient: ['#82b1ff', '#82b1ff'] // or color: '#3aeabb', or image: 'http://i.imgur.com/pT0i89v.png'
		},
	});

	/*
		==================
		Rating Star Yollo Color
		==================
	*/
	$('.review-rating-yellow-5').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});

	$('.review-rating-yellow-4').rateYo({
		rating: 4,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-yellow-3').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-yellow-2').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-yellow-1').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});

	/*
		==================
		Rating Star Blue Color
		==================
	*/
	$('.review-rating-blue-5').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#047bd5',
		normalFill: '#e3e3e3'
	});

	$('.review-rating-blue-4').rateYo({
		rating: 4,
		starWidth: '19px',
		ratedFill: '#047bd5',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-blue-3').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#047bd5',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-blue-2').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#047bd5',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-blue-1').rateYo({
		rating: 4,
		starWidth: '19px',
		ratedFill: '#047bd5',
		normalFill: '#e3e3e3'
	});
	/*
		==================
		Rating Star Red Color
		==================
	*/
	$('.review-rating-red-5').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#e50046',
		normalFill: '#e3e3e3'
	});

	$('.review-rating-red-4').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#e50046',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-red-3').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#e50046',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-red-2').rateYo({
		rating: 4,
		starWidth: '19px',
		ratedFill: '#e50046',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-red-1').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#e50046',
		normalFill: '#e3e3e3'
	});
	/*
		==================
		Rating Star Green Color
		==================
	*/
	$('.review-rating-green-5').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#86b817',
		normalFill: '#e3e3e3'
	});

	$('.review-rating-green-4').rateYo({
		rating: 1,
		starWidth: '19px',
		ratedFill: '#86b817',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-green-3').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#86b817',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-green-2').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#86b817',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-green-1').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#86b817',
		normalFill: '#e3e3e3'
	});
	/*
		==================
		Rating Star Dark Yellow Color
		==================
	*/
	$('.review-rating-dark-yellow-5').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#ff6a00',
		normalFill: '#e3e3e3'
	});

	$('.review-rating-dark-yellow-4').rateYo({
		rating: 4,
		starWidth: '19px',
		ratedFill: '#ff6a00',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-dark-yellow-3').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#ff6a00',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-dark-yellow-2').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#ff6a00',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-dark-yellow-1').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#ff6a00',
		normalFill: '#e3e3e3'
	});
	/*
		==================
		Rating Star Light Yellow Color
		==================
	*/
	$('.review-rating-light-yellow-5').rateYo({
		rating: 5,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});

	$('.review-rating-light-yellow-4').rateYo({
		rating: 4,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-light-yellow-3').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-light-yellow-2').rateYo({
		rating: 2,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});
	$('.review-rating-light-yellow-1').rateYo({
		rating: 3,
		starWidth: '19px',
		ratedFill: '#ff9800',
		normalFill: '#e3e3e3'
	});

	/*
		====================
		Accordion Load
		====================
	*/
	$('.wd-accordion').accordion();

	/*
		====================
		Tooltip
		====================
	*/
	$('[data-toggle=\'tooltip\']').tooltip()

    /*
        ====================================
            Product Rating
        ====================================
    */
    $('.rating-slider-1').slider({
        value:0,
        min: 0,
        max: 5,
        step: 1,
        slide: function( event, ui ) {
            $( '#slider-value' ).html( ui.value );
            if (ui.value == 1) {
                $( '.cat-1' ).addClass( 'active-color' );
            }else{
                $( '.cat-1' ).removeClass( 'active-color' );
            }
            if (ui.value == 2) {
                $( '.cat-1' ).addClass( 'active-color' );
                $( '.cat-2' ).addClass( 'active-color' );
            }else{
                $( '.cat-2' ).removeClass( 'active-color' );
            }
            if (ui.value == 3) {
                $( '.cat-1' ).addClass( 'active-color' );
                $( '.cat-2' ).addClass( 'active-color' );
                $( 'cat-3' ).addClass( 'active-color' );
            }else{
                $( '.cat-3' ).removeClass( 'active-color' );
            }
            if (ui.value == 4) {
                $( '.cat-1' ).addClass( 'active-color' );
                $( '.cat-2' ).addClass( 'active-color' );
                $( '.cat-3' ).addClass( 'active-color' );
                $( '.cat-4' ).addClass( 'active-color' );
            }else{
                $( '.cat-4' ).removeClass( 'active-color' );
            }
            if (ui.value == 5) {
                $( '.cat-1' ).addClass( 'active-color' );
                $( '.cat-2' ).addClass( 'active-color' );
                $( '.cat-3' ).addClass( 'active-color' );
                $( '.cat-4' ).addClass( 'active-color' );
                $( '.cat-5' ).addClass( 'active-color' );
            }else{
                $( '.cat-5' ).removeClass( 'active-color' );
            }
        }
    }
    );
    $('.rating-slider-2').slider({
        value:0,
        min: 0,
        max: 5,
        step: 1,
        slide: function( event, ui ) {
            $( '#slider-value' ).html( ui.value );
            if (ui.value == 1) {
                $( '.cat-2-1' ).addClass( 'active-color' );
            }else{
                $( '.cat-2-1' ).removeClass( 'active-color' );
            }
            if (ui.value == 2) {
                $( '.cat-2-1' ).addClass( 'active-color' );
                $( '.cat-2-2' ).addClass( 'active-color' );
            }else{
                $( '.cat-2-2' ).removeClass( 'active-color' );
            }
            if (ui.value == 3) {
                $( '.cat-2-1' ).addClass( 'active-color' );
                $( '.cat-2-2' ).addClass( 'active-color' );
                $( 'cat-2-3' ).addClass( 'active-color' );
            }else{
                $( '.cat-2-3' ).removeClass( 'active-color' );
            }
            if (ui.value == 4) {
                $( '.cat-2-1' ).addClass( 'active-color' );
                $( '.cat-2-2' ).addClass( 'active-color' );
                $( '.cat-2-3' ).addClass( 'active-color' );
                $( '.cat-2-4' ).addClass( 'active-color' );
            }else{
                $( '.cat-2-4' ).removeClass( 'active-color' );
            }
            if (ui.value == 5) {
                $( '.cat-2-1' ).addClass( 'active-color' );
                $( '.cat-2-2' ).addClass( 'active-color' );
                $( '.cat-2-3' ).addClass( 'active-color' );
                $( '.cat-2-4' ).addClass( 'active-color' );
                $( '.cat-2-5' ).addClass( 'active-color' );
            }else{
                $( '.cat-2-5' ).removeClass( 'active-color' );
            }
        }
    }
    );
    $('.rating-slider-3').slider({
        value:0,
        min: 0,
        max: 5,
        step: 1,
        slide: function( event, ui ) {
            $( '#slider-value' ).html( ui.value );
            if (ui.value == 1) {
                $( '.cat-3-1' ).addClass( 'active-color' );
            }else{
                $( '.cat-3-1' ).removeClass( 'active-color' );
            }
            if (ui.value == 2) {
                $( '.cat-3-1' ).addClass( 'active-color' );
                $( '.cat-3-2' ).addClass( 'active-color' );
            }else{
                $( '.cat-3-2' ).removeClass( 'active-color' );
            }
            if (ui.value == 3) {
                $( '.cat-3-1' ).addClass( 'active-color' );
                $( '.cat-3-2' ).addClass( 'active-color' );
                $( 'cat-3-3' ).addClass( 'active-color' );
            }else{
                $( '.cat-3-3' ).removeClass( 'active-color' );
            }
            if (ui.value == 4) {
                $( '.cat-3-1' ).addClass( 'active-color' );
                $( '.cat-3-2' ).addClass( 'active-color' );
                $( '.cat-3-3' ).addClass( 'active-color' );
                $( '.cat-3-4' ).addClass( 'active-color' );
            }else{
                $( '.cat-3-4' ).removeClass( 'active-color' );
            }
            if (ui.value == 5) {
                $( '.cat-3-1' ).addClass( 'active-color' );
                $( '.cat-3-2' ).addClass( 'active-color' );
                $( '.cat-3-3' ).addClass( 'active-color' );
                $( '.cat-3-4' ).addClass( 'active-color' );
                $( '.cat-3-5' ).addClass( 'active-color' );
            }else{
                $( '.cat-3-5' ).removeClass( 'active-color' );
            }
        }
    }
    );
    $('.rating-slider-4').slider({
        value:0,
        min: 0,
        max: 5,
        step: 1,
        slide: function( event, ui ) {
            $( '#slider-value' ).html( ui.value );
            if (ui.value == 1) {
                $( '.cat-4-1' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-1' ).removeClass( 'active-color' );
            }
            if (ui.value == 2) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-2' ).removeClass( 'active-color' );
            }
            if (ui.value == 3) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
                $( 'cat-4-3' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-3' ).removeClass( 'active-color' );
            }
            if (ui.value == 4) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
                $( '.cat-4-3' ).addClass( 'active-color' );
                $( '.cat-4-4' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-4' ).removeClass( 'active-color' );
            }
            if (ui.value == 5) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
                $( '.cat-4-3' ).addClass( 'active-color' );
                $( '.cat-4-4' ).addClass( 'active-color' );
                $( '.cat-4-5' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-5' ).removeClass( 'active-color' );
            }
        }
    }
    );
    $('.rating-slider-4').slider({
        value:0,
        min: 0,
        max: 5,
        step: 1,
        slide: function( event, ui ) {
            $( '#slider-value' ).html( ui.value );
            if (ui.value == 1) {
                $( '.cat-4-1' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-1' ).removeClass( 'active-color' );
            }
            if (ui.value == 2) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-2' ).removeClass( 'active-color' );
            }
            if (ui.value == 3) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
                $( 'cat-4-3' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-3' ).removeClass( 'active-color' );
            }
            if (ui.value == 4) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
                $( '.cat-4-3' ).addClass( 'active-color' );
                $( '.cat-4-4' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-4' ).removeClass( 'active-color' );
            }
            if (ui.value == 5) {
                $( '.cat-4-1' ).addClass( 'active-color' );
                $( '.cat-4-2' ).addClass( 'active-color' );
                $( '.cat-4-3' ).addClass( 'active-color' );
                $( '.cat-4-4' ).addClass( 'active-color' );
                $( '.cat-4-5' ).addClass( 'active-color' );
            }else{
                $( '.cat-4-5' ).removeClass( 'active-color' );
            }
        }
    }
    );
    $('.rating-slider-5').slider({
        value:0,
        min: 0,
        max: 5,
        step: 1,
        slide: function( event, ui ) {
            $( '#slider-value' ).html( ui.value );
            if (ui.value == 1) {
                $( '.cat-5-1' ).addClass( 'active-color' );
            }else{
                $( '.cat-5-1' ).removeClass( 'active-color' );
            }
            if (ui.value == 2) {
                $( '.cat-5-1' ).addClass( 'active-color' );
                $( '.cat-5-2' ).addClass( 'active-color' );
            }else{
                $( '.cat-5-2' ).removeClass( 'active-color' );
            }
            if (ui.value == 3) {
                $( '.cat-5-1' ).addClass( 'active-color' );
                $( '.cat-5-2' ).addClass( 'active-color' );
                $( 'cat-5-3' ).addClass( 'active-color' );
            }else{
                $( '.cat-5-3' ).removeClass( 'active-color' );
            }
            if (ui.value == 4) {
                $( '.cat-5-1' ).addClass( 'active-color' );
                $( '.cat-5-2' ).addClass( 'active-color' );
                $( '.cat-5-3' ).addClass( 'active-color' );
                $( '.cat-5-4' ).addClass( 'active-color' );
            }else{
                $( '.cat-5-4' ).removeClass( 'active-color' );
            }
            if (ui.value == 5) {
                $( '.cat-5-1' ).addClass( 'active-color' );
                $( '.cat-5-2' ).addClass( 'active-color' );
                $( '.cat-5-3' ).addClass( 'active-color' );
                $( '.cat-5-4' ).addClass( 'active-color' );
                $( '.cat-5-5' ).addClass( 'active-color' );
            }else{
                $( '.cat-5-5' ).removeClass( 'active-color' );
            }
        }
    }
    );

    /*
        ====================================
            cat-department
        ====================================
    */
    $('#cat-department').on( 'click', function() {
        $( '#department-list' ).toggle(
          function() {
            $( this ).addClass( 'selected' );
          }, function() {
            $( this ).removeClass( 'selected' );
          }
        );
    });

    /*
        ====================================
            Counter
        ====================================
    */
    $('.counter').counterUp({
        delay: 35,
        time: 5000
    });


	$('.test-slider-up').owlCarousel({
		loop: true,
		autoplay: true,
		items: 1,
		nav: false,
		dots: false,
		autoplayHoverPause: true,
		animateOut: 'slideOutUp',
		animateIn: 'slideInUp'
	})


  	/*
		====================================
			Sticky Nav
		====================================
  	*/
	if( $( window ).width() > 992 ){
		$('.sticker-nav').sticky({topSpacing:0});
	}

  	/*
		====================================
			Load More
		====================================
  	*/
    $('.reviews-load-more').slice(0, 12).addClass('display');
    $('#loadMore').on('click', function (e) {
        e.preventDefault();
        $('.reviews-load-more:hidden').slice(0, 3).addClass('display');
        if ($('.reviews-load-more:hidden').length == 0) {
            $('#load').fadeOut('slow');
        }
    });

    $('.reviews-load-more-full_grid').slice(0, 8).addClass('display');
    $('#loadMore_full_grid').on('click', function (e) {
        e.preventDefault();
        $('.reviews-load-more-full_grid:hidden').slice(0, 3).addClass('display');
        if ($('.reviews-load-more-full_grid:hidden').length == 0) {
            $('#load').fadeOut('slow');
        }
    });



  	/*
		====================================
			onePageNav
		====================================
  	*/
	$('#nav').onePageNav();

  	/*
		====================================
			Smooth Scrolling
		====================================
  	*/
 //  	if( $( window ).width() > 992 ){
	// 	 $('body').niceScroll({
	// 		cursorcolor:		'#51abff',
	// 		cursorwidth: 		'18px',
	// 		cursorborder: 		'0px solid #000',
	// 		scrollspeed: 		0,
	// 		autohidemode: 		false,
	// 		background: 		'#f7f7f7',
	// 		hidecursordelay: 	400,
	// 		cursorfixedheight: 	false,
	// 		cursorminheight: 	20,
	// 		enablekeyboard: 	true,
	// 		horizrailenabled: 	true,
	// 		bouncescroll: 		false,
	// 		smoothscroll: 		true,
	// 		iframeautoresize: 	true,
	// 		touchbehavior: 		false,
	// 		zindex: 999999
	// 	 });

	//   	/*
	// 		====================================
	// 			Wow Animation
	// 		====================================
	//   	*/
	// 	// new WOW().init();
	// }
  	/*
		====================================
			Scroll to Up
		====================================
  	*/
	 $.scrollUp({
	 	scrollText: '<i class=\'fa fa-angle-double-up\' aria-hidden=\'true\'></i>',
	 	scrollDistance: 1800,
	 	scrollSpeed: 500,
	 	animationSpeed: 500
	 });


	  $(window).on('load', function(){ 
	    $('div.preloader-body').remove();
	    $('body').removeClass('preloader-body');
	  });





  });// DOM Ready

}(jQuery)); // IIFE