$( '.thumbGallery' ).click( function() {
    utility.onErrorImg( '.cbp-popup-lightbox-img' );
});

var gridContainer = $('#grid-container'),
		filtersContainer = $('#filters-container'),
		gridBlog = $('#grid-blog'),
		filtersBlog = $('#filters-blog'),
		wrap, filtersCallback;

//http://webfixture.com/cbp-plugin/documentation/
gridContainer.cubeportfolio({
		defaultFilter: '*',
		animationType: 'flipOutDelay',
		gapHorizontal: 10,
		gapVertical: 10,
		gridAdjustment: 'alignCenter',
		caption: 'revealBottom',
		displayType: 'bottomToTop',
		displayTypeSpeed: 100,

		// lightbox
		lightboxDelegate: '.cbp-lightbox',
		lightboxGallery: true,
		lightboxTitleSrc: 'data-title',
		lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

		// singlePage popup
		singlePageDelegate: '.cbp-singlePage',
		singlePageDeeplinking: true,
		singlePageStickyNavigation: true,
		singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
		

//		// single page inline
//		singlePageInlineDelegate: '.cbp-singlePageInline',
//		singlePageInlinePosition: 'above',
//		singlePageInlineInFocus: true,
//		singlePageInlineCallback: function (url, element) {
//			// to update singlePage Inline content use the following method: this.updateSinglePageInline(yourContent)
//		}
	});


	/*********************************
	 add listener for filters
	 *********************************/
	if (filtersContainer.hasClass('cbp-l-filters-dropdown')) {
		wrap = filtersContainer.find('.cbp-l-filters-dropdownWrap');
		wrap.on({
			'mouseover.cbp': function () {
				wrap.addClass('cbp-l-filters-dropdownWrap-open');
			},
			'mouseleave.cbp': function () {
				wrap.removeClass('cbp-l-filters-dropdownWrap-open');
			}
		});

		filtersCallback = function (me) {
			wrap.find('.cbp-filter-item').removeClass('cbp-filter-item-active');

			wrap.find('.cbp-l-filters-dropdownHeader').text(me.text());

			me.addClass('cbp-filter-item-active');

			wrap.trigger('mouseleave.cbp');
		};

	} else {
		filtersCallback = function (me) {
			me.addClass('cbp-filter-item-active').siblings().removeClass('cbp-filter-item-active');
		};
	}

	filtersContainer.on('click.cbp', '.cbp-filter-item', function () {        
		var me = $(this);

		if (me.hasClass('cbp-filter-item-active')) {
			return;
		}

		// get cubeportfolio data and check if is still animating (reposition) the items.
		if (!$.data(gridContainer[0], 'cubeportfolio').isAnimating) {
			filtersCallback.call(null, me);
		}

		// filter the items
		gridContainer.cubeportfolio('filter', me.data('filter'), function () {
		});

	});


	/*********************************
	 activate counter for filters
	 *********************************/
	gridContainer.cubeportfolio('showCounter', filtersContainer.find('.cbp-filter-item'), function () {
		// read from url and change filter active
		var match = /#cbpf=(.*?)([#|?&]|$)/gi.exec(location.href),
			item;
		if (match !== null) {
			item = filtersContainer.find('.cbp-filter-item').filter('[data-filter="' + match[1] + '"]');
			if (item.length) {
				filtersCallback.call(null, item);
			}
		}
	});


