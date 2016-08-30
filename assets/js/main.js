
jQuery(function($) {

	var wh = $(window).height();
	var ww = $(window).width();

	if ($('#brand-manage').length) {
		setUserTime();
	}

	$(window).on("orientationchange resize", function() {
		wh = $(window).height();
		ww = $(window).width();
	});

	$(window).on('load', function() {
		equalColumns();
	});

	$(document).ready(function() {
		if (selected_day) {
			var date_on_cal = $.fullCalendar.moment(selected_day).format('YYYY-MM-DD');
			$('#calendar').children('div:last').find('table').find('td.fc-today').removeClass('ui-state-highlight');
			$('#calendar').children('div:last').find('table').find('td.fc-today').removeClass('fc-today');
			$('#calendar').children('div:last').find('table').find('[data-date="' + date_on_cal + '"]').addClass('ui-state-highlight');
			$('#calendar').children('div:last').find('table').find('[data-date="' + date_on_cal + '"]').addClass('fc-today');
		}

		// Prevent enter key from submitting forms.
		$(document).keydown(function(event) {
			var allow_enter = 0;
			if (event.keyCode === 13) {
				$.each($('textarea'), function(i, item){
					if($(item).attr('id') == $(event.target).attr('id')){
						allow_enter = 1;
					}
				});

				if($(event.target).data('step-no') == 4 || $(event.target).attr('id') == 'addTag' || $(event.target).hasClass('input-search'))
				{
					allow_enter = 1;
				}

				if(allow_enter == 0){
					event.preventDefault();
					return false;
				}
			}
		});

		jQuery('.txt-disable').bind('keypress', function(e) {
			e.stopPropagation();
			return false;
		});

		$('.amselect').mask('Pp', {
			'translation': {
				P: {
					pattern: '[AaPp]'
				},
				p: {
					pattern: '[Mm]'
				},
			}
		});

		$(".hour-select").mask('00');
		$(".minute-select").mask('00');

		$(".single-date-select").mask('00/00/0000');

		$(document).on('click', '.sub-user-outlet', function() {
			var savedOutlets = $('#userOutlet').val();
			var newOutlets = [];
			var thisOutlet = $(this).data('selectedOutlet');
			$(this).toggleClass('disabled selected');
			if ($(this).hasClass('selected')) {
				if (savedOutlets !== '') {
					newOutlets.push(savedOutlets);
				}
				newOutlets.push(thisOutlet);
				if($('#userSelect select').val() != ''){
					toggleBtnClass('#addRole', false);
				}
			} else {
				savedOutlets = savedOutlets.split(',');
				var index = savedOutlets.indexOf(thisOutlet + "");
				savedOutlets.splice(index, 1);
				newOutlets.push(savedOutlets);
			}
			$('#userOutlet').val(newOutlets);
		});

		var outlet_id = $('.outlet_ul li:first').data('selected-outlet');
		var outlet_const = $('.outlet_ul li:first').data('outlet-const');
		$('.outlet_ul li:first').toggleClass('disabled');
		$('.outlet_ul li:first').siblings().addClass('disabled');
		$('#postOutlet').val(outlet_id);
		$('#postOutlet').attr('data-outlet-const', outlet_const);
		if (outlet_const == 'twitter') {
			//only allow 140 characters for tweets
			text_char_limit(outlet_const, '140');
		}

		if (outlet_const == 'linkedin') {
			//only allow 140 characters for tweets
			text_char_limit(outlet_const, '256');
		}
		createPreview();

		$(document).on('click','#post-details .outlet-list li, #edit-post-details .outlet-list li', function() {

			var previous_outlet = $('#postOutlet').val();
			var outlet = $(this).data('selectedOutlet');
			var outlet_const = $(this).data('outlet-const');
			$('#postCopy').removeAttr('maxlength');
			$('.extra-outlet-fields').removeAttr('style');

			//shrink file upload area to allow for additional fields
			if(outlet_const === 'linkedin' || outlet_const === 'pinterest' || outlet_const === 'youtube') {
				$('.container-post-details .form__input').addClass('single-row');
			}
			else {
				$('.container-post-details .form__input').removeClass('single-row');
			}

			
			if(outlet_const !== 'twitter' && outlet_const !== 'linkedin') {
				$('.tweet-chars').remove();
			}
			//only allow 140 characters for tweets
			if (outlet_const === 'twitter') {
				text_char_limit(outlet_const, '140');
			}
			//only allow 256 characters for linkedin
			if (outlet_const === 'linkedin') {
				text_char_limit(outlet_const, '256');
			}

			if (outlet_const === 'vine' || outlet_const === 'youtube') {
				if ($('.form__preview-wrapper img').length) {
					if (outlet_const === 'youtube') {
						getConfirm(language_message.youtube_outlet_change_error,'','alert',function(confResponse) {});
						return false;
					} else {
						getConfirm(language_message.vine_outlet_change_error,'','alert',function(confResponse) {});
						return false;
					}
					
				}				
			}
			if (outlet_const === 'youtube') {
				showHide($(this), '#youtubePostFields');
			}


			if (outlet_const == 'instagram') {
				if ($('.form__preview-wrapper video').length) {
					getConfirm(language_message.insta_outlet_change_error,'','alert',function(confResponse) {});
					return false;
				}

				if ($('.form__preview-wrapper img').length > 1) {
					getConfirm(language_message.insta_outlet_change_img_error,'','alert',function(confResponse) {});
					return false;
				}
			}

			if (outlet_const == 'linkedin') {
				showHide($(this), '#linkedinPostFields');
				if ($('.form__preview-wrapper img').length > 1) {
					getConfirm(language_message.linkedin_outlet_change_error,'','alert',function(confResponse) {});
					return false;
				}
			}

			if (outlet_const == 'pinterest') {
				showHide($(this), '#pinterestPostFields');
				if ($('.form__preview-wrapper img').length > 1) {
					getConfirm(language_message.pinterest_outlet_change_error,'','alert',function(confResponse) {});
					return false;
				}
			}
			if (outlet_const === 'tumblr') {
				// showHide($(this), '#tumblrContentTypes');
				showHide($(this), '#tumblrContentTypes');
				showHide($(this), '#tumblrTextPost','#defaultPostCopy, #mediaUpload, .extra-tb-fields');
				$('.content-list li:first').toggleClass('disabled');
				$('.content-list li:first').siblings().addClass('disabled');
				$('#tumblrContent').val($('.content-list li:first').data('selected-content'));
			}

			if (previous_outlet != outlet_const) {
				$(this).toggleClass('disabled');
				$(this).siblings().addClass('disabled');
				$('#postOutlet').attr('data-outlet-const', outlet_const);
				$('#postOutlet').val(outlet);
				removeFromPreview();
			}
			setTimeout(equalColumns, 400);
		});

		$(document).on('click','.content-list li', function() {
			$(this).toggleClass('disabled');
			$(this).siblings().addClass('disabled');
			$('#tumblrContent').val($(this).data('selected-content'));
		});

		$(".alert").fadeTo(5000, 500).slideUp(500, function() {
			// $(".alert").alert('close');
		});

		$(document).on('click', '.has-archive, .category_date', function(event) {
			var $btn_enable = false;
			$.each($('.has-archive'), function(a, controler) {
				if ($(controler).hasClass('selected')) {
					if ($("input[name='exportDate']:checked").val() == 'daterange') {
						if ($('#start_date').val() != '' && $('#end_date').val() != '') {
							$btn_enable = true;
						} else {

							$btn_enable = false;
						}
					} else {
						$btn_enable = true;
					}
				}
			});
			if (!$btn_enable) {
				toggleBtnClass($("#archive-export button[type=submit]"), true);
			} else {
				toggleBtnClass($("#archive-export button[type=submit]"), false);
			}
		});

		//nav activation
		var pathname = location.pathname;
		$('.navbar-brand-manage .nav-link').each(function() {
			var href = $(this).attr('href');
			if (href.indexOf(pathname) > -1) {
				$(this).addClass('active');
			}
			var sub_pages = $(this).data('sub_pages');
			if (sub_pages != undefined) {
				if (pathname.indexOf(sub_pages) > -1) {
					$(this).addClass('active');
				}
			}
		});

		/*show brand nav dropdown
		 *use timeout to prevent immediate hide on mouse out
		*/
		var hoverTimeout;
		$('.navbar-brand-manage .dropdown').hover(function() {
			clearTimeout(hoverTimeout);
			$(this).addClass('open');
		}, function() {
			var $self = $(this);
			hoverTimeout = setTimeout(function() {
				$self.removeClass('open');
			}, 400);
		});
		/*	fake check box select
		 *	This is used to check or uncheck the checkox
		 *
		 */
		 var btnClicks = 0;
		 $('body').on('click', '.check-box', function() {
		 	var $btn = $(this);
		 	if ($btn.hasClass('has-archive')) {
				/*
				 *	This is used only for archive page only
				 */
				 var $chk_box = '';
				 if ($btn.data('value') == 'check-all') {
				 	$chk_box = $btn.closest('.timeframe-list').find('input');
					/*
					 *	$chk_box = radio input is used to check or uncheck all the checkbox
					 */
					 $.each($chk_box, function(a, input_btn) {
					 	if ($btn.hasClass('selected')) {
					 		$(input_btn).removeAttr('checked');
					 	} else {
					 		$(input_btn).attr('checked', 'checked');
					 	}
					 });

					} else {
					/*
					 *	$chk_box = radio input is used to check or uncheck selected the checkbox
					 */
					 $chk_box = $btn.siblings('input');

					 if ($btn.hasClass('selected')) {
					 	$chk_box.removeAttr('checked');
					 } else {
					 	$chk_box.attr('checked', 'checked');
					 }
					}

				}
				if ($btn.hasClass('disabled')) {
					return;
				}

				var buttonVal = $btn.attr('data-value');
				var checked = false;
				var inputGroup = $btn.attr('data-group');
				if (buttonVal !== "check-all") {
					$btn.toggleClass('selected');
				} else if (buttonVal === "check-all" && !$btn.hasClass('selected')) {
					$('.check-box[data-group="' + inputGroup + '"]').addClass('selected');
					$('input[name="' + inputGroup + '"]').prop('checked', true);
				} else if (buttonVal === "check-all" && $btn.hasClass('selected')) {
					$('.check-box[data-group="' + inputGroup + '"]').removeClass('selected');
					$('input[name="' + inputGroup + '"]').prop('checked', false);
				}
				if ($btn.hasClass('selected')) {
					checked = true;
				} else {
					checked = false;
				}

				$('input[value="' + buttonVal + '"]').prop('checked', checked).trigger('change');

			//add selected users to list from popover
			if ($btn.closest('.popover-users').length) {
				var userImg = $btn.closest('li').find('img');
				$(userImg).attr('data-id', buttonVal);
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var $activePhase = $('#phaseDetails').find('.active');
				var activePhaseId = $activePhase.attr('id');
				if ($btn.hasClass('selected')) {
					var phase_number = $activePhase.data('id');
					var inputDiv = '<input class="hidden-xs-up approvers" type="checkbox" checked="checked" value="' + buttonVal + '" name="phase[' + phase_number + '][approver][]">';
					$activePhase.find('.user-list li').prepend(imgDiv);	
					setTimeout(function() {
						setPhaseBtns($activePhase);
					}, 100);

					btnClicks++;
				} else {
					$activePhase.find('img[data-id="' + buttonVal + '"]').parent().remove();
					setTimeout(function() {
						setPhaseBtns($activePhase);
					}, 100);

					btnClicks--;
				}
				if (btnClicks > 0) {
					$activePhase.find('.post-approver-name').hide();
				} else {
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
		var btnClicks = 0;
		$('body').on('click', '.radio-button', function() {
			var $btn = $(this);
			if ($btn.hasClass('disabled')) {
				return;
			}
			var buttonVal = $btn.attr('data-value');
			var checked = false;
			var inputGroup = $btn.attr('data-group');
			if (buttonVal !== "check-all") {
				$btn.toggleClass('selected');
			} else if (buttonVal === "check-all" && !$btn.hasClass('selected')) {
				$('.radio-button[data-group="' + inputGroup + '"]').addClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', true);
			} else if (buttonVal === "check-all" && $btn.hasClass('selected')) {
				$('.radio-button[data-group="' + inputGroup + '"]').removeClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', false);
			}
			if ($btn.hasClass('selected')) {
				checked = true;
			} else {
				checked = false;
			}
			$('input[value="' + buttonVal + '"]').prop('checked', checked);

			//add selected users to list from popover
			if ($btn.closest('#qtip-popover-user-list').length !== 0) {
				var userImg = $btn.closest('li').find('img');
				var checkbox = $btn.parent().children('.approvers');
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var $activePhase = $('#phaseDetails .approval-phase.active');
				var activePhaseId = $activePhase.attr('id');
				if ($btn.hasClass('selected')) {
					var phase_number = $activePhase.data('id');
					$(checkbox).attr('name', 'phase[' + phase_number + '][approver][]');
					$activePhase.find('.user-list li').prepend(imgDiv);
					$activePhase.find('img[src="' + imgSrc + '"]').parent().prepend(checkbox);
					// $btn.attr('data-linked-phase', activePhaseId);
					btnClicks++;
				} else {
					$activePhase.find('img[src="' + imgSrc + '"]').parent().remove();
					$btn.removeAttr('data-linked-phase');
					btnClicks--;
				}
				if (btnClicks > 0) {
					$activePhase.find('.post-approver-name').hide();
				} else {
					$activePhase.find('.post-approver-name').show();
				}
			}
		});

		$('body').on('click', '.select-box', function() {
			var $box = $(this);
			var boxVal = $box.attr('data-value');
			var inputGroup = $box.attr('data-group');

			if (boxVal !== "check-all") {
				$box.toggleClass('checked');
			} else if (boxVal === "check-all" && !$box.hasClass('checked')) {
				$('.select-box[data-group="' + inputGroup + '"]').addClass('checked');
				$('.delete-draft').attr('data-toggle', 'modal');
			} else if (boxVal === "check-all" && $box.hasClass('checked')) {
				$('.select-box[data-group="' + inputGroup + '"]').removeClass('checked');
				$('.delete-draft').attr('data-toggle', '');
			}

			var postsTotDelete = [];
			$.each($(".select-box"), function(a, b) {
				if ($(b).hasClass('checked') && $(b).data('value') != "check-all") {
					postsTotDelete.push($(b).data('value'));
				}
			});

			if (postsTotDelete.length) {
				$('.delete-draft').attr('data-toggle', 'modal');
				toggleBtnClass($('.delete-draft'), false);
			} else {
				$('.delete-draft').attr('data-toggle', '');
				toggleBtnClass($('.delete-draft'), true);
			}
		});

		//different media uploads for facebook
		$('body').on('click', '#facebookMediaUpload .media-item', function() {
			var mediaType = $(this).data('value');
			$('input[value="' + mediaType + '"]').prop('checked', true);
			$('#facebookMediaUpload').slideUp(function() {
				if (mediaType === "Album") {
					$('#mediaUpload').addClass('photo-album-upload');
				}
				$('#mediaUpload').slideDown(function() {
					if (mediaType === "Album") {
						$('#albumType').show();
					}
				});
			});
		});

		$('#albumName').on('keyup', function() {
			if ($(this).val() !== "") {
				$('input[value="newAlbum"]').prop('checked', true);
			}
		});

		$('#existingAlbum').on('change', function() {
			if ($(this).val() !== "") {
				$('input[value="existingAlbum"]').prop('checked', true);
			}
		});

		$('.page-main-header a[class*="tf-icon"]').on('click blur', function() {
			$(this).toggleClass('active');
		});

		$('body').on('click', function(e) {
			//hide visible tooltips when body is clicked
			var $target = $(e.target);
			if ($target.closest('.popover-clickable').length === 0 && $target.closest('.popover-toggle').length === 0) {
				$('.qtip').qtip('hide');
				$('.popover-toggle').each(function() {
					var $toggler = $(this);
					$toggler.removeClass('selected');
					//add animation back to go to brand button
					if ($toggler.hasClass('show-brands-toggler')) {
						setTimeout(function() {
							$toggler.addClass('animated pulse');
						}, 200);
					}
				});
			}
			//hide tooltips
			if ($target.hasClass('qtip-hide')) {
				$('.qtip').qtip('hide');
			}
			//hide modals
			if ($target.hasClass('modal-hide')) {
				$('.modal').modal('hide');
			}
		});

		//hide active tooltips on input focus
		$('body').on('focus', '.form-control', function() {
			var $target = $(this);
			if ($target.attr('data-toggle') === undefined) {
				//make sure this isn't a tooltip in a tooltip situation
				if ($target.closest('.qtip').length === 0) {
					$('.qtip').fadeOut();
				} else {
					$target.closest('.qtip').addClass('parent-tooltip');
					$('.qtip:not(.parent-tooltip)').fadeOut(function() {
						$target.closest('.qtip').removeClass('parent-tooltip');
					});
				}
			} else {
				//hide qtip that doesn't have the id of the one that should display now
				var qtipId = $(this).data('hasqtip');
				$target.closest('.qtip').addClass('parent-tooltip');
				$('.qtip:not(.parent-tooltip):not(#qtip-' + qtipId + ')').fadeOut(function() {
					$target.closest('.qtip').removeClass('parent-tooltip');
				});
			}
		});

		/*Tag Functions*/
		$('body').on('click', '.post_tags', function() {
			$(this).toggleClass('selected');
			var checked = false;
			var numTags = $('.tag-list .selected').length;
			var tag = $(this).find('.fa');
			var tagClass = tag.data('tag');
			if ($(this).hasClass('selected')) {
				var newTag = tag.clone();
				newTag.children().attr('checked', true);
				newTag.prependTo('.tag-select');
				checked = true;
			} else {
				$('.tag-select').find('.fa').each(function() {
					if ($(this).data('tag') === tagClass) {
						$(this).remove();
					}
				});
				checked = false;
			}
			if (numTags > 0) {
				$('.tag-select .fa.color-gray-lighter').hide();
			} else {
				$('.tag-select .fa.color-gray-lighter').show();
			}
			//set the input value
			var $input = $(this).find('input');
			// $input.attr("checked", checked);			
		});

		//assign tags to post
		$('body').on('click', '.select-post-tags .tag-list .tag', function() {
			$(this).toggleClass('selected');
			console.log('assign tags to post');
			var checked = false;
			var numTags = $('.tag-list .selected').length;
			var tag = $(this).find('.fa');
			var tagClass = tag.attr('class');
			if ($(this).hasClass('selected')) {
				var newTag = tag.clone();
				newTag.prependTo('.tag-select');
				checked = true;
			} else {
				$('.tag-select').find('.fa').each(function() {
					if ($(this).attr('class') === tagClass) {
						$(this).remove();
					}
				});
				checked = false;
			}
			if (numTags > 0) {
				$('.tag-select .fa.color-gray-lighter').hide();
			} else {
				$('.tag-select .fa.color-gray-lighter').show();
			}
			//set the input value
			var $input = $(this).find('input');
			$input.prop('checked', checked);
		});

		$('body').on('click', '.btn-change-phase', function() {
			var next = $(this).data('newPhase');
			nextPhase(next, this);
		});

		$('body').on('click', '.show-hide', function(e) {
			e.preventDefault();
			var $trigger = $(this);
			var show = $trigger.data('show');
			var hide = $trigger.data('hide');
			showHide($trigger, show, hide);
		});

		$('body').on('click', '#showSearch', function(e) {
			e.preventDefault();
			setTimeout(function() {
				$('.form-search, .input-search').animate({
					width: '300px'
				}, function() {
					$('.input-search').attr('placeholder', 'Search').focus();
				});
			}, 400);
		});
		$('body').on('blur', '.form-search .input-search', function(e) {
			setTimeout(function() {
				$('.form-search, .input-search').animate({
					width: '0'
				}, function() {
					$('.input-search').attr('placeholder', '');
				});
			}, 400);
		});
	});


	$(document).on('click', '[data-toggle="addPhases"]', function() {
		if ($('.container-approvals').children('.add_phases_num')) {
			$('.container-approvals').children('.add_phases_num').remove();
		}

		if ($('#qtip-popover-user-list')) {
			$('#qtip-popover-user-list').remove();
		}

		if ($('.add-phases')) {
			$('.add-phases').remove();
		}
		var columnParent = $(this).closest('.col-md-4');
		var div_src = $(this).data('div-src');

		var approvalsContainer = $('.container-approvals');
		// approvalsContainer.empty();
		approvalsContainer.children('.dafault-phase').addClass('hide');
		$.get(base_url + div_src, function(data) {
			approvalsContainer.prepend(data);
		});
		columnParent.css('z-index', 2000);
		if(!$(this).parents('.modal').length) {
			$('#brand-manage').append('<div class="modal-backdrop fade in modal-contain"></div>').wrapInner("<div class='relative-wrapper'></div>");
		}
		else {
			$(this).closest('.modal-body').append('<div class="modal-backdrop fade in modal-contain"></div>');
		}
	});

	$(document).on('click', '.cancel-phase', function() {		
		var phases = $('#phaseDetails .approval-phase:not(.saved-phase)');
		var phase_added = 0;
		$.each(phases, function() {
			var phaseId = $(this).data('id');
			var id =  $(this).attr('id');
			var selected_timezone = $(this).find('.approval_timezone option:selected').text();

			// $('#preview_approvalPhase1' + parseInt(phaseId)+1 ).find('.timezones-preview .zone').text($('option:selected',this).text());
			
			$(this).addClass('hide').removeClass('active');
			var preview_div = $('#preview_approvalPhase' + (parseInt(phaseId) + 1) );
			if ($(preview_div).find('.user-img').length && $(preview_div).find('.phase-date-time-input').val() && $(preview_div).find('.hour-select').val() && $(preview_div).find('.minute-select').val()) {
				phase_added = 1;
				$('.saved-phase[data-id="' + phaseId + '"]').removeClass('hide').addClass('active');
			}
		});
		if(phase_added == 0)
		{
			$('.container-approvals').find('.dafault-phase').removeClass('hide');
			$('.container-approvals').find('.add-phases').remove();
			$('.container-approvals').find('.overlay-box').remove();
			$('.modal-contain').remove();
		}
	});

	$(document).on('click', '.cancel-edit-phase', function() {
		$('#is-new-approver').val('no');
		$.each($('#phaseDetails .saved-phase'), function() {
			var phaseId = $(this).data('id');
			$('.approval-phase[data-id="' + phaseId + '"]').removeClass('active').addClass('hide');
			if ($(this).find('.approval-list li').length) {				
				$('.saved-phase[data-id="' + phaseId + '"]').removeClass('inactive hide');
			} else {
				$(this).addClass('hide');
			}
		});
		$('.phase-footer').addClass('hide');
		$('#submit-approval-btns').show();
	});

	$('body').on('contentShown', '#phaseDetails', function() {
		addIncrements();
	});

	$('body').on('qtipShown', function(e, classes) {
		if (classes.indexOf('popover-post-date') > -1) {
			addIncrements();
		}
	});

	$('.showInvisible').on('click', function(e) {
		e.stopPropagation();
		$(this).next('.invisible').toggleClass('invisible visible');
	});

	$('.hideVisible').on('click', function(e) {
		e.stopPropagation();
		$(this).closest('.visible').toggleClass('invisible visible');
	});

	if ($('.table-approvals').length) {
		$('.approval-list .approval-list').each(function() {
			var listWidth = 8;
			$(this).find('li').each(function() {
				listWidth += $(this).outerWidth();
			});
			$(this).css('width', listWidth);
		});

		//truncate post copy
		$(".post-excerpt").dotdotdot({
			ellipsis: '',
			wrap: 'letter'
		});
	}

	//Time selector functions
	$(document).on('click', '.incrementer', function(e) {
		var $target = $(e.target);
		var incDec = ($target.hasClass('increase')) ? 'increase' : 'decrease';
		var inputName = $(this).data('for');
		var relatedInput = $('input[name="' + inputName + '"]');

		if (relatedInput.length > 1) {
			var relatedInput = $('input[name="' + inputName + '"]:last');
		}

		if (relatedInput.hasClass('hour-select')) {
			setHrs(relatedInput, incDec);
		}
		if (relatedInput.hasClass('minute-select')) {
			setMins(relatedInput, incDec);
		}
		if (relatedInput.hasClass('amselect')) {
			setAmPm(relatedInput, incDec);
		}
	});


	$('body').on('keyup', '.time-input', function(e) {
		var incDec;
		var input = $(this);
		//up arrow pressed
		if (e.which === 38) {
			incDec = 'increase';
		}
		//down arrow pressed
		else if (e.which === 40) {
			incDec = 'decrease';
		} else {
			var val = input.val();
			var phaseId = input.closest('.approval-phase').data('id');
			if (input.hasClass('hour-select')) {
				savePhaseHrs(phaseId, val);
			}
			if (input.hasClass('minute-select')) {
				savePhaseMins(phaseId, val);
			}
			if (input.hasClass('amselect')) {
				savePhaseAmPm(phaseId, val);
			}
			return;
		}
		if (input.hasClass('hour-select')) {
			isValidNumber(e, 12, input);
			setHrs(input, incDec);
		}
		if (input.hasClass('minute-select')) {
			isValidNumber(e, 59, input);
			setMins(input, incDec);
		}
		if (input.hasClass('amselect')) {
			setAmPm(input, incDec);
		}
	});

	//show all the user and data to preview whcih we added while adding phase datails 
	//and show phase preview view
	$(document).on('click', '.save-phases', function() {
		var phases = $('#phaseDetails .approval-phase:not(.saved-phase)');
		$('#only_ph_one_date').val(''),
 		$('#only_ph_one_hour').val(''),
 		$('#only_ph_one_minute').val(''),
 		$('#only_ph_one_ampm').val('');
		if(!phaseValidation()){
			return false;
		}
		$.each(phases, function() {
			var phase = this;
			$('#preview_'+$(phase).attr('id')).find('li').empty();
			$('#preview_edit_'+$(phase).attr('id')).find('ul').empty();
			var img = $(phase).find('img');
			$.each(img,function(a,b){
				var div=document.createElement('div');
				var inputDiv = '<input class="hidden-xs-up approvers" type="checkbox" checked="checked" value="' + $(b).attr('data-id') + '" name="phase[' + $(phase).attr('data-id') + '][approver][]">';
				$(div).attr('class','pull-sm-left user-img');				
				$(div).append(inputDiv);
				$(div).append($(b).clone());
				$('#preview_'+$(phase).attr('id')).find('li').append($(div));

				if($('#preview_edit_'+$(phase).attr('id')).length)
				{
					var li=document.createElement('li');
					$(li).attr('class','pull-sm-left pending');					
					$(li).append(inputDiv);
					var previewImgDivEdit = $(li).append($(b).clone());
					$('#preview_edit_'+$(phase).attr('id')).find('ul').append(previewImgDivEdit);
				}
			});		

			var phaseId = $(this).data('id');
			var id =  $(this).attr('id');
			var selected_timezone = $(this).find('.approval_timezone option:selected').text();
			//show time on preview (date)
			var date = $('#approvalPhase' + (parseInt(phaseId) + 1)).find('.phase-date-time-input').val();			
			$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.date-preview').text(date);
			$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.phase-date-time-input').val(date);


			$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.date-preview').text(date);
			$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.phase-date-time-input').val(date);

			//for preview of edit (hour minute and ampm)
			var time = $('#approvalPhase' + (parseInt(phaseId) + 1));			
			var time_preview_edit = $('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).closest('.time-preview');
			$(time_preview_edit).find('.hour-preview').val($(time).find('.hour-select').val());
			
			$(time_preview_edit).find('.minute-preview').val($(time).find('.minute-select').val());
			$(time_preview_edit).find('.ampm-preview').val($(time).find('.amselect').val());

			//for preview of add (hour minute and ampm)
			var time_preview = $('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.time-preview');			
			$(time_preview).find('.hour-preview').text($(time).find('.hour-select').val());
			$(time_preview).find('.minute-preview').text($(time).find('.minute-select').val());
			$(time_preview).find('.ampm-preview').text($(time).find('.amselect').val());

			//for edit preview(hour minute and ampm)
			var time_preview = $('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.time-preview');			
			$(time_preview).find('.hour-preview').text($(time).find('.hour-select').val());
			$(time_preview).find('.minute-preview').text($(time).find('.minute-select').val());
			$(time_preview).find('.ampm-preview').text($(time).find('.amselect').val());
			// console.log($(time_preview).find('.ampm-preview'));
			// console.log($(time).find('.amselect').val());

			//show time on preview (date)
			var note = $('#approvalPhase' + (parseInt(phaseId) + 1)).find('.approvalNotes').val();
			if(note)
			{		
				$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.approval-note').html('NOTE:'+note);			
				$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.approval-note').html('NOTE:'+note);
			}
			else
			{
				$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.approval-note').html('');			
				$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.approval-note').html('');
			}

			//show time on preview (timezone)
			$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.timezones-preview .zone').text($('option:selected',this).text());			
			$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.timezones-preview .zone').text($('option:selected',this).text());


			//hidden fields in preview
			var phase_preview = $('#preview_approvalPhase' + (parseInt(phaseId) + 1));
			$(phase_preview).find('.hour-select').val($(time).find('.hour-select').val());
			$(phase_preview).find('.minute-select').val($(time).find('.minute-select').val());
			$(phase_preview).find('.amselect').val($(time).find('.amselect').val());
			$(phase_preview).find('.note').val(note);
			$(phase_preview).find('.zone').val($(time).find('.approval_timezone option:selected').val());

			//hidden fields in edit preview
			var phase_preview = $('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1));	
			$(phase_preview).find('.hour-select').val($(time).find('.hour-select').val());
			$(phase_preview).find('.minute-select').val($(time).find('.minute-select').val());
			$(phase_preview).find('.amselect').val($(time).find('.amselect').val());
			$(phase_preview).find('.note').val(note);			
			$(phase_preview).find('.zone').val($(time).find('.approval_timezone option:selected').val());


			
			$(this).addClass('hide').removeClass('active');
			if ($(this).find('.approver-selected .user-img').length && $(this).find('.phase-date-time-input').val() && $(this).find('.hour-select').val() && $(this).find('.minute-select').val()) {
				$('.saved-phase[data-id="' + phaseId + '"]').removeClass('hide').addClass('active');
			}
		});
		$('#save-phase-btns, .modal-contain').hide();
		$('#submit-approval-btns').show();
	});

	$(document).on('click', '.edit-phase', function() {
		$('#is-new-approver').val('yes');
		var phases = $('#phaseDetails .approval-phase:not(.saved-phase)');
		var editPhaseNum = $(this).closest('.approval-phase').data('id');
		
		//show edit phase view
		$.each(phases, function() {
			//only remove that phase which is selected during the adding number of phases
			if(!$(this).hasClass('hidden-phase'))
			{
				$(this).removeClass('hide').addClass('inactive');
			}
		});
		$('.phase-footer').removeClass('hide');
		
		//hide saved phase view and and add user images which are in preview view to edit view
		$('#phaseDetails .saved-phase').each(function(a,b) {
			$(this).addClass('hide').removeClass('active');
			var img = $(this).find('img');
			$('[data-id="'+$(this).attr('data-id')+'"]:not(.saved-phase)').find('.user-img').remove();
			var user_list = $('[data-id="'+$(this).attr('data-id')+'"]:not(.saved-phase)').find('li');
			$.each(img,function(a,b)
			{
				var div=document.createElement('div');
				$(div).attr('class','pull-sm-left user-img');					
				$(div).append($(b).clone());
				$(user_list).prepend(div);
			});

			var $previewPhase = $('.saved-phase[data-id="' + $(b).attr('data-id') + '"]');
			var date = $previewPhase.find('.phase-date-time-input').val();
			var hour = $previewPhase.find('.hour-select').val();
			var minute = $previewPhase.find('.minute-select').val();
			var ampm = $previewPhase.find('.ampmselect').val();
			var ampm = $previewPhase.find('.note').val();
			$(b).find('.phase-date-time-input').val(date);
			$(b).find('.hour-select').val(hour);
			$(b).find('.minute-select').val(minute);
			$(b).find('.amselect').val(ampm);
			$(b).find('.approvalNotes').val(ampm);
		});
		var $activePhase = $('.approval-phase[data-id="' + editPhaseNum + '"]:not(.saved-phase)');		

		$activePhase.removeClass('inactive').addClass('active');

		setPhaseBtns($activePhase);
		$('#save-phase-btns, .modal-contain').show();
		$('#submit-approval-btns').hide();
	});

	//resubmit approval single phsae
	$(document).on('click', '.resubmit-approval', function() {
		var btn = this;
		var phase_id = $(this).attr('id');
		var outlet = $('#postOutlet').val();
		var phase_ids = [];
		if (phase_id) {
			phase_ids.push(phase_id);
			$.ajax({
				type: 'POST',
				data: {
					'phase_ids': phase_ids,
					'outlet': outlet
				},
				dataType: 'json',
				url: base_url + 'posts/resubmit_phases',
				success: function(response) {
					if (response.response == 'success') {
						$(btn).remove();
					} else {
						getConfirm(language_message.unable_to_resubmit,'','alert',function(confResponse) {
							// return false;
						});
					}
				}
			});
		}
	});

	function setHrs(input, incDec) {
		var newVal;
		var minVal = $(input).attr('data-min');
		var maxVal = $(input).attr('data-max');
		var inputVal = parseInt($(input).val(), 10);
		if (!inputVal) {
			inputVal = 0;
		}
		if (incDec === "increase") {
			if (inputVal < maxVal) {
				newVal = inputVal + 1;
			} else if (inputVal >= maxVal) {
				newVal = minVal;
			}
		} else if (incDec === "decrease") {
			if (inputVal > minVal) {
				newVal = inputVal - 1;
			} else if (inputVal <= minVal) {
				newVal = maxVal;
			}
		}
		$(input).val(newVal);
		var $activePhase = $(input).closest('.approval-phase.active');
		if ($activePhase.length) {
			var phaseId = $activePhase.data('id');
			savePhaseHrs(phaseId, newVal);
		}
	}

	function setMins(input, incDec) {
		var newVal;
		var minVal = $(input).attr('data-min');
		var maxVal = $(input).attr('data-max');
		var inputVal = parseInt($(input).val(), 10);
		if (!inputVal) {
			inputVal = 0;
		}
		if (incDec === "increase") {
			if (inputVal < maxVal) {
				newVal = inputVal + 1;
			} else if (inputVal >= maxVal) {
				newVal = minVal;
			}
		} else if (incDec === "decrease") {
			if (inputVal > minVal) {
				newVal = inputVal - 1;
			} else if (inputVal <= minVal) {
				newVal = maxVal;
			}
		}
		if (newVal < 10) {
			newVal = '0' + newVal;
		}
		$(input).val(newVal);

		var $activePhase = $(input).closest('.approval-phase.active');
		if ($activePhase.length) {
			var phaseId = $activePhase.data('id');
			savePhaseMins(phaseId, newVal);
		}
	}

	function setAmPm(input, incDec) {
		var $activePhase = $(input).closest('.approval-phase.active');
		if (incDec) {
			($(input).val() === 'am') ? $(input).val('pm') : $(input).val('am');
		}
		if ($activePhase.length) {
			var phaseId = $activePhase.data('id');
			savePhaseAmPm(phaseId, $(input).val().toUpperCase());
		}
	}

	function savePhaseHrs(id, val) {
		// $('.saved-phase[data-id="' + id + '"]').find('.time-preview .hour-preview').html(val);
		setPhaseBtns($('.approval-phase.active[data-id="' + id + '"]'));
	}

	function savePhaseMins(id, val) {
		// $('.saved-phase[data-id="' + id + '"]').find('.time-preview .minute-preview').html(val);
		setPhaseBtns($('.approval-phase.active[data-id="' + id + '"]'));
	}

	function savePhaseAmPm(id, val) {
		// $('.saved-phase[data-id="' + id + '"]').find('.time-preview .ampm-preview').html(val);
		setPhaseBtns($('.approval-phase.active[data-id="' + id + '"]'));
	}

	function setPhaseBtns(activePhase) {
		var phaseId = activePhase.data('id');
		//to hide next button for last phase		
		if(phaseId == $('#phaseDetails').find('.approval-phase:not(".saved-phase"):not(".hide")').length - 1)
		{
			if(phaseId != 2)
			{
				activePhase.find('.btn-change-phase:not(.btn-default)').text('Add Phase');
			}
			else
			{
				activePhase.find('[data-new-phase]:eq(' + 1 + ')').addClass('hide');
			}
		}


		var btn_num = 0;
		if (activePhase.find('.approver-selected .user-img').length) {
			if (activePhase.find('.phase-date-time-input').val() && activePhase.find('.hour-select').val() && activePhase.find('.minute-select').val()) {				
				if (activePhase.find('[data-new-phase]').length > 1) {
					btn_num = phaseId;
				}
				toggleBtnClass(activePhase.find('[data-new-phase]:eq(' + btn_num + ')'), false);

				if (phaseId === 0) {
					toggleBtnClass($('.save-phases'), false);
				}
			} else {
				if (activePhase.find('[data-new-phase]').length) {
					btn_num = phaseId;
				}
				toggleBtnClass(activePhase.find('[data-new-phase]:eq(' + btn_num + ')'), true);

				if (phaseId === 0) {
					toggleBtnClass($('.save-phases'), true);
				}
			}
		} else {
			if (activePhase.find('[data-new-phase]').length > 1) {
				btn_num = phaseId;
			}
			toggleBtnClass(activePhase.find('[data-new-phase]:eq(' + btn_num + ')'), true);

			if (phaseId === 0) {
				toggleBtnClass($('.save-phases'), true);
			}
		}
		//if button is to go to previous phase then it should not be disabled
		if(activePhase.find('[data-new-phase]:eq(' + btn_num + ')').text() == 'Previous')
		{
			toggleBtnClass(activePhase.find('[data-new-phase]:eq(' + btn_num + ')'), false);
		}
	}

	function nextPhase(i, control) {
		if($(control).text() == 'Add Phase')
		{
			$(control).text('Next Phase');
		}
		if ($(control).closest('.approval-phase').hasClass('active'))
			$(control).closest('.approval-phase').addClass('inactive').removeClass('active');
		var linkedPhase;
		var $activePhase = $('#approvalPhase' + i);
		$activePhase.removeClass('inactive').addClass('active').removeClass('hide').removeClass('hidden-phase');
		setPhaseBtns($activePhase);
		
		if(i == $('#phaseDetails').find('.approval-phase:not(".saved-phase"):not(".hide")').length)
		{
			$activePhase.find('.delete-phase').removeClass('hide');
		}
		else
		{
			if($('#phaseDetails').find('.preview_approvalPhase1').length || $('#phaseDetails').find('.preview_approvalPhase2').length || $('#phaseDetails').find('.preview_approvalPhase3').length)
			{
				$activePhase.find('.delete-phase').addClass('hide');
			}
		}
	}
	
	window.addIncrements = function addIncrements() {
		$('body').find('.time-select .time-input').each(function() {
			var inputName = $(this).attr('name');
			var increment = '<div class="incrementer" data-for="' + inputName + '"><i class="fa fa-caret-up increase"></i><i class="fa fa-caret-down decrease"></i></div>';
			$(this).after(increment);
			if ($(this).hasClass('minute-select')) {
				$(this).before('<span class="time-separator">:</span>');
			}
		});
	};

	addIncrements();

	window.equalColumns = function equalColumns(div) {
		if (div === undefined) {
			div = '.page-main';
		}
		//reset heights to default to get appropriate calculation
		$(div + ' .equal-columns .equal-height, ' + div + ' .equal-section').css('height', '');

		var colHs = [];
		$(div).find('.equal-section').each(function() {
			var colH = $(this).outerHeight();
			colHs.push(colH);
		});
		var tallest = Math.max.apply(null, colHs);
		$(div + ' .equal-section').css('height', tallest);

		var dashboardH = $('.page-main').outerHeight();
		var newColsH = dashboardH;
		var headhH = $('.page-main-header').outerHeight(true);
		var colsH = $(div + ' .equal-columns').outerHeight(true);
		if (headhH) {
			newColsH = dashboardH - headhH;
		}
		var magicNum = 0;
		$(div).find('.equal-columns .equal-height').each(function() {
			if ($(this).parents().hasClass('brand-steps')) {
				magicNum = 60;
			}
			if ($(this).parents().hasClass('brand-settings')) {
				magicNum = 30;
			}
			if ($(this).parents().hasClass('modal')) {
				$(this).css('height', colsH);
			} else {
				if (newColsH > colsH) {
					$(this).css('height', newColsH - magicNum);
				} else {
					$(this).css('height', colsH);
				}
			}
		});
	};

	window.qtipEqualColumns = function qtipEqualColumns() {
		var colsH = $('.equal-columns').outerHeight(true);
		$('.equal-columns .equal-height').each(function() {
			$(this).css('height', colsH);
		});
	};

	window.showHide = function showHide(trigger, show, hide) {
		if (hide) {
			$(hide).slideUp(function() {
				//call custom function on completion
				$(hide).trigger('contentSlidUp', [trigger]);
				$(show).slideDown(function() {
					$(show).trigger('contentSlidDown', [trigger]);
					equalColumns();
				});
			});
		} else {
			$(show).slideToggle(function() {
				$(show).trigger('contentSlidDown', [trigger]);
				equalColumns();
			});
		}
	}

	window.showPostPopover = function showPostPopover(element, id, jsEvent, className) {
		var offsetY, offsetX, tipW, tipH;
		if (className === 'approvals-post') {
			offsetY = 27;
			offsetX = 9;
			tipW = 30;
			tipH = 15;
		} else {
			offsetY = 0;
			offsetX = 0;
			tipW = 20;
			tipH = 10;
		}
		element.qtip({
			content: {
				text: function(event, api) {
					$.ajax({
						url: base_url + "posts/get_post_info/" + id + '/' + $('#calendar_type').val()
					}).then(function(content) {
						// Set the tooltip content upon successful retrieval
						api.set('content.text', content);
						var tipId = api.get('id');
						//reposition tooltip after images load
                        document.getElementById('qtip-' + tipId).addEventListener('load', function(event){
                            var elm = event.target;
                            if( elm.nodeName.toLowerCase() === 'img' && !$(elm).hasClass('loaded')){
                                $(elm).addClass('loaded');
                                if($('#qtip-' + tipId + ' img.loaded').length === $('#qtip-' + tipId + ' img').length) {
                                    // All images loaded
									api.reposition();
                                }
                            }
                        },
                        true
                        );
					}, function(xhr, status, error) {
						// Upon failure... set the tooltip content to the status and error value
						api.set('content.text', status + ': ' + error);
					});
					return 'Loading...'; // Set some initial text
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
				effect: false,
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
				width: 435
			}
		}, jsEvent);
	};

	//live preview		
	function createPreview() {
		var postOutletClass;
		$('#live-post-preview').empty();
		$('.no-of-photos').html('');
		var outlet_id = $('#postOutlet').val();
		var selected_outlet = $('#postOutlet').attr('data-outlet-const');
		var post_copy;
		if ($('#postCopy').val()) {
			post_copy = $('#postCopy').val().replace(/\r?\n/g, '<br/>');
			$('#outlet_' + outlet_id + ' .post_copy_text').html(post_copy);
		}
		$('#live-post-preview').append($('#outlet_' + selected_outlet).html());
	}

	$(document).on('keyup', '#postCopy', function() {
		var selected_outlet = $('#postOutlet').attr('data-outlet-const');
		var post_copy = $(this).val();
		var post_length = post_copy.length;
		post_copy = convertToLink(post_copy);
		post_copy = hashtagToLink(post_copy);
		post_copy = atToLink(post_copy);
		if(selected_outlet === 'twitter' || selected_outlet === 'linkedin') {
			var charsLeft ;
			if(selected_outlet === 'twitter'){
				charsLeft = 140 - post_length;
			}
			if(selected_outlet === 'linkedin'){
				charsLeft = 256 - post_length;
			}
			$('#charsLeft').text(charsLeft);
		}
		$('#live-post-preview .post_copy_text').html(post_copy.replace(/\r?\n/g, '<br/>'));
	});

	//youtube video title
	$(document).on('keyup', '#ytVideoTitle', function() {		
		$('.video-title').html($(this).val());
	});

	/*
	*	Delete the Post
	*/
	$(document).on("click", ".delete_post", function(event) {
		event.preventDefault();
		var post_id = [];
		post_id.push($(this).data('post-id'));
		getConfirm(language_message.delete_post,'','',function(confResponse) {
			if(confResponse){
				$.ajax({
					'type': 'POST',
					dataType: 'json',
					url: base_url + 'posts/delete_post',
					data: {
						'post_ids': post_id
					},
					success: function(response) {
						location.reload();
					}
				});
			}
		});
	});

	/*
	*	Delete selected post from Draft
	*/
	$(document).on("click", "#submitDeleteDrafts", function(event) {
		var postsTotDelete = [];
		$.each($(".select-box"), function(a, b) {
			if ($(b).hasClass('checked') && $(b).data('value') != "check-all") {
				postsTotDelete.push($(b).data('value'));
			}
		});

		$.ajax({
			'type': 'POST',
			dataType: 'json',
			url: base_url + 'posts/delete_post',
			data: {
				'post_ids': postsTotDelete
			},
			success: function(response) {
				location.reload();
			}
		});
	});

	$(document).on("click", ".approve_post", function(event) {
		var post_id = $(this).data('post-id');
		var user_id = $(this).data('user-id');

		if (post_id) {
			$.ajax({
				'type': 'POST',
				dataType: 'json',
				url: base_url + 'posts/approve_post/',
				data: {
					'post_id': post_id,
					'user_id': user_id,
				},
				success: function(response) {
					//	.log(response);
					//location.reload();
				}
			});
		}
	});

	$(document).on("click", ".change-approve-status", function(event) {
		var phase_id = $(this).data('phase-id');
		var status = $(this).data('phase-status');
		var user_id = $('#user-id').val()
		var post_id = $(this).data('post-id');
		var btn = this;

		if (post_id) {
			$.ajax({
				'type': 'POST',
				dataType: 'json',
				url: base_url + 'posts/change_post_status',
				data: {
					'phase_id': phase_id,
					'status': status,
					'user_id': user_id,
					'post_id': post_id
				},
				success: function(response) {
					if ($(btn).attr('id') == 'approval_list_btn') {
						$(btn).hide();
						$(btn).parent().children('a:eq(1)')
						$(btn).parent().children('a:eq(1)').show();
					} else {
						$(btn).parent().addClass('hide');
						if ($(btn).parent('.before-approve').length) {
							$(btn).parent().parent().children('div:last').removeClass('hide')
						} else {
							$(btn).parent().parent().children('div:first').removeClass('hide')
						}
					}
				}
			});
		}
	});

	//view edit request
	/*
	 * change the status comment(Accept, Reject)
	 */

	 $(document).on('click', '.change-status', function() {
	 	var comment_id = $(this).data('id');
	 	var status = $(this).data('status');

	 	var data = {
	 		'comment_id': comment_id,
	 		'status': status
	 	};
	 	var control = this;
	 	$.ajax({
	 		type: 'POST',
	 		url: base_url + 'approvals/change_comment_status',
	 		data: data,
	 		success: function(response) {
	 			if (response == 1) {
	 				$(control).parent().parent().children('p:last').html('Status: ' + status);
	 				$(control).parent().children('button').prop('disabled', true);
	 			} else {
	 				getConfirm(language_message.unable_to_change_status,'','alert',function(confResponse) {
						// return false;
					});
	 			}
	 		}
	 	});
	 });

	 $(document).on('click', '.schedule-post', function() {
	 	var id = $(this).attr('id');
	 	var btn = this;
	 	if (id) {
	 		$.ajax({
	 			'type': 'POST',
	 			url: base_url + 'posts/schedule_post',
	 			data: {
	 				'post_id': id
	 			},
	 			success: function(response) {
	 				if (response == 1) {
	 					$(btn).html('Scheduled');
	 					$(btn).prop('disabled', true);
	 					// $(btn).addClass('btn-disabled');
	 					// $(btn).addClass('btn-secondary');
	 					// $(btn).removeClass('btn-default');
	 				} else {
	 					getConfirm(language_message.unable_to_post,'','alert',function(confResponse) {
							// return false;
						});
	 				}
	 			}
	 		});
	 	}
	 });

	 $(document).on("click", ".edit_post", function(event) {
		//.qtip is my qtip element from the parent page and then I hide it.
		$('.qtip', window.parent.document).qtip("hide");
	});

	 $(document).on('click', '.got-to-calender', function(e) {
	 	e.preventDefault();
	 	$('#selected_date').val($(this).data('post-date'));
	 	$('#summary-form').submit();
	 });

	 $('body').on('click', '.toggleActive', function(e) {
	 	e.preventDefault();
	 	$(this).closest('.approval-phase').toggleClass('active inactive');
	 	$(this).find('.fa').toggleClass('fa-angle-right fa-angle-down');
	 	equalColumns();
	 });



	 $(document).on('click', '.delete-phase', function(event) {
	 	event.preventDefault();
	 	$btn = $(this);	 
	 	var post_id, phase_id;
	 	post_id = $btn.attr('data-post-id');
	 	phase_id = $btn.attr('data-phase-id');

	 	getConfirm(language_message.confirm_delete_phase,'','',function(confResponse) {
		 	if (confResponse) {
		 		if(post_id && phase_id)
		 		{
			 		$.ajax({
			 			'type': 'POST',
			 			dataType: 'json',
			 			url: base_url + 'phases/delete',
			 			data: {
			 				'post_id': post_id,
			 				'phase_id': phase_id
			 			},
			 			success: function(response) {
			 				if (response.status == 'success') {
			 					console.log($('.col-md-4:eq(2)'));
			 					$('.phases-div').remove();
			 					$('.modal-backdrop').remove();
								$( ".insert_after" ).after(response.html);
								addIncrements();
								qtipEqualColumns();
			 				} else {
			 				// 	getConfirm(language_message.try_again,'','alert',function(confResponse) {
								// 	// $('.modal-hide').click();
								// });
			 				}
			 			}
			 		});
			 	}
		 		var phase_no = $btn.data('id') + 1;
		 		if(phase_no == 1)
		 		{
			 		$("#preview_approvalPhase"+phase_no).find('li').empty();
		 			$('.cancel-phase').trigger('click');
		 		}
		 		else
		 		{
			 		$("#approvalPhase"+phase_no).find('input:not(.amselect)').val('');
			 		$("#approvalPhase"+phase_no).find('textarea').val('');
			 		$("#approvalPhase"+phase_no).find('li .user-img').remove();
			 		$("#preview_approvalPhase"+phase_no).find('li').empty();

			 		$("#approvalPhase"+phase_no).addClass('hide');
			 		// $("#approvalPhase"+phase_no - 1).find('.btn-change-phase:not(.btn-default)');
			 		nextPhase(phase_no -1,$("#approvalPhase"+phase_no - 1).find('.btn-change-phase:not(.btn-default)'));
			 	}
		 	}
		 });
	 });

	 // $(document).on('click', '.go_back', function() {
	 // 	$btn = $(this).next("button");
	 // 	$.each($btn.data(), function(i, k) {
	 // 		var attr_name = i.split(/(?=[A-Z])/);
	 // 		var str = attr_name[0] + '-' + attr_name[1];
	 // 		$btn.removeAttr("data-" + str.toLowerCase());
	 // 	});
	 // });

	 $(document).on('change', 'select[name="time_zone"]', function() {
	 	var selected_abb;
	 	selected_abb = $(this).find(':selected').data('abbreviation');
	 	$('#timezone_abbreviation').text(selected_abb);
	 });

	$(document).on('click','.set_schedule_id',function(){
    	var post_id = $(this).data('post-id');
    	$('#schedule-post').attr('data-post-id',post_id);
    	$('#send-mail').attr('data-post-id',post_id);
    });

    $(document).on('click','#schedule-post',function(){
    	var post_id = $(this).attr('data-post-id');
    	$.ajax({
    		url:base_url+'posts/schedule_post',
    		data:{post_id:post_id},
    		type:'POST',
    		success:function(response)
    		{
    			if(response == '1')
    			{
    				window.location.reload();
    			}
    			else
    			{
    				getConfirm(language_message.unable_to_schedule,'','alert',function(confResponse) {
						return false;
					});
    			}

    		}
    	});
    });

	$(document).on('click','#send-mail',function(){
    	var post_id = $(this).attr('data-post-id');
    	$.ajax({
    		url:base_url+'send_mail_pending_approvers',
    		data:{post_id:post_id},
    		type:'POST',
    		success:function(response)
    		{
    			if(response == "1")
    			{
    				window.location.reload();
    			}
    			else
    			{
    				getConfirm(language_message.unable_to_schedule,'','alert',function(confResponse) {
						return false;
					});					
    			}

    		}
    	});
    });

	 $('.collapse').on('shown.bs.collapse', function(){
	 	$(this).next().text('Less');
	 }).on('hidden.bs.collapse', function(){
	 	$(this).next().text('See more');		
	 });

	 toggleBtnClass = function(btnClass, btnState) {
	 	$(btnClass).prop('disabled', btnState);
	 	if (btnState) {
	 		$(btnClass).addClass('btn-disabled');
	 	} else {
	 		$(btnClass).removeClass('btn-disabled');
	 	}
	 };

	 $('#timezone_abbreviation').text($('select[name="time_zone"]').find(':selected').data('abbreviation'));

		if (desktop_notify_status == 0 && plan_data.real_time_notification != 0)
		{
			if(Notification.permission !== 'granted'){
				Notification.requestPermission();
			}
			alert_notification();
		}
	});

function alert_notification() {
	setTimeout(function() {
		jQuery.ajax({
			url: base_url + 'brands/get_active_notifications',
			type: 'get',
			dataType: 'json',
			success: function(response) {
				if (response) {
					n = new Notification("Please check the notification", {
						body: response.text,
						icon: "star.ico"
					});
				}
			}
		});
		
		alert_notification();
	}, 10000);
}

function convertToLink(text) {
	var exp = /(\b((https?|ftp|file):\/\/|(www))[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]*)/ig;
	return text.replace(exp, "<a href='$1' target='_blank'>$1</a>");
}

function hashtagToLink(text) {
	var exp = /(?:^|\W)#(\w+)(?!\w)/g;
	return text.replace(exp, " <a href='$1' target='_blank'>#$1</a>");
}

function atToLink(text) {
	var exp = /(?:^|\W)@(\w+)(?!\w)/g;
	return text.replace(exp, "<a href='$1' target='_blank'>@$1</a>");
}

function setUserTime() {
	d = new Date();
	var localTime = d.getTime();
	localOffset = d.getTimezoneOffset() * 60000;
	utc = localTime + localOffset; 	
	today = utc + (3600000*user_data.timezone); 
	today = new Date(today);
	
	// var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();

	var ampm = h >= 12 ? 'pm' : 'am';

	// add leading 0
	if (s < 10) {
		s = "0" + s;
	}

	h = checkHours(h);
	m = checkMinutes(m);
	document.getElementById('userTime').innerHTML = h + ":" + m + ":" + s;
	//set timezone
	var tz = moment.tz.guess();
	var zoneAbbr = moment.tz(tz).zoneAbbr();
	// var ampm = moment().format('a');
	document.getElementById('userTimeZone').innerHTML = ampm + " " + zoneAbbr;
	//realtime time updates
	var t = setTimeout(setUserTime, 500);
}

function checkMinutes(i) {
	if (i < 10) {
		i = "0" + i
	}; // add zero in front of numbers < 10
	return i;
}

function checkHours(i) {
	if (i > 12) {
		i = i - 12
	}; //12 hour format
	return i;
}

function showContent(obj) {
	obj.fadeIn(function() {
		obj.trigger('contentShown');
	});

	if(jQuery('#phaseDetails').attr('id') == jQuery(obj).attr('id'))
	{		
		var phases = jQuery('.add_phases_num #approvalPhases').val();
		jQuery.each(jQuery('#phaseDetails').find('.approval-phase'),function(index,obj){			

			if(jQuery(this).data('id') >= phases)
			{
				jQuery(this).addClass('hide');
				jQuery(this).addClass('hidden-phase');
			}
		});

		setPhaseBtnsCreatePost(jQuery('#phaseDetails').find('.approval-phase:first'),phases - 1);

	}
}

function setPhaseBtnsCreatePost(activePhase,phaseCount) {
	// var phaseId = activePhase.data('id');
	var btn_num = 0;
	if(jQuery(activePhase).data('id') == phaseCount)
	{
		activePhase.find('[data-new-phase]:eq(' + btn_num + ')').text('Add Phase');
		activePhase.find('.delete-phase').removeClass('hide');
	}
}

function hideContent(obj) {
	obj.fadeOut(function() {
		obj.trigger('contentHidden');
	});
}

function text_char_limit(outlet_const, limit){
	limit = parseInt(limit);
	var tweet = $("#postCopy").val();
	var chars = tweet.length;
	var charsLeft = limit - chars;
	if (tweet.length > limit) {
		var tweetTrunc = tweet.substring(0, limit);
		$("#postCopy").val(tweetTrunc);
	}
	if(charsLeft < 0 ){
		charsLeft = 0;
	}
	$("#postCopy").attr("maxlength", limit);

	if ($('.form__preview-wrapper img').length > 4 && outlet_const == 'twitter') {
		getConfirm(language_message.twitter_img_allowed_outlet_change,'','alert',function(confResponse) {});
		return false;
	}
	if(!$('.tweet-chars').length) {
		$('#postCopy').after('<div class="tweet-chars"><span id="charsLeft" class="color-danger">' + charsLeft + '</span> characters remaining.</div>');
	}
	else {
		$('#charsLeft').text(charsLeft);
	}
}


function getConfirm(confirmMessage,confirmTitle,is_alert,callback){
	
	var $ = jQuery;
	var title = $("#confirmTitle");
	var message = $("#confirmMessage");
	title.empty();
	message.empty();
	confirmMessage = confirmMessage || '';
	confirmTitle = confirmTitle || '';
	
	if(confirmTitle ==''){
		confirmTitle = 'Alert';
	}

	$('#confirmbox').modal({
		show:true,
		backdrop:true,
		keyboard: false,
	});

	title.html(confirmTitle);
	message.html(confirmMessage);

	if(is_alert == 'alert'){
		$('#confirmFalse').hide();
	}else{
		$('#confirmFalse').show();
	}

	$('#confirmFalse').click(function(){
		$('#confirmbox').modal('hide');
		if (callback) callback(false);
	});
	$('#confirmTrue').click(function(){
		$('#confirmbox').modal('hide');
		if (callback) callback(true);
	});
}
