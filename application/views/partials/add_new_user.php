
<div id="addNewUser" class="hidden">
	<h5 class="text-xs-center border-bottom border-black ">Add a User<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="User Images...Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h5>
	<div class="form-group">
		<a href="#" class="remove-user-img hide">
			<i class="tf-icon-circle remove-upload">x</i>
		</a>
		<div class="center-block new-user-pic"  id="img_div" >
			<input type='file' id='userfileInput' name='files' accept='image/*'>
			<div class="cropme" id="new_user_pic" style="width: 70px; height: 70px;"></div>
			<input type="hidden" name="user_pic_base64" value="" id="user_pic_base64">
			<input type="hidden" name="is_user_image" value="" id="is_user_image">
		</div>
		<div class="upload-error error hide" style="margin-left: 15%;">Wrong file type uploaded</div>
		<div class="form__uploading">Uploading ...</div>
		<div class="form__success">Done!</div>
		<div class="form__error">Error! <span></span></div>
	</div>
	<div class="form-group input-margin" id="userSelect">
		<select class="form-control" name="user_select" id="user-select">
			<option value="">Select User</option>
			<!-- Loop through all users from the master account -->
			<?php
			if(!empty($brand_id))
			{
				if(!empty($users))
				{
					foreach($users as $user)
					{
						if(!empty($brand_id)){
							if(!is_set_permmition($user->aauth_user_id ,$brand_id)){
								$img_url=img_url()."default_profile.jpg";
								if (file_exists(upload_path().$user->img_folder.'/users/'.$user->aauth_user_id.'.png'))
						        {
						            $img_url = upload_url().$user->img_folder.'/users/'.$user->aauth_user_id.'.png?'.uniqid();
						        }
								?>
									<option data-fname="<?php echo ucfirst($user->first_name) ?>" data-lname="<?php echo ucfirst($user->last_name) ?>" value="<?php echo $user->aauth_user_id; ?>" data-img-url="<?php echo $img_url; ?>"><?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?></option>
								<?php
							}
						}					
					}
				}
			}
			else
			{
				if(!empty($users))
				{
					foreach($users as $user)
					{
						$img_url=img_url()."default_profile.jpg";
						if (file_exists(upload_path().$user->img_folder.'/users/'.$user->aauth_user_id.'.png'))
				        {
				            $img_url = upload_url().$user->img_folder.'/users/'.$user->aauth_user_id.'.png?'.uniqid();
				        }
						?>
						?>
						<option data-fname="<?php echo ucfirst($user->first_name) ?>" data-img-url="<?php echo $img_url; ?>" data-lname="<?php echo ucfirst($user->last_name) ?>" value="<?php echo $user->aauth_user_id; ?>"><?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?></option>
						<?php
					}
				}
			}
			?>
			<option value="Add New">Add New User</option>
		</select>
	</div>

	<div class="form-group input-margin hidden" id="addUserInfo">
		<label for="firstName">User Info:</label>
		<input type="text" class="form-control" id="firstName" placeholder="First Name *" name="first_name" autocomplete="off">
		<input type="text" class="form-control" id="lastName" placeholder="Last Name *" name="last_name" autocomplete="off">
		<div id="nameValid" class="error hide"></div>
		<input type="text" class="form-control" id="userTitle" placeholder="Title">
		<input type="email" class="form-control" id="userEmail" placeholder="Email *" name="email" autocomplete="off">
		<div id="emailValid" class="error hide"><?php echo $this->lang->line('valid_email'); ?></div>
		<div id="emailUniqueValid" class="error hide"><?php echo $this->lang->line('email_used'); ?></div>
	</div>
	
	<h5 class="border-title"><span>Permitted Outlets</span></h5>
	<div class="outlet-list" id="user-selected-outlet">
		<ul>
			<?php
			if(!empty($outlets) AND isset($brand_id))
			{
				foreach($outlets as $outlet)
				{
					?>
					<li class="disabled sub-user-outlet" data-selected-outlet-name="<?php echo strtolower($outlet->outlet_name); ?>" data-selected-outlet="<?php echo strtolower($outlet->id); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>		
					<?php
				}
			}
			?>
			<li data-group="post-tag" data-value="disabled" class="check-all-user-outlet"><i class="fa fa-circle tag-custom"></i><span class="tag-title">All</span></li>
		</ul>
	</div>
	<input type="hidden" id="userOutlet">
</div>
