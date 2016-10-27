jQuery(function($) {
	$(document).ready(function() {
		$('body').on('shown.bs.modal', '#calendarSelectModal', function() {
			changeDateCalendar('calendar-change-day');
		});
		$('body').on('shown.bs.modal', '#calendarSelectWeekModal', function() {
			changeDateCalendar('calendar-change-week');
		});

		//Get modal content from an external source
		$('body').on('click', '[data-toggle="modal-ajax"]', function(e) {
			e.preventDefault();
			var newModal = $('#emptyModal').clone();
			var $target = $(this);
			var mid = $target.data('modalId');
			var mtitle = $target.data('title');
			var mclass = $target.data('class');
			var mhead = document.createElement('div');
			mhead.className = 'modal-header';
			var closeBtn = '<button type="button" class="modal-toggler modal-hide"><span class="sr-only">Toggle Modal</span><span class="icon-bar"></span><span class="icon-bar"></span></button>';
			$.get($target.data('modalSrc'), function(data) {
				newModal.attr('id', mid);
				if (mclass !== "") {
					newModal.addClass(mclass);
				}
				if (mtitle) {
					mtitle = '<h1 class="text-xs-center">' + mtitle + '</h1>';
					mhead.innerHTML = closeBtn + mtitle;
					newModal.find('.modal-body').before(mhead);
				}
				newModal.find('.modal-body').html(data);
				newModal.modal({
					show: true,
					backdrop: 'static'
				});
	
				if ($target.data('clear') === 'no') {
					$target.attr('data-toggle', 'modal-ajax-inline');
				}

				if(mid == 'modal-post-filters')
				{
					setTimeout(function(){
						$('.post-filters .filter').each(function(a,b){							
							$('#selectedFilters .filter-list .filter-remove').each( function(c,d) {
								if($(d).data('status') && $(b).data('status') && ($(d).data('status') == $(b).data('status')))
								{
									$(b).addClass('checked').removeClass('disabled');
								}
								else if($(b).data('id') && ($(d).data('id') == $(b).data('id')))
								{
									$(b).addClass('checked').removeClass('disabled');
								}
								else if($(b).data('tag-id') && ($(d).data('tag-id') == $(b).data('tag-id')))
								{
									$(b).addClass('checked').removeClass('disabled');
								}
							});
						});
					},500);
				}
			});
		});

		//Get modal content from inline source
		$('body').on('click', '[data-toggle="modal-ajax-inline"]', function(e) {
			e.preventDefault();
			var $target = $(this);
			var mid = $target.data('modalId');
			$('#' + mid).modal({
				show: true,
				backdrop: 'static'
			});
			$('#' + mid).on('shown.bs.modal', function() {
				addIncrements();
			});
		});

		$('body').on('click', '.modal-hide', function() {
			$('.modal').modal('hide');
		});
	});
});
