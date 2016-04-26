// JavaScript Document

jQuery(function($) {
	$(document).ready(function() {
		//Get popover content from an external source
		$('body').on('click', '[data-toggle="popover-reorder-brands"]', function(e) {
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
						once: true,
						success: function(data) {
							this.set('content.text', data);
							$( ".reorder-brand-list" ).sortable({
								axis: "y",
								update: function() {
									//reorder brands
									$('#brand-sort').fadeOut(function() {
										$( ".reorder-brand-list li" ).each(function(i) {
											var brand = $(this).data('brand');
											var $twin = $('#brand-sort').find('.brand-overview[data-brand="' + brand + '"]');
											$twin.attr('data-list-order', i);
											var previous = i - 1;
											if(i === '0') {
												$('#brand-sort').prepend($twin);
											}
											else {
												$twin.insertAfter('.brand-overview[data-list-order="' + previous + '"]');
											}
										});
										$('#brand-sort').fadeIn();
									});
								}
							});
							$( ".reorder-brand-list" ).disableSelection();
						}
					}
				},
				events: {
					show: function() {
						$target.attr('data-toggle', 'popover-inline');
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
	});
});
