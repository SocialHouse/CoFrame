jQuery(function($) {
	$(document).ready(function() {
		$('body').on('shown.bs.modal', '#calendarSelectModal', function() {
			changeDateCalendar('calendar-change-day');
		});
		$('body').on('shown.bs.modal', '#calendarSelectWeekModal', function() {
			changeDateCalendar('calendar-change-week');
		});
	});
});
