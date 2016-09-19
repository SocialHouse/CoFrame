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
	
				if ($target.data('clear') == 'no') {
					$target.attr('data-toggle', 'modal-ajax-inline');
				}
				if ($('#qtip-popover-post-menu')) {
					$('#qtip-popover-post-menu').hide();
				}
			});
		});

		$('body').on('hidden.bs.modal', '#edit-post-modal', function() {
			$(this).remove();
			allFiles = [];
			equalColumns();
		});
		$('body').on('hidden.bs.modal', '#edit-request-modal', function() {
			$(this).remove();
			equalColumns();
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
				equalColumns('#' + mid);
				addIncrements();
			});
			if ($('#qtip-popover-post-menu')) {
				$('#qtip-popover-post-menu').hide();
			}
		});

		//append modal content to the body to prevent zindex issues
		$('body').on('click', '[data-toggle="modal"]', function(e) {
			e.preventDefault();
			var appendTo = $(this).data('append');
			if(appendTo) {
				var modalDiv = $(this).data('target');
				$(modalDiv).appendTo(appendTo);
			}
		});
	
		$('body').on('click', '.modal-toggler', function() {
			$('.modal').modal('hide');
		});
	});
});
