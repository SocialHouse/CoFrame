//This identifies your website in the createToken call below
Stripe.setPublishableKey('pk_test_gAbZ9z9LZ2LuVpuTO0BkQSIU');

$(document).ready(function($) {
	$('#make_payment').click(function(event) {
		var $form = $('#payment-form');

		// Disable the submit button to prevent repeated clicks
		$form.find('button').prop('disabled', true);
		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from submitting with the default action
		return false;
	});

	function stripeResponseHandler(status, response) {
		console.log(response);
		
		var form = $('#payment-form');

		if (response.error) {
			// Show the errors on the form
			$('.payment-errors').text(response.error.message);
			$('.payment-errors').show();
			form.find('button').prop('disabled', false);
		} 
		else {
			// response contains id and card, which contains additional card details
			var token = response.id;
			// Insert the token into the form so it gets submitted to the server
			form.append($('<input type="hidden" name="stripe_token" />').val(token));
			// and submit			
			form.get(0).submit();
		}
	};
});