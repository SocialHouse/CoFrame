var $ = jQuery;
jQuery(document).ready(function(){
	jQuery('#phone').mask("000-000-0000", {placeholder: "Phone"});
	jQuery('#ccNumber').mask("0000-0000-0000-0000", {placeholder: "0000-0000-0000- 1235"});
	jQuery('#cvv').mask("000", {placeholder: "***"});
	jQuery('#zip').mask("00000", {placeholder: "11111"});


	$('.make_payment').click(function(event) {
		event.preventDefault();
		var $form = $('#payment_form');
		$('#selected_plan').val($(this).data('plan'));
		$form.submit();
	});
});