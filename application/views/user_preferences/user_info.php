<section id="user-preferences" class="page-main bg-white col-sm-12">
	<div class="relative-wrapper">
		<header class="page-main-header">
			<h1 class="center-title section-title">Account Settings</h1>
		</header>
		<div class="row equal-columns">
			<div class="col-xl-4 col-xl-offset-4 col-sm-6 col-sm-offset-3 text-xs-center equal-height">
				<div class="user-info">
					<?php 
					$this->load->view('user_preferences/preference_nav');
				
					if(!empty($user_details)){
						$image ='';
						$cls= 'hide';
						$is_user_image ="no";
						if (file_exists(upload_path().$user_details->img_folder.'/users/'.$this->user_id.'.png'))
						{
							$is_user_image = 'yes';
							$path = upload_url().$user_details->img_folder.'/users/'.$this->user_id.'.png?'.uniqid();
							$image = '<img src="'.$path.'">';
							$cls ='';
						}
	
						$email_check = '';
						$desktop_check = '';
						$urgent_check = '';
						if($user_details->email_notification == '0'){
							$email_check = 'checked="checked"';
						}
						if($user_details->desktop_notification == '0'){
							$desktop_check = 'checked="checked"';
						}
						if($user_details->urgent_notification == '0'){
							$urgent_check = 'checked="checked"';
						}
					?>
						<form action="<?php echo base_url();?>User_preferences/edit_my_info" method="post" id="edit_user_info">
						
						<input type="hidden" name="aauth_user_id" id="aauth_user_id" value="<?php echo $user_details->id ?>">
						
						<div class="form-group brand-image">
							<a href="#" class="user-preference remove-user-img <?php echo $cls; ?>">
								<i class="tf-icon-circle remove-upload">x</i>
							</a>
							<div class="center-block new-user-pic"  id="img_div" >
								<input type='file' id='userfileInput' name='files' accept='image/*'>
								<div class="cropme" id="new_user_pic" style="width: 70px; height: 70px;">
									<?php echo $image; ?>
								</div>
								<input type="hidden" name="user_pic_base64" value="" id="user_pic_base64">
								<input id="is_user_image" type="hidden" value="<?php echo $is_user_image?>" name="is_user_image">
							</div>
							<div class="upload-error error hide" style="margin-left: 15%;">Wrong file type uploaded</div>
							<div class="form__uploading">Uploading ...</div>
							<div class="form__success">Done!</div>
							<div class="form__error">Error! <span></span></div>
						</div>
						<?php
							echo print_flashdata();
					    ?>
	
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
							<?php
								$data_error = 'false';
								if(!empty($user_details->phone))
								{
									$data_error = 'true';
								}
							?>
							<fieldset class="form-group">
								<label class="sr-only" for="phoneNumber">Phone Number</label>
								<input type="tel" id="phone" name="phone" data-error="<?php echo $data_error; ?>" class="form-control" value="<?php echo (!empty($user_details->phone))? $user_details->phone:''?>">
								<input type="hidden" name="phoneNumber" id="phoneNumber" value="<?php echo (!empty($user_details->phone))? $user_details->phone:''?>"> 
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
								<label class="sr-only" for="password">Current Password</label>
								<input type="password" class="form-control" id="current_password" placeholder="Current Password" name="current_password">
							</fieldset>
							<fieldset class="form-group">
								<label class="sr-only" for="password">New Password</label>
								<input type="password" class="form-control" id="new_password" placeholder="New Password" name="new_password">
							</fieldset>
							<fieldset class="form-group">
								<label class="sr-only" for="password">Confirm new Password</label>
								<input type="password" class="form-control" id="confirm_password" placeholder="Confirm new Password" name="confirm_password">
							</fieldset>
						</div>
						<?php
						$class = 'hide';
						if(check_user_perm($this->user_id,'master') OR $this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
						{
							$class = '';
						}
						?>
						<div class="<?php echo $class; ?>">
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
						</div>
						<label class="section-label">Notification</label>
						<div class="field-group text-xs-left">
							<fieldset class="form-group">
								<label>
									<input type="checkbox" value="yes" <?php echo $email_check ?> name="email_notification" >&nbsp;Email &nbsp;
								</label>
								<label>
									<input type="checkbox" value="yes" <?php echo $desktop_check ?> name="desktop_notification" >&nbsp;Desktop &nbsp;
								</label>
								<label>
									<input type="checkbox" value="yes" <?php echo $urgent_check ?> name="urgent_notification" >&nbsp;Urgent &nbsp;
								</label>
							</fieldset>
						</div>
						<button type="submit" class="btn btn-secondary btn-sm">Save Changes</button>
					</form>
						<?php			
					}
					?>
				</div>
	
				<div class="page-divider" ></div>
			</div>
		</div>
		<?php $this->load->view('partials/footer_nav'); ?>
	</div>
</section>



