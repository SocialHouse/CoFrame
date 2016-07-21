jQuery(function($) {
	// init Isotope
	var $container = $('.calendar-day').isotope({
		itemSelector: '.post-day'
	});

	var $containerApp = $('.calendar-app').isotope({
		itemSelector: '.post-approver'
	});

	setTimeout(function() {		
		$containerApp.find('tr').attr('style','');
		$filter_btn = $(document).find('[data-toggle="popover-ajax"]')[1];
		$filter_btn.click();
	},200);

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
				$('.filter-list').children('li[data-value="' + filterVal + '"]').remove();
				// $selectedFilters.find('.filter-remove[data-value="' + filterVal + '"]').remove();
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

	$(document).on('click','.save-filter',function(){
		var inclusives = [];
		var outlet_ids = [];
		var statuses = [];
		var tags = [];
		var filter_id;
		if($('#filter_id').val())
			filter_id = $('#filter_id').val();

		$('.filter').each( function() {
			inclusives.push( '[data-filters*="' + $(this).data('value') + '"]' );
			//use value if checked
			if ( $(this).hasClass('checked' )) {				
				if($(this).data('id'))
					outlet_ids.push( $(this).data('id') );
				if($(this).data('status'))
					statuses.push( $(this).data('status') );

				if($(this).data('tag-id'))
				{
					tags.push($(this).data('tag-id'));
				}

			}
			else {				
				var index = inclusives.indexOf($(this).data('value'));
				if( index > -1) {
					inclusives.splice(index, 1);
					outlet_ids.splice(index, 1);
					statuses.splice(index, 1);
					tags.splice(index, 1);
				}
			}
		});

		$.ajax({
			url:base_url+'calendar/save_filters',
			type:'POST',
			data:{tags:tags,outlets:outlet_ids,statuses:statuses,brand_id:$('#filter_brand_id').val(),filter_id:filter_id},
			success:function(response){

			}
		});
	});

	$('#selectedFilters').on('click', '.filter-remove-list', function() {
		var filterVal = $(this).data('value');
		$('.post-filters').find('.filter[data-value="' + filterVal + '"]').click();
		$(this).fadeOut();
		$(this).remove();
		applyFilter();
	});

	if($('#filter-id').val())
	{
		$('#selectedFilters').slideDown();
		if(!$('#calendar_type').val() || $('#calendar_type').val() == 'day')			

		setTimeout(function(){
			jQuery('#show-filter-overlay').trigger('click');
			setTimeout(function(){
				$('.qtip-hide').trigger('click');
				applyFilter();
			},150);
		},50);
	}

	function applyFilter()
	{
		// map input values to an array
		setTimeout(function(){
			var inclusives = [];
			var outlet_ids = [];
			var statuses = [];
			var tags = [];

			$.each($('.filter-list').children('li'),function(index,li){
				console.log(li);
				inclusives.push( '[data-filters*="' + $(this).data('value') + '"]' );

				if($(this).data('id'))
					outlet_ids.push( $(this).data('id') );

				if($(this).data('status'))
					statuses.push( $(this).data('status') );

				if($(this).data('tag-id'))
					tags.push($(this).data('color')+'__'+$(this).data('value'));
			});

			// combine inclusive filters
			var filterValue = inclusives.length ? inclusives.join(', ') : '*';
			$('#outlet_ids').val(outlet_ids.join());
			$('#statuses').val(statuses.join());
			$('#tags').val(tags.join());
			if($container.length)
				$container.isotope({ filter: filterValue });
			if($containerApp.length)
			{
				$containerApp.isotope({ filter: filterValue });
			}


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
			setTimeout(function(){
				rendercalendar();
			},1000);
			// rendercalendar();
		},400);
	}

	function filterPosts() {
		// map input values to an array
		var inclusives = [];
		var outlet_ids = [];
		var statuses = [];
		var tags = [];
		// inclusive filters from checkboxes
		$('.filter').each( function() {
			//use value if checked
			if ( $(this).hasClass('checked' )) {

				inclusives.push( '[data-filters*="' + $(this).data('value') + '"]' );				
				
				if($(this).data('id'))
					outlet_ids.push( $(this).data('id') );

				if($(this).data('status'))
					statuses.push( $(this).data('status') );

				if($(this).data('tag-id'))
					tags.push($(this).data('color')+'__'+$(this).data('value'));

			}
			else {
				var index = inclusives.indexOf($(this).data('value'));
				if( index > -1) {
					inclusives.splice(index, 1);
					outlet_ids.splice(index, 1);
					statuses.splice(index, 1);
					tags.splice(index, 1);
				}
			}
		});	

		// combine inclusive filters
		var filterValue = inclusives.length ? inclusives.join(', ') : '*';		
		$('#outlet_ids').val(outlet_ids.join());
		$('#statuses').val(statuses.join());
		$('#tags').val(tags.join());

		if($container.length)
			$container.isotope({ filter: filterValue });
		if($containerApp.length)
		{
			$containerApp.isotope({ filter: filterValue });
		}


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

		rendercalendar();
	}

	function rendercalendar()
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
		var calendar_class = '#calendar-week'
		if($('#calendar_type').val() == 'month')
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
			var calendar_class = '#calendar-month';
		}		

		$(calendar_class).fullCalendar ('removeEvents');

		$source = {
			        url: base_url+'calendar/get_events',
			        dataType: 'json',
			        method:'post',
			        data: {			          
			            start: start,
			            end: end,
			            brand_id:$('#brand_id').val(),
			            outlets:$('#outlet_ids').val(),
			            statuses:$('#statuses').val(),
			            tags:$('#tags').val(),
		                view_type:$('#calendar_type').val()
			        }
		        };
		$(calendar_class).fullCalendar('addEventSource', $source);

		
	}

	window.findApprovalsbyDate = function findApprovalsbyDate(date) {
		$.ajax({
            url: base_url+'approvals/get_approvals_by_date',
            dataType: 'html',
            method:'POST',
            data: {
                date: date,
                brand_id: $('#brand-id').val()
            },
            success: function(doc) {
            	if(doc)
            	{
	            	var $items = $(doc);
	            	$('.calendar-app').empty();
	            	$('.calendar-app').append( $items ).isotope( 'addItems', $items );
	            	setTimeout(function() {		
						$containerApp.find('tr').attr('style','');
						$containerApp.attr('style','');						
					},200);
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
	            	var $items = $(doc);	            	
	            	$('.calendar-day').empty();
	            	$('.calendar-day').append( $items ).isotope( 'addItems', $items );
	            	setTimeout(function() {		
						$container.find('.post-day').attr('style','');						
					},200);
					applyFilter();
	            }
	        });
	};	
});
