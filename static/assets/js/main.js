jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();

	$(window).on("orientationchange resize", function () {
		wh = $(window).height();
		ww = $(window).width();
	});
	$('[data-toggle="popover"]').popover({
		container: 'body',
		html: true,
		trigger: 'focus'
	});

	$(document).ready(function() {

		$('.show-brands-toggler').on('click', function(e) {
			e.preventDefault();
		});
		
		$('#post-details .outlet-list li').on('click', function() {
			var outlet = $(this).attr('data-selected-outlet');
			$(this).toggleClass('disabled');
			$(this).siblings().addClass('disabled');
			$('#postOutlet').val(outlet);
		});


		//equal column heights
		var dashboardH = $('#brand-manage').height();
		var headhH = $('.page-main-header').outerHeight(true);
		$('.equal-cols [class*=col-]').each(function() {
			$(this).css('height', dashboardH - headhH - 2);
		});
	});

});

