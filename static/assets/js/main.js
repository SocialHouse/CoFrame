jQuery(function($) {

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

		$('.show-brands-toggler').on('click', function(e) {
			e.preventDefault();
		});
		
		$('#post-details .outlet-list li').on('click', function() {
			var outlet = $(this).attr('data-selected-outlet');
			$(this).toggleClass('disabled');
			$(this).siblings().addClass('disabled');
			$('#postOutlet').val(outlet);
		});

		//equal column heights
		var dashboardH = $('#brand-manage').height();
		var headhH = $('.page-main-header').innerHeight();
		var colsH = $('.equal-cols').innerHeight();
		var newColsH = dashboardH - headhH - 2;
		$('.equal-cols [class*=col-]').each(function() {
			if(newColsH > colsH) {
				$(this).css('height', dashboardH - headhH - 2);
			}
			else {
				$(this).css('height', colsH);
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
			$btn.toggleClass('selected');
			if(buttonVal === "check-all") {
				var inputGroup = $(this).attr('data-group');
				$('.radio-button[data-group="' + inputGroup + '"]').addClass('selected');
				$('input[name="' + inputGroup + '"]').prop('checked', true);
			}
			if($btn.hasClass('selected')) {
				checked = true;
				btnClicks++;
			}
			else {
				checked = false;
				btnClicks--;
			}
			$('input[value="' + buttonVal + '"]').prop('checked', checked);

			//add selected users to list from popover
			if($btn.closest('#popover-user-list').length !== 0) {
				var userImg = $(this).closest('li').find('img');
				var imgSrc = userImg.attr('src');
				var imgDiv = userImg.parent().clone();
				var $activePhase = $('#phaseDetails .approval-phase.active');
				var activePhaseId = $activePhase.attr('id');
				console.log(activePhaseId);
				$btn.attr('data-linked-phase', activePhaseId);
				if($(this).hasClass('selected')) {
					$activePhase.find('.user-list li').prepend(imgDiv);
				}
				else {
					$activePhase.find('img[src="' + imgSrc + '"]').parent().remove();
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
		$('[data-toggle="popover"]').popover({
			container: 'body',
			html: true,
			trigger: 'focus'
		});
		//Get popover content from an external source
		$('body').on('click', '[data-toggle="popover-ajax"]', function() {
			var target=$(this);
			var pclass = target.data('popoverClass');
			var pid = target.data('popoverId');
			var pattachment = target.data('attachment');
			var ptattachment = target.data('targetAttachment');
			var poffset = target.data('offset');
			var ptitle = target.data('title');
			var parrow = target.data('popoverArrow');
			$.get(target.data('contentSrc'),function(data) {
				var popoverDiv = $(document.createElement('div'));
				var popoverContent = $(document.createElement('div'));
				var popoverTitle, popoverArrow;
				if(ptitle.length) {
					popoverTitle = '<h5>' + ptitle + '</h5>';
				}
				else {
					popoverTitle = "";
				}
				if(parrow) {
					popoverArrow = '<div class="popover-arrow"></div>';
				}
				else {
					popoverArrow = '';
				}
				if(ptattachment.indexOf('left') > -1) {
					pclass += ' popover-left';
				}
				popoverContent.addClass('popover-content').html(popoverArrow + popoverTitle + data);
				popoverDiv.addClass('popover-inline popover ' + pclass).attr('id', pid).html(popoverContent).insertAfter(target);
				ajaxTether = new Tether({
					element: '#' + pid,
					target: target,
					attachment: pattachment,
					targetAttachment: ptattachment,
					targetOffset: poffset,
					constraints: [
						{
							to: 'window',
							attachment: 'together'
						}
					]
				});
				ajaxTether.enable();
				ajaxTether.position();
				popoverDiv.animate({'opacity': 1});
				//alter toggle attribute so that ajax call is not made again
				target.removeAttr('data-toggle');
				target.removeAttr('data-content-src');
			});
		});
		//Get popover content from an inline div
		$('body').on('click', '[data-toggle="popover-inline"]', function() {
			ajaxTether.position();
			var target=$(this);
			var pid = target.data('contentSrc');
			var pattachment = target.data('attachment');
			var ptattachment = target.data('targetAttachment');
			var poffset = target.data('offset');
			var ptitle = target.data('title');
			$(pid).find('h5').html(ptitle);
			inlineTether = new Tether({
				element: pid,
				target: target,
				attachment: pattachment,
				targetAttachment: ptattachment,
				targetOffset: poffset,
				constraints: [
					{
						to: 'window',
						attachment: 'together'
					}
				]
			});
			inlineTether.enable();
			$(pid).fadeToggle(function() {
				inlineTether.position();
			});
		});

		$('body').on('click', '.popover-toggle', function() {
			$(this).toggleClass('selected');
			if($(this).data('popoverId')) {
				var popover = $(this).data('popoverId');
				$('#' + popover).fadeToggle();
			}
		});

		$('body').on('click', function(e) {
			var $target = $(e.target);
			if($target.closest('.popover-clickable').length === 0 && $target.closest('.popover-toggle').length === 0) {
				$('.popover-clickable').fadeOut();
				$('.popover-toggle').removeClass('selected');
			}
		});

		$('body').on('click', '.tag-list .tag', function() {
			var checked = false;
			$(this).toggleClass('selected');
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
			var buttonVal = $(this).attr('data-value');
			$('input[value="' + buttonVal + '"]').prop('checked', checked);
		});

		$('body').on('click', '.btn-change-phase', function() {
			var next = $(this).data('newPhase');
			nextPhase(next);
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
		$('.approval-phase').removeClass('active');
		$('#approvalPhase' + i).removeClass('inactive').addClass('active');
		var $selected = $('#popover-user-list').find('.selected');
		$selected.each(function() {
			var linkedPhase = $(this).data('linkedPhase');
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