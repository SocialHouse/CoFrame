var $ = jQuery;

$(document).ready(function(){
	
	
	if(jQuery("#edit_user_info").length)
	{
		$.fn.intlTelInput.loadUtils( base_url+"assets/js/vendor/utils.js");
		var $phone_no = jQuery('#phone').val();
		var telInput = $("#phone");
		console.log($phone_no);
		telInput.intlTelInput({
			allowDropdown: true,
	      	autoHideDialCode: true,
			autoPlaceholder: true,
			dropdownContainer: "body",
			//excludeCountries: ["us"],
			geoIpLookup: function(callback) {
			$.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
				var countryCode = (resp && resp.country) ? resp.country : "";
				callback(countryCode);
			});
			},
			initialCountry: "auto",
			nationalMode: true,
			setNumber:$phone_no,
			//numberType: "MOBILE",
			//onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
			// preferredCountries: ['cn', 'jp'],
			separateDialCode: true
		});
		// initialise plugin

		// on blur: validate
		telInput.blur(function() {
			if ($.trim(telInput.val())) {
			    if (telInput.intlTelInput("isValidNumber")) {
			    	$(telInput).data('error','true');
				    console.log( $(telInput).data('error'));
			    }else{
			    	console.log($(telInput).data('error'));
			    	$(telInput).data('error','false');	
		    	}
		  	}
		});

	}
	
	$('.cropme').simpleCropper();

	$('.change_plan').click(function(event) {
		event.preventDefault();
		var message = language_message.change_plan_confirmation;
		if($('#brand_id').val())
		{
			alert(language_message.change_plan_billing_details);
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
$(window).load(function() {
	setTimeout(function(){
		var phone_no = jQuery('#phone').val();
		jQuery('#phone').val(phone_no.trim().replace(/[^a-z0-9]+/gi, ''));
		console.log(phone_no.trim().replace(/[^a-z0-9]+/gi, ''));
	},200);
});
