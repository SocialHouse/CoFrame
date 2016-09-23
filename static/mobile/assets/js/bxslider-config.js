jQuery(function($) {
	$(window).on("orientationchange", function () {
		destroySlider();
	});

	function horizSlider() {
		slider = $('.bxslider').bxSlider({
			slideMargin:16,
			infiniteLoop: false,
			nextSelector: '#outlet-next',
			prevSelector: '#outlet-prev',
			nextText: '<i class="fa fa-angle-right fa-custom-circle bg-black"></i>',
			prevText: '<i class="fa fa-angle-left fa-custom-circle bg-black"></i>',
			hideControlOnEnd: true,
			moveSlides: 1,
			pager: false,
			touchEnabled: false,
			breaks: [{screen:320, slides:5},{screen:375, slides:6},{screen:560, slides:8}]
		});
	}
	function destroySlider() {
		slider.destroySlider();
		horizSlider();
	}
	window.onload = function() {
		horizSlider();
	};

});