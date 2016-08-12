jQuery(function($) {
	$(document).ready(function() {
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
				overwrite: false,
				position: {
					my: 'top center',
					at: 'bottom center',
					container: $('.page-main'),
					target: $target,
					viewport: $('.page-main')
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
					},
					visible: function() {
						var modal = this;
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
	});
});
