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
		if($(this).data('plan_change') == 'downgrade')
		{
			var current_users = $(this).data('current_users');
			var current_brand_count = $(this).data('current_brand_count');
			var brand_wise_tags = $('#brand_wise_tags').val();	
			var brand_wise_outlets = $('#brand_wise_outlets').val();			

			var users_allowed = $(this).data('users');
			var brands_allowed = $(this).data('brands');

			var user_error = 0;
			var brand_error = 0;
			var tag_error = 0;
			var outlet_error = 0;
			var tag_error = 0;
			var outlet_error = 0;

			var tag_error_string = '';
			var outlet_error_string = '';
			var error_msg = '';

			if(current_users > users_allowed)
			{
				var additional_count = current_users - users_allowed;
				error_msg += language_message.user_limit_downgrade.replace('%user_number%',additional_count);
				user_error = 1;				
			}

			if(current_brand_count > brands_allowed)
			{
				var additional_count = current_brand_count - brands_allowed;
				brand_msg = language_message.brand_limit_downgrade.replace('%brand_number%',additional_count)
				if(user_error)
				{
					error_msg += 'and';
					brand_msg = brand_msg.replace('Please remove','');
				}
				
				error_msg += brand_msg;
				brand_error = 1;
			}

			if(brand_wise_tags)
			{
				brand_wise_tags = $.parseJSON(brand_wise_tags);
				var allowed_tags = $(this).data('tags');
				$.each(brand_wise_tags,function(a,b){					
					if(b.count > allowed_tags)
					{
						tag_error_string += b.name;						
						tag_error = 1;
					}
				});
			}

			if(tag_error)
			{
				tag_msg = language_message.tag_limit_downgrade.replace('%message%',tag_error_string);
				if(user_error || brand_error)
				{
					error_msg += 'and';
					tag_msg = tag_msg.replace('Please remove','');
				}
				error_msg +=  tag_msg;
			}

			if(brand_wise_outlets)
			{
				brand_wise_outlets = $.parseJSON(brand_wise_outlets);
				var allowed_outlets = $(this).data('outlets');
				$.each(brand_wise_outlets,function(a,b){					
					if(b.count > allowed_outlets)
					{
						outlet_error_string += b.name;
						if(outlet_error)
						{
							outlet_error_string += ', ';
						}
						outlet_error = 1;
					}
				});
			}

			if(outlet_error)
			{
				outlet_msg = language_message.outlet_limit_downgrade.replace('%message%',tag_error_string);
				if(user_error || brand_error || tag_error)
				{
					error_msg += 'and';
					outlet_msg = outlet_msg.replace('Please remove','');
				}
				error_msg += outlet_msg;
			}

			if(outlet_error || tag_error || user_error || brand_error)
			{
				alert(error_msg);
				return false;
			}
		}
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
		if(phone_no)
		{
			jQuery('#phone').val(phone_no.trim().replace(/[^a-z0-9]+/gi, ''));
		}
	},200);
});
