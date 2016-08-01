<?php
if(check_user_perm($this->user_id,'master') OR check_user_perm($this->user_id,'billing') OR $this->user_id == $this->user_data['account_id'])
{
	?>
	<section id="user-preferences" class="page-main bg-white col-sm-12">
		<header class="page-main-header">
			<h1 class="center-title section-title">User Preferences</h1>
		</header>
		<div class="row">
			<div class="col-md-4 col-md-offset-4 text-xs-center">
				<div class="user-info">
					<?php 
						$this->load->view('user_preferences/preference_nav');
					?>
					<div class="row equal-columns relative-wrapper ">
						<div class="brand-step equal-height col-md-12" id="brandStep3">
							<div class="container-brand-step">
								<form id="user_preferences_add_user" method="POST" class="file-upload clearfix has-advanced-upload " action="<?php echo base_url()?>user_preferences/add_user" enctype="multipart/form-data">
									
									<div class="brand-image"></div>
									<div class="brand-fields">
										<div id="addNewUser">
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
											<div class="form-group input-margin" id="addUserInfo">
												<label for="firstName">User &nbsp;&nbsp;Info:</label>
												<input type="text" class="form-control" id="firstName" placeholder="First Name *" name="first_name" autocomplete="off">
												<input type="text" class="form-control" id="lastName" placeholder="Last Name *" name="last_name" autocomplete="off">
												<div id="nameValid" class="error hide"></div>
												<input type="text" class="form-control" id="userTitle" placeholder="Title" name="title">
												<input type="email" class="form-control" id="userEmail" placeholder="Email *" name="email" autocomplete="off">
												<div id="emailValid" class="error hide"><?php echo $this->lang->line('valid_email'); ?></div>
												<div id="emailUniqueValid" class="error hide"><?php echo $this->lang->line('email_used'); ?></div>
											</div>

											<div class="form-group">
												<label>Role:<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover-inline" data-placement="bottom" data-popover-id="set-role" data-popover-class="popover-inline" data-attachment="top left" data-target-attachment="bottom center" data-offset-x="-22" data-popover-width="400" data-popover-arrow="true" data-arrow-corner="top left"></i></label>
												<select class="form-control" id="userRoleSelect" name="selected_role">
													<option value="">Select Role</option>
													<?php
													if(!empty($groups))
													{
														foreach($groups as $group)
														{
															if ($group->name == 'Admin' || $group->name == 'Billing' )
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
											<div id="set-role" class="hidden">
												<p><strong>Master Admin</strong><br>
												The Master Admin is the master of the account with the ability to control all brand and user settings and can: Create, Edit, Approve, View Content, User Settings, Brand Settings, Billing. </p>
													
												<p><strong>Billing</strong><br>
												Billing can view: Billing.</p>
											</div>
										</div>
									</div>
									<footer class="post-content-footer">
										<div >
											<button type="button" class="btn btn-sm btn-default pull-left">Cancel</button>
											<button type="submit"" class="btn btn-sm pull-sm-right btn-secondary" >Save</button>
										</div>
									</footer>
								</form>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<div class="page-divider"></div>
		</div>
	</section>
	<?php
}
else
{	
	$this->load->view('user_preferences/no_perm_user_prefrance');
}
?>