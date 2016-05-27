jQuery(function($) {
	// init Isotope
	var $container = $('.calendar-day').isotope({
		itemSelector: '.post-day'
	});

	$('body').on('click', '.filter', function() {
		var $filter = $(this);
		var filterVal = $filter.attr('data-value');
		var inputGroup = $filter.attr('data-group');
		var $selectedFilters = $('#selectedFilters');
		var $filterItem, filterContent, filterClass;
		if(inputGroup === "post-status") {
			filterContent = $(this).find('label').text();
		}
		else {
			filterContent = $(this).html();
		}
		if(inputGroup === "post-outlet") {
			filterClass = ' outlet-list';
		}
		else {
			filterClass = '';
		}
		if(filterVal !== "check-all") {
			$filterItem =  $(document.createElement('li'));
			$filterItem.attr('data-value', filterVal).addClass('filter-remove' + filterClass).append(filterContent + "<i class='tf-icon-close'></i>");
			$filter.toggleClass('checked');
			if(inputGroup === "post-outlet") {
				$filter.toggleClass('disabled');
			}
			if($filter.hasClass('checked')) {
				$selectedFilters.find('.filter-list').append($filterItem);
			}
			else {
				$selectedFilters.find('.filter-remove[data-value="' + filterVal + '"]').remove();
			}
		}
		else if(filterVal === "check-all" && !$filter.hasClass('checked')) {
			$('.filter[data-group="' + inputGroup + '"]').addClass('checked');
			if(inputGroup === "post-outlet") {
				$('.filter[data-group="' + inputGroup + '"]').removeClass('disabled');
				filterClass = ' outlet-list';
			}
			$('.filter[data-group="' + inputGroup + '"]').not($filter).each(function() {
				$filterItem =  $(document.createElement('li'));
				filterContent = $(this).html();
				filterVal = $(this).attr('data-value');
				$filterItem.attr('data-value', filterVal).addClass('filter-remove' + filterClass).append(filterContent + "<i class='tf-icon-close'></i>");
				$selectedFilters.find('.filter-list').append($filterItem);
			});
		}
		else if(filterVal === "check-all" && $filter.hasClass('checked')) {
			$('.filter[data-group="' + inputGroup + '"]').removeClass('checked');
			if(inputGroup === "post-outlet") {
				$('.filter[data-group="' + inputGroup + '"]').not($filter).addClass('disabled');
			}
			$('.filter[data-group="' + inputGroup + '"]').each(function() {
				filterVal = $(this).attr('data-value');
				$selectedFilters.find('.filter-remove[data-value="' + filterVal + '"]').remove();
			});
		}
		
		filterPosts();
	});	
	
	$('body').on('click', '.reset-filter', function() {
		$('.filter').each( function() {
			var $filter = $(this);
			var inputGroup = $filter.attr('data-group');
			$filter.removeClass('checked');
			if(inputGroup === "post-outlet") {
				$filter.not('[data-value="check-all"]').addClass('disabled');
			}
			
		});
		$('#selectedFilters ul').empty();
		filterPosts();
	});
	
	$('#selectedFilters').on('click', '.filter-remove', function() {
		var filterVal = $(this).data('value');
		$('.post-filters').find('.filter[data-value="' + filterVal + '"]').click();
	});

	function filterPosts() {
		// map input values to an array
		var inclusives = [];
		var outlet_ids = [];
		var statuses = [];
		// inclusive filters from checkboxes
		$('.filter').each( function() {
			//use value if checked
			if ( $(this).hasClass('checked' )) {
				inclusives.push( $(this).data('value') );
				if($(this).data('id'))
					outlet_ids.push( $(this).data('id') );

				if($(this).data('status'))
					statuses.push( $(this).data('status') );
			}
			else {
				var index = inclusives.indexOf($(this).data('value'));
				if( index > -1) {
					inclusives.splice(index, 1);
					outlet_ids.splice(index, 1);
					statuses.splice(index, 1);
				}
			}
		});	

		// combine inclusive filters
		var filterValue = inclusives.length ? inclusives.join(', ') : '*';
		$('#outlet_ids').val(outlet_ids.join());
		$('#statuses').val(statuses.join());

		$container.isotope({ filter: filterValue });
		if(inclusives.length) {
			$('#selectedFilters').slideDown(function() {
				equalColumns();
			});
		}
		else {
			$('#selectedFilters').slideUp(function() {
				equalColumns();
			});
		}

		renderCalender();
	}

	function renderCalender()
	{
		var date = new Date();
		var first = date.getDate() - date.getDay(); // First day is the day of the month - the day of the week
		var last = first + 6; // last day is the first day + 6

		var firstDay = new Date(date.setDate(first));
		var dd = firstDay.getDate();
		var mm = firstDay.getMonth() + 1;
		var y = firstDay.getFullYear();
		var start = y+'-'+mm+'-'+dd;

		var lastDay = new Date(date.setDate(last));
		var dd = lastDay.getDate();
		var mm = lastDay.getMonth() + 1;
		var y = lastDay.getFullYear();
		var end = y+'-'+mm+'-'+dd;
		var calender_class = '#calendar-week'
		if($('#calender_type').val() == 'month')
		{
			var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
			var dd = firstDay.getDate();
			var mm = firstDay.getMonth() + 1;
			var y = firstDay.getFullYear();
			var start = y+'-'+mm+'-'+dd;

			var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
			lastDay.setDate(lastDay.getDate() + 5);	
			var dd = lastDay.getDate();
			var mm = lastDay.getMonth() + 1;
			var y = lastDay.getFullYear();
			var end = y+'-'+mm+'-'+dd;
			var calender_class = '#calendar-month';
		}		

		$(calender_class).fullCalendar ('removeEvents');

		$source = {
			        url: base_url+'calender/get_events',
			        dataType: 'json',
			        data: {			          
			            start: start,
			            end: end,
			            brand_id:$('#brand_id').val(),
			            outlets:$('#outlet_ids').val(),
			            statuses:$('#statuses').val(),
			        }
		        };

		$(calender_class).fullCalendar('addEventSource', $source);

		
	}
});