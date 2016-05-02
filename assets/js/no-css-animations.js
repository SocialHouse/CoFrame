// JavaScript Document

jQuery(function($) {
	var wh = $(window).height();
	var ww = $(window).width();
	fadeInSections();
	
	$('.navbar-fixed-top').animate({
    	opacity: 1
	}, 'slow');

	$(window).scroll(function() {
		var st = $(window).scrollTop();
		fadeInSections();
	});
	
	function fadeInSections() {
		$('.animated').each(function() {
			section = $(this);
			sectionTop = section.offset().top;
			if((sectionTop - $(window).scrollTop()) < wh-200) {
				section.animate({'opacity': 1}, 'slow');
			}
		});
	}
	
		
});