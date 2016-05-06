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
		var filterContent, filterClass;
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
		var $filterItem =  $(document.createElement('li'));
		$filterItem.attr('data-value', filterVal).addClass('filter filter-remove' + filterClass).append(filterContent + "<i class='tf-icon-close'></i>");
		if(filterVal !== "check-all") {
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
			}
		}
		else if(filterVal === "check-all" && $filter.hasClass('checked')) {
			$('.filter[data-group="' + inputGroup + '"]').removeClass('checked');
			if(inputGroup === "post-outlet") {
				$('.filter[data-group="' + inputGroup + '"]').not($filter).addClass('disabled');
			}
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
		filterPosts();
	});
	
	$('#selectedFilters').on('click', '.filter-remove', function() {
		var filterVal = $(this).data('value');
		$('.post-filters').find('.filter[data-value="' + filterVal + '"]').click();
	});

	function filterPosts() {
		// map input values to an array
		var inclusives = [];
		// inclusive filters from checkboxes
		$('.filter').each( function() {
			//use value if checked
			if ( $(this).hasClass('checked' )) {
				inclusives.push( $(this).data('value') );
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
});