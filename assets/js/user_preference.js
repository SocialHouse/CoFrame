var $ = jQuery;
$(document).ready(function(){
	$('#phone').mask("000-000-0000", {placeholder: "Phone"});
	
	$('.cropme').simpleCropper();

	$('.change_plan').click(function(event) {
		event.preventDefault();
		var message = 'Are you sure you want to change plan.';
		if($('#brand_id').val())
		{
			alert('To cahnge plan first add billing details');
		}
		else
		{
			if(confirm(message))
			{
				var $form = $('#payment_form');
				$('#selected_plan').val($(this).data('plan'));
				$form.submit();
			}
		}
	});
});