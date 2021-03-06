<?php
if(check_user_perm($this->user_id,'master') OR check_user_perm($this->user_id,'billing') OR $this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND ($this->user_data['user_group'] == 'Master Admin' OR $this->user_data['user_group'] == 'Billing')))
{
	?>
	<section id="user-preferences" class="page-main bg-white col-sm-12">
		<div class="relative-wrapper">
			<header class="page-main-header">
				<h1 class="center-title section-title">Account Settings</h1>
			</header>
			<div class="row">
				<div class="col-xl-4 col-xl-offset-4 col-sm-6 col-sm-offset-3 text-xs-center">
					<div class="user-info">
						<?php 
							$this->load->view('user_preferences/preference_nav');
						?>
						<div class="row relative-wrapper ">
							<div class="brand-step col-sm-12" id="brandStep3">
								<?php
									
									$message = $this->session->flashdata('message');
									if(!empty($message)){
										?>
										   <div class="col-sm-12 center">
											  <strong><?php echo $message; ?></strong>
										   </div>
										<?php
									}
								?>
								<div class="container-brand-step">
									<div class="brand-image"></div>
									<div class="brand-fields">
										<input type="hidden" name="all_users" id="all_users" value="<?php echo $all_users_count; ?>">
										<!-- Display the user list with permission in TABLE format-->
										<div id="users_list" class="user-permissions-list">
											<div class="clearfix">
												<div class="pull-md-right">
													<div class="table-header">
														<div class="permission">Create</div>
													</div>
													<!-- <div class="table-header">
														<div class="permission">Edit</div>
													</div> -->
													<div class="table-header">
														<div class="permission">Approve</div>
													</div>
													<div class="table-header">
														<div class="permission">View Content</div>
													</div>
													<div class="table-header">
														<div class="permission">Brand Settings</div>
													</div>
													<div class="table-header">
														<div class="permission">Billing</div>
													</div>
													<div class="table-header">
														<div class="permission">Master</div>
													</div>
												</div>
											</div>
											<?php
												$master_user_count = 1;
												if(!empty($added_users))
												{ 
													// echo '<pre>'; print_r($added_users);echo '</pre>'; die;
													foreach($added_users as $user)
													{ 
														?> 
														<div class="table" id="table_id_<?php echo $user->aauth_user_id; ?>">
															<div class="table-cell">
																<div class="pull-sm-left post-approver-img">
																	<a href="#" class="btn-icon btn-gray edit-user-permission show-hide" href="#addUser" data-hide="#users_list,#addUserLink,#addUserBtns,#userDropdown" data-show="#addNewUser, #updateUserBtns,#addUserInfo" data-user-id="<?php echo $user->aauth_user_id; ?>">
																		<i class="fa fa-pencil"></i>
																	</a>
																	<i class="tf-icon-circle remove-item remove-user" data-user-id="<?php echo $user->aauth_user_id; ?>" title="Remove User">x</i>
																	<?php echo print_user_image($user->img_folder,$user->aauth_user_id ); ?>
																</div>
																<div class="hidden">
																	<span class="title"><?php echo $user->title; ?></span>
																	<span class="email"><?php echo $user->email; ?></span>
																</div>
																<div class="pull-sm-left post-approver-name">
																	<strong>
																		<span class="first_name"><?php echo $user->first_name; ?></span>
																		&nbsp;
																		<span class="last_name"><?php echo $user->last_name; ?></span>
																	</strong>
																		<span class="role pull-sm-left role"><?php echo $user->role; ?></span>
																</div>
	
															</div>
															
																<div class="table-cell text-xs-center vertical-middle has-permission">
																	<?php 
																		if (check_user_perm($user->aauth_user_id,"create",'','')) {
																			?> 
																			<i class="fa fa-check"></i>
																			<?php
																		}
																	?> 
																</div>
															
																<div class="table-cell text-xs-center vertical-middle has-permission">
																	<?php 
																		if (check_user_perm($user->aauth_user_id,"approve",'', $this->user_data['account_id'])) {
																			?> 
																			<i class="fa fa-check"></i>
																			<?php
																		}
																	?> 
																</div>
																
																<div class="table-cell text-xs-center vertical-middle has-permission">
																	<?php 
																		if (check_user_perm($user->aauth_user_id,"view",'', $this->user_data['account_id'])) {
																			?> 
																			<i class="fa fa-check"></i>
																			<?php
																		}
																	?> 
																</div>
																<div class="table-cell text-xs-center vertical-middle has-permission">
																	<?php 
																		if (check_user_perm($user->aauth_user_id,"settings",'', $this->user_data['account_id'])) {
																			?> 
																			<i class="fa fa-check"></i>
																			<?php
																		}
																	?> 
																</div>
																<div class="table-cell text-xs-center vertical-middle has-permission">
																	<?php 
																		if (check_user_perm($user->aauth_user_id,"billing",'', $this->user_data['account_id'])) {
																			?> 
																			<i class="fa fa-check"></i>
																			<?php
																		}
																	?> 
																</div>
																<div class="table-cell text-xs-center vertical-middle has-permission">
																	<?php 
																		if (check_user_perm($user->aauth_user_id,"master",'', $this->user_data['account_id'])) {
																			?> 
																			<i class="fa fa-check"></i>
																			<?php
																		}
																	?> 
																</div> 
														</div>
														<?php
														if($user->role == 'Master Admin'){
															$master_user_count++;
														}
													} 
												}
											?>
										</div>
										<!-- END table format-->

										<!-- Add new user and Edit user form START -->
										<div id="addNewUser" class="hidden">
											<form id="user_preferences_add_user" data method="POST" class="file-upload clearfix has-advanced-upload " action="<?php echo base_url()?>user_preferences/add_user" enctype="multipart/form-data">
												<h5 class="text-xs-center border-bottom border-black ">Add a User<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="User Images...Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h5>

												<!-- User drop-down with all users -->
												<div class="form-group input-margin show-hide hidden" id="userDropdown">
													<select class="form-control" name="user_select">
														<option value="">Select User</option>
														<!-- Loop through all users from the master account -->
														<?php
														
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
																	<option data-fname="<?php echo ucfirst($user->first_name) ?>" data-img-url="<?php echo $img_url; ?>" data-email="<?php echo  $user->email;?>" data-title="<?php echo  $user->title;?>" data-lname="<?php echo ucfirst($user->last_name) ?>" value="<?php echo $user->aauth_user_id; ?>"><?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?></option>
																	<?php
																}
															}
														?>
														<option value="Add New">Add New User</option>
													</select>
												</div>
												<!--END User drop-down with all users -->

												<!--Input form -->
												<div id="addUserInfo" class="hidden">
													<div class="form-group">
														<a href="#" class="remove-user-img hide">
															<i class="tf-icon-circle remove-upload">x</i>
														</a>
														<div class="center-block new-user-pic"  id="img_div" >
															<input type='file' id='userfileInput' name='files' accept='image/*'>
															<div class="cropme" id="new_user_pic" style="width: 70px; height: 70px;"></div>
															<input type="hidden" name="user_pic_base64" value="" id="user_pic_base64">
															<input type="hidden" name="is_user_image" value="" id="is_user_image">
															<input type="hidden" name="master_user_count" value="<?php echo $master_user_count; ?>" id="master_user_count">
														</div>
														<div class="upload-error error hide" style="margin-left: 15%;">Wrong file type uploaded</div>
														<div class="form__uploading">Uploading ...</div>
														<div class="form__success">Done!</div>
														<div class="form__error">Error! <span></span></div>
													</div>

													<div class="form-group input-margin" >
														<label for="firstName">User &nbsp;&nbsp;Info:</label>
														<input type="text" class="form-control" id="firstName" placeholder="First Name *" name="first_name" autocomplete="off">
														<input type="text" class="form-control" id="lastName" placeholder="Last Name *" name="last_name" autocomplete="off">
														<input type="text" class="form-control" id="userTitle" placeholder="Title" name="title">
														<input data-user_preference="true" type="email" class="form-control" id="userEmail" placeholder="Email *" name="email" autocomplete="off">
														<div id="emailValid" class="error hide"><?php echo $this->lang->line('valid_email'); ?></div>
														<div id="emailUniqueValid" class="error hide"><?php echo $this->lang->line('email_used'); ?></div>
													</div>
		
													<div class="form-group">
														<label>Role:<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover-inline" data-placement="bottom" data-popover-id="set-role" data-popover-class="popover-inline" data-attachment="top left" data-target-attachment="bottom center" data-offset-x="-22" data-popover-width="400" data-popover-arrow="true" data-arrow-corner="top left"></i></label>
														<select class="form-control" id="userRoleSelect" name="role">
															<option value="">Select Role</option>
															<?php
															if(!empty($groups))
															{
																foreach($groups as $group)
																{
																	if ($group->name == 'Master Admin' || $group->name == 'Billing' )
																	{
																		?>
																		<option value="<?php echo strtolower($group->name); ?>"><?php echo $group->name; ?></option>
																		<?php
																	}
																}
															}
															?>
														</select>
													</div>
												</div>												
												
												<div id="set-role" class="hidden">
													<p><strong>Master Admin</strong><br>
													The Master Admin is the master of the account with the ability to control all brand and user settings and can: Create, Edit, Approve, View Content, User Settings, Brand Settings, Billing. </p>
													<p><strong>Billing</strong><br>
													Billing can view: Billing.</p>
												</div>

												<footer class="post-content-footer">
													<div id="addUserBtns" >
														<button type="button" class="btn btn-sm btn-default pull-sm-left show-hide btn-cancel" data-hide="#addNewUser,#addUserLink" data-show="#addUserLink, #users_list">Cancel</button>
														<button id="addRole" type="submit" class="btn btn-sm pull-sm-right btn-secondary" >Save</button>
													</div>
													<div id="updateUserBtns">
														<button type="button" class="btn btn-sm btn-default pull-sm-left show-hide btn-cancel" data-hide="#addNewUser,#addUserLink" data-show="#addUserLink, #users_list">Cancel</button>
														<button id="addRole" type="submit" class="btn btn-sm pull-sm-right btn-secondary update_user" >Update</button>
													</div>
												</footer>
											</form>
										</div>
										<!-- Add new user and Edit user form END Here-->

									</div>
									<?php 
										if($this->plan_data['users'] >$all_users_count )
										{
											?>
											<a href="#addUser" id="addUserLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addUserLink, #users_list, #updateUserBtns" data-show="#addNewUser,#userDropdown,#addUserBtns">
												<i class="tf-icon circle-border">+</i>
												Add User
											</a>
											<?php 
										}
										else
										{
											?>
											<div class="col-sm-12">
												<?php echo str_replace("%user_number%", $this->plan_data['users'], $this->lang->line('user_limit')) ;?>
											</div>
											<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--<div class="page-divider"></div>-->
			</div>
			<?php $this->load->view('partials/footer_nav'); ?>
		</div>
	</section>
	<?php

}
else
{	
	$this->load->view('user_preferences/no_perm_user_prefrance');
}
?>
