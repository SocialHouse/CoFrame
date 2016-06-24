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
		
		$('body').on('click', '#post-details .outlet-list li', function() {
			var outlet = $(this).data('selectedOutlet');
			$(this).toggleClass('disabled');
			$(this).siblings().addClass('disabled');
			$('#postOutlet').val(outlet);
		});

		//equal column heights
		equalColumns();

		//temp nav activation
		var pathname = location.pathname;
		var pagename = pathname.replace('/static/', '');
		$('.navbar-brand-manage .nav-link').each(function() {
			var href = $(this).attr('href');
			if(href === pagename) {
				$(this).addClass('active');
			}
		});

		//fake check box select
		var btnClicks = 0;
		$('body').on('click', '.check-box', function() {
			var $btn = $(this);
			if($btn.hasClass('disabled')){
				return;
			}
			var buttonVal = $btn.attr('data-value');
			var checked = false;
			var inputGroup = $btn.attr('data-group');
			if(buttonVal !== "check-all") {
				$btn.toggleClass('selected');
			}
			else if(buttonVal === "check-all" && !$btn.hasClass('selected')) {
				$('.check-box[data-group="' + inputGroup + '"]').addClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', true);
			}
			else if(buttonVal === "check-all" && $btn.hasClass('selected')) {
				$('.check-box[data-group="' + inputGroup + '"]').removeClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', false);
			}
			if($btn.hasClass('selected')) {
				checked = true;
			}
			else {
				checked = false;
			}
			$('input[value="' + buttonVal + '"]').prop('checked', checked).trigger('change');
			//add selected users to list from popover
			if($btn.closest('#qtip-popover-user-list').length !== 0) {
				var userImg = $btn.closest('li').find('img');
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var $activePhase = $('.approval-phase.editing');
				var activePhaseId = $activePhase.attr('id');
				if($btn.hasClass('selected')) {
					$activePhase.find('.user-list li').prepend(imgDiv);
					$btn.attr('data-linked-phase', activePhaseId);
					btnClicks++;
				}
				else {
					$activePhase.find('img[src="' + imgSrc + '"]').parent().remove();
					$btn.removeAttr('data-linked-phase');
					btnClicks--;
				}
				if(btnClicks > 0) {
					$activePhase.find('.post-approver-name').hide();
				}
				else {
					$activePhase.find('.post-approver-name').show();
				}
			}
		});
		//fake check box label click
		$('body').on('click', '.label-check-box', function() {
			var related = $(this).data('for');
			$('.check-box[data-value="' + related + '"]').trigger('click');
		});

		//fake radio button select
		$('body').on('click', '.radio-button', function() {
			var $btn = $(this);
			if($btn.hasClass('disabled')){
				return;
			}
			var buttonVal = $btn.attr('data-value');
			var checked = false;
			var inputGroup = $btn.attr('data-group');
			var $siblings = $('.radio-button[data-group="' + inputGroup + '"]');
			$siblings.removeClass('selected');
			$btn.toggleClass('selected');
			if($btn.hasClass('selected')) {
				checked = true;
			}
			else {
				checked = false;
			}
			$('input[value="' + buttonVal + '"]').prop('checked', checked);
		});

		$('body').on('click', '.select-box', function() {
			var $box = $(this);
			var boxVal = $box.attr('data-value');
			var inputGroup = $box.attr('data-group');
			if(boxVal !== "check-all") {
				$box.toggleClass('checked');
			}
			else if(boxVal === "check-all" && !$box.hasClass('checked')) {
				$('.select-box[data-group="' + inputGroup + '"]').addClass('checked');
			}
			else if(boxVal === "check-all" && $box.hasClass('checked')) {
				$('.select-box[data-group="' + inputGroup + '"]').removeClass('checked');
			}
		});

		$('body').on('click', '#facebookMediaUpload .media-item', function() {
			var mediaType = $(this).data('value');
			$('input[value="' + mediaType + '"]').prop('checked', true);
			$('#facebookMediaUpload').slideUp(function() {
				if(mediaType === "Album") {
					$('#mediaUpload').addClass('photo-album-upload');
				}
				$('#mediaUpload').slideDown(function() {
					if(mediaType === "Album") {
						$('#albumType').show();
					}
				});
			});
		});
		$('#albumName').on('keyup', function() {
			if($(this).val() !== "") {
				$('input[value="newAlbum"]').prop('checked', true);
			}
		});
		$('#existingAlbum').on('change', function() {
			if($(this).val() !== "") {
				$('input[value="existingAlbum"]').prop('checked', true);
			}
		});
		//popover triggers
		$('[data-toggle="popover"]').qtip({
			content: {
				attr: 'data-content'
			},
			position: {
				my: 'top center',
				at: 'bottom center'
			},
			show: {
				effect: function() {
					$(this).fadeIn();
				},
				event: 'click'
			},
			hide: {
				effect: function() {
					$(this).fadeOut();
				},
				event: 'click unfocus'
			},
			style: {
				classes: 'qtip-shadow',
				tip: {
					width: 20,
					height: 10
				},
				width: 280
			}
		});
		//load popover on page load
		$('[data-toggle="popover-onload"]').qtip({
			content: {
				attr: 'data-content'
			},
			position: {
				my: 'top center',
				at: 'bottom center'
			},
			show: {
				effect: function() {
					$(this).fadeIn();
				},
				ready: true
			},
			hide: {
				effect: function() {
					$(this).fadeOut();
				},
				event: 'unfocus'
			},
			style: {
				classes: 'qtip-shadow text-xs-center',
				tip: {
					width: 20,
					height: 10
				},
				width: 320
			}
		});
		//Get popover content from an external source
		$('body').on('click', '[data-toggle="popover-ajax"]', function(e) {
			var $target=$(this);
			var pcontent = $target.data('contentSrc');
			var pclass = $target.data('popoverClass');
			var pid = $target.data('popoverId');
			var pattachment = $target.data('attachment');
			var ptattachment = $target.data('targetAttachment');
			var poffsetX = $target.data('offsetX');
			var poffsetY = $target.data('offsetY');
			var pwidth = $target.data('popover-width');
			var ptitle = $target.data('title');
			var parrow = $target.data('popoverArrow');
			var arrowcorner = $target.data('arrowCorner');
			var pcontainer = $target.data('popoverContainer');
			var phide = $target.data('hide');
			if(!pcontainer) {
				pcontainer = '.page-main';
			}
			var tipW = 1;
			var tipH = 1;
			if(parrow) {
				tipW = 20;
				tipH = 10;
			}
			if(phide !== false) {
				phide = 'click unfocus';
			}
			$target.qtip({
				content: {
					title: ptitle,
					text: 'Loading...',
					ajax: {
						url: pcontent,
						type: 'GET',
						once: true
					}
				},
				events: {
					show: function() {
						$target.attr('data-toggle', 'popover-ajax-inline');
					},
					visible: function() {
						var classes = $(this).qtip('api').get('style.classes');
						$('.qtip').trigger('qtipShown', [classes]);
					}
				},
				id: pid,
				position: {
					adjust: {
						x: poffsetX,
						y: poffsetY
					},
					at: ptattachment,
					my: pattachment,
					container: $(pcontainer),
					target: $target
				},
				show: {
					effect: function() {
						$(this).fadeIn();
					},
					event: e.type,
					ready: true,
					solo: true
				},
				hide: {
					effect: function() {
						$(this).fadeOut();
					},
					event: phide
				},
				overwrite: false,
				style: {
					classes: 'qtip-shadow ' + pclass,
					tip: {
						width: tipW,
						height: tipH,
						corner: arrowcorner,
						mimic: 'center'
					},
					width: pwidth
				}
			}, e);
		});

		//Get popover content from an external source
		$('body').on('click', '[data-toggle="popover-ajax-inline"]', function(e) {
			var $target = $(this);
			var pid = $target.data('popoverId');
			var pclass = $target.data('popoverClass');
			var pattachment = $target.data('attachment');
			var ptattachment = $target.data('targetAttachment');
			var poffsetX = $target.data('offsetX');
			var poffsetY = $target.data('offsetY');
			var pwidth = $target.data('popover-width');
			var ptitle = $target.data('title');
			var parrow = $target.data('popoverArrow');
			var arrowcorner = $target.data('arrowCorner');
			var pcontainer = $target.data('popoverContainer');
			var phide = $target.data('hide');
			if(!pcontainer) {
				pcontainer = '.page-main';
			}
			var tipW = 1;
			var tipH = 1;
			if(parrow) {
				tipW = 20;
				tipH = 10;
			}
			if(phide !== false) {
				phide = 'click unfocus';
			}
			$('#qtip-' + pid).qtip('api').set({
				'content.title': ptitle,
				'events.visible' : function() {
					var classes = $(this).qtip('api').get('style.classes');
					$('.qtip').trigger('qtipShown', [classes]);
				},
				'hide.effect': function() { $(this).fadeOut(); },
				'hide.event': phide,
				'position.adjust.x': poffsetX,
				'position.adjust.y': poffsetY,
				'position.at': ptattachment,
				'position.my': pattachment,
				'position.container': $(pcontainer),
				'position.target': $target,
				'overwrite': false,
				'show.effect': function() { $(this).fadeIn(); },
				'show.event': e.type,
				'show.solo': true,
				'style.classes': 'qtip-shadow ' + pclass,
				'style.tip.corner': arrowcorner,
				'style.tip.mimic': 'center',
				'style.tip.height': tipH,
				'style.tip.width': tipW,
				'style.width': pwidth
			}, e);
		});

		//Get popover content from an inline div
		$('body').on('click', '[data-toggle="popover-inline"]', function(e) {
			var $target = $(this);
			var pid = $target.data('popoverId');
			var pclass = $target.data('popoverClass');
			var pattachment = $target.data('attachment');
			var ptattachment = $target.data('targetAttachment');
			var poffsetX = $target.data('offsetX');
			var poffsetY = $target.data('offsetY');
			var pwidth = $target.data('popover-width');
			var parrow = $target.data('popoverArrow');
			var arrowcorner = $target.data('arrowCorner');
			var pcontainer = $target.data('popoverContainer');
			if(!pcontainer) {
				pcontainer = '.page-main';
			}
			var tipW = 1;
			var tipH = 1;
			if(parrow) {
				tipW = 20;
				tipH = 10;
			}
			$target.qtip({
				content: {
					text: $('#' + pid)
				},
				events: {
					visible: function() {
						var classes = $(this).qtip('api').get('style.classes');
						$('.qtip').trigger('qtipShown', [classes]);
					}
				},
				hide: {
					effect: function() {
						$(this).fadeOut();
					},
					event: 'click unfocus'
				},
				position: {
					adjust: {
						x: poffsetX,
						y: poffsetY
					},
					at: ptattachment,
					my: pattachment,
					container: $(pcontainer),
					target: $target
				},
				overwrite: false,
				show: {
					effect: function() {
						$(this).fadeIn();
					},
					event: e.type,
					ready: true,
					show: true,
				},
				style: {
					classes: 'qtip-shadow ' + pclass,
					tip: {
						corner: arrowcorner,
						mimic: 'center',
						height: tipH,
						width: tipW
					},
					width: pwidth
				}
			}, e);
		});

		$('body').on('click blur', '.popover-toggle', function(e) {
			e.preventDefault();
			var $toggler = $(this);
			if($toggler.hasClass('show-brands-toggler')) {
				if($toggler.hasClass('animated')) {
					$toggler.removeClass('animated pulse');
					setTimeout(function() {
						$toggler.addClass('selected');
					}, 150);
				}
				else {
					$toggler.removeClass('selected');
					setTimeout(function() {
						$toggler.addClass('animated pulse');
					}, 200);
				}
			}
			else {
				if(e.type === 'click') {
					//remove selected class if user clicks from one toggler to another
					$('.popover-toggle.selected').each(function() {
						$(this).removeClass('selected');
					});
					$toggler.addClass('selected');
				}
				else {
					$toggler.removeClass('selected');
				}
			}
		});
		$('.calendar-header a[class*="tf-icon"]').on('click blur', function() {
			$(this).toggleClass('active');
		});
		//remove selected state on tooltip toggles when body is clicked
		$('body').on('click', function(e) {
			var $target = $(e.target);
			if($target.closest('.popover-clickable').length === 0 && $target.closest('.popover-toggle').length === 0) {
				$('.popover-toggle').each(function() {
					var $toggler = $(this);
					$toggler.removeClass('selected');
					//add animation back to go to brand button
					if($toggler.hasClass('show-brands-toggler')) {
						setTimeout(function() {
							$toggler.addClass('animated pulse');
						}, 200);
					}
				});
			}
			//hide tooltips
			if($target.hasClass('qtip-hide')) {
				$('.qtip').qtip('hide');
			}
			if($target.hasClass('modal-hide')) {
				$('.modal').modal('hide');
			}
		});
		//hide active tooltips on input focus
		$('body').on('focus', '.form-control', function() {
			var $target = $(this);
			if($target.attr('data-toggle') === undefined) {
				//make sure this isn't a tooltip in a tooltip situation
				if($target.closest('.qtip').length === 0) {
					$('.qtip').fadeOut();
				}
				else {
					$target.closest('.qtip').addClass('parent-tooltip');
					$('.qtip:not(.parent-tooltip)').fadeOut(function() {
						$target.closest('.qtip').removeClass('parent-tooltip');
					});
				}
			}
			else {
				//hide qtip that doesn't have the id of the one that should display now
				var qtipId = $(this).data('hasqtip');
				$target.closest('.qtip').addClass('parent-tooltip');
				$('.qtip:not(.parent-tooltip):not(#qtip-' + qtipId + ')').fadeOut(function() {
					$target.closest('.qtip').removeClass('parent-tooltip');
				});
			}
		});

		/*Tag Functions*/
		//assign tags to post
		$('body').on('click', '.select-post-tags .tag-list .tag', function() {
			$(this).toggleClass('selected');
			var checked = false;
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
			var $input = $(this).find('input');
			$input.prop('checked', checked);
		});

		$('body').on('click', '.btn-change-phase', function() {
			var next = $(this).data('newPhase');
			nextPhase(next);
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

		$('body').on('click', '#showSearch', function(e) {
			e.preventDefault();
			setTimeout(function() {
				$('.form-search, .input-search').animate({
					width: '300px'
				}, function(){
					$('.input-search').attr('placeholder', 'Search').focus();
				});
			}, 400);
		});
	});



	$('.commentReply').on('contentSlidDown', function(event, element) {
		if($(this).is(':visible')) {
			element.addClass('active');
			$(this).closest('.comment').addClass('has-reply');
		}
		else {
			element.removeClass('active');
			$(this).closest('.comment').removeClass('has-reply');
		}
	});
	
	$('.add-attachment').on('click', function() {
		$(this).closest('.attachment').find('input[type="file"]').click();
	});

	//modal triggers
	//Get modal content from an external source
	$('body').on('click', '[data-toggle="modal-ajax"]', function() {
		var newModal = $('#emptyModal').clone();
		var $target=$(this);
		var mid = $target.data('modalId');
		var msize = $target.data('modalSize');
		$.get($target.data('modalSrc'),function(data) {
			newModal.attr('id', mid);
			if(msize !== "") {
				newModal.find('.modal-dialog').addClass('modal-' + msize);
			}
			newModal.find('.modal-body').html(data);
			newModal.modal({
				show: true,
				backdrop: 'static'
			});
			newModal.on('shown.bs.modal', function () {
				$('.modal-toggler').fadeIn();
				fileDragNDrop();
				equalColumns();
			});
			newModal.on('hide.bs.modal', function () {
				$('.modal-toggler').fadeOut();
			});
			$target.attr('data-toggle', 'modal-ajax-inline');
		});
	});
	//Get modal content from inline source
	$('body').on('click', '[data-toggle="modal-ajax-inline"]', function() {
		var $target=$(this);
		var mid = $target.data('modalId');
		$('#' + mid).modal({
			show: true,
			backdrop: 'static'
		});
		$('#' + mid).on('shown.bs.modal', function () {
			$('.modal-toggler').fadeIn();
			equalColumns();
		});
		$('#' + mid).on('hide.bs.modal', function () {
			$('.modal-toggler').fadeOut();
		});
	});
	$('.modal').on('show.bs.modal', function() {
		$('.modal-toggler').fadeIn();
	});
	$('.modal').on('hide.bs.modal', function() {
		$('.modal-toggler').fadeOut();
	});
	$('.modal-toggler').on('click', function() {
		$('.modal').modal('hide');
	});
	$('[data-toggle="addPhases"]').one('click', function() {
		var columnParent = $(this).closest('.col-md-4');
		var approvalsContainer = $('.container-approvals');
		approvalsContainer.empty();
		$.get('lib/add-phase-details.php',function(data) {
			approvalsContainer.append(data);
		});
		columnParent.css('z-index', 2000);
		$('#brand-manage').append('<div class="modal-backdrop fade in modal-contain"></div>').wrapInner("<div class='relative-wrapper'></div>");
	});

	$('body').on('contentShown', '#phaseDetails', function() {
		addIncrements();
	});
	$('body').on('qtipShown', function(e, classes) {
		if(classes.indexOf('popover-post-date') > -1) {
			addIncrements();
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

	function nextPhase(i) {
		var linkedPhase;
		$('.approval-phase').removeClass('active');
		$('#approvalPhase' + i).removeClass('inactive').addClass('active');
		var $selected = $('#qtip-popover-user-list').find('.selected');
		$selected.each(function() {
			linkedPhase = $(this).attr('data-linked-phase');
			if(linkedPhase === 'approvalPhase' + i) {
				$(this).removeClass('disabled');
			}
			else {
				$(this).addClass('disabled');
			}
		});
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

	window.equalColumns = function equalColumns() {
		var dashboardH = $('.page-main').outerHeight();
		var headhH = $('.page-main-header').outerHeight(true);
		var colsH = $('.equal-columns').outerHeight(true);
		var newColsH = dashboardH - headhH;
		var magicNum = 0;
		$('.equal-columns .equal-height').each(function() {
				if($(this).parent().hasClass('brand-steps')) {
					magicNum = 60;
				}
				if(newColsH > colsH) {
					$(this).css('height', dashboardH - headhH - magicNum);
				}
				else {
					$(this).css('height', colsH);
				}
		});
		var colHs = [];
		$('.equal-section').each(function() {
			$(this).css('height', '');
			var colH = $(this).outerHeight();
			colHs.push(colH);
		});
		var tallest = Math.max.apply(null, colHs);
		$('.equal-section').css('height', tallest);
	};
	window.qtipEqualColumns = function qtipEqualColumns() {
		var colsH = $('.equal-cols').outerHeight(true);
		$('.equal-columns .equal-height').each(function() {
			$(this).css('height', colsH);
		});
	};
	window.showPostPopover = function showPostPopover(element, id, jsEvent, className) {
		var offsetY, offsetX, tipW, tipH;
		if(className === 'approvals-post') {
			offsetY = 27;
			offsetX = 9;
			tipW = 30;
			tipH = 15;
		}
		else {
			offsetY = 0;
			offsetX = 0;
			tipW = 20;
			tipH = 10;
		}
		element.qtip({
			content: {
				text: 'Loading...',
				ajax: {
					url: "edit-post-weekly-calendar.php?postid="+id,
					type: 'GET',
					once: true
				}
			},
			events: {
				hide: function() {
					//remove the tooltip from the dom once hidden
					$(this).qtip('destroy');
				},
				visible: function() {
					qtipEqualColumns();
				}
			},
			position: {
				adjust: {
					y: offsetY,
					x: offsetX
				},
				at: 'right top',
				my: 'left center',
				container: $('.page-main'),
				target: element,
				viewport: $('.page-main')
			},
			show: {
				effect: function() {
					$(this).fadeIn();
				},
				event: jsEvent.type,
				ready: true
			},
			hide: {
				effect: function() {
					$(this).fadeOut();
				},
				event: 'unfocus'
			},
			//overwrite: true,
			style: {
				classes: 'qtip-shadow qtip-calendar-post popover-clickable ' + className,
				tip: {
					width: tipW,
					height: tipH,
					corner: true,
					mimic: 'center'
				},
				width: 635
			}
		}, jsEvent);
	};
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