jQuery(function($) {

	// alert('test');
	// $('#invalidEmail').modal('show');

	var wh = $(window).height();
	var ww = $(window).width();

	$(window).on("orientationchange resize", function () {
		wh = $(window).height();
		ww = $(window).width();
		if(ww < 1024) {
			if(!$.scrollify.isDisabled()) {
				$.scrollify.disable();
			}
		}
	});
	
	$(window).scroll(function() {
		var st = $(window).scrollTop();
		if(ww > 991) {
			if(st >= wh && $('.navbar-fixed-top').hasClass('home')) {
				$('.navbar-fixed-top .btn-login').fadeOut(function() {
					$('.navbar-fixed-top').removeClass('home');
					$(this).fadeIn();
				});
			}
			else if(st ===0 ) {
				$('.navbar-fixed-top .btn-login').fadeOut(function() {
					$('.navbar-fixed-top').addClass('home');
					$(this).fadeIn();
				});
			}
		}
	});
	
	//activate scrollify plugin
	if(ww > 1023) {
		$.scrollify({
			section : ".page-section",
		});
	}

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
		
		$('body, html').animate({scrollTop: sectionTop}, function() {
			$('.nav-toggle').collapse('hide');
		});
	});
	$('.section-content a').on('click',function(e) {
		var href = $(this).attr('href');
		//if href starts with #, animate scroll to section
		if(/^#/.test(href) === true) {
			e.preventDefault();
			var sectionTop = $(href).offset().top;
			$('body, html').animate({scrollTop: sectionTop});
		}
	});
	
	$('.page-next-prev a').on('click', function(e) {
		e.preventDefault();
		var section = $(this).attr('href');
		var $thisSection = $(this).parents('.page-section');
		var $next;
		if(section === '#next') {
			$next = $thisSection.next('.page-section');
		}
		else {
			$next = $thisSection.prev('.page-section');
		}
		var sectionTop = $next.offset().top;
		
		$('body, html').animate({scrollTop: sectionTop});
	});
	
	$('.home .play-btn').on('click', function() {
		$('.home-video .embed-responsive').animate({opacity: 1},function() {
			playVideo();
		});
		$('.home .play-btn').fadeOut();
	});
	
	$('.btn-choose-plan').on('click', function() {
		var plan = $(this).attr('data-plan');
		var price = $(this).attr('data-price');
		$('#plan').val(plan.toUpperCase());
		$('#selected-plan').html('<span class="highlight">' + plan + '</span><br>(' + price + ' per month)');
	});

	$('#plan').change(function(){		
		if($(this).val())
			$('#selected-plan').html('<span class="highlight">' + $(this).val() + '</span><br>(' + $(this).find(':selected').attr('data-price') + ' per month)');
	});
	
	
	/*Modal Functions*/
	$('.modal').modal({
		backdrop: false,
		show: false
	});
	
	$('.modal-toggler').on('click', function() {
		modalClick = false;
		$('.modal').modal('hide');
	});
	/*
	boolean & functions for checking if we are navigating between modals
	if true, we don't need to perform the fading and wrapping functions each time a new modal is shown/hidden
	*/
	var modalClick = false;
	$('.modal').on('show.bs.modal', function() {
		if(!modalClick) {			
			$.scrollify.disable();
			$('.page-template-default').addClass('modal-open');

			$('.section-content, .page-next-prev, .container-head').fadeOut();
			$('.modal-toggler').fadeIn();
			if(Modernizr.cssfilters) {
				$('.page-section').wrap("<div class='blur' style='background-color: #000; height: 100%;'></div>");
			}
		}
		else {
			modalClick = false;
		}
	});
	$('#loginModal').on('shown.bs.modal', function() {
		$('#email_id').focus();
	});
	$('.modal').on('hidden.bs.modal', function() {
		if(!modalClick) {
			
    		$('.page-template-default').removeClass('modal-open');
    		$.scrollify.enable();
	    	
			$('.section-content, .container-head').fadeIn();
			if(ww > 991) {
				$('.page-next-prev').fadeIn();
			}
			$('.modal-toggler').fadeOut();
			$('.blur > .page-section').unwrap();
		}
	});
	
	$(document).keyup(function(e) {
	    if (e.keyCode == 27) { 
	    	if($('.page-template-default').hasClass('modal-open'))
	    	{
	    		$('.page-template-default').removeClass('modal-open');
	    		$.scrollify.enable();
	    	}
	    }
	});

	$('.modal [data-toggle]').on('click', function(e) {
		e.stopPropagation();
		modalClick = true;
		var $thisModal = $(this).parents('.modal');
		var newModal = $(this).attr('href');
		$thisModal.modal('hide');
		setTimeout(function() {
			$(newModal).modal('show');
		}, 500);
	});
	
	//international phone drop-down
	$.fn.intlTelInput.loadUtils( base_url+"assets/js/vendor/utils.js");

	var telInput = $("#phone");
  	
	telInput.intlTelInput({
		dropdownContainer: "body",
		geoIpLookup: function(callback) {
		$.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
			var countryCode = (resp && resp.country) ? resp.country : "";
			callback(countryCode);
		});
		},
		initialCountry: "auto",
		separateDialCode: true
	});
	
	// initialise plugin

	// on blur: validate
	telInput.blur(function() {
		if ($.trim(telInput.val())) {
		    if (telInput.intlTelInput("isValidNumber")) {
			    $(telInput).data('error','true');
		    }else{
		    	console.log($(telInput).data('error'));
		    	$(telInput).data('error','false');	
	    	}
	  	}
	});

	// console.log(jQuery("#phone").intlTelInput("getNumber"));
	//$.fn.intlTelInput.loadUtils( base_url+"assets/js/vendor/utils.js");
	
	//animated content
	// test for css animation support with fallback
	if(Modernizr.cssanimations) {
		$.getScript(base_url+'assets/js/css-animations.js');
	}
	else {
		$.getScript(base_url+'assets/js/no-css-animations.js');
	}
	
	
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
	//$('#phone').mask("000-000-0000", {placeholder: "Phone"});
});

//Youtube Iframe API
// This code loads the IFrame Player API code asynchronously.

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// This function creates an <iframe> (and YouTube player)
// after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		videoId: 'dQw4w9WgXcQ'
	});
}

function playVideo() {
	player.playVideo();
}