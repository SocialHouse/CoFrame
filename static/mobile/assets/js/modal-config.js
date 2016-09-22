jQuery(function($) {
	$(document).ready(function() {
		$('body').on('shown.bs.modal', '#calendarSelectModal', function() {
			changeDateCalendar('calendar-change-day')
		});
	});
});
