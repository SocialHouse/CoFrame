jQuery(function($) {

	// $('.container-approvals').click(function(){
	// 	$(this).addClass('modal-backdrop');
	// 	$(this).addClass('fade');
	// 	$(this).addClass('in');
	// 	$(this).addClass('modal-contain');
	// 	return false;
	// });

	var wh = $(window).height();
	var ww = $(window).width();

	var inlineTether, ajaxTether;

	if($('#brand-manage').length) {
		setUserTime();
	}

	$(window).on("orientationchange resize", function () {
		wh = $(window).height();
		ww = $(window).width();
	});

	$(document).ready(function() {

		var outlet_id = $('.outlet_ul li:first').data('selected-outlet');
		var outlet_const = $('.outlet_ul li:first').data('outlet-const');
		$('.outlet_ul li:first').toggleClass('disabled');
		$('.outlet_ul li:first').siblings().addClass('disabled');
		$('#postOutlet').val(outlet_id);
		$('#postOutlet').attr('data-outlet-const',outlet_const);		
		createPreview();

		equalColumns();
		
		$('#post-details .outlet-list li').on('click', function() {
			var previous_outlet = $('#postOutlet').val();
			var outlet = $(this).data('selectedOutlet');
			var outlet_const = $(this).data('outlet-const');
			if(previous_outlet != outlet)
			{
				$(this).toggleClass('disabled');
				$(this).siblings().addClass('disabled');
				$('#postOutlet').val(outlet);
				$('#postOutlet').attr('data-outlet-const',outlet_const);

				var upload_element = '<input type="file" multiple="" data-multiple-caption="{count} files selected" class="form__file" id="postFile" name="files[]">';
				upload_element += '<label class="file-upload-label" id="postFileLabel" for="postFile"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>'
				upload_element += '<button class="form__button btn btn-sm btn-default" type="submit">Upload</button>';
				$('.form__input').removeClass('has-files');
				$('.form__input').empty();
				$('.form__input').append(upload_element);
				
				createPreview();
			}
		});

		// $('#brandStep2 .outlet-list li').on('click', function() {
		// 	if(!$(this).hasClass('saved')) {
		// 		$(this).toggleClass('disabled selected');
		// 		$(this).siblings().each(function() {
		// 			if(!$(this).hasClass('saved')) {
		// 				$(this).addClass('disabled');
		// 			}
		// 		});
		// 		if(!$(this).hasClass('disabled')) {
		// 			$('#addOutlet').removeClass('btn-disabled').prop("disabled", false);
		// 		}
		// 		else {
		// 			$('#addOutlet').addClass('btn-disabled').prop("disabled", true);
		// 		}
		// 	}
		// });
		// $('#brandStep3 .outlet-list li').on('click', function() {
		// 	var savedOutlets = $('#userOutlet').val();
		// 	var newOutlets = [];
		// 	var thisOutlet = $(this).data('selectedOutlet');
		// 	$(this).toggleClass('disabled selected');
		// 	if($(this).hasClass('selected')) {
		// 		if(savedOutlets !== '') {
		// 			newOutlets.push(savedOutlets);
		// 		}
		// 		newOutlets.push(thisOutlet);
		// 	}
		// 	else {
		// 		savedOutlets = savedOutlets.split(',');
		// 		var index = savedOutlets.indexOf(thisOutlet);
		// 		savedOutlets.splice(index, 1);
		// 		newOutlets.push(savedOutlets);
		// 	}
		// 	$('#userOutlet').val(newOutlets);
		// });
		// //add brand outlet to list
		// $('#addOutlet').on('click', function() {
		// 	var $selectedItem = $('#brandOutlets .selected');
		// 	var numberSelected =  $selectedItem.length;
		// 	var savedOutlets = [];
		// 	var outletsVal = $('#brandOutlet').val();
		// 	if(numberSelected > 0) {
		// 		var $selectedList = $('#selectedOutlets ul');
		// 		var $listItem = $(document.createElement('li'));
		// 		if(outletsVal !== '') {
		// 			savedOutlets.push(outletsVal);
		// 		}
		// 		savedOutlets.push($selectedItem.data('selectedOutlet'));
		// 		var outletHtml = $selectedItem.html();
		// 		var outletTitle = $selectedItem.data('selectedOutlet');
		// 		var removeOutlet = '<a href="#" class="pull-sm-right remove-outlet" data-remove-outlet="' + outletTitle + '"><i class="tf-icon circle-border">x</i></a>';
		// 		$listItem.append(outletHtml + outletTitle + removeOutlet).attr('data-outlet', outletTitle);
		// 		$selectedItem.addClass('saved').removeClass('selected');
		// 		//set input field value
		// 		$('#brandOutlet').val(savedOutlets);
		// 		$selectedList.append($listItem);
		// 	}
		// 	else {
		// 		return;
		// 	}
		// });
		// //remove brand outlet to list
		// $('body').on('click', '.remove-outlet', function() {
		// 	var savedOutlets = $('#brandOutlet').val().split(',');
		// 	var removeOutlet = $(this).data('remove-outlet');
		// 	$('#selectedOutlets li[data-outlet="' + removeOutlet + '"]').slideUp(function() {
		// 		var index = savedOutlets.indexOf(removeOutlet);
		// 		$(this).remove();
		// 		savedOutlets.splice(index, 1);
		// 		$('#brandOutlet').val(savedOutlets);
		// 	});
		// 	$('#brandOutlets li[data-selected-outlet="' + removeOutlet + '"]').removeClass('saved').addClass('disabled');
		// });

		// $('#userRoleSelect').on('change', function() {
		// 	var selectedRole = $(this).val();
		// 	var $actPermissions = $('.permission-details:visible');
		// 	if($actPermissions.length) {
		// 		$actPermissions.fadeOut(function() {
		// 			$('#' + selectedRole + 'Permissions').slideDown();
		// 		});
		// 	}
		// 	else {
		// 		$('#' + selectedRole + 'Permissions').slideDown();
		// 	}
		// });

		// $('.edit-permissions').on('click', function() {
		// 	var section = $(this).data('section');
		// 	var $sectionList = $('#' + section).find('.permissions-list');
		// 	$(this).toggleClass('btn-disabled');
		// 	$sectionList.toggleClass('view');
		// 	if($(this).hasClass('btn-disabled')) {
		// 		$sectionList.find('li').css('display', 'block');
		// 	}
		// 	else {
		// 		$sectionList.find('li.hidden').css('display', 'none');
		// 	}
		// });
		// $('.permissions-list .radio-button').on('click', function() {
		// 	var $parent = $(this).parent('li');
		// 	$parent.toggleClass('hidden');
		// });
		

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
		
			if($btn.hasClass('user-list')) {				
				if($btn.parent().parent().parent().parent().parent().attr('id') != 'qtip-popover-user-list')
				{
					$btn.parent().parent().parent().parent().parent().attr('id','qtip-popover-user-list');
				}

				var userImg = $btn.closest('li').find('img');
				$(userImg).attr('data-id',buttonVal);
				var checkbox = $btn.parent().children('.approvers');
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var newImage = userImg.clone();
				// var img = imgDiv;
				var $activePhase = $('#phaseDetails .approval-phase.active');
				var activePhaseId = $activePhase.attr('id');
				
				if($btn.hasClass('selected')) {
					$activePhase.parent().children('div:eq(1)').find('.user-list li').append(imgDiv);
				
				
					var phase_number = $activePhase.data('id');
					var inputDiv = '<input class="hidden-xs-up approvers" type="checkbox" checked="checked" value="' + buttonVal + '" name="phase['+phase_number+'][approver][]">';
					$activePhase.find('.user-list li').prepend(imgDiv);
					$activePhase.find('img[data-id="' + buttonVal + '"]').parent().prepend(inputDiv);					
					$btn.attr('data-linked-phase', activePhaseId);

					$activePhase.parent().children('div:eq(1)').find('.user-list').append('<li class="pull-sm-left approved"></li>')
					$activePhase.parent().children('div:eq(1)').find('.user-list li:last').append(newImage);
					
					setTimeout(function() {
						if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
						{							
							if($activePhase.find('.phase-date-time-input').val() && $activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
							{
								var btn_num = 0;
								if($activePhase.find('[data-new-phase]').length > 1)
									btn_num = 1;
								toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);
								
								if($activePhase.data('id') == 0)
								{
									toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
								}
							}							
						}
						else
						{
							var btn_num = 0;
							if($activePhase.find('[data-new-phase]').length > 1)
								btn_num = 1;
							toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);

							if($activePhase.data('id') == 0)
							{
								toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
							}
						}						
					},100);

					btnClicks++;
				}
				else {
					$activePhase.find('img[data-id="' + buttonVal + '"]').parent().remove();
					$activePhase.parent().children('div:eq(1)').find('img[data-id="' + buttonVal + '"]').parent().remove();

					setTimeout(function() {
						if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
						{
							if($activePhase.find('.phase-date-time-input').val() && $activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
							{
								var btn_num = 0;
								if($activePhase.find('[data-new-phase]').length > 1)
									btn_num = 1;
								toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);
								if($activePhase.data('id') == 0)
								{
									toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
								}
							}
						}
						else
						{
							var btn_num = 0;
							if($activePhase.find('[data-new-phase]').length > 1)
								btn_num = 1;
							toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);

							if($activePhase.data('id') == 0)
							{
								toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
							}
						}
					},100);
					// $btn.removeAttr('data-linked-phase');
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
		var btnClicks = 0;
		$('body').on('click', '.radio-button', function() {
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
				$('.radio-button[data-group="' + inputGroup + '"]').addClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', true);
			}
			else if(buttonVal === "check-all" && $btn.hasClass('selected')) {
				$('.radio-button[data-group="' + inputGroup + '"]').removeClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', false);
			}
			if($btn.hasClass('selected')) {
				checked = true;
			}
			else {
				checked = false;
			}
			$('input[value="' + buttonVal + '"]').prop('checked', checked);

			//add selected users to list from popover
			if($btn.closest('#qtip-popover-user-list').length !== 0) {
				var userImg = $btn.closest('li').find('img');
				var checkbox = $btn.parent().children('.approvers');			
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var $activePhase = $('#phaseDetails .approval-phase.active');
				var activePhaseId = $activePhase.attr('id');				
				if($btn.hasClass('selected')) {
					var phase_number = $activePhase.data('id');
					$(checkbox).attr('name','phase['+phase_number+'][approver][]');
					$activePhase.find('.user-list li').prepend(imgDiv);
					$activePhase.find('img[src="' + imgSrc + '"]').parent().prepend(checkbox);					
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

		$('body').on('click', '.select-box', function() {
			var $box = $(this);
			var boxVal = $box.attr('data-value');
			var inputGroup = $box.attr('data-group');

			

			if(boxVal !== "check-all") {
				$box.toggleClass('checked');
		    	
			}
			else if(boxVal === "check-all" && !$box.hasClass('checked')) {
				$('.select-box[data-group="' + inputGroup + '"]').addClass('checked');
				$('.delete-draft').attr('data-toggle','modal');						
			}
			else if(boxVal === "check-all" && $box.hasClass('checked')) {
				$('.select-box[data-group="' + inputGroup + '"]').removeClass('checked');				
				$('.delete-draft').attr('data-toggle','');
			}

			var postsTotDelete = [];
			$.each($(".select-box"),function(a,b){
	    		if($(b).hasClass('checked') && $(b).data('value') != "check-all")
	    		{
	    			postsTotDelete.push($(b).data('value'));
	    		}
	    	});

	    	if(postsTotDelete.length)
	    	{
	    		$('.delete-draft').attr('data-toggle','modal');
	    		toggleBtnClass('btn-disabled','btn-secondary',$('.delete-draft'),false);		    	
	    	}
	    	else
	    	{
	    		$('.delete-draft').attr('data-toggle','');
	    		toggleBtnClass('btn-secondary','btn-disabled',$('.delete-draft'),true);	
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
			
			if($(this).hasClass('post-filter-popup'))
			{
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
			}
			else
			{
				$('#qtip-' + pid).qtip('api').set({
					'content.title': ptitle,
					'content.title': ptitle,
					'events.visible' : function() {
						var classes = $(this).qtip('api').get('style.classes');
						$('.qtip').trigger('qtipShown', [classes]);
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
			if($toggler.hasClass('selected')) {
				$('.qtip').qtip('hide');
			}
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
				$toggler.toggleClass('selected');
			}
		});
		$('.calendar-header a[class*="tf-icon"]').on('click blur', function() {
			$(this).toggleClass('active');
		});
		//hide visible tooltips when body is clicked
		$('body').on('click', function(e) {
			var $target = $(e.target);
			if($target.closest('.popover-clickable').length === 0 && $target.closest('.popover-toggle').length === 0) {
				$('.qtip').qtip('hide');
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
		$('body').on('click','.post_tags',function(){
			$(this).toggleClass('selected');
			var checked = false;
			var numTags = $('.tag-list .selected').length;
			var tag = $(this).find('.fa');
			var tagClass = tag.data('tag');
			if($(this).hasClass('selected')) {
				var newTag = tag.clone();
				newTag.children().attr('checked',true);
				newTag.prependTo('.tag-select');
				checked = true;
			}
			else {
				$('.tag-select').find('.fa').each(function() {
					if($(this).data('tag') === tagClass) {
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
			// $input.attr("checked", checked);			
		});

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
			nextPhase(next,this);
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
				addIncrements();
				$(".content-container").addClass('height-999');
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
		if($(".content-container").hasClass('height-999')){
			$(".content-container").removeClass('height-999');
			console.log('removed');
			equalColumns();
		}		
		$('.modal').modal('hide');
	});

	$(document).on('click','[data-toggle="addPhases"]',function() {		
		if($('.container-approvals').children('.add_phases_num'))
		{			
			$('.container-approvals').children('.add_phases_num').remove();			
		}

		if($('#qtip-popover-user-list'))
		{
			$('#qtip-popover-user-list').remove();
		}

		if($('.add-phases'))
		{
			$('.add-phases').remove();	
		}
		var columnParent = $(this).closest('.col-md-4');
		var div_src = $(this).data('div-src');

		var approvalsContainer = $('.container-approvals');
		// approvalsContainer.empty();
		approvalsContainer.children('.dafault-phase').addClass('hide');
		$.get(base_url+div_src,function(data) {
			approvalsContainer.append(data);
		});
		columnParent.css('z-index', 2000);
		$('#brand-manage').append('<div class="modal-backdrop fade in modal-contain"></div>').wrapInner("<div class='relative-wrapper'></div>");
	});

	$(document).on('click','.cancel-phase',function(){		
		$('.container-approvals').children('div:first').removeClass('hide');		
		$('.container-approvals').children('div:eq(1)').remove();
		$('.container-approvals').children('div:eq(2)').remove();
		$('.modal-backdrop').remove();
		if($(this).hasClass('phase-num'))
		{
			$(this).trigger('click');
		}
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

		if(relatedInput.length > 1)
		{
			var relatedInput = $('input[name="' + inputName + '"]:last');		
		}
		
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

	$(document).on('keyup blur','.approvalNotes',function(){		
		var textarea_text = $(this).parent().parent().parent().children('div:last').find('.approval-note').html($(this).val().replace(/\r?\n/g,'<br/>'));
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
	
		$activePhase = $(input).parent().parent().parent().parent().parent();		

		var preview_phase = $activePhase.parent().children('div:last');

		var minute = $(input).parent().children('input:eq(1)');
		var ampm = $(input).parent().children('input:eq(2)');		
		var phase_num = $activePhase.data('id') + 1;
		$(preview_phase).find('.time-preview'+phase_num).html(newVal+':'+$(minute).val()+' '+$(ampm).val());
		
		if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
		{
			if($activePhase.find('.phase-date-time-input').val() && $activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
			{
				var btn_num = 0;
				if($activePhase.find('[data-new-phase]').length > 1)
					btn_num = 1;

				toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);

				if($activePhase.data('id') == 0)
				{
					toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
				}
			}
			else
			{
				var btn_num = 0;
				if($activePhase.find('[data-new-phase]').length > 1)
					btn_num = 1;
				toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);

				if($activePhase.data('id') == 0)
				{
					toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
				}
			}
		}
		else
		{
			var btn_num = 0;
			if($activePhase.find('[data-new-phase]').length > 1)
				btn_num = 1;
			toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);

			if($activePhase.data('id') == 0)
			{
				toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
			}
		}
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
		
		$activePhase = $(input).parent().parent().parent().parent().parent();

		var preview_phase = $activePhase.parent().children('div:last');

		var minute = $(input).parent().children('input:eq(1)');
		var ampm = $(input).parent().children('input:eq(2)');		
		var phase_num = $activePhase.data('id') + 1;
		$(preview_phase).find('.time-preview'+phase_num).html(newVal+':'+$(minute).val()+' '+$(ampm).val());		
		if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
		{
			if($activePhase.find('.phase-date-time-input').val() && $activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
			{
				var btn_num = 0;
				if($activePhase.find('[data-new-phase]').length > 1)
					btn_num = 1;
				toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);

				if($activePhase.data('id') == 0)
				{
					toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
				}
			}
			else
			{
				var btn_num = 0;
				if($activePhase.find('[data-new-phase]').length > 1)
					btn_num = 1;
				toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);	

				if($activePhase.data('id') == 0)
				{
					toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
				}
			}			
		}
		else
		{
			var btn_num = 0;
			if($activePhase.find('[data-new-phase]').length > 1)
				btn_num = 1;
			toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);	

			if($activePhase.data('id') == 0)
			{
				toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
			}
		}
	}
	function setAmPm(input) {
		($(input).val() === 'am') ? $(input).val('pm') : $(input).val('am');
	}	

	function nextPhase(i,control) {
		$(control).parent().parent().addClass('inactive');
		$(control).parent().parent().removeClass('active');
		var linkedPhase;
		$('.approval-phase').removeClass('active');
		$('#approvalPhase' + i).removeClass('inactive').addClass('active');
		$activePhase = $('#approvalPhase' + i).removeClass('inactive');
		if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
		{
			if($activePhase.find('.phase-date-time-input').val() && $activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
			{
				var btn_num = 0;
				if($activePhase.find('[data-new-phase]').length > 1)
					btn_num = 1;
				toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);
				
				if($activePhase.data('id') == 0)
				{
					toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
				}
			}
		}

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

	$(document).on('click','.save-phases',function(){		
		var child_divs = $('#phaseDetails').children('div');

		$.each(child_divs,function(a,b){
			$(b).children('div:first').addClass('hide');
			if($(b).find('.user-list li').children('div').length > 2 && $(b).find('.phase-date-time-input').val() && $(b).find('.hour-select').val() && $(b).find('.minute-select').val())
			{				
				$(b).children('div:eq(1)').removeClass('hide');
				$(b).children('div:eq(1)').addClass('active');
			}

			if(a == 3)
			{
				$(b).children('div:eq(1)').removeClass('hide');
				$(b).children('div:eq(1)').addClass('active');
			}
		});

		$('.modal-backdrop').remove();
	});

	$(document).on('click','.edit-phase',function(){
		var child_divs = $('#phaseDetails').children('div');
		$.each(child_divs,function(a,b){			
			$(b).children('div:first').removeClass('hide');
			$(b).children('div:first').addClass('inactive');
			$(b).children('div:eq(1)').addClass('hide');
			$(b).children('div:eq(1)').removeClass('active');			
		});
		
		$(this).parent().parent().parent().children('div:first').removeClass('inactive');	
		var $activePhase = $(this).parent().parent().parent().children('div:first');
		
		if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
		{
			if($activePhase.find('.phase-date-time-input').val() && $activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
			{
				var btn_num = 0;
				if($activePhase.find('[data-new-phase]').length > 1)
					btn_num = 1;
				toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);
				
				if($activePhase.data('id') == 0)
				{
					toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
				}
			}
		}
		$activePhase.addClass('active');		
	});

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
		var colsH = $('.equal-cols').outerHeight(true);
		var newColsH = dashboardH - headhH;
		var magicNum = 0;
		//equal column heights v2
		//use this for everything once integration starts
		$('.equal-cols-cal .equal-height').each(function() {
				if(newColsH > colsH) {
					$(this).css('height', dashboardH - headhH - 2);
				}
				else {
					$(this).css('height', colsH);
				}
		});
		$('.equal-cols [class*=col-]').each(function() {
			if($(this).parent().hasClass('brand-steps')) {
				magicNum = 60;
			}
			if(!$(this).hasClass('brand-steps')) {
				if(newColsH > colsH) {
					$(this).css('height', dashboardH - headhH - magicNum);
				}
				else {
					if($(this).parent().hasClass('create'))
					{
						$(this).css('height', 862);
					}
					else
						$(this).css('height', colsH);
				}
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
		$('.equal-cols .equal-height').each(function() {
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
					url: base_url+"posts/get_post_info/"+id,
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
	//live preview		
	function createPreview(){
		$('#live-post-preview').empty();
		$('.no-of-photos').html('');
    	var outlet_id = $('#postOutlet').val();
    	var selected_outlet = $('#postOutlet').attr('data-outlet-const');
    	var post_copy;
    	if($('#postCopy').val())
    		post_copy = $('#postCopy').val().replace(/\r?\n/g,'<br/>')
    	$('#outlet_'+outlet_id+' .post_copy_text').html(post_copy);
    	$('#live-post-preview').append($('#outlet_'+selected_outlet).html());    	
    }

    $(document).on('keyup','#postCopy',function(){
    	var post_copy = $(this).val();
    	post_copy = convertToLink(post_copy);
    	$('#live-post-preview .post_copy_text').html(post_copy.replace(/\r?\n/g,'<br/>'));
    });

    $(document).on("submit", "#reschedule_post", function(event){
	 	event.preventDefault();
    	var post_url = $(this).attr('action');
    	var selected_date = $('#selected_date').val();    	
    	$.ajax({
	    		'type':'POST',
	    		'data':$(this).serialize()+'&selcted_data='+ selected_date,
	    		dataType: 'html',
	    		url: post_url,                 
	            success: function(response)
	            {
	            	if(response  != 'false')
	            	{
	            		alert('Your post has been update successfully. ');
	            	}
	            	$('.calendar-day').empty();
	            	console.log(response);
	            	$('.calendar-day').html(response);
	            }
	    	});
    });


    $(document).on("click", ".delete_post", function(event){
    	event.preventDefault();
    	if(confirm("Are you sure, you want to delete it?"))
        {
        	var post_id = [];
        	post_id.push($(this).data('post-id'));

	    	$.ajax({
	    		'type':'POST',
	    		dataType: 'json',
	    		url: base_url+'posts/delete_post',
	    		data:{'post_ids':post_id},
	            success: function(response)
	            {
	            	location.reload();
	            }
	    	});
	    }    	
    });

    $(document).on("click", "#submitDeleteDrafts", function(event){
    	var postsTotDelete = [];
    	$.each($(".select-box"),function(a,b){
    		if($(b).hasClass('checked') && $(b).data('value') != "check-all")
    		{
    			postsTotDelete.push($(b).data('value'));
    		}
    	});

    	$.ajax({
    		'type':'POST',
    		dataType: 'json',
    		url: base_url+'posts/delete_post',
    		data:{'post_ids':postsTotDelete},
            success: function(response)
            {
            	location.reload();
            }
    	});
    });

    $(document).on('click','.delete-img',function(){
    	$('.'+$(this).data('delete')).remove();
    	$(this).remove();
    });
    
});
	
	function convertToLink(text) {
		var exp = /(\b((https?|ftp|file):\/\/|(www))[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]*)/ig;
		return text.replace(exp,"<a class='anchor_color' href='$1'>$1</a>");
	}

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

	toggleBtnClass = function(oldClass,newClass,btnClass,btnState){
		jQuery(btnClass).attr('disabled',btnState);
		if(!jQuery(btnClass).hasClass(newClass))
		{
			jQuery(btnClass).addClass(newClass);
		}
		jQuery(btnClass).removeClass(oldClass);
	}
	
	
	