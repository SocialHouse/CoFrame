jQuery(function($) {
	$(document).ready(function() {
		$('body').on('shown.bs.modal', '#calendarSelectModal', function() {
			showSelectCalendar('calendar-select-date');
		});
	});
});
