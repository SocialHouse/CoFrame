jQuery(function($) {
	$(document).ready(function() {
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

		//append modal content to the body to prevent zindex issues
		$('body').on('click', '[data-toggle="modal"]', function(e) {
			var appendTo = $(this).data('append');
			if(appendTo.length) {
				var modalDiv = $(this).data('target');
				$(modalDiv).appendTo(appendTo);
			}
		});

		$('.modal').on('show.bs.modal', function() {
			$('.modal-toggler').fadeIn();
		});
	
		$('.modal').on('hide.bs.modal', function() {
			$('.modal-toggler').fadeOut();
		});
	
		$('.modal-toggler').on('click', function() {
	
			if ($('#edit-post-modal').length) {
				setTimeout(function() {
					$('#edit-post-modal').remove();
				}, 500);
				allFiles = [];
				equalColumns();
			}

			if($("#edit-request-modal").length){
				setTimeout(function() {
					$("#edit-request-modal").remove();
				}, 500);
				equalColumns();
			}

			$('#qtip-popover-post-menu-content').show();
			$('.modal').modal('hide');
		});
	});
});
