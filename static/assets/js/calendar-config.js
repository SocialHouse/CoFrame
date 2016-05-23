var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
var tmd = tomorrow.getDate();
var tmm = tomorrow.getMonth()+1;
var tmy = tomorrow.getFullYear();
var calendarType,
	endDate,
	endType,
	inputType,
	startDate,
	startType,
	firstEventDay;

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

		$('.calendar-summary #calendar').fullCalendar({
			aspectRatio: '.92',
			buttonText: {
				prev: '',
				next: ''
			},
			contentHeight: 'auto',
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			fixedWeekCount: false,
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			theme: true,
			themeButtonIcons: false
    	});

		//weekly calendar
		$('#calendar-week').fullCalendar({
			allDaySlot: false,
			columnFormat: 'ddd D',
			defaultTimedEventDuration: '00:01:00', //events are 1 minute long, no end time needed
			defaultView: 'agendaWeek',
			dragOpacity: 1,
			editable: true,
			eventClick: function(calEvent, jsEvent) {
				showPostPopover($(this), calEvent.id, jsEvent, 'week-post')
			},
			eventDragStart: function() {
				$('.fc-event').css('opacity', '.2');
			},
			eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
				//show confirmation modal
				var newModal = $('#emptyModal').clone();
				newModal.attr('id', '');
				newModal.addClass('alert-modal modal-reschedule-post');
				newModal.find('.modal-dialog').addClass('modal-sm');
				var confirmationButtons = '<footer class="post-content-footer"><a href="#" class="btn btn-sm btn-default" id="cancelEventChange">Cancel</a><a href="#" class="btn btn-sm  btn-default pull-sm-right" id="confirmEventChange">Confirm</a></footer>';
				newModal.find('.modal-body').html('<h2 class="text-xs-center">Reschedule Event?</h2><p class="text-xs-center">You are about to reschedule the post of "' + event.title + '" to ' + event.start.format('MMMM D, YYYY h:mm a') + '</p>' + confirmationButtons);
				newModal.modal({
					show: true,
					backdrop: 'static'
				});
				$('body').on('click', '#cancelEventChange', function(e) {
					e.preventDefault();
					revertFunc();
					newModal.modal('hide');
					newModal.on('hidden.bs.modal', function () {
						newModal.remove();
					});
				});
				$('body').on('click', '#confirmEventChange', function(e) {
					e.preventDefault();
					newModal.modal('hide');
					newModal.on('hidden.bs.modal', function () {
						newModal.remove();
					});
				});
			},
			events: 'assets/js/events.json',
			header: false,
			slotLabelFormat : 'h:mm a',
			snapDuration: '00:15:00',
			viewRender: function() {
				var month = GetCalendarMonth('#calendar-week');
				var dates = GetCalendarDateRange();
				$('#calendarDateRange').html(dates);
				$('#calendarCurrentMonth').text(month);
				$('.fc-day-header').each(function() {
					var dateText = $(this).text();
					var todayDate = $.fullCalendar.moment().format('YYYY-MM-DD');
					var headerDate = $(this).data('date');
					if(headerDate === todayDate) {
						$(this).html('<div class="fc-today-highlight">' + dateText + '</div>');
						$(this).addClass('fc-today-header');
					}
				});
			}
		});

		//Monthly calendar
		$('#calendar-month').fullCalendar({
			dayNamesShort: [
				'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'
			],
			editable: true,
			eventAfterAllRender: function() {
				var $moreEvents = $('#calendar-month').find('.fc-more');
				$moreEvents.each(function(i) {
					var moreText = $(this).text();
					var newText = moreText.replace('+', '');
					$(this).html('<span class="bg-outlet bg-all"><i>+</i></span>' + newText);
				});
			},
			eventClick: function(calEvent, jsEvent) {
				showPostPopover($(this), calEvent.id, jsEvent, 'month-post')
			},
			eventConstraint: {
				start: moment().format('YYYY-MM-DD'),
				end: '2200-01-01'
			},
			eventDragStart: function(event) {
				$('.fc-event').css('opacity', '.2');
			},
			eventDragStop: function() {
				$('.fc-event').css('opacity', '1');
			},
			eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
				//show confirmation modal
				var newModal = $('#emptyModal').clone();
				newModal.attr('id', '');
				newModal.addClass('alert-modal modal-reschedule-post');
				newModal.find('.modal-dialog').addClass('form-inline').css('width', 380);
				$.get('lib/calendar-edit-date.php',function(data) {
					newModal.find('.modal-body').html('<h2 class="text-xs-center">Reschedule Post</h2><h3 class="text-xs-center">' + event.title + '<h3>' + data);
					var newMonth = $.fullCalendar.moment(event.start).format('MM');
					var newDay = $.fullCalendar.moment(event.start).format('D');
					var newYear = $.fullCalendar.moment(event.start).format('YYYY');
					var newTime = $.fullCalendar.moment(event.start).format('h:mm');
					var newAmPm = $.fullCalendar.moment(event.start).format('a');
					//set the form values
					newModal.find('select[name="postMonth"]').val(newMonth);
					newModal.find('select[name="postDay"]').val(newDay);
					newModal.find('select[name="postYear"]').val(newYear);
					newModal.find('input[name="postTime"]').val(newTime);
					newModal.find('select[name="postAmPm"]').val(newAmPm);
					newModal.modal({
						show: true,
						backdrop: 'static'
					});
				});
				$('body').on('click', '.qtip-hide', function(e) {
					e.preventDefault();
					revertFunc();
					newModal.modal('hide');
					newModal.on('hidden.bs.modal', function () {
						newModal.remove();
					});
				});
				$('body').on('click', '.modal-reschedule-post button[type="submit"]', function(e) {
					e.preventDefault();
					var postMonth = newModal.find('select[name="postMonth"]').val();
					var postDay = newModal.find('select[name="postDay"]').val();
					var postYear = newModal.find('select[name="postYear"]').val();
					var postTime = newModal.find('input[name="postTime"]').val();
					var postAmPm = newModal.find('select[name="postAmPm"]').val();
					var postDate = postYear + "-" + postMonth + "-" + postDay + " " + postTime + " " + postAmPm;
					event.start = $.fullCalendar.moment(postDate, 'YYYY-M-D h:mm a');
					$('#calendar-month').fullCalendar('updateEvent', event);
					newModal.modal('hide');
					newModal.on('hidden.bs.modal', function () {
						newModal.remove();
					});
				});
			},
			events: 'assets/js/events.json',
			eventLimit: true,
			fixedWeekCount: false,
			header: false,
			snapDuration: '00:15:00',
			viewRender: function() {
				var dates = GetCalendarMonth('#calendar-month');
				$('#calendarCurrentMonth').html(dates);
			}
		});

		//Get popover calendar for date selector
		$('body').on('click, focus', 'input[data-toggle="popover-calendar"]', function(e) {
			//don't fire calendar popover if date is today or tomorrow
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
			inputType = $(this).attr('name');
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
					show: function(e, api) {
						//don't show calendar popup if date is today or tomorrow
						if(calendarType === "today" || calendarType === "tomorrow") {
							e.preventDefault();
						}
					},
					visible: function() {
						if(inputType !== undefined) {
							showSelectCalendar(pid);
						}
					}
				},
				hide: {
					effect: function() {
						$(this).fadeOut();
					},
					event: 'unfocus'
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

		//Get popover calendar for date selector
		$('body').on('click', 'a[data-toggle="popover-calendar"]', function(e) {
			//don't fire calendar popover if date is today or tomorrow
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
					event: 'unfocus'
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

		$('body').on('click', '#calendar-change-day #getPostsByDate', function() {
			//insert functionality to filter by post date here
		});
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
				next: ''
			},
			contentHeight: 280,
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			eventOverlap: false,
			fixedWeekCount: false,
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			dayClick: function(date) {
				if(inputType === 'start-date') {
					if(startDate !== undefined) {
						//remove previously set start date
						$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
					}
					startDate = date;
					if(endDate === undefined || endDate < startDate) {
						endDate = date;
					}
				}
				else if(inputType === 'end-date') {
					if(endDate !== undefined) {
						//remove previously set end date
						$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
					}
					endDate = date;
					if(startDate === undefined || startDate > endDate) {
						startDate = date;
					}
				}
				var eventData = {
					allDay: true,
					start: $.fullCalendar.moment(startDate),
					end: $.fullCalendar.moment(endDate).add(1, 'days'), //end was returning one day prior for highlighting, so adding one day.
					rendering: 'background',
					color: '#f4d3d5'
				};
				$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', eventData, true);
				exportStart = $.fullCalendar.moment(startDate).format('M/D/YYYY');
				exportEnd = $.fullCalendar.moment(endDate).format('M/D/YYYY');
				$('input[name="end-date"]').val(exportEnd);
				$('input[name="start-date"]').val(exportStart);
			},
			theme: true,
			themeButtonIcons: false
		});
		//render events saved from other calendars
		if(startDate !== undefined && endDate !== undefined) {
			//remove previously set events and redraw
			$('#' + id + ' .date-select-calendar').fullCalendar('removeEvents');
			var savedEvent = {
				allDay: true,
				start: startDate,
				end: $.fullCalendar.moment(endDate).add(1, 'days'), //end was returning one day prior for highlighting, so adding one day
				rendering: 'background',
				color: '#f4d3d5'
			};
			$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', savedEvent, true);
		}
	};

	window.GetCalendarDateRange = function GetCalendarDateRange() {
		var calendar = $('#calendar-week').fullCalendar('getCalendar');
		var view = calendar.view;
		var start = $.fullCalendar.moment(view.start).format('D');
		var end = $.fullCalendar.moment(view.end).subtract(1, 'days').format('D');
		var dates = start + "&#8211;" + end;
		return dates;
	};
	window.GetCalendarMonth = function GetCalendarMonth(calType) {
		var calendar = $(calType).fullCalendar('getCalendar');
		var view = calendar.view;
		var start = $.fullCalendar.moment(view.intervalStart).format('MMMM');
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
						color: '#f4d3d5'
					};
					$('#' + id + ' .date-select-calendar').fullCalendar('renderEvent', eventData, true);
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
	};

});