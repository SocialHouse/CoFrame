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

	$(document).ready(function() {
		
		$('.navbar-main').on('show.bs.collapse', function () {
			$('html').addClass('nav-expand');
		});
		$('.navbar-main').on('hide.bs.collapse', function () {
			$('html').removeClass('nav-expand');
		});
		
		$('.to-do-list ol, .to-do-list ul, .pricing-details ul').on('show.bs.collapse', function () {
			var arrow = $(this).parent().find('.expand-collapse:first');
			arrow.addClass('fa-angle-down').removeClass('fa-angle-right');
		});
		$('.to-do-list ol, .to-do-list ul, .pricing-details ul').on('hide.bs.collapse', function () {
			var arrow = $(this).parent().find('.expand-collapse');
			arrow.removeClass('fa-angle-down').addClass('fa-angle-right');
		});


		$('body').on('click', '.show-hide', function(e) {
			e.preventDefault();
			var $trigger = $(this);
			var show = $trigger.data('show');
			var hide = $trigger.data('hide');
			if(hide) { 
				$(hide).slideUp(function() {
					//call custom function on completion
					$(hide).trigger('contentSlidUp', [$trigger]);
					$(show).slideDown(function(){
						$(show).trigger('contentSlidDown', [$trigger]);
					});
				});
			}
			else {
				$(show).slideToggle(function(){
					$(show).trigger('contentSlidDown', [$trigger]);
				});
			}
		});

	});

	$('body').on('click', '.target-hidden', function(e) {
		e.preventDefault();
		var target = $(this).attr('href');
		$(target).click();
	});
	
	$('body').on('click', '.outlet-list li:not(.filter)', function(e) {
		$(this).toggleClass('disabled');
		$(this).siblings().addClass('disabled');
	});
	
	$('.content-editable').each(function() {
		var id = $(this).attr('id');
		document.getElementById(id).addEventListener("input", function() {
			var input = $(this).data('input');
			var content = $(this).html();
			$(input).val(content);
		});
	});

	//assign tags to post
	$('body').on('click', '.tag:not(.filter)', function() {
		var tagVal = $(this).data('value');
		var tagGroup = $(this).data('group');
		if(tagVal !== 'check-all') {
			$(this).toggleClass('selected');
			var checked = false;
			if ($(this).hasClass('selected')) {
				checked = true;
			} else {
				checked = false;
			}
			//set the input value
			var $input = $(this).find('input');
			$input.prop('checked', checked);
		}
		else {
			$('.tag[data-group="' + tagGroup + '"]').each(function() {
				if(!$(this).hasClass('selected')) {
					$(this).addClass('selected');
					checked = true;
					//set the input value
					var $input = $(this).find('input');
					$input.prop('checked', checked);
				}
			});
		}
	});

	//Time selector functions
	$('body').on('click', '.incrementer', function(e) {
		var $target = $(e.target);
		var incDec = ($target.hasClass('increase')) ? 'increase' : 'decrease';
		var inputName = $(this).data('for');
		var relatedInput = $('input[name="' + inputName + '"]');
		if(relatedInput.hasClass('hour-select')) {
			setHrs(relatedInput, incDec);
		}
		if(relatedInput.hasClass('minute-select')) {
			setMins(relatedInput, incDec);
		}
		if(relatedInput.hasClass('amselect')) {
			setAmPm(relatedInput);
		}
	});
	$('body').on('keydown', '.time-input', function(e) {
		var incDec;
		//up arrow pressed
		if(e.which === 38) {
			incDec = 'increase';
		}
		//down arrow pressed
		else if(e.which === 40) {
			incDec = 'decrease';
		}
		else {
			return;
		}
		var input = $(this);
		if(input.hasClass('hour-select')) {
			setHrs(input, incDec);
		}
		if(input.hasClass('minute-select')) {
			setMins(input, incDec);
		}
		if(input.hasClass('amselect')) {
			setAmPm(input);
		}
	});

	function setHrs(input, incDec) {
		var newVal;
		var minVal = $(input).attr('data-min');
		var maxVal = $(input).attr('data-max');
		var inputVal = parseFloat($(input).val());
		if(!inputVal) {
			inputVal = 0;
		}
		if(incDec === "increase") {
			if(inputVal < maxVal) {
				newVal = inputVal + 1;
			}
			else if(inputVal >= maxVal) {
				newVal = minVal;
			}
		}
		else if(incDec === "decrease") {
			if(inputVal > minVal) {
				newVal = inputVal - 1;
			}
			else if(inputVal <= minVal) {
				newVal = maxVal;
			}
		}
		$(input).val(newVal);
	}
	function setMins(input, incDec) {
		var newVal;
		var minVal = $(input).attr('data-min');
		var maxVal = $(input).attr('data-max');
		var inputVal = parseFloat($(input).val());
		if(!inputVal) {
			inputVal = 0;
		}
		if(incDec === "increase") {
			if(inputVal < maxVal) {
				newVal = inputVal + 1;
			}
			else if(inputVal >= maxVal) {
				newVal = minVal;
			}
		}
		else if(incDec === "decrease") {
			if(inputVal > minVal) {
				newVal = inputVal - 1;
			}
			else if(inputVal <= minVal) {
				newVal = maxVal;
			}
		}
		if(newVal < 10) {
			newVal = '0' + newVal;
		}
		$(input).val(newVal);
	}
	function setAmPm(input) {
		($(input).val() === 'am') ? $(input).val('pm') : $(input).val('am');
	}
	window.addIncrements = function addIncrements() {
		$('body').find('.time-select .time-input').each(function() {
			var inputName = $(this).attr('name');
			var increment = '<div class="incrementer" data-for="' + inputName + '"><i class="fa fa-caret-up increase"></i><i class="fa fa-caret-down decrease"></i></div>';
			$(this).after(increment);
			if($(this).hasClass('minute-select')) {
				$(this).before('<span class="time-separator">:</span>');
			}
		});
	};
	addIncrements();

});

	var today = new Date();

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

	function showContent(obj) {
		obj.fadeIn(function() {
			obj.trigger('contentShown');
		});
	}
	function hideContent(obj) {
		obj.fadeOut(function() {
			obj.trigger('contentHidden');
		});
	}