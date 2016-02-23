jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();
	var path = window.location.pathname;

	window.onload = function() {
		centerCentered();
	};

	$(window).on("orientationchange resize", function () {
		wh = $(window).height();
		ww = $(window).width();
		centerCentered();
	});
	
	$(window).scroll(function() {
		var st = $(window).scrollTop();
		//set scrolled state of nav bar on internal pages
		if(st > 40 && ww < 959) {
			$('#menu-global-navigation').addClass('scrolled');
		}
		else {
			$('#menu-global-navigation').removeClass('scrolled');
		}
	});

	$('.navbar-main-wrapper').on('show.bs.collapse', function () {
		$('html').addClass('nav-expand');
	});
	$('.navbar-main-wrapper').on('hide.bs.collapse', function () {
		$('html').removeClass('nav-expand');
	});
	
	$('.navbar-main .nav-link').on('click', function(e) {
		e.preventDefault();
		var section = $(this).attr('href');
		var sectionTop = $(section).offset().top;
		
		$('body, html').animate({scrollTop: sectionTop});
	});
	
	//set positioning of dropdown menus
	//set parent to display block to calculate offset
	$('.mega-menu:not(.columns) .dropdown-menu').css({'display': 'block', 'opacity': 0});
	var $dropdowns = $('.mega-menu:not(.columns) .mega-nav');
	$dropdowns.each(function() {
		var $drop = $(this);
		var $dropParent = $drop.parents('.mega-menu');
		var pLeft = $dropParent.offset().left;
		var dLeft = $drop.offset().left;
		var padding = Math.ceil(pLeft - dLeft);
		$drop.css('padding-left', padding);
		$drop.parents('.dropdown-menu').css({'display': '', 'opacity': ''});
	});

	//set active press menu state
	if(path.indexOf('press') >= 0) {
		var $pressMenu = $('#menu-global-navigation').find('a[href*="press"]');
		var $pressPage = $('.left-col .nav').find('a[href*="press"]');
		$pressPage.parents('.page_item').addClass('current_page_ancestor');
		$pressMenu.parents('.menu-item').addClass('current-menu-ancestor');
	}
	//set active team state
	if(path.indexOf('team') >= 0) {
		var $teamMenu = $('#menu-global-navigation').find('a[href*="team"]');
		var $teamPage = $('.left-col .nav').find('a[href*="team"]');
		$teamPage.parents('.page_item').addClass('current_page_ancestor');
		$teamMenu.parents('.menu-item').addClass('current-menu-ancestor');
	}
	
	$('#searchform').click(function() {
		$(this).addClass('focused');
	});
	
	//contact map
	$('#googlemap').on('click', function() {
		$('#googlemap iframe').css("pointer-events", "auto");
	});
	$('#googlemap').on('mouseleave', function() {
		$('#googlemap iframe').css("pointer-events", "none");
	});

	
	$('.accordion .collapse').on('show.bs.collapse', function () {
	  	var openLink = $(this).prev();
		openLink.find('.fa').removeClass('fa-angle-right').addClass('fa-angle-down');
	});
	$('.accordion .collapse').on('hide.bs.collapse', function () {
	  	var openLink = $(this).prev();
		openLink.find('.fa').removeClass('fa-angle-down').addClass('fa-angle-right');
		openLink.blur();
	});
	
	if($('.accordion').length) {
		var hash = window.location.hash;
		if(hash.length) {
			var showTop = $(hash).prev().offset().top;
			$('body, html').animate({scrollTop: showTop+70}, function() {
				$(hash).collapse('show');
			});
		}
	}
		
	$('.get-more-info-modal a').on('click',function(e) {
		e.preventDefault();
		$('#moreInfo').modal();
	});
	

	function centerCentered() {
		$( '.centered' ).each(function() {
			var cH = $(this).outerHeight();
			var parentH = $(this).parents('.item').height();
			$(this).css('margin-top',  ((parentH - cH)/2)).removeClass('invisible');
		});
	}

});