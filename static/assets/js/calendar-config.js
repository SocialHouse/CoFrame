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
	startType;

jQuery(function($) {
	$(document).ready(function() {
		$('#calendarBtnToday').on('click', function(e) {
			e.preventDefault();
			$('#calendar-week, #calendar-month').fullCalendar( 'today' );
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
			eventDragStart: function() {
				$('.fc-event').css('opacity', '.2');
			},
			eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
				//show confirmation modal
				var newModal = $('#emptyModal').clone();
				newModal.attr('id', '');
				newModal.addClass('alert-modal');
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
				var dates = GetCalendarDateRange();
				$('#calendarDateRange').html(dates);
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
			buttonText: {
				prev: '',
				next: ''
			},
			dayNamesShort: [
				'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'
			],
			editable: true,
			events: 'assets/js/events.json',
			eventLimit: 4,
			fixedWeekCount: false,
			header: false,
			snapDuration: '00:15:00',
			theme: true,
			themeButtonIcons: false
		});

		//Get popover calendar
		$('body').on('click, focus', '[data-toggle="popover-calendar"]', function(e) {
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
						showSelectCalendar(pid);
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
			gotoDate: '2016 11 22',
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
});