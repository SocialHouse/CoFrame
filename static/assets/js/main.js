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

	//popover triggers
	$('[data-toggle="popover"]').popover({
		container: 'body',
		html: true,
		trigger: 'focus'
	});
	//Get popover content from an external source
	$('[data-toggle="popover-ajax"]').one('click', function() {
		var target=$(this);
		var position = target.data('placement');
		var pclass = target.data('popoverClass');
		var pid = target.data('popoverId');
		$.get(target.data('contentSrc'),function(data) {
			var popoverDiv = $(document.createElement('div'));
			var popoverContent = $(document.createElement('div'));
			popoverContent.addClass('popover-content').html(data);
			popoverDiv.addClass('popover-inline popover ' + pclass).attr('id', pid).html(popoverContent).insertAfter(target);
			new Tether({
				element: '#' + pid,
				target: target,
				attachment: 'bottom right',
				targetAttachment: 'top right',
				offset: '2px 0'
			});
			popoverDiv.animate({'opacity': 1});
		});
	});
	//Get popover content from an inline div
	$('[data-toggle="popover-inline"]').on('click', function() {
		console.log('popover inline');
		var target=$(this);
		var position = target.data('placement');
		var pclass = target.data('popoverClass');
		var pcontent = target.data('contentSrc');
		target.popover({
			content: $(pcontent).html(),
			container: '.container-post-details',
			html: true,
			placement: position,
			template: '<div class="popover ' + pclass + '" role="tooltip"><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
		}).popover('toggle');
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

		//fake radio button select
		$('.radio-button').on('click', function() {
			var buttonVal = $(this).attr('data-value');
			var checked = false;
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

		$('.tag-select').on('click', function() {
			$(this).toggleClass('selected');
			if($(this).data('popoverId')) {
				var popover = $(this).data('popoverId');
				$('#' + popover).fadeToggle();
			}
		});

		$('body').on('click', '.tag-list .tag', function() {
			var checked = false;
			$(this).toggleClass('selected');
			var numTags = $('.tag-list .selected').length;
			var tag = $(this).find('.fa');
			var tagClass = tag.attr('class');
			if($(this).hasClass('selected')) {
				var newTag = tag.clone();
				newTag.prependTo('.tag-select');
				checked = true;
			}
			else {
				$('.tag-select').find('.fa').each(function() {
					if($(this).attr('class') === tagClass) {
						$(this).remove();
					}
				});
				checked = false;
			}
			if(numTags > 0) {
				$('.tag-select .fa.color-gray-lighter').hide();
			}
			else {
				$('.tag-select .fa.color-gray-lighter').show();
			}
			//set the input value
			var buttonVal = $(this).attr('data-value');
			$('input[value="' + buttonVal + '"]').prop('checked', checked);
		});
		$('body').on('click', function(e) {
			var $target = $(e.target);
			if($target.closest('.popover').length === 0 && $target.closest('.tag-select').length === 0) {
				$('.popover').fadeOut();
				$('.tag-select').removeClass('selected');
			}
		});
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