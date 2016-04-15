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

	$(document).ready(function() {
		$('.calendar-summary #calendar').fullCalendar({
			aspectRatio: '.92',
			buttonText: {
				prev: '',
				next: ''
			},
			contentHeight: 'auto',
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			fixedWeekCount: false,
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			theme: true,
			themeButtonIcons: false
    	});
	});

});

