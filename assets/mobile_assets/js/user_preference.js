var $ = jQuery;

$(document).ready(function(){

	$('.change_plan').click(function(event) {
		event.preventDefault();
		$contorl = $(this);
		if($contorl.data('plan_change') == 'downgrade')
		{
			//billing user can not downgrade the plan
			if(user_data.user_group && user_data.user_group == 'Billing')
			{
				//alert(language_message.biling_downgrade);
				getConfirm(language_message.biling_downgrade,'','alert',function(confResponse){});
				return false;
			}

			var current_users = $contorl.data('current_users');
			var current_brand_count = $contorl.data('current_brand_count');
			var current_master_users = $contorl.data('current_master_users');

			var brand_wise_tags = $('#brand_wise_tags').val();	
			var brand_wise_outlets = $('#brand_wise_outlets').val();			

			var users_allowed = $contorl.data('users');
			var brands_allowed = $contorl.data('brands');
			var master_users_allowed = $contorl.data('master_users');

			var user_error = 0;
			var master_user_error = 0;
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

			if(current_master_users > master_users_allowed)
			{
				var additional_count = current_master_users - master_users_allowed;
				master_user_msg = language_message.master_users_limit_downgrade.replace('%master_users_number%',additional_count)
				if(user_error)
				{
					error_msg += 'and';
					master_user_msg = master_user_msg.replace('Please remove','');
				}
				
				error_msg += master_user_msg;
				master_user_error = 1;
			}

			if(current_brand_count > brands_allowed)
			{
				var additional_count = current_brand_count - brands_allowed;
				brand_msg = language_message.brand_limit_downgrade.replace('%brand_number%',additional_count)
				if(user_error || master_user_error)
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
				var allowed_tags = $contorl.data('tags');
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
				if(user_error || brand_error || master_user_error)
				{
					error_msg += 'and';
					tag_msg = tag_msg.replace('Please remove','');
				}
				error_msg +=  tag_msg;
			}

			if(brand_wise_outlets)
			{
				brand_wise_outlets = $.parseJSON(brand_wise_outlets);
				var allowed_outlets = $contorl.data('outlets');
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
				if(user_error || brand_error || tag_error || master_user_error)
				{
					error_msg += 'and';
					outlet_msg = outlet_msg.replace('Please remove','');
				}
				error_msg += outlet_msg;
			}

			if(outlet_error || tag_error || user_error || brand_error || master_user_error)
			{
				getConfirm(error_msg,'','alert',function(confResponse) {});
				return false;
			}
		}
		var message = language_message.change_plan_confirmation;
		if($('#brand_id').val())
		{
			getConfirm(language_message.change_plan_billing_details,'','alert',function(confResponse){});
			// alert(language_message.change_plan_billing_details);
		}
		else
		{
			getConfirm(message,'','',function(confResponse) {
				if(confResponse)
				{
					var $form = $('#payment_form');
					$('#selected_plan').val($contorl.data('plan'));
					$form.submit();
				}
			});
		}
	});

	$(document).on('click', '.edit-user-permission', function(e) {
		var aauth_user_id = $(this).data('user-id');
		var first_name = $('#table_id_'+aauth_user_id).find('.first_name').text();
		var last_name = $('#table_id_'+aauth_user_id).find('.last_name').text();
		var title = $('#table_id_'+aauth_user_id).find('.title').text();
		var email = $('#table_id_'+aauth_user_id).find('.email').text();
		var role = $('#table_id_'+aauth_user_id).find('.role').text();
		var img_src = $('#table_id_'+aauth_user_id).find('.circle-img').attr('src');
		
		$('#user_preferences_add_user #firstName').val(first_name);
		$('#user_preferences_add_user #lastName').val(last_name);
		$('#user_preferences_add_user #userTitle').val(title);
		$('#user_preferences_add_user #userEmail').val(email);
		$('#user_preferences_add_user #userRoleSelect').val(role.toLowerCase());
		
		if(img_src.search('default_profile.jpg') == -1){
			$("#new_user_pic").addClass('hasUpload');
			$(".remove-user-img").removeClass('hide');
			$('#new_user_pic').prepend($('<img>',{src:img_src}));
			$('#is_user_image').val('already_exists');
		}
		$('<input>').attr({
			    type: 'hidden',
			    id: 'user_id',
			    name: 'user_id',
			    value:aauth_user_id
			}).appendTo('#user_preferences_add_user');

		$('<input>').attr({
			    type: 'hidden',
			    id: 'previous_group',
			    name: 'previous_group',
			    value:role.toLowerCase()
			}).appendTo('#user_preferences_add_user');

		$('#userEmail').prop('readonly', true);
		$('#userEmail').attr('name', 'old_email');
		$('#user_preferences_add_user').attr('action',base_url+'user_preferences/edit_user_info')	;	
	});

	$(document).on('click', '#updateUserBtns .btn-cancel', function(e) {
		$('#addUserInfo input').val('');
		$('#user_preferences_add_user')[0].reset();
		$('#user_preferences_add_user  #new_user_pic').empty();
		$('#user_preferences_add_user #user_id').remove();
		$('#user_preferences_add_user #previous_group').remove();
		$('#is_user_image').val('');
		$(".remove-user-img").addClass('hide');
		$("#user_preferences_add_user #new_user_pic").removeClass('hasUpload');
		$('#user_preferences_add_user #userEmail').prop('readonly', false);
		$('#user_preferences_add_user #userEmail').attr('name', 'email');
		$('#user_preferences_add_user').attr('action',base_url+'user_preferences/add_user')	;
	});

	$(document).on('change', '#userDropdown select', function(e) {
		e.preventDefault();
		$('#userDropdown').slideUp(function() {
			$('#addUserInfo').slideDown(function() {
				equalColumns();
			});
		});
		if ($(this).val() == "") {
			return false;
			$('#addUserBtns').slideDown(function() {
				equalColumns();
			});
		}else{

			if ($(this).val() === "Add New") {
				$('#addUserBtns').slideDown(function() {
					equalColumns();
				});

				$('#updateUserBtns').slideUp(function() {
					equalColumns();
				});
				$('#addUserInfo input:not(:hidden)').val('');
				$('#user_preferences_add_user')[0].reset();
				$('#user_preferences_add_user  #new_user_pic').empty();
				$('#user_preferences_add_user #user_id').remove();
				$('#user_preferences_add_user #previous_group').remove();
				$('#is_user_image').val('');
				$(".remove-user-img").addClass('hide');
				$("#user_preferences_add_user #new_user_pic").removeClass('hasUpload');
				$('#user_preferences_add_user #userEmail').prop('readonly', false);
				$('#user_preferences_add_user #userEmail').attr('name', 'email');
				$('#user_preferences_add_user').attr('action',base_url+'user_preferences/add_user')	;

			} else {
				$('#addUserBtns').slideUp(function() {
					equalColumns();
				});

				$('#updateUserBtns').slideDown(function() {
					equalColumns();
				});				
				var aauth_user_id = $(this).val();
				var first_name = $(this).find(':selected').data('fname');
				var last_name =$(this).find(':selected').data('lname');
				var title = $(this).find(':selected').data('title');
				var email =$(this).find(':selected').data('email');
				
				var img_src = $(this).find(':selected').data('img-url');

				$('#user_preferences_add_user #firstName').val(first_name);
				$('#user_preferences_add_user #lastName').val(last_name);
				$('#user_preferences_add_user #userTitle').val(title);
				$('#user_preferences_add_user #userEmail').val(email);
				$('#user_preferences_add_user #userRoleSelect').val('');
				
				if(img_src.search('default_profile.jpg') == -1){
					
					$('#new_user_pic').prepend($('<img>',{src:img_src}));
					$('#is_user_image').val('already_exists');
				}
				$('<input>').attr({
					    type: 'hidden',
					    id: 'user_id',
					    name: 'user_id',
					    value:aauth_user_id
					}).appendTo('#user_preferences_add_user');
				$('#userEmail').prop('readonly', true);
				$('#userEmail').attr('name', 'old_email');
				$('#user_preferences_add_user').attr('action',base_url+'user_preferences/edit_user_info')	;	
			}

			toggleBtnClass('#addRole', true);
		}
	});

	$(document).on('click', '#addUserLink', function(e) {
		if(plan_data.users <= $('#all_users').val() && !$('#user_preferences_add_user #user_id').length){
			getConfirm(language_message.user_limit.replace('%user_number%',plan_data.users),'','alert',function(confResponse) {
				setTimeout(function(){
					$('#addUserBtns .btn-cancel').click();
				},500);
			});
			//alert(language_message.user_limit.replace('%user_number%',plan_data.users));
		}
	});

	$(document).on('change','#userfileInput',function(event){
		var reader = new FileReader();
		reader.readAsDataURL(event.target.files[0]);
		reader.onload = function (e) {			
			$('.circle-img').attr('src',e.target.result);
			$('#user_pic_base64').val(e.target.result);
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
