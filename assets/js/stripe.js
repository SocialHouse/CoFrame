//This identifies your website in the createToken call below
var $ = jQuery;
Stripe.setPublishableKey('pk_test_gAbZ9z9LZ2LuVpuTO0BkQSIU');

$(document).ready(function($) {
	// $('#make_payment').click(function(event) {
	// 	var $form = $('#payment-form');
	// 	console.log($form);
	// 	// Disable the submit button to prevent repeated clicks
	// 	$form.find('button').prop('disabled', true);
	// 	Stripe.card.createToken($form, stripeResponseHandler);

	// 	// Prevent the form from submitting with the default action
	// 	return false;
	// });

	function stripeResponseHandler(status, response) {
		console.log(response);
		
		var form = $('#payment-form');

		if (response.error) {
			// Show the errors on the form
			alert(response.error.message);
			// $('.payment-errors').text(response.error.message);
			// $('.payment-errors').show();
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

	jQuery('#payment-form').validate({    	
        rules: {
        	name: {required: true},
        	cc_number: {required: true,number: true},
        	cvc:{required: true,number: true},
        	expiry_month: {required: true},
        	expiry_year :{ required:6 },
        	zip: {required: true},
            country :{required: true}
        },
        messages :{
        	name: {required: "Please enter full name"},
        	cc_number: {required: "Please enter credit card number",number: 'Please enter valid credit card number'},
        	cvc:{required: 'Please enter CVV',number: 'Please enter valid CVV'},
        	expiry_month: {required: "Please select expiration month"},
        	expiry_year :{ required:"Please select expiration year" },
            zip :{required:'Please enter zip/postal code'},
            country:{required: "Please select country"}
        }
    });

    $('#make_payment').on('click', function() {
	    if($("#payment-form").valid())
	    {
			var $form = $('#payment-form');
			// Disable the submit button to prevent repeated clicks
			$form.find('button').prop('disabled', true);
			Stripe.card.createToken($form, stripeResponseHandler);
	    }
	});
});