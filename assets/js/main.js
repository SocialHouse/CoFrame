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
		$('.outlet_ul li:first').toggleClass('disabled');
		$('.outlet_ul li:first').siblings().addClass('disabled');
		$('#postOutlet').val(outlet_id);		
		createPreview();

		equalColumns();
		
		$('#post-details .outlet-list li').on('click', function() {
			var previous_outlet = $('#postOutlet').val();
			var outlet = $(this).data('selectedOutlet');
			if(previous_outlet != outlet)
			{
				$(this).toggleClass('disabled');
				$(this).siblings().addClass('disabled');
				$('#postOutlet').val(outlet);

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
			if($btn.closest('#qtip-popover-user-list').length !== 0) {
				var userImg = $btn.closest('li').find('img');
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var $activePhase = $('#phaseDetails .approval-phase.active');
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
				event: 'unfocus'
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
					ready: true
				},
				hide: {
					effect: function() {
						$(this).fadeOut();
					},
					event: 'unfocus'
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
			if(!pcontainer) {
				pcontainer = '.page-main';
			}
			var tipW = 1;
			var tipH = 1;
			if(parrow) {
				tipW = 20;
				tipH = 10;
			}
			$('#qtip-' + pid).qtip('api').set({
				'content.title': ptitle,
				'hide.effect': function() {
					$(this).fadeOut();
				},
				'hide.event': 'unfocus',
				'position.adjust.x': poffsetX,
				'position.adjust.y': poffsetY,
				'position.at': ptattachment,
				'position.my': pattachment,
				'position.container': $(pcontainer),
				'position.target': $target,
				'overwrite': false,
				'show.effect': function() { $(this).fadeIn(); },
				'show.event': e.type,
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
				hide: {
					effect: function() {
						$(this).fadeOut();
					},
					event: 'unfocus'
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
					ready: true
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

		$('body').on('click', '.popover-toggle', function(e) {
			e.preventDefault();
			var $toggler = $(this);
			//remove focus from the button
			$toggler.blur();
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
		// $('body').on('click', '.btn-next-step', function() {
		// 	var next = $(this).data('nextStep');
		// 	nextStep(next);
		// });

		$('body').on('click', '.show-hide', function(e) {
			e.preventDefault();
			var show = $(this).data('show');
			var hide = $(this).data('hide');
			$(hide).slideUp(function() {
				//call custom function on completion
				$(hide).trigger('contentSlidUp');
				$(show).slideDown(function(){
					$(show).trigger('contentSlidDown');
				});
			});
		});		
	});

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
		var div_src = $(this).data('div-src');

		var approvalsContainer = $('.container-approvals');
		approvalsContainer.empty();
		$.get(base_url+div_src,function(data) {
			approvalsContainer.append(data);
		});
		columnParent.css('z-index', 2000);
		$('#brand-manage').append('<div class="modal-backdrop fade in modal-contain"></div>').wrapInner("<div class='relative-wrapper'></div>");
	});

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

	// function nextStep(i) {
	// 	$('.brand-step').removeClass('active').addClass('inactive');
	// 	$('#brandStep' + i).removeClass('inactive').addClass('active');
	// }

	window.equalColumns = function equalColumns() {
		var dashboardH = $('.page-main').outerHeight();
		var headhH = $('.page-main-header').outerHeight(true);
		var colsH = $('.equal-cols').outerHeight(true);
		console.log(colsH);
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
					colsH = 723;
					$(this).css('height', colsH);
				}
			}
		});
	};
	window.qtipEqualColumns = function qtipEqualColumns() {
		var colsH = $('.equal-cols').outerHeight(true);
		$('.equal-cols .equal-height').each(function() {
			$(this).css('height', colsH);
		});
	}

	//live preview		
	function createPreview(){
		$('#live-post-preview').empty();
		$('.no-of-photos').html('');
    	var outlet_id = $('#postOutlet').val();
    	var post_copy;
    	if($('#postCopy').val())
    		post_copy = $('#postCopy').val().replace(/\r?\n/g,'<br/>')
    	$('#outlet_'+outlet_id+' .post_copy_text').html(post_copy);
    	$('#live-post-preview').append($('#outlet_'+outlet_id).html());    	
    }

    $(document).on('keyup','#postCopy',function(){
    	var post_copy = $(this).val();
    	$('#live-post-preview .post_copy_text').html(post_copy.replace(/\r?\n/g,'<br/>'));
    });

    //save outlet to brand
    $(document).on('click','#save_outlet',function(){
    	var control = this;
    	var brand_id = $('#brand_id').val();
    	var elements = $('.outlets');

    	var outlet_ids = [];
    	$.each(elements,function(i,value){    		
    		outlet_ids.push($(value).val());
    	});    	

    	$.ajax({
    		url: base_url+'brands/save_outlet',
    		data: {'brand_id': brand_id,'outlets': outlet_ids},
    		type:'POST',
    		dataType: 'json',
    		success: function( data ){
    			
    			if(data.response == 'success')
    			{
    				console.log(data.response);
    				$(control).parents().children('.btn-next-step').trigger('click');
    			}
    		}
    	});
    });

    //save tags
     $(document).on('click','.submit_tag',function(){     
    	var control = this;
    	var brand_id = $('#brand_id').val();
    	var selected_labels = $('.labels');

    	var tags = [];
    	$('input[name="selected_tags[]"]:checked').each(function(i) {
		   console.log(this.value);
		   tags[i] = this.value;
		});

    	var labels = []
    	$.each(selected_labels,function(i,value){    		
    		labels[i] = $(value).val();
    	});
    	

    	$.ajax({
    		url: base_url+'brands/save_tags',
    		data: {'brand_id': brand_id,'tags': tags,'labels':labels},
    		type:'POST',
    		dataType: 'json',
    		success: function( data ){
    			
    			if(data.response == 'success')
    			{    				
    				window.location.href = base_url+'brands/success/'+data.brand_id;
    			}
    		}
    	});
    });

    $('#firstName').keyup(function(){
    	$('.user-name-role').html($(this).val()+' '+$('#lastName').val());
    });

    $('#lastName').keyup(function(){
    	$('.user-name-role').html($('#firstName').val().toUpperCase()+' '+$(this).val().toUpperCase());
    });

    $('#userRoleSelect').change(function(){
    	if($(this).val())
    	{
    		$('.addUserToBrand').prop('disabled',false);
    	}
    	else
    	{
    		$('.addUserToBrand').prop('disabled',true);
    	}
    });

    $('.skip_step').click(function(){
    	var brand_id = $('#brand_id').val();
    	if(brand_id)
    	{
    		window.location.href = base_url+'brands/success/'+brand_id;
    	}
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

	function showContent(obj) {
		obj.fadeIn();
	}
	function hideContent(obj) {
		obj.fadeOut();
	}

	