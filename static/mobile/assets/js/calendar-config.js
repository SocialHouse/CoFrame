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

		$('#calendarBtnToday').on('click', function(e) {
			e.preventDefault();
			if($('#calendar-week').length) {
				$('#calendar-week').fullCalendar( 'today' );
				$('#calendar-change-week .date-select-calendar').fullCalendar('destroy');
			}
			else if($('#calendar-month').length) {
				$('#calendar-month').fullCalendar( 'today' );
				$('#calendar-change-month .date-select-calendar').fullCalendar('destroy');
			}
			else
			{
				$('#calendar-change-day .date-select-calendar').fullCalendar('destroy');
				var date = new Date().toJSON().slice(0,10);
				var month = moment(date).format('MMM');
				var day = moment(date).format('DD, YYYY');
				$('#calendarCurrentdate').text(day);
				$('#calendarCurrentMonth').text(month);
				findPostbyDate(date);
			}
		});

		//print & export functions
		$('body').on('change', '#startDateType', function() {
			startType = $(this).val();
			var startInput = $('input[name="start-date"]');
			if(startType === "today") {
				startInput.val(mm + '/' + dd + '/' + yyyy);
			}
			else if(startType === "tomorrow") {
				startInput.val(tmm + '/' + tmd + '/' + tmy);
			}
			else {
				startInput.val('');
				startInput.focus();
			}
			calendarType = startType;
		});

		$('body').on('change', '#endDateType', function() {
			endType = $(this).val();
			var endInput = $('input[name="end-date"]');
			if(endType === "today") {
				endInput.val(mm + '/' + dd + '/' + yyyy);
			}
			else if(endType === "tomorrow") {
				endInput.val(tmm + '/' + tmd + '/' + tmy);
			}
			else {
				endInput.val('');
				endInput.focus();
			}
			calendarType = endType;
		});

		//Get popover calendar for date selector
		$('body').on('focus', 'input[data-toggle="popover-calendar"]', function(e) {
			var $target = $(this);
			var tindex = $target.index('input[data-toggle="popover-calendar"]');
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
			//clone the calendar div and give custom id to allow for multiple date selectors on one page
			var calendarClone = $('#' + pid).clone();
			calendarClone.attr('id', pid + tindex);
			inputType = $target.attr('name');
			var inputVal = $target.val();
			if(inputVal === '') {
				startDate = today;
				endDate = '';
			}
			else if(inputVal !== '' && $target.hasClass('single-date-select')) {
				startDate = $.fullCalendar.moment(inputVal, 'MM/D/YYYY');
				endDate = $.fullCalendar.moment(inputVal, 'MM/D/YYYY');
			}
			
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
					text: calendarClone
				},
				events: {
					show: function(e, api) {
						//don't show calendar popup if date is set to today or tomorrow
						if(calendarType === "today" || calendarType === "tomorrow") {
							e.preventDefault();
						}
					},
					visible: function() {
						if(inputType !== undefined) {
							showSelectCalendar(pid + tindex);
						}
					}
				},
				hide: {
					effect: function() {
						$(this).fadeOut();
					},
					event: 'unfocus'
				},
				overwrite:false,
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
				style: {
					classes: 'qtip-shadow popover-calendar ' + pclass,
					tip: {
						corner: arrowcorner,
						mimic: 'center',
						height: tipH,
						width: tipW
					},
					width: pwidth
				}
			}, e);
		});

		//allow click on date select calendar without blurring date input and therefore closing calendar
		$('body').on('mousedown', '.date-select-calendar', function(e) {
			e.preventDefault();
		});

		//update date ranges on input blur
		$('body').on('blur', 'input[name="start-date"], input[name="end-date"]', function() {
			var inputVal = $(this).val();
			if(inputVal !== "") {
				if($(this).attr('name') === 'start-date') {
					startDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
					if(endDate === undefined || startDate > endDate) {
						endDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
						$('input[name="end-date"]').val(endDate.format('M/DD/YYYY'));
					}
				}
				if($(this).attr('name') === 'end-date') {
					endDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
					if(startDate === undefined || endDate < startDate) {
						startDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
						$('input[name="end-date"]').val(startDate.format('M/DD/YYYY'));
					}
				}
			}
		});

		
		//Get popover calendar for date selector
		$('body').on('click', 'a[data-toggle="popover-calendar"]', function(e) {
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
					text: $('#' + pid)
				},
				events: {
					visible: function() {
						changeDateCalendar(pid);
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
					ready: true
				},
				style: {
					classes: 'qtip-shadow ' + pclass,
					tip: {
						corner: arrowcorner,
						mimic: 'center',
						height: tipH,
						width: tipW
					},
					width: pwidth
				}
			}, e);
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

		$('body').on('click', '#calendar-change-month .btn-cancel', function() {
			var curView = $('#calendar-month').fullCalendar('getView');
			var curMonthStart = $.fullCalendar.moment(curView.intervalStart).format('YYYY-MM-DD');
			var selectedView =  $('#calendar-change-month .date-select-calendar').fullCalendar('getView');
			var selectedStart = $.fullCalendar.moment(selectedView.intervalStart).format('YYYY-MM-DD');
			if(selectedStart !== curMonthStart) {
				//navigate to current date range
				$('#calendar-change-month .date-select-calendar').fullCalendar('gotoDate', curMonthStart);
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
					color: '#f4d3d5'
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
						color: '#ffff'
					};
					$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', eventData, true);
					daySelectedDate = date.format();
					
				}
				$('#getPostsByDate').removeClass('btn-disabled').removeAttr('disabled');
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