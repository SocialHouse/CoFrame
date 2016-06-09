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
	daySelectedDate;

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
			defaultView: 'basicWeek',
			dragOpacity: 1,
			editable: true,
			eventAfterAllRender: function() {
				$("#calendar-week .fc-title").dotdotdot();
			},
			eventClick: function(calEvent, jsEvent) {
				showPostPopover($(this), calEvent.id, jsEvent, 'week-post')
			},
			eventConstraint: {
				start: moment().format('YYYY-MM-DD'),
				end: '2200-01-01'
			},
			eventDragStart: function() {
				$('.fc-event').css('opacity', '.2');
			},
			eventDragStop: function() {
				$('.fc-event').css('opacity', '1');
			},
			eventDrop: function(event, delta, revertFunc) {
				//show confirmation modal
				eventDropModal(event, revertFunc, '#calendar-week');
			},
			// events: 'assets/js/events.json',
			events: function(start, end, timezone, callback) {				
		        $.ajax({
		            url: base_url+'calendar/get_events',
		            dataType: 'json',
		            method:'POST',
		            data: {
		                // our hypothetical feed requires UNIX timestamps
		                start: start.format('YYYY-MM-DD'),
		                end: end.format('YYYY-MM-DD'),
		                brand_id:$('#brand_id').val(),
		                tags:$('#tags').val()
		            },
		            success: function(doc) {
		            	callback(doc);
		            }
		        });
		    },
			header: false,
			timeFormat: 'h:mm a',
			viewRender: function() {

				var month = GetCalendarMonth('#calendar-week');
				var year = GetCalendarYear('#calendar-week');
				var dates = GetCalendarDateRange();
				$('#calendarCurrentYear').text(year);
				$('#calendarDateRange').html(dates);
				$('#calendarCurrentMonth').text(month);
				//$('#calendarCurrentYear').text(month);
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
			eventDrop: function(event, delta, revertFunc) {
				//show confirmation modal
				eventDropModal(event, revertFunc, '#calendar-month');
			},
			// events: base_url+'calendar/get_events/'+$('#brand_id').val(),
			events: function(start, end, timezone, callback) {				
		        $.ajax({
		            url: base_url+'calendar/get_events',
		            dataType: 'json',
		            method:'POST',
		            data: {
		                // our hypothetical feed requires UNIX timestamps
		                start: start.format('YYYY-MM-DD'),
		                end: end.format('YYYY-MM-DD'),
		                brand_id:$('#brand_id').val(),
		                tags:$('#tags').val()
		            },
		            success: function(doc) {
		            	callback(doc);
		            }
		        });
		    },
			eventLimit: true,
			fixedWeekCount: false,
			header: false,
			snapDuration: '00:15:00',
			viewRender: function() {
				var dates = GetCalendarMonth('#calendar-month');
				var year = GetCalendarYear('#calendar-month');
				$('#calendarCurrentYear').text(year);
				$('#calendarCurrentMonth').html(dates);
			}
		});

		$('#calendar-archive-1').fullCalendar({
			aspectRatio: '.92',
			buttonText: {
				prev: '',
				prevYear: '',
				next: '',
				nextYear: ''
			},
			contentHeight: 'auto',
			dayClick: function(date) {
				var exportStart, exportEnd;
				//remove previously set dates
				startDate = date;
				if(endDate === undefined || startDate > endDate ) {
					endDate = date;
				}
				exportStart = $.fullCalendar.moment(startDate).format('M/D/YYYY');
				exportEnd = $.fullCalendar.moment(endDate).format('M/D/YYYY');
				$('input[name="start-date"]').val(exportStart);
				$('input[name="end-date"]').val(exportEnd);
				$('input[value="daterange"]').prop('checked', true);
				var eventData = {
					allDay: true,
					start: $.fullCalendar.moment(startDate),
					end: $.fullCalendar.moment(endDate).add(1, 'days'), //end returns one day prior for highlighting, so adding one day.
					rendering: 'background',
					color: '#f4d3d5'
				};
				$('#calendar-archive-1, #calendar-archive-2').fullCalendar('removeEvents');
				$('#calendar-archive-1, #calendar-archive-2').fullCalendar('renderEvent', eventData, true);
			},
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			fixedWeekCount: false,
			header: {
				left: 'prevYear prev',
				center: 'title',
				right: 'next nextYear'
			},
			theme: true,
			themeButtonIcons: false,
			viewRender: function(view) {
				equalColumns();
			}
		});
		$('#calendar-archive-2').fullCalendar({
			aspectRatio: '.92',
			buttonText: {
				prev: '',
				prevYear: '',
				next: '',
				nextYear: ''
			},
			contentHeight: 'auto',
			dayClick: function(date) {
				var exportStart, exportEnd;
				//remove previously set dates
				//$('#calendar-archive-1, #calendar-archive-2').fullCalendar('removeEvents');
				endDate = date;
				if(startDate === undefined || endDate < startDate ) {
					startDate = date;
				}
				exportStart = $.fullCalendar.moment(startDate).format('M/D/YYYY');
				exportEnd = $.fullCalendar.moment(endDate).format('M/D/YYYY');
				$('input[name="start-date"]').val(exportStart);
				$('input[name="end-date"]').val(exportEnd);
				$('input[value="daterange"]').prop('checked', true);
				var eventData = {
					allDay: true,
					start: $.fullCalendar.moment(startDate),
					end: $.fullCalendar.moment(endDate).add(1, 'days'), //end returns one day prior for highlighting, so adding one day.
					rendering: 'background',
					color: '#f4d3d5'
				};
				$('#calendar-archive-1, #calendar-archive-2').fullCalendar('removeEvents');
				$('#calendar-archive-1, #calendar-archive-2').fullCalendar('renderEvent', eventData, true);
			},
			dayNamesShort: [
				'S', 'M', 'T', 'W', 'T', 'F', 'S'
			],
			fixedWeekCount: false,
			header: {
				left: 'prevYear prev',
				center: 'title',
				right: 'next nextYear'
			},
			theme: true,
			themeButtonIcons: false,
			viewRender: function(view) {
				equalColumns();
			}
		});
		//set second calendar one month ahead
		$('#calendar-archive-2').fullCalendar('gotoDate', $.fullCalendar.moment(nextMonth, 'M/DD/YYYY'));

		//Get popover calendar for date selector
		$('body').on('click focus', 'input[data-toggle="popover-calendar"]', function(e) {			
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
			//clone the calendar div to allow for multiple date selectors on one page
			var calendarClone = $('#' + pid).clone();
			calendarClone.attr('id', pid + '-clone');
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
							showSelectCalendar(pid + '-clone');
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
		//update single date calendar on input blur
		// $('body').on('blur', '.single-date-select', function() {
		// 	var inputVal = $(this).val();
		// 	if(inputVal !== "") {
		// 		startDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
		// 		endDate = $.fullCalendar.moment(inputVal, 'M/DD/YYYY');
		// 		$activePhase = $(this).parent().parent().parent().parent();					
		// 		setTimeout(function() {

		// 			var phase_num = $activePhase.data('id') + 1;
		// 			// console.log(phase_num)
		// 			// console.log($('.date-preview'+phase_num));
		// 			// console.log(startDate.format('M/DD/YYYY'));
		// 			$('.date-preview'+phase_num).html(startDate.format('M/DD/YYYY')+' at')
		// 			if($activePhase.find('.approver-selected').children('li').children('div').length > 2)
		// 			{						
		// 				if($activePhase.find('.hour-select').val() && $activePhase.find('.minute-select').val())
		// 				{
		// 					var btn_num = 0;
		// 					if($activePhase.find('[data-new-phase]').length > 1)
		// 						btn_num = 1;
		// 					toggleBtnClass('btn-disabled','btn-secondary',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),false);

		// 					if($activePhase.data('id') == 0)
		// 					{
		// 						toggleBtnClass('btn-disabled','btn-secondary',$('.save-phases'),false);
		// 					}
		// 				}
		// 			}
		// 			else
		// 			{

		// 				if($activePhase.find('[data-new-phase]').length > 1)
		// 					btn_num = 1;
		// 				toggleBtnClass('btn-secondary','btn-disabled',$activePhase.find('[data-new-phase]:eq('+btn_num+')'),true);	

		// 				if($activePhase.data('id') == 0)
		// 				{
		// 					toggleBtnClass('btn-secondary','btn-disabled',$('.save-phases'),true);
		// 				}
		// 			}
		// 		},100);
		// 	}
		// });

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

		$('body').on('click', '#calendar-change-day #getPostsByDate', function() {
			// $('#calendarCurrentdate').text(daySelectedDate);
			// $('#calendarCurrentMonth').text(daySelectedDate);
			var date = moment(daySelectedDate);
			selectedmonth = moment(daySelectedDate).format('MMM');
			selectedday = moment(daySelectedDate).format('DD \, YYYY');
			$('#calendarCurrentdate').text(selectedday);
			$('#calendarCurrentMonth').text(selectedmonth);
			findPostbyDate(daySelectedDate)
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

	window.eventDropModal = function eventDropModal(event, revertFunc, calendar) {
		var newModal = $('#emptyModal').clone();
		newModal.attr('id', '');
		newModal.addClass('alert-modal modal-reschedule-post');
		newModal.find('.modal-dialog').addClass('form-inline').css('width', 380);
		$.get('lib/calendar-edit-date.php',function(data) {
			newModal.find('.modal-body').html('<h2 class="text-xs-center">Reschedule Post</h2><h3 class="text-xs-center">' + event.title + '<h3>' + data);
			var newMonth = $.fullCalendar.moment(event.start).format('MM');
			var newDay = $.fullCalendar.moment(event.start).format('D');
			var newYear = $.fullCalendar.moment(event.start).format('YYYY');
			var newHour = $.fullCalendar.moment(event.start).format('h');
			var newMin = $.fullCalendar.moment(event.start).format('mm');
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
			newModal.on('shown.bs.modal', function () {
				addIncrements();
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
			$(calendar).fullCalendar('updateEvent', event);
			//insert ajax call to update database here
			//run line below on ajax success
			//$(calendar).fullCalendar( 'refetchEvents' );
			newModal.modal('hide');
			newModal.on('hidden.bs.modal', function () {
				newModal.remove();
			});
		});
	};

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
				if($('#calendar-archive-1').length) {
					$('input[value="daterange"]').prop('checked', true);
					$('#calendar-archive-1, #calendar-archive-2').fullCalendar('removeEvents');			
					$('#calendar-archive-1, #calendar-archive-2').fullCalendar('renderEvent', eventData, true);
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
			end = "<strong>" + endMonth + "</strong> " + end;
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
						color: '#f4d3d5'
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
	};


	window.findPostbyDate = function findPostbyDate(date) {
		$.ajax({
	            url: base_url+'calendar/get_post_by_date',
	            dataType: 'html',
	            method:'POST',
	            data: {
	                // our hypothetical feed requires UNIX timestamps
	                sdate: date,
	                brand_id:$('#brand_id').val(),
	            },
	            success: function(doc) {
	            	$('.calendar-day').empty();
	            	$('.calendar-day').html(doc);	            	
	            }
	        });
	};

});