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
		createPreview();

		$('#post-details .outlet-list li').on('click', function() {
			var previous_outlet = $('#postOutlet').val();
			var outlet = $(this).data('selectedOutlet');
			var outlet_const = $(this).data('outlet-const');
			$('#postCopy').removeAttr('maxlength');
			if (outlet_const == 'twitter') {
				//only allow 140 characters for tweets
				var tweet = $("#postCopy").val();
				var chars = tweet.length;
				var charsLeft = 140 - chars;
				if (tweet.length > 140) {
					var tweetTrunc = tweet.substring(0, 140);
					$("#postCopy").val(tweetTrunc);
				}
				$("#postCopy").attr("maxlength", 140);

				if ($('.form__preview-wrapper img').length > 4) {
					alert(language_message.twitter_img_allowed_outlet_change);
					return false;
				}
				$('#postCopy').after('<div class="tweet-chars"><span id="charsLeft" class="color-danger">' + charsLeft + '</span> characters remaining.</div>');
			}
			if(outlet_const !== 'twitter') {
				$('.tweet-chars').remove();
			}

			if (outlet_const == 'vine' || outlet_const == 'youtube') {
				if ($('.form__preview-wrapper img').length) {
					if (outlet_const == 'youtube') {
						alert(language_message.youtube_outlet_change_error);
					} else {
						alert(language_message.vine_outlet_change_error);
					}

					return false;
				}
			}

			if (outlet_const == 'instagram') {
				if ($('.form__preview-wrapper video').length) {
					alert(language_message.insta_outlet_change_error);
					return false;
				}

				if ($('.form__preview-wrapper img').length > 1) {
					alert(language_message.insta_outlet_change_img_error);
					return false;
				}
			}

			if (outlet_const == 'linkedin') {
				if ($('.form__preview-wrapper img').length > 1) {
					alert(language_message.linkedin_outlet_change_error);
					return false;
				}
			}

			if (outlet_const == 'pinterest') {
				if ($('.form__preview-wrapper img').length > 1) {
					alert(language_message.pinterest_outlet_change_error);
					return false;
				}
			}

			if (previous_outlet != outlet_const) {
				$(this).toggleClass('disabled');
				$(this).siblings().addClass('disabled');
				$('#postOutlet').attr('data-outlet-const', outlet_const);
				$('#postOutlet').val(outlet);
				removeFromPreview();
			}
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

		//popover triggers
		$('body').on('mouseover', '[data-toggle="popover-hover"]', function(e) {
			var $target = $(this);
			var pcontent = $target.data('content');
			$target.qtip({
				content: {
					text: pcontent
				},
				position: {
					my: 'top center',
					at: 'bottom center',
					viewport: $('.content-area')
				},
				show: {
					effect: function() {
						$(this).fadeIn();
					},
					event: e.type,
					ready: true
				},
				style: {
					classes: 'qtip-shadow',
					tip: {
						width: 20,
						height: 10
					}
				}
			}, e);
		});

		$('body').on('click', '[data-toggle="popover"]', function(e) {
			var $target = $(this);
			var pcontent = $target.data('content');
			$target.qtip({
				content: {
					text: pcontent
				},
				position: {
					my: 'top center',
					at: 'bottom center'
				},
				show: {
					effect: function() {
						$(this).fadeIn();
					},
					event: e.type,
					ready: true
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
			}, e);
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
			var $target = $(this);
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
			var pconstrain = $target.data('popoverConstrain');
			var phide = $target.data('hide');
			if (!pcontainer) {
				pcontainer = '.page-main';
			}
			if (!pconstrain) {
				pconstrain = false;
			} else {
				pconstrain = $(pconstrain);
			}
			var tipW = 1;
			var tipH = 1;
			if (parrow) {
				tipW = 20;
				tipH = 10;
			}
			if (phide !== false) {
				phide = 'click unfocus';
			}
			$target.qtip({
				content: {
					title: ptitle,
					text: function(event, api) {
						$.ajax({
							url: pcontent
						}).then(function(content) {
							// Set the tooltip content upon successful retrieval
							api.set('content.text', content);
						}, function(xhr, status, error) {
							// Upon failure... set the tooltip content to the status and error value
							api.set('content.text', status + ': ' + error);
						});
						return 'Loading...'; // Set some initial text
					}
				},
				events: {
					show: function() {
						$target.attr('data-toggle', 'popover-ajax-inline');
						if($target.hasClass('approver-selected'))
						{
							$('[data-toggle="popover-ajax"]').attr('data-toggle', 'popover-ajax-inline');
						}
					},
					visible: function() {
						var modal = this;
						// $(modal).attr('id','qtip-'+pid);
						// $(modal).find('qtip-content').attr('id','qtip-'+pid+'-content');
						var classes = $(this).qtip('api').get('style.classes');
						$('.qtip').trigger('qtipShown', [classes]);

						/*	used for display selected and not selected (hide) Approvals list
						 *	This is use to disable users which are already selected in next phase for only first phase on edit post overlay page
						 */
						 
						 if ($target.hasClass('first-new-phase')) {
						 	var $activePhase = $target.closest('.approval-phase');
						 	var phaseId = $activePhase.attr('id');
						 	var users = $(modal).find('.user-list li');
						 	$.each(users, function(c, user) {
						 		var ttipUser = $(user).find('input[name="post-approver"]').val();
						 		var $phaseUser = $activePhase.find('.approver-selected img[data-id="' + ttipUser + '"]');
						 		if($phaseUser.length) {
						 			$(user).find('[data-group="post-approver"]').addClass('selected');						 			
						 		}
						 	});
						 }
						 else
						 {
						 	//if user added one phase with all user and on edit post
						 	//he removed one user from first user and then go to next phase
						 	//it should not disable all user except which removed
						 	var $activePhase = $target.closest('.approval-phase');
						 	var phaseId = $activePhase.attr('id');
						 	var users = $(modal).find('.user-list li');
						 	$.each(users, function(c, user) {
						 		var ttipUser = $(user).find('input[name="post-approver"]').val();
						 		
						 		var $phaseUser = $activePhase.find('.approver-selected img[data-id="' + ttipUser + '"]');
						 		
						 		if($phaseUser.length) 
						 		{
						 			$(user).find('[data-group="post-approver"]').addClass('selected');
						 		}
						 		
						 	});
					 	}
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
					target: $target,
					viewport: pconstrain
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
			var pconstrain = $target.data('popoverConstrain');
			var phide = $target.data('hide');
			if (!pcontainer) {
				pcontainer = '.page-main';
			}
			if (!pconstrain) {
				pconstrain = false;
			} else {
				pconstrain = $(pconstrain);
			}
			var tipW = 1;
			var tipH = 1;
			if (parrow) {
				tipW = 20;
				tipH = 10;
			}
			if (phide !== false) {
				phide = 'click unfocus';
			}

			if (!$target.hasClass('approver-selected')) {

				$('#qtip-' + pid).qtip('api').set({
					'content.title': ptitle,
					'events.visible': function() {
						var classes = $(this).qtip('api').get('style.classes');
						$('.qtip').trigger('qtipShown', [classes]);
					},
					'hide.effect': function() {
						$(this).fadeOut();
					},
					'hide.event': phide,
					'position.adjust.x': poffsetX,
					'position.adjust.y': poffsetY,
					'position.at': ptattachment,
					'position.my': pattachment,
					'position.container': $(pcontainer),
					'position.target': $target,
					'position.viewport': pconstrain,
					'overwrite': false,
					'show.effect': function() {
						$(this).fadeIn();
					},
					'show.event': e.type,
					'show.solo': true,
					'style.classes': 'qtip-shadow ' + pclass,
					'style.tip.corner': true,
					'style.tip.mimic': 'center',
					'style.tip.height': tipH,
					'style.tip.width': tipW,
					'style.width': pwidth
				}, e);
			} else {
				$('#qtip-' + pid).qtip('api').set({
					'content.title': ptitle,
					'content.title': ptitle,
					'events.visible': function() {
						var classes = $(this).qtip('api').get('style.classes');
						$('.qtip').trigger('qtipShown', [classes]);

						var modal = this;
						var count = 0;

						/*	used for display selected and not selected (hide) Approvals list
						 *	This is use to disable users which are already selected in previous phase on create post and edit post overlay page
						 *
						 */		 
						 if ($target.hasClass('first-new-phase')) {
						 	var $activePhase = $target.closest('.approval-phase');
						 	var phaseId = $activePhase.attr('id');
						 	var users = $(modal).find('.user-list li');
						 	$.each(users, function(c, user) {
						 		var ttipUser = $(user).find('input[name="post-approver"]').val();
						 		var $phaseUser = $('#phaseDetails').find('.approver-selected img[data-id="' + ttipUser + '"]');
						 		if($phaseUser.length) {
						 			var selectedPhase = $phaseUser.closest('.approval-phase').attr('id');
						 			if(phaseId === selectedPhase) {
						 				$(user).find('[data-group="post-approver"]').addClass('selected');
						 			}
						 		}
						 		else
						 		{
						 			$(user).find('[data-group="post-approver"]').removeClass('selected');
						 		}
						 	});
						 }
						 else
						 {
						 	
						 	var $activePhase = $target.closest('.approval-phase');
						 	var phaseId = $activePhase.attr('id');
						 	var users = $(modal).find('.user-list li');
						 	$.each(users, function(c, user) {
						 		var ttipUser = $(user).find('input[name="post-approver"]').val();
						 		var $phaseUser = $activePhase.find('.approver-selected img[data-id="' + ttipUser + '"]');						 		
						 		if($phaseUser.length) {
						 			var selectedPhase = $phaseUser.closest('.approval-phase').attr('id');
						 			if(phaseId === selectedPhase) {
						 				$(user).find('[data-group="post-approver"]').addClass('selected').removeClass('disabled');
						 			}
						 		}
						 		else
						 		{
						 			$(user).find('[data-group="post-approver"]').removeClass('selected');
						 		}
						 	});
						 }
						},
						'hide.event': 'unfocus',
						'position.adjust.x': poffsetX,
						'position.adjust.y': poffsetY,
						'position.at': ptattachment,
						'position.my': pattachment,
						'position.container': $(pcontainer),
						'position.target': $target,
						'overwrite': false,
						'style.classes': 'qtip-shadow ' + pclass,
						'style.tip.corner': arrowcorner,
						'style.tip.mimic': 'center',
						'style.tip.height': tipH,
						'style.tip.width': tipW
					}).show({
						effect: function() {
							$(this).fadeIn();
						},
						event: e.type,
						ready: true
					}, e);
				}
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
			if (!pcontainer) {
				pcontainer = '.page-main';
			}
			var tipW = 1;
			var tipH = 1;
			if (parrow) {
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
						corner: true,
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
			if ($toggler.hasClass('show-brands-toggler')) {
				if (e.type === 'click') {
					if ($toggler.hasClass('animated')) {
						$toggler.removeClass('animated pulse');
						setTimeout(function() {
							$toggler.addClass('selected');
						}, 300);
					} else {
						$toggler.removeClass('selected');
						$('.popover-brand-list').qtip('hide');
						setTimeout(function() {
							$toggler.addClass('animated pulse');
						}, 200);
					}
				} else {
					$toggler.removeClass('selected');
					setTimeout(function() {
						$toggler.addClass('animated pulse');
					}, 200);
				}
			} else {
				if (e.type === 'click') {
					//remove selected class if user clicks from one toggler to another
					$('.popover-toggle.selected').each(function() {
						$(this).removeClass('selected');
					});
					$toggler.addClass('selected');
				} else {
					$toggler.removeClass('selected');
				}
			}
		});

		$('.page-main-header a[class*="tf-icon"]').on('click blur', function() {
			$(this).toggleClass('active');
		});

		//hide visible tooltips when body is clicked
		$('body').on('click', function(e) {
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
			if (hide) {
				$(hide).slideUp(function() {
					//call custom function on completion
					$(hide).trigger('contentSlidUp', [$trigger]);
					$(show).slideDown(function() {
						$(show).trigger('contentSlidDown', [$trigger]);
						equalColumns();
					});
				});
			} else {
				$(show).slideToggle(function() {
					$(show).trigger('contentSlidDown', [$trigger]);
					equalColumns();
				});
			}
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
	});


	//modal triggers
	//Get modal content from an external source
	$('body').on('click', '[data-toggle="modal-ajax"]', function(e) {
		e.preventDefault();
		var newModal = $('#emptyModal').clone();
		var $target = $(this);
		var mid = $target.data('modalId');
		var msize = $target.data('modalSize');
		var mtitle = $target.data('title');
		var mclass = $target.data('class');
		$.get($target.data('modalSrc'), function(data) {
			newModal.attr('id', mid);
			if (msize !== "") {
				newModal.find('.modal-dialog').addClass('modal-' + msize);
			}
			if (mclass !== "") {
				newModal.addClass(mclass);
			}
			if (mtitle) {
				mtitle = '<h2 class="text-xs-center">' + mtitle + '</h2>';
				newModal.find('.modal-body').html(mtitle + data);
			} else {
				newModal.find('.modal-body').html(data);
			}
			newModal.modal({
				show: true,
				backdrop: 'static'
			});
			newModal.on('shown.bs.modal', function() {
				$('.modal-toggler').fadeIn();
				fileDragNDrop();
				equalColumns('#' + mid);
				addIncrements();
			});
			newModal.on('hide.bs.modal', function() {
				$('.modal-toggler').fadeOut();
			});

			if ($target.data('clear') == 'no') {
				$target.attr('data-toggle', 'modal-ajax-inline');
			}
			if ($('#qtip-popover-post-menu-content')) {
				$('#qtip-popover-post-menu-content').hide();
			}
		});
	});

	//Get modal content from inline source
	$('body').on('click', '[data-toggle="modal-ajax-inline"]', function(e) {
		e.preventDefault();
		var $target = $(this);
		var mid = $target.data('modalId');
		$('#' + mid).modal({
			show: true,
			backdrop: 'static'
		});
		$('#' + mid).on('shown.bs.modal', function() {
			$('.modal-toggler').fadeIn();
			equalColumns('#' + mid);
			addIncrements();
		});
		$('#' + mid).on('hide.bs.modal', function() {
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

		if ($('#edit-post-details').length) {
			var edit_modal = $('#edit-post-details').closest('.modal');
			setTimeout(function() {
				edit_modal.remove();
			}, 500);
			allFiles = [];
			equalColumns();
		}
		$('#qtip-popover-post-menu-content').show();
		$('.modal').modal('hide');
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

			$('#preview_approvalPhase1' + parseInt(phaseId)+1 ).find('.timezones-preview .zone').text($('option:selected',this).text());
			
			$(this).addClass('hide').removeClass('active');
			if ($(this).find('.approver-selected .user-img').length && $(this).find('.phase-date-time-input').val() && $(this).find('.hour-select').val() && $(this).find('.minute-select').val()) {
				phase_added = 1;
				$('.saved-phase[data-id="' + phaseId + '"]').removeClass('hide').addClass('active');
			}
		});

		if(phase_added == 0)
		{
			$('.container-approvals').children('div:first').removeClass('hide');
			$('.container-approvals').children('div:eq(1)').remove();
			$('.container-approvals').children('div:eq(2)').remove();
			$('.modal-contain').remove();
			if ($(this).hasClass('phase-num')) {
				$(this).trigger('click');
			}

			$('#qtip-popover-user-list').remove();
		}
		// $,each($phases,function(a,b){

		// });
		
	});

	$(document).on('click', '.cancel-edit-phase', function() {
		$('#is-new-approver').val('no');
		$.each($('#phaseDetails .saved-phase'), function() {
			var phaseId = $(this).data('id');
			if ($(this).find('.approval-list li').length) {
				$('.approval-phase[data-id="' + phaseId + '"]').removeClass('active').addClass('hide');
				$('.saved-phase[data-id="' + phaseId + '"]').removeClass('inactive hide');
			} else {
				$(this).addClass('hide');
			}
		});
		$('.phase-footer').addClass('hide');
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
	$('body').on('click', '.incrementer', function(e) {
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

	// $(document).on('keyup blur', '.approvalNotes', function() {
	// 	var phaseId = $(this).closest('.approval-phase.active').data('id');
	// 	$('.saved-phase[data-id="' + phaseId + '"]').find('.approval-note').html('NOTE: ' + $(this).val().replace(/\r?\n/g, '<br/>'));
	// });

	// $(document).on('change', '.approval_timezone', function() {
	// 	var phaseId = $(this).closest('.approval-phase.active').attr('id');
	// 	$('#preview_edit_' + phaseId ).find('.timezones-preview .zone').text($('option:selected',this).text());
	// 	$('#preview_' + phaseId ).find('.timezones-preview .zone').text($('option:selected',this).text());
	// });

	//show all the user and data to preview whcih we added while adding phase datails 
	//and show phase preview view
	$(document).on('click', '.save-phases', function() {
		var phases = $('#phaseDetails .approval-phase:not(.saved-phase)');		
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
			$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.date-preview'+(parseInt(phaseId) + 1)).text(date);
			$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.date-preview'+(parseInt(phaseId) + 1)).text(date);

			//for preview of edit (hour minute and ampm)
			var time = $('#approvalPhase' + (parseInt(phaseId) + 1));			
			var time_preview_edit = $('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).closest('.time-preview');
			$(time_preview_edit).find('.hour-preview').val($(time).find('.hour-select').val());
			
			$(time_preview_edit).find('.minute-preview').val($(time).find('.minute-select').val());
			$(time_preview_edit).find('.ampm-preview').val($(time).find('.amselect').val());

			//for preview of add (hour minute and ampm)
			var time_preview = $('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).closest('.time-preview');			
			$(time_preview).find('.hour-preview').val($(time).find('.hour-select').val());
			$(time_preview).find('.minute-preview').val($(time).find('.minute-select').val());
			$(time_preview).find('.ampm-preview').val($(time).find('.amselect').val());

			//show time on preview (date)
			var note = $('#approvalPhase' + (parseInt(phaseId) + 1)).find('.note').val();
			$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.approval-note').html(note);
			$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.approval-note').html(note);

			//show time on preview (timezone)
			$('#preview_approvalPhase' + (parseInt(phaseId) + 1)).find('.timezones-preview .zone').text($('option:selected',this).text());
			$('#preview_edit_approvalPhase' + (parseInt(phaseId) + 1)).find('.timezones-preview .zone').text($('option:selected',this).text());
			
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
		$('#phaseDetails .saved-phase').each(function() {
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
						alert(language_message.unable_to_resubmit);
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
		$('.saved-phase[data-id="' + id + '"]').find('.time-preview .hour-preview').html(val);
		setPhaseBtns($('.approval-phase.active[data-id="' + id + '"]'));
	}

	function savePhaseMins(id, val) {
		$('.saved-phase[data-id="' + id + '"]').find('.time-preview .minute-preview').html(val);
		setPhaseBtns($('.approval-phase.active[data-id="' + id + '"]'));
	}

	function savePhaseAmPm(id, val) {
		$('.saved-phase[data-id="' + id + '"]').find('.time-preview .ampm-preview').html(val);
		setPhaseBtns($('.approval-phase.active[data-id="' + id + '"]'));
	}

	function setPhaseBtns(activePhase) {
		var phaseId = activePhase.data('id');		
		//to hide next button for last phase		
		if(phaseId == $('#phaseDetails').find('.approval-phase:not(".saved-phase"):not(".hide")').length - 1)
		{
			if(phaseId != 2)
			{
				activePhase.find('[data-new-phase]:eq(' + 1 + ')').text('Add Phase');
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
		setUserList(i);
	}
	
	function setUserList(i) {
		var $selected = $('#qtip-popover-user-list').find('.selected');
		$selected.each(function() {
			$(this).removeClass('selected');
		});
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
		if(selected_outlet === 'twitter') {
			var charsLeft = 140 - post_length;
			$('#charsLeft').text(charsLeft);
		}
		$('#live-post-preview .post_copy_text').html(post_copy.replace(/\r?\n/g, '<br/>'));
	});

	/*
	*	Delete the Post
	*/
	$(document).on("click", ".delete_post", function(event) {
		event.preventDefault();
		if (confirm(language_message.delete_post)) {
			var post_id = [];
			post_id.push($(this).data('post-id'));

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
					//console.log(response);
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
	 				alert(language_message.unable_to_change_status);
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
	 					$(btn).addClass('btn-disabled');
	 					$(btn).addClass('btn-secondary');
	 					$(btn).removeClass('btn-default');
	 				} else {
	 					alert(language_message.unable_to_post);
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
	 	post_id = $btn.data('post-id');
	 	phase_id = $btn.data('phase-id');

	 	if (confirm(language_message.confirm_delete_phase)) {
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
	 					window.location.reload();
	 					$('.modal-hide').click();
	 				} else {
	 					alert(language_message.try_again);
	 					$('.modal-hide').click();
	 				}
	 			}
	 		});
	 	}
	 });

	 $(document).on('click', '.go_back', function() {
	 	$btn = $(this).next("button");
	 	$.each($btn.data(), function(i, k) {
	 		var attr_name = i.split(/(?=[A-Z])/);
	 		var str = attr_name[0] + '-' + attr_name[1];
	 		$btn.removeAttr("data-" + str.toLowerCase());
	 	});
	 });

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
    				alert(language_message.unable_to_schedule);
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
    				alert(language_message.unable_to_schedule);
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
	 	//alert_notification();
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
	}
}

function hideContent(obj) {
	obj.fadeOut(function() {
		obj.trigger('contentHidden');
	});
}