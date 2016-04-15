jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();

	$(window).on("orientationchange resize", function () {
		wh = $(window).height();
		ww = $(window).width();
	});
	$('[data-toggle="popover"]').popover({
		container: 'body',
		html: true
	});
	
});

