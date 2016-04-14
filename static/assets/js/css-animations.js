jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();

	$('.navbar-fixed-top').animate({
    	opacity: 1
	}, 1000);

	$(window).on("orientationchange resize", function () {
		if(ww > 1024) {
			animateSections();
		}
	});
	
	$(window).scroll(function() {
		if(ww > 1024) {
			animateSections();
		}
	});
	
	//animated content
	if(ww > 1024) {
		animateSections();
	}

	function animateSections() {
		$('.animated').each(function() {
			var section = $(this);
			var sectionTop = section.offset().top;
			if((sectionTop - $(window).scrollTop()) < wh) {
				var animation = section.data('animation');
				section.addClass(animation);
			}
		});
	}
		
	Modernizr.load([
	  {
		// test for css animation support
		test: Modernizr.cssanimations,
		// Modernizr.load loads javascript if cssanimations not supported
		nope: '/wp-content/themes/sassapress/assets/js/no-css-animations.js',
		// Modernizr.load loads javascript if cssanimations are supported
		yep: '/wp-content/themes/sassapress/assets/js/css-animations.js'
	  }
	]);
});