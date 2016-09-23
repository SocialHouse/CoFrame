var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
var tmd = tomorrow.getDate();
var tmm = tomorrow.getMonth()+1;
var tmy = tomorrow.getFullYear();
var nextMonth = today.getMonth()+2 + "/" + "1/" + yyyy;
var calendarType,
	endDate,
	endType,
	inputType,
	startDate,
	startType,
	firstEventDay,
	daySelectedDate,
	selected_day;

jQuery(function($) {
	$(document).ready(function() {

		//allow click on date select calendar without blurring date input and therefore closing calendar
		$('body').on('mousedown', '.date-select-calendar', function(e) {
			e.preventDefault();
		});

		if(selected_day)
		{
			findPostbyDate(selected_day);
		}

		$('body').on('click', '#calendar-change-week #getPostsByDate', function() {
			$('#calendar-week').fullCalendar('gotoDate', $.fullCalendar.moment(firstEventDay));
		});
		$('body').on('click', '#calendar-change-month #getPostsByDate', function() {
			$('#calendar-month').fullCalendar('gotoDate', $.fullCalendar.moment(firstEventDay));
		});

		$('body').on('click', '#calendar-change-week .btn-cancel', function() {
			var curView = $('#calendar-week').fullCalendar('getView');
			var curWeekStart = $.fullCalendar.moment(curView.intervalStart).format('YYYY-MM-DD');
			var selectedWeek =  $('#calendar-change-week .date-select-calendar').find('.selected-week');
			var selectedStart = selectedWeek.find('td:first').data('date');
			if(selectedStart !== curWeekStart) {
				//remove week highlight
				selectedWeek.removeClass('selected-week');
				//navigate to current date range
				$('#calendar-change-week .date-select-calendar').fullCalendar('gotoDate', curWeekStart);
				//rehighlight current date range
				$('#calendar-change-week .date-select-calendar .fc-bg td.fc-day').each(function() {
					if($(this).data('date') === curWeekStart) {
						$(this).closest('.fc-row').addClass('selected-week');
					}
				});
			}
		});

	});

	window.showSelectCalendar = function showSelectCalendar(id) {
		var exportStart, exportEnd;

		$('#' + id + ' .date-select-calendar').fullCalendar({
			buttonText: {
				prev: '',
				prevYear: '',
				next: '',
				nextYear: ''
			},
			contentHeight: 280,
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			eventOverlap: false,
			fixedWeekCount: false,
			header: {
				left: 'prevYear prev',
				center: 'title',
				right: 'next nextYear'
			},
			dayClick: function(date) {
				//for date range

				if(inputType === 'start-date' || inputType === 'end-date') {
					//remove previously set dates
					$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
					if(inputType === 'start-date') {
						startDate = date;
						if(endDate === undefined || startDate > endDate ) {
							endDate = date;
						}
					}
					else if(inputType === 'end-date') {
						endDate = date;
						if(startDate === undefined || endDate < startDate) {
							startDate = date;
						}
					}
					exportStart = $.fullCalendar.moment(startDate).format('M/D/YYYY');
					exportEnd = $.fullCalendar.moment(endDate).format('M/D/YYYY');
					$('input[name="start-date"]').val(exportStart);
					$('input[name="end-date"]').val(exportEnd);
				}
				//regular single date select
				else {
					//don't allow dates earlier than today
					var today = $.fullCalendar.moment().format('YYYYMMDD');
					var selected = $.fullCalendar.moment(date).format('YYYYMMDD');
					
					if(selected < today) {
						return;
					}
					if(startDate !== undefined) {
						//remove previously set start date
						$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
					}
					startDate = date;
					endDate = date;
					
					$('input[name="' + inputType + '"]').val($.fullCalendar.moment(date).format('M/D/YYYY'));
				}
				
				var eventData = {
					allDay: true,
					start: $.fullCalendar.moment(startDate),
					end: $.fullCalendar.moment(endDate).add(1, 'days'), //end returns one day prior for highlighting, so adding one day.
					rendering: 'background',
					color: '#c71f2a'
				};
				
				daySelectedDate = $.fullCalendar.moment(startDate);
				if($('input[value="daterange"]').length) {
					$('input[value="daterange"]').prop('checked', true);
				}

				$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', eventData, true);
			},
			theme: true,
			themeButtonIcons: false,
			viewRender: function() {
				$('.qtip').qtip('reposition');
			}
		});
		//render previously selected dates on display
		if(endDate === undefined || endDate === "") {
			endDate = today;
		}
		if(startDate !== undefined && endDate !== undefined) {

			var savedEvent = {
				allDay: true,
				start: $.fullCalendar.moment(startDate, 'M/D/YYYY'),
				end: $.fullCalendar.moment(endDate, 'M/D/YYYY').add(1, 'days'), //end returns one day prior for highlighting, so adding one day.
				rendering: 'background',
				color: '#f4d3d5'
			};
			$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
			$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', savedEvent , true);
			if(inputType !== 'end-date') {
				$('#' + id + ' .date-select-calendar').fullCalendar('gotoDate', startDate);
			}
			else {
				$('#' + id + ' .date-select-calendar').fullCalendar('gotoDate', endDate);
			}
		}
	};

	window.GetCalendarDateRange = function GetCalendarDateRange() {
		var calendar = $('#calendar-week').fullCalendar('getCalendar');
		var view = calendar.view;
		var startMonth = $.fullCalendar.moment(view.start).format('MMMM');
		var start = $.fullCalendar.moment(view.start).format('D');
		var endMonth = $.fullCalendar.moment(view.end).subtract(1, 'days').format('MMMM');
		var end = $.fullCalendar.moment(view.end).subtract(1, 'days').format('D');
		if(startMonth !== endMonth) {
			end = endMonth + " " + end;
		}
		var dates = start + "&#8211;" + end;
		return dates;
	};
	
	window.GetCalendarMonth = function GetCalendarMonth(calType) {
		var calendar = $(calType).fullCalendar('getCalendar');
		var view = calendar.view;
		var start = $.fullCalendar.moment(view.intervalStart).format('MMMM');
		return start;
	};

	window.GetCalendarYear = function GetCalendarYear(calType) {
		var calendar = $(calType).fullCalendar('getCalendar');
		var view = calendar.view;
		var start = $.fullCalendar.moment(view.intervalStart).format('YYYY');
		return start;
	};
	
	window.changeDateCalendar = function changeDateCalendar(id) {
		$('#' + id + ' .date-select-calendar').fullCalendar({
			buttonText: {
				prev: '',
				next: ''
			},
			contentHeight: 280,
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			fixedWeekCount: false,
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			dayClick: function(date) {
				$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
				if(id === "calendar-change-week") {
					var $week = $(this).closest('.fc-week');
					$week.addClass('selected-week');
					$week.siblings().removeClass('selected-week');
					firstEventDay = $week.find('td:first-child').data('date');
				}
				else if(id === "calendar-change-day") {
					var eventData = {
						allDay: true,
						start: $.fullCalendar.moment(date),
						end: $.fullCalendar.moment(date).add(1, 'days'), //end was returning one day prior for highlighting, so adding one day.
						rendering: 'background',
						color: '#c71f2a'
					};
					$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', eventData, true);
					daySelectedDate = date.format();
					
				}
				$('#getPostsByDate').removeClass('btn-disabled').removeAttr('disabled');
				//set selected day color to white
				if(id === "calendar-change-day") {
					$('.fc-day-number[data-date='+date.format()+']').css('color', '#fff');
					$('.fc-day-number[data-date!='+date.format()+']').css('color', '');
				}
			},
			theme: true,
			themeButtonIcons: false,
			viewRender: function(view) {
				if(id === "calendar-change-month") {
					var curMonthView = $('#calendar-month').fullCalendar('getView');
					var curMonth = $.fullCalendar.moment(curMonthView.intervalStart).format('M');
					var selectMonth = $.fullCalendar.moment(view.intervalStart).format('M');
					if(curMonth !== selectMonth) {
						firstEventDay = view.intervalStart;
						$('#getPostsByDate').removeClass('btn-disabled').removeAttr('disabled');
					}
				}
			}
		});

		if(selected_day)
		{
			$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
			var eventData = {
				allDay: true,
				start: $.fullCalendar.moment(selected_day),
				end: $.fullCalendar.moment(selected_day).add(1, 'days'), //end was returning one day prior for highlighting, so adding one day.
				rendering: 'background',
				color: '#f4d3d5'
			};
			$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', eventData, true);
			selected_day = '';
		}
	};

	if(selected_day)
	{
		var date = moment(selected_day);
		selectedmonth = moment(selected_day).format('MMM');
		selectedday = moment(selected_day).format('DD, YYYY');
		$('#calendarCurrentdate').text(selectedday);
		$('#calendarCurrentMonth').text(selectedmonth);
	}

});