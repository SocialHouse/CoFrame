jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();

	if($('#brand-manage').length) {
		setUserTime();
	}

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
		var headhH = $('.page-main-header').innerHeight();
		var colsH = $('.equal-cols').innerHeight();
		var newColsH = dashboardH - headhH - 2;
		$('.equal-cols [class*=col-]').each(function() {
			if(newColsH > colsH) {
				$(this).css('height', dashboardH - headhH - 2);
			}
			else {
				$(this).css('height', colsH);
			}
		});

		//temp nav activation
		var pathname = location.pathname;
		var pagename = pathname.replace('/static/', '');
		$('.navbar-brand-manage .nav-link').each(function() {
			var href = $(this).attr('href');
			if(href === pagename) {
				$(this).addClass('active');
			}
		});
	});

	//fake radio button select
	$('.radio-button').on('click', function() {
		var buttonVal = $(this).attr('data-value');
		$(this).toggleClass('selected');
		if(buttonVal === "check-all") {
			var inputGroup = $(this).attr('data-group');
			$('.radio-button[data-group="' + inputGroup + '"]').addClass('selected').html('<i class="fa fa-check"></i>');
			$('input[name="' + inputGroup + '"]').prop('checked', true);
		}
		if($(this).hasClass('selected')) {
			checked = true;
			$(this).html('<i class="fa fa-check"></i>');
		}
		else {
			checked = false;
			$(this).html('');
		}
		$('input[value="' + buttonVal + '"]').prop('checked', checked);
	});

});

function setUserTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    h = checkHours(h);
    m = checkMinutes(m);
    document.getElementById('userTime').innerHTML = h + ":" + m;
    var t = setTimeout(setUserTime, 500);
}
function checkMinutes(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
function checkHours(i) {
    if (i > 12) {i = i-12}; //12 hour format
    return i;
}