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
			$('.filter[data-group="' + inputGroup + '"][data-value="check-all"]').removeClass('selected checked');
		}
		else if(filterVal === "check-all" && !$filter.hasClass('checked')) {
			$('.filter[data-group="' + inputGroup + '"]').addClass('checked');
			if(inputGroup === "post-outlet") {
				$('.filter[data-group="' + inputGroup + '"]').removeClass('disabled');
				filterClass = ' outlet-list';
			}
			$('.filter[data-group="' + inputGroup + '"]').not($filter).each(function() {
				$filterItem =  $(document.createElement('li'));
				if(inputGroup === "post-status") {
					filterContent = $(this).find('label').text();
				}
				else {
					filterContent = $(this).html();
				}
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
		var current = this;
		var inclusives = [];
		var outlet_ids = [];
		var statuses = [];
		var tags = [];

		$('#selectedFilters .filter-list .filter-remove').each( function() {
			if($(this).data('id'))
			{
				if($(current).data('id') != $(this).data('id'))
					outlet_ids.push( $(this).data('id') );
			}

			if($(this).data('status'))
			{
				if($(current).data('status') != $(this).data('status'))
					statuses.push( $(this).data('status') );
			}

			if($(this).data('tag-id'))
			{
				if($(current).data('tag-id') != $(this).data('tag-id'))
					tags.push($(this).data('tag-id'));
			}
		});
		$('#statuses_ids').val(statuses)
		$('#tags_ids').val(tags);
		$('#outlets_ids').val(outlet_ids);

		setTimeout(function(){
			$('#filter-form-remove').submit();
		},100);		
	});

	function filterPosts() {
		// map input values to an array
		var inclusives = [];
		// inclusive filters from checkboxes
		$('.filter').each( function() {
			//use value if checked
			if ( $(this).hasClass('checked' )) {
				inclusives.push( '[data-filters*="' + $(this).data('value') + '"]' );
			}
			else {
				var index = inclusives.indexOf($(this).data('value'));
				if( index > -1) {
					inclusives.splice(index, 1);
				}
			}
		});	

		// combine inclusive filters
		var filterValue = inclusives.length ? inclusives.join(', ') : '*';

		$container.isotope({ filter: filterValue });
		if(inclusives.length) {
			$('#selectedFilters').slideDown();
		}
		else {
			$('#selectedFilters').slideUp();
		}
	}

	$(document).on('click','.save-filter',function(){
		updateFilters();
	});

	function updateFilters()
	{
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
		$('#statuses').val(statuses)
		$('#tags').val(tags);
		$('#outlets').val(outlet_ids);

		setTimeout(function(){
			$('#filter-form').submit();
		},100);
		
		// $.ajax({
		// 	url:base_url+'calendar/save_filters',
		// 	type:'POST',
		// 	data:{tags:tags,outlets:outlet_ids,statuses:statuses,brand_id:$('#filter_brand_id').val(),filter_id:filter_id},
		// 	success:function(response){

		// 	}
		// });
	}
});