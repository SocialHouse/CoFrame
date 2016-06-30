var $ = jQuery;

$(document).ready(function(){
	
	
	if(jQuery("#edit_user_info").length)
	{
		$.fn.intlTelInput.loadUtils( base_url+"assets/js/vendor/utils.js");
		var $phone_no = jQuery('#phone').val();
		var telInput = $("#phone");
		
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