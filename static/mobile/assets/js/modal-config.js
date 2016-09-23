jQuery(function($) {
	$(document).ready(function() {
		$('body').on('shown.bs.modal', '#calendarSelectModal', function() {
			changeDateCalendar('calendar-change-day');
		});
		$('body').on('shown.bs.modal', '#calendarSelectWeekModal', function() {
			changeDateCalendar('calendar-change-week');
		});

		//Get modal content from an external source
		$('body').on('click', '[data-toggle="modal-ajax"]', function(e) {
			e.preventDefault();
			var newModal = $('#emptyModal').clone();
			var $target = $(this);
			var mid = $target.data('modalId');
			var mtitle = $target.data('title');
			var mclass = $target.data('class');
			$.get($target.data('modalSrc'), function(data) {
				newModal.attr('id', mid);
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
				});
	
				if ($target.data('clear') == 'no') {
					$target.attr('data-toggle', 'modal-ajax-inline');
				}
			});
		});

	});
});
