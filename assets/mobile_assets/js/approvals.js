jQuery(function($) {

	$(document).ready(function() {
		$('.outlet-list li').on('click',function(){
			var outlet_id = $(this).data('selected-outlet-id');
			$.ajax({
				url:base_url+'approvals/get_outlet_approvals',
				data:{'brand_id':$('#brand_id').val(),'outlet_id': outlet_id},
				type:'POST',
				success:function(response)
				{
					$('.my-approvals').html(response);
				}
			})
		});

		$(document).on("click", ".change-approve-status", function(event) {
			event.preventDefault();
			var phase_id = $(this).data('phase-id');
			var status = $(this).data('phase-status');
			var user_id = $('#user-id').val()
			var post_id = $(this).data('post-id');
			var btn = this;

			if (post_id) {
				$.ajax({
					'type': 'POST',
					dataType: 'json',
					url: base_url + 'posts/change_post_status',
					data: {
						'phase_id': phase_id,
						'status': status,
						'user_id': user_id,
						'post_id': post_id
					},
					success: function(response) {
						if ($(btn).attr('id') == 'approval_list_btn') {
							$(btn).hide();
							$(btn).parent().children('a:eq(1)')
							$(btn).parent().children('a:eq(1)').show();
						} else {
							$(btn).parent().addClass('hidden');
							if ($(btn).parent('.before-approve').length) {
								$(btn).parent().parent().children('div:last').removeClass('hidden')
							} else {
								$(btn).parent().parent().children('div:first').removeClass('hidden')
							}
						}
					}
				});
			}
		});
	});
})