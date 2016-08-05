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
			color: '#f4d3d5',
			rendering: 'background',
			dayClick: function(date) {
				$('.calendar-summary #calendar').fullCalendar('removeEvents');
				var eventData = {
					allDay: true,
					start: $.fullCalendar.moment(date),					
					rendering: 'background',
					color: '#f4d3d5'
				};
				$('.calendar-summary #calendar').fullCalendar('renderEvent', eventData, true);
				$("#selected_date").val($.fullCalendar.moment(date).format('YYYY-MM-DD'));
				var date_on_cal = $.fullCalendar.moment(date).format('YYYY-MM-DD');
			
				$.ajax({
					url:base_url+'brands/get_summary',
					type:'POST',
					data:{brand_id:$('#brand_id').val(),slug:$('#brand_slug').val(),selected_date:$("#selected_date").val()},
					dataType:'JSON',
					success:function(response)
					{
						if(response)
						{
							$('.summary-posts').html(response.html);
						}
					}
				});
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
		                outlets:$('#outlet_ids').val(),
			            statuses:$('#statuses').val(),
			            tags:$('#tags').val(),
		                view_type:'week'
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
		                tags:$('#tags').val(),
		                view_type:'month'
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

		$('body').on('click', '#calendar-change-day #getPostsByDate', function() {
			var date = moment(daySelectedDate);
			selectedmonth = moment(daySelectedDate).format('MMM');
			selectedday = moment(daySelectedDate).format('DD, YYYY');
			$('#calendarCurrentdate').text(selectedday);
			$('#calendarCurrentMonth').text(selectedmonth);
			if($(this).hasClass('approval-date-filter'))
			{
				findApprovalsbyDate(daySelectedDate);
			}
			else
			{
				findPostbyDate(daySelectedDate);
			}
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

	window.eventDropModal = function eventDropModal(event, revertFunc, calendar) {
		var newModal = $('#emptyModal').clone();
		selected_date = moment(event.start._d).format('YYYY-MM-DD H:mm');
		var today = moment().format("YYYY-MM-DD H:mm");		

		newModal.attr('id', '');
		newModal.addClass('alert-modal modal-reschedule-post');
		newModal.find('.modal-dialog').addClass('form-inline').css('width', 380);
		$.get(base_url+'calendar/reschedule',function(data) {
			newModal.find('.modal-body').html('<h2 class="text-xs-center">Reschedule Post</h2><h3 class="text-xs-center">' + event.title + '<h3>' + data);
			var newMonth = $.fullCalendar.moment(event.start).format('MM');
			var newDay = $.fullCalendar.moment(event.start).format('DD');
			var newYear = $.fullCalendar.moment(event.start).format('YYYY');
			if(!moment(selected_date).isAfter(today)){
				var newHour = moment(today).add(1, 'hours').format('hh');				
				var newMin = moment().format("mm");
				var newAmPm = moment().format("a");
			}else{
				var newHour = $.fullCalendar.moment(event.start).format('hh');
				var newMin = $.fullCalendar.moment(event.start).format('mm');
				var newAmPm = $.fullCalendar.moment(event.start).format('a');
			}
			
			//set the form values
			newModal.find('input[name="post_date"]').val(newMonth + '/' + newDay + '/' + newYear);
			newModal.find('input[name="post_hour"]').val(newHour);
			newModal.find('input[name="post_minute"]').val(newMin);
			newModal.find('input[name="post_ampm"]').val(newAmPm);
			newModal.find('input[name="post_id"]').val(event.id);
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

		$('body').on('submit', '#reschedule_date', function(ev) {
			ev.preventDefault();
			var newDate = newModal.find('input[name="post_date"]').val();
			var newHour = newModal.find('input[name="post_hour"]').val();
			var newMin = newModal.find('input[name="post_minute"]').val();
			var newAmPm = newModal.find('input[name="post_ampm"]').val();
			var postId = newModal.find('input[name="post_id"]').val();			
		 	
		 	var message, error_div, error_display = false;
		 	var today = moment().format("YYYY-MM-DD");
		 	var selected_date;
		 	var today = moment().format("YYYY-MM-DD H:mm");			
			error_div = $('#reschedule_error');
			error_div.text(message);
			error_div.hide();
			if(newDate != ''){
				// conveted in spefic dete format
				selected_date = newDate+' '+newHour+':'+newMin+' '+newAmPm;
				newDate = moment(new Date (newDate)).format('YYYY-MM-DD');
				selected_date = moment(new Date (selected_date)).format('YYYY-MM-DD H:mm');
				if(moment(selected_date).isAfter(today)){
					error_display = false;
				}else{
					error_display = true;
					message=language_message.enter_hour_minutes;
				}
			}else{
				error_display = true;
				message=language_message.select_re_date;
			}
			if(!error_display){
				var postDate = newDate + " " + newHour + ":" + newMin + " " + newAmPm;
				$.ajax({
					url:base_url+'calendar/save_reschedule',
					type:'post',
					data:{
						post_date:newDate,
						post_hour:newHour,
						post_minute:newMin,
						post_ampm:newAmPm,
						post_id:postId
					},
					success:function(response){
						postDate = moment(selected_date).format('MM/D/YYYY h:mm a');
						event.start = $.fullCalendar.moment(postDate, 'MM/D/YYYY h:mm a');
						$(calendar).fullCalendar('updateEvent', event);
						newModal.modal('hide');
						newModal.on('hidden.bs.modal', function () {
							newModal.remove();
						});
					}
				});	
			}else{
				error_div.text(message);
				error_div.show();
				return false;
			}
				
		});

		$(document).on('click','.save-reschedule',function(){
			$('#reschedule_date').find('input[name="post-date"]')
			$('#reschedule_date').find('input[name="post-hour"]]')
			$('#reschedule_date').find('input[name="post-date"]')
			$('#reschedule_date').find('input[name="post-date"]')
			$('#reschedule_date').find('input[name="post-date"]')
		});
	};

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
		// $('#calendar-change-day #getPostsByDate').trigger('click');
	}

	$(document).on("change, keyup, blur", "#edit_minute, #edit_ampm, #edit_hour, #reschedule_day", function(event){
		event.preventDefault();	

		var error_display = false;
		$error_div = $('#reschedule_error');
		$('#reschedule_error').hide();
		$('#reschedule_error').empty();

		edit_date = $('#reschedule_day').val();
		edit_hour = $('#edit_hour').val();
		edit_minute = $('#edit_minute').val();
		edit_ampm = $('#edit_ampm').val();

		if(edit_date != '' && edit_hour != '' && edit_minute != '' && edit_ampm != ''){
			var selected_date = edit_date+' '+edit_hour+':'+edit_minute+' '+edit_ampm;
			var today = moment().format("YYYY-MM-DD H:mm");

			selected_date = moment(new Date (selected_date)).format('YYYY-MM-DD H:mm');

			if(moment(selected_date).isAfter(today)){
				error_display = false;
			}else{
				message = 'please select valid date and time';
				error_display = true;
			}
		}else{
			message = 'please select date, hour and time';
			error_display = true;
		}

		if(error_display){
			$error_div.val(message);
			$error_div.show();
			toggleBtnClass($('.overlay-footer button[type="submit"]'),true);
		}else{
			
			$error_div.val('');
			$error_div.hide();
			toggleBtnClass($('.overlay-footer button[type="submit"]'),false);
		}

	});


	$(document).on("submit", "#reschedule_post", function(event){
		event.preventDefault();
		var post_url = $(this).attr('action');
		var selected_date = $('#selected_date').val();        
		$.ajax({
		      'type':'POST',
		      'data':$(this).serialize()+'&selcted_data='+ selected_date,
		      dataType: 'html',
		      url: post_url,                 
		      success: function(response)
		      {
		          if(response  != 'false')
		          {
		              alert('Your post has been update successfully. ');
		          }
		          $('.calendar-day').empty();
		          console.log(response);
		          $('.calendar-day').html(response);
		      }
	    });
	});

	$(document).on("click", ".duplicate-post", function(event){
		event.preventDefault();
		var sltDate ;
		var post_id = $(this).data('post-id');
		if (typeof daySelectedDate === "undefined") {
			sltDate = moment().format('YYYY-MM-DD');
		}else{
			sltDate = daySelectedDate;
		}
		if(post_id){
			$.ajax({
				type:'GET',
				dataType:'JSON',
				url:base_url+'drafts/duplicate_post_ajax/'+post_id,
				success:function(response){
					alert(response.message);
					if(response.status)
					{
						findPostbyDate(daySelectedDate);
					}
				}
			});
		}
	});
});