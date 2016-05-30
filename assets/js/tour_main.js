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
	
	$('.home-video, .home .play-btn').on('click', function() {
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
				$('.page-section').wrap("<div class='blur' style='background-color: #000'></div>");
			}
		}
		else {
			modalClick = false;
		}
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

	// $('#login').on('click',function(){
	// 	var username = $('#username').val();
	// 	var password = $('#login_password').val();
	// 	var remember_me = $('#remember_me:checked').val();
		
	// 	$.ajax({
	// 		"url": base_url+'tour/check_login',
	// 		"data":{"username":username,"password":password,'remember_me':remember_me},
	// 		"type":"POST",
	// 		success: function(response)
	//         {
	//         	var json = $.parseJSON(response);
	//         	if(json.response == 'success')
	//         	{
	//         		window.location.href = base_url+"brands/overview";
	//         	}
	//         	else
	//         	{
	//         		if(json.response == 'verify')
	//         		{
	//         			$('#fail_msg_header').html('Verify account');
	//         			$('#go_to_login').html('Go to login');
	//         		}
	//         		else
	//         		{
	//         			$('#fail_msg_header').html('Invalid Email or Password');
	//         			$('#go_to_login').html('Try again');
	//         		}

	//         		$('#login_fail_msg').html(json.message)	        		
	//         		$('#loginModal').modal('hide');
	//         		$('#invalidEmail').modal('show');

	// 				modalClick = true;
	// 				var $thisModal = $(this).parents('.modal');
	// 				var newModal = $(this).attr('href');
	// 				$thisModal.modal('hide');
	// 				setTimeout(function() {
	// 					$('#invalidEmail').modal('show');
	// 				}, 500);
	// 				$('.blur > .page-section').unwrap();
					
	// 				if(Modernizr.cssfilters) {
	// 					$('.page-section').wrap("<div class='blur' style='background-color: #000'></div>");
	// 				}
	//         	}
	//         }
	// 	});
	// });

	// $('#reset_pass').on('click',function(){
	// 	var email = $('#forgotEmail').val();		
		
	// 	$.ajax({
	// 		"url": base_url+'tour/reset_password',
	// 		"data":{"email":email},
	// 		"type":"POST",
	// 		success: function(response)
	//         {
	//         	var json = $.parseJSON(response);
	//         	if(json.response == 'success')
	//         	{
	//         		$('#recovery_header').html('Password Recovery');
	//         		$('#recovery_message').html(json.message);
	//         		$('#dismissBtn').show();
	//         		$('#go_to_revover_pass').hide();	        		
	//         		$('#go_login').hide();
	//         	}
	//         	else
	//         	{
	//         		$('#recovery_header').html('Forgot password error');
	//         		$('#recoverPassSuccessBtn').html('Try again');

	//         		$('#go_to_revover_pass').show();
	//         		$('#dismissBtn').hide();
	//         		$('#go_login').hide();	
	//         		$('#recovery_message').html(json.message);
	//         	}

	//         	modalClick = true;
	// 			var $thisModal = $(this).parents('.modal');
	// 			$('#recoverPassword').modal('hide');
	// 			setTimeout(function() {
	// 				$('#recoverPasswordSuccess').modal('show');
	// 			}, 500);
	// 			$('.blur > .page-section').unwrap();

	// 			if(Modernizr.cssfilters) {
	// 				$('.page-section').wrap("<div class='blur' style='background-color: #000'></div>");
	// 			}
	//         }
	// 	});
	// });

	// $('#save_pass').on('click',function(){
	// 	var newPass = $('#newPass').val();		
	// 	var token = $('#token').val();
		
	// 	$.ajax({
	// 		"url": base_url+'tour/save_password',
	// 		"data":{"password":newPass,'token': token},
	// 		"type":"POST",
	// 		success: function(response)
	//         {
	//         	var json = $.parseJSON(response);
	//         	if(json.response == 'success')
	//         	{
	//         		$('#recovery_header').html('');	        		
	//         		$('#savePassword').modal('hide');
	//         		$('#recovery_message').html(json.message);
	//         		// $('#loginModal').modal('show');
	//         		// $('#recoverPasswordSuccess').modal('show');
	//         		$('#go_login').show();
	//         		$('#go_to_revover_pass').hide();
	//         		$('#dismissBtn').hide();
	//         	}
	//         	else
	//         	{
	//         		$('#recovery_header').html('Forgot password error');
	//         		if(json.response == 'fail')
	//         		{	        			
	//         			$('#recoverPassSuccessBtn').html('Try again');
	//         		}
	//         		$('#go_login').hide();	
	//         		$('#go_to_revover_pass').show();
	//         		$('#dismissBtn').hide();
	//         		$('#recovery_message').html(json.message);
	//         		$('#savePassword').modal('hide');
	//         		// $('#recoverPasswordSuccess').modal('show');
	//         	}

	//         	modalClick = true;
	// 			var $thisModal = $(this).parents('.modal');
	// 			var newModal = $(this).attr('href');
	// 			$thisModal.modal('hide');
	// 			setTimeout(function() {
	// 				$('#recoverPasswordSuccess').modal('show');
	// 			}, 500);
	// 			$('.blur > .page-section').unwrap();

	// 			if(Modernizr.cssfilters) {
	// 				$('.page-section').wrap("<div class='blur' style='background-color: #000'></div>");
	// 			}
	//         }
	// 	});
	// });
	
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