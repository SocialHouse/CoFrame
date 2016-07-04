jQuery(document).ready(function(){

	jQuery('#loginForm').validate({
        rules: {
            email : { required: true, email:true},
            password : { required : true }
        },
        messages :{
            email : { required : "Please enter email address" , email: "Please enter a valid email address",},
            password : { required : "Please enter password" }
        },
        submitHandler: function(form, event) {
        	jQuery('#loading_main').show();
            event.preventDefault();
            var username = jQuery('#email_id').val();
			var password = jQuery('#login_password').val();
			var remember_me = jQuery('#remember_me:checked').val();
			
			jQuery.ajax({
				"url": base_url+'tour/check_login',
				"data":{"email":username,"password":password,'remember_me':remember_me},
				"type":"POST",
				success: function(response)
		        {
		        	var json = jQuery.parseJSON(response);
		        	if(json.response == 'success')
		        	{
		        		window.location.href = base_url+"brands/overview";
		        	}
		        	else
		        	{
		        		if(json.response == 'verify')
		        		{
		        			jQuery('#fail_msg_header').html('Verify account');
		        			jQuery('#go_to_login').html('Go to login');
		        		}
		        		else
		        		{
		        			jQuery('#fail_msg_header').html('Invalid Email or Password');
		        			jQuery('#go_to_login').html('Try again');
		        		}

		        		jQuery('#login_fail_msg').html(json.message)	        		
		        		jQuery('#loginModal').modal('hide');		        		
						jQuery('#loginSuccess').trigger('click');
						jQuery('#loading_main').hide();
		        	}
		        }
			});
        }
    });

    jQuery('#resetPassForm').validate({
        rules: {
            email : { required: true, email:true,
            		remote: {
	                    url: base_url+"tour/check_email_exist",
	                    type: "post"
	                }
	            }
        },
        messages :{
        	email: {
            	required: "Please enter your email address",
                email: "Please enter a valid email address",
                remote: "The email you entered did not match our records"
            }
        },
        submitHandler: function(form, event) {
        	jQuery('#loading_main').show();
            event.preventDefault();
            var email = jQuery('#forgotEmail').val();		
		
			jQuery.ajax({
				"url": base_url+'tour/reset_password',
				"data":{"email":email},
				"type":"POST",
				success: function(response)
		        {
		        	var json = jQuery.parseJSON(response);
		        	if(json.response == 'success')
		        	{
		        		jQuery('#recovery_header').html('Password Recovery');
		        		jQuery('#recovery_message').html(json.message);
		        		jQuery('#dismissBtn').show();
		        		jQuery('#go_to_recover_pass').hide();	        		
		        		jQuery('#go_login').hide();
		        	}
		        	else
		        	{
		        		jQuery('#recovery_header').html('Forgot password error');
		        		jQuery('#recoverPassSuccessBtn').html('Try again');

		        		jQuery('#go_to_recover_pass').show();
		        		jQuery('#dismissBtn').hide();
		        		jQuery('#go_login').hide();	
		        		jQuery('#recovery_message').html(json.message);
		        	}
		        	jQuery('#recoverSuccessBtn').trigger('click');
		        	jQuery('#loading_main').hide();
		        }
			});
        }
    });

    jQuery('#setPassForm').validate({
        rules: {
            password :{ required : true,minlength:6 },
            confirm_password :{ required : true,equalTo: "#newPass"},
        },
        messages :{
        	password :{ required : "Please enter password",minlength:"Please enter minimum 6 character password" },
            confirm_password :{ required : "Please re-enter password" },
        },
        submitHandler: function(form, event) {
        	jQuery('#loading_main').show();
            event.preventDefault();           
			var newPass = jQuery('#newPass').val();		
			var token = jQuery('#token').val();
			
			jQuery.ajax({
				"url": base_url+'tour/save_password',
				"data":{"password":newPass,'token': token},
				"type":"POST",
				success: function(response)
		        {		        	
		        	var json = jQuery.parseJSON(response);
		        	if(json.response == 'success')
		        	{
		        		jQuery('#recovery_header').html('');	        		
		        		jQuery('#savePassword').modal('hide');
		        		jQuery('#recovery_message').html(json.message);
		        		
		        		jQuery('#go_login').show();
		        		jQuery('#go_to_recover_pass').hide();
		        		jQuery('#dismissBtn').hide();
		        	}
		        	else
		        	{
		        		jQuery('#recovery_header').html('Forgot password error');
		        		if(json.response == 'fail')
		        		{	        			
		        			jQuery('#recoverPassSuccessBtn').html('Try again');
		        		}
		        		jQuery('#go_login').hide();	
		        		jQuery('#go_to_recover_pass').show();
		        		jQuery('#dismissBtn').hide();
		        		jQuery('#recovery_message').html(json.message);
		        		jQuery('#savePassword').modal('hide');
		        	}
		        	jQuery('#recoverSuccessBtn').trigger('click');
		        	jQuery('#loading_main').hide();
		        }
			});		
        }
    });

    jQuery.validator.addMethod("domain", function(value, element) {
	  return this.optional(element) || /^\s*(http\:\/\/)?([a-z\d\-]{1,63}\.)*[a-z\d\-]{1,255}\.[a-z]{2,6}\s*$/.test(value);
	});

	jQuery.validator.addMethod("phone_num", function(value, element) {
	  return this.optional(element) ||  /^(?:\(\d{3}\)|\d{3}-)\d{3}-\d{4}$/.test(value);
	});



	jQuery.validator.addMethod('checkData',  function(value, element) {
       	console.log('result '+jQuery(element).data('error'));
       	if(jQuery(element).data('error') == 'false'){
	 		return false;
	 	}else{
	 		return true;
	 	}
    }, "Please enter valid phone number");

   
    jQuery('#register_form').validate({
		errorPlacement: function(error, element) {
			error.appendTo(element.closest('.form-group'));
		},
    	onkeyup: false,
        rules: {
        	first_name: {required: true},
        	last_name: {required: true},
        	email: {required: true,email:true,
        			remote: {
	                    url: base_url+"tour/check_email_exist",
	                    type: "post",
	                    dataFilter: function(data) {
	                    	console.log(data);
	                    	if(data == 'true')
	                    	{
	                    		return false;
	                    	}
	                    	return true;           
		                }
	                }
        		},
        	phone:{checkData: true, required: true},
        	timezone: {required: true},
        	plan: {required: true},
        	username: {required: true,
        				remote: {
		                    url: base_url+"tour/check_username_exist",
		                    type: "post"
		                }
        			},
            password :{ required : true,minlength:6 },
            confirm_password :{ required : true,equalTo: "#password"},
            company_email :{email: true},
            company_url:{domain:true}
        },
        messages :{
        	first_name: {required: "Please enter first name"},
        	last_name: {required: "Please enter last name"},
        	email: {required: 'Please enter email address',email: 'Please enter valid email address',remote: "This email is already in use"},
        	phone:{required: "Please enter phone number",  checkData: 'Please enter valid phone number'},
        	timezone: {required: "Please select timezone"},
        	plan: {required: "Please select plan"},
        	username: {required: "Please enter username",remote:'This username is already taken'},
        	password :{ required : "Please enter password",minlength:"Minimum 6 character required" },
            confirm_password :{ required : "Please re-enter password" },
            company_email :{email:'Please enter valid email address'},
            company_url:{domain: "Please enter valid url eg. www.example.com"}
        },
        submitHandler: function(form, event) {
        	jQuery('#loading_main').show();
            event.preventDefault();
            var firstName = jQuery('#firstName').val();
            var lastName = jQuery('#lastName').val();
            var emailAddress = jQuery('#emailAddress').val();
            var phoneNumber = jQuery('#phone').val();
            if(jQuery("#register_form").length)
			{
				phoneNumber = jQuery("#phone").intlTelInput("getNumber");
			}

            var timeZone = jQuery('#timeZone').val();
            var userName = jQuery('#userName').val();
            var password = jQuery('#password').val();
            var confirmPassword = jQuery('#confirmPassword').val();
            var companyName = jQuery('#companyName').val();
            var companyURL = jQuery('#companyURL').val();
            var plan = jQuery('#plan').val();
            var title = jQuery('#title').val();

            jQuery.ajax({
				"url": base_url+'tour/register',
				"data":{"first_name":firstName,'last_name': lastName,'email':emailAddress,'phone':phoneNumber,'timezone':timeZone,'username':userName,'password':password,'confirm_password': confirmPassword,'company_name':companyName,'company_url':companyURL,'plan':plan,'title':title},
				"type":"POST",
				success: function(response)
		        {

		        	var json = jQuery.parseJSON(response);
		        	if(json.response == 'success')
		        	{		        				        		
		        		jQuery('#register_form')[0].reset();						
						jQuery('#gotTologRegister').show();
						jQuery('#registerTryAgain').hide();
						jQuery('#registerCancel').show();
		        	}
		        	else
		        	{
		        		jQuery('#gotTologRegister').hide();
						jQuery('#registerTryAgain').show();
						jQuery('#registerCancel').hide();
		        	}
		        	jQuery('.registerResponseText').text(json.message);
		        	jQuery('#regResponseBtn').trigger('click');
					jQuery('#loading_main').hide();
		        }
			});	
        }
    });


    jQuery('#registerSubUser').validate({
    	onkeyup: false,
        rules: {        
        	email: {required: true,
        				remote: {
		                    url: base_url+"tour/check_username_exist",
		                    type: "post"
		                }
        			},
            password :{ required : true,minlength:6 },
            confirm_password :{ required : true,equalTo: "#password_reg"},
        },
        messages :{        
        	email: {required: "Please enter email address",remote:'This email address is already taken'},
        	password :{ required : "Please enter password",minlength:"Minimum 6 character required" },
            confirm_password :{ required : "Please re-enter password" },            
        },
        submitHandler: function(form, event) {
        	jQuery('#loading_main').show();
            event.preventDefault();

            var user_id = jQuery('#user_id').val();
            var verification_code = jQuery('#verification_code').val();
            var email = jQuery('#email_reg').val();
            var password = jQuery('#password_reg').val();
            var confirmPassword = jQuery('#confirm_password_reg').val();

            jQuery.ajax({
				"url": base_url+'tour/save_sub_user',
				"data":{'user_id':user_id,'verification_code':verification_code,'email':email,'password':password,'confirm_password': confirmPassword},
				"type":"POST",
				success: function(response)
		        {

		        	var json = jQuery.parseJSON(response);
		        	if(json.response == 'success')
		        	{		        				        		
		        		jQuery('#registerSubUser')[0].reset();						
						jQuery('#gotTologRegister').show();
						jQuery('#registerModal').hide();
						jQuery('#registerTryAgain').hide();
						jQuery('#registerCancel').show();
		        	}
		        	else
		        	{
		        		jQuery('#gotTologRegister').hide();
						jQuery('#registerTryAgain').show();
						jQuery('#registerCancel').hide();
		        	}
		        	jQuery('.registerResponseText').text(json.message);
		        	jQuery('#regResponseBtn').trigger('click');
					jQuery('#loading_main').hide();
		        }
			});	
        }
    });

    jQuery('#edit_user_info').validate({
    	onkeyup: false,
        rules: {
        	first_name: {required: true},
        	last_name: {required: true},
        	phone:{checkData: true, required: true},
        	timezone: {required: true},
        	password :{ minlength:6 },
            company_email :{email: true},
            company_url:{domain:true}
        },
        messages :{
        	first_name: {required: "Please enter first name"},
        	last_name: {required: "Please enter last name"},
        	phone:{required: "Please enter phone number",  checkData: 'Please enter valid phone number'},
        	timezone: {required: "Please select timezone"},
        	password :{ minlength:"Minimum 6 character required" },
            company_email :{email:'Please enter valid email address'},
            company_url:{domain: "Please enter valid url eg. www.example.com"}
        },
        submitHandler: function(form, event) {
        	if(jQuery("#edit_user_info").length)
			{
				$('#phoneNumber').val(jQuery("#phone").intlTelInput("getNumber"));
	        	jQuery('#loading_main').show();
	            event.preventDefault();
	            form.submit();
			}
        }
    });

  });