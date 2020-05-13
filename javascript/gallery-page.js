var slickCarouselOptions = {

	//lazyLoad: 'ondemand',
	slickFilter: 'figure',
	slidesToShow: 2,
	slidesToScroll: 2,
	infinite: true,
	prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
	nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
	mobileFirst: true,
	responsive: [
		{
			breakpoint: 480,
			settings: {
				slickFilter: 'figure',
				rows: 2,
				slidesPerRow: 4,
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
	]
};

jQuery(document).ready(function() {


	jQuery('.image-gallery').each( function() {
		var imageGallery = jQuery(this);
		var items = [];

		imageGallery.find('a').each(function() {
			var anchor = jQuery(this);
			var item = {
				src : anchor.attr('href'),
				w : anchor.data('width'),
				h : anchor.data('height'),
				title : anchor.attr('aria-label')
			}

			items.push(item);
		});

		var $pswp = jQuery('.pswp')[0];

		imageGallery.on('click', 'figure', function(event) {

			event.preventDefault();

			var figure = jQuery(this);

			var index = figure.data('index');
			var options = {
				index: index,
				bgOpacity: 0.7,
				showHideOpacity: true,
				fullscreenEl: true,
				shareEl: false,
			}

			// Initialize PhotoSwipe
			var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
			lightBox.init();
		});
	});

	jQuery('.gallery-widget .image-gallery').slick(slickCarouselOptions);

});
