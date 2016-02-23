jQuery(function($) {	
	function horizSlider() {
		slider = $('.bxslider').bxSlider({
			slideMargin:0,
			infiniteLoop: false,
			preloadImages:'all',
			autoReload: true,
			nextText: '',
			prevText: '',
			pager: false,
			breaks: [{screen:768, slides:2},{screen:769, slides:4}]
		});
	}
	function destroySlider() {
		slider.reloadSlider();
		horizSlider();
	}
	window.onload = function() {
		horizSlider();
	}
});