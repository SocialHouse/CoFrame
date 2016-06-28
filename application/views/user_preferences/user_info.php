<div class="col-md-4 col-md-offset-4 text-xs-center">
	<div class="user-info">
		<?php 
			$this->load->view('user_preferences/preference_nav');
		?>
		<?php
		
		if(!empty($user_details)){
			// echo '<pre>'; print_r($user_details);echo '</pre>'; die;
			// echo '<pre>'; print_r(get_my_brand($user_details->id));echo '</pre>'; die;


			$path = img_url()."default_profile.jpg";
			
			// if (file_exists(upload_path().$brand->created_by.'/users/'.$user->aauth_user_id.'.png'))
			// {
			// 	$path = upload_url().$brand->created_by.'/users/'.$user->aauth_user_id.'.png';
			// }
			?>
			<form action="<?php echo base_url();?>User_preferences/edit_my_info" method="post" id="edit_user_info">
			<input type="hidden" name="aauth_user_id" id="aauth_user_id" value="<?php echo $user_details->id ?>">
			<img src="<?php echo img_url()?>fpo/norel.jpg" alt="Norel Mancuso" class="circle-img user-img">
			<label class="section-label">Personal Info</label>
			<div class="field-group">
				<div class="clearfix">
					<fieldset class="form-group float-md">
						<label class="sr-only" for="firstName">First Name</label>
						<input type="text" class="form-control" id="firstName" placeholder="First Name" name="first_name" value="<?php echo (!empty($user_details->first_name))? $user_details->first_name:''?>">
					</fieldset>
					<fieldset class="form-group float-md">
						<label class="sr-only" for="lastName">Last Name</label>
						<input type="text" class="form-control" id="lastName" placeholder="Last Name" name="last_name" value="<?php echo (!empty($user_details->last_name))? $user_details->last_name:''?>">
					</fieldset>
				</div>
				<fieldset class="form-group">
					<label class="sr-only" for="emailAddress">Email address</label>
					<input type="email" class="form-control"  readonly="readonly" id="emailAddress" placeholder="Email" name="email" value="<?php echo (!empty($user_details->email))? $user_details->email:''?>">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="phoneNumber">Phone Number</label>
					<input type="tel" id="phone" class="form-control" id="phoneNumber" placeholder="Phone" name="phone" value="<?php echo (!empty($user_details->phone))? $user_details->phone:''?>">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="timeZone">Time Zone</label>
					<select class="form-control" id="timeZone" name="timezone">
						<option value="">Time Zone</option>
						<?php 
						if(!empty($timezones_list)){
							foreach ($timezones_list as $key => $obj) {
								if($obj->value == $user_details->timezone){
									$selected = ' selected="selected"';
								}else{
									$selected = '';
								}
								echo '<option value="'.$obj->value.'" '.$selected.'>'.$obj->timezone.'</option>';
							}
						}
						?>
					</select>
				</fieldset>
			</div>
			<label class="section-label">Login Info</label>
			<div class="field-group">
				<fieldset class="form-group">
					<label class="sr-only" for="userName">User Name</label>
					<input type="text" readonly="readonly" class="form-control" id="userName" placeholder="User Name" name="username" value="<?php echo (!empty($user_details->name))? $user_details->name:''?>">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="password">Password</label>
					<input type="password" class="form-control" id="password" placeholder="Password" name="password">
				</fieldset>
			</div>
			<label class="section-label">Master Admin Info</label>
			<div class="field-group">
				<fieldset class="form-group">
					<label class="sr-only" for="companyName">Company Name</label>
					<input type="text" class="form-control" id="companyName" placeholder="Company Name" name="company_name" value="<?php echo (!empty($user_details->company_name))? $user_details->company_name:''?>">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="companyEmail">Company Email</label>
					<input type="email" class="form-control" id="companyEmail" placeholder="Company Email" name="company_email" value="<?php echo (!empty($user_details->company_email))? $user_details->company_email:''?>">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="companyURL">Company URL</label>
					<input type="text" class="form-control" id="companyURL" placeholder="Company URL" name="company_url" value="<?php echo (!empty($user_details->company_url))? $user_details->company_url:''?>">
				</fieldset>
			</div>
			<button type="submit" class="btn btn-secondary btn-sm">Save Changes</button>
		</form>
			<?php			
		}
		?>
	</div>
</div>
<div class="page-divider" ></div>



