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
		
		$('#post-details .outlet-list li').on('click', function() {
			var outlet = $(this).data('selectedOutlet');
			$(this).toggleClass('disabled');
			$(this).siblings().addClass('disabled');
			$('#postOutlet').val(outlet);
		});

		//equal column heights
		var dashboardH = $('.page-main').height();
		var headhH = $('.page-main-header').innerHeight();
		var colsH = $('.equal-cols').innerHeight();
		var newColsH = dashboardH - headhH;
		var magicNum = 0;
		$('.equal-cols [class*=col-]').each(function() {
			if($(this).parent().hasClass('brand-steps')) {
				magicNum = 60;
			}
			if(!$(this).hasClass('brand-steps')) {
				if(newColsH > colsH) {
					$(this).css('height', dashboardH - headhH - 2 - magicNum);
				}
				else {
					$(this).css('height', colsH);
				}
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
					}
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
			if(!pwidth) {
				pwidth = 280;
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
					effect:function() {
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
			});
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
			var show = $(this).data('show');
			var hide = $(this).data('hide');
			$(hide).slideUp(function() {
				$(show).slideDown();
			});
		});
	});

	//modal triggers
	//Get modal content from an external source
	$('[data-toggle="modal-ajax"]').one('click', function() {
		var newModal = $('#emptyModal').clone();
		var target=$(this);
		var mid = target.data('modalId');
		var msize = target.data('modalSize');
		$.get(target.data('modalSrc'),function(data) {
			newModal.attr('id', mid);
			if(msize !== "") {
				newModal.find('.modal-dialog').addClass('modal-' + msize);
			}
			newModal.find('.modal-body').html(data);
			newModal.modal('show');
		});
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