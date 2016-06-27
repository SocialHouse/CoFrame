<div class="container-brand-step">
	<form id="step_3_edit" method="POST" class="file-upload clearfix has-advanced-upload " action="<?php echo base_url()?>brands/save_tags" enctype="multipart/form-data">
		<input type="hidden" id="user_id" name="user_id" value="<?php echo $this->user_id; ?>">
		<input type="hidden" id="brand_id" name="brand_id" value="<?php echo $brand->id; ?>">
		<input type="hidden" id="slug" name="slug" value="<?php echo $brand->slug; ?>">
		<h4 class="text-xs-center">Users &amp; Permissions</h4>
		<div class="brand-image"></div>
		<div class="brand-fields">
			<div id="userPermissionsList" class="user-permissions-list">
				<div class="clearfix">
					<div class="pull-sm-right">
						<div class="table-header">
							<div class="permission">Create</div>
						</div>
						<div class="table-header">
							<div class="permission">Edit</div>
						</div>
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
					</div>
				</div>	
				<?php 
					if(!empty($users))
					{ 
						foreach($users as $user)
						{ 
							//echo '<pre>'; print_r($user);echo '</pre>';
							?> 
							<div class="table">
								<div class="table-cell">
									<?php
										$path = img_url()."default_profile.jpg";
									
										if (file_exists(upload_path().$brand->created_by.'/users/'.$user->aauth_user_id.'.png'))
										{
											$path = upload_url().$brand->created_by.'/users/'.$user->aauth_user_id.'.png';
										}
									?>
									<div class="pull-sm-left post-approver-img"><img src="<?php echo $path; ?>" width="36" height="36" alt="" class="circle-img"/><i class="tf-icon-circle remove-item remove-user" title="Remove User">x</i></div>
									<div class="pull-sm-left post-approver-name"><strong><?php echo $user->first_name . " " . $user->last_name; ?></strong><?php echo get_user_groups($user->aauth_user_id); ?></div>
								</div>
								<div class="table-cell text-xs-center vertical-middle has-permission">
									<?php 
										if (check_user_perm($user->aauth_user_id,"create")) {
											?> 
											<i class="fa fa-check"></i>
											<?php
										}
									?> 
								</div>
								<div class="table-cell text-xs-center vertical-middle has-permission">
									<?php 
										if (check_user_perm($user->aauth_user_id,"edit")) {
											?> 
											<i class="fa fa-check"></i>
											<?php
										}
									?> 
								</div>
								<div class="table-cell text-xs-center vertical-middle has-permission">
									<?php 
										if (check_user_perm($user->aauth_user_id,"approve")) {
											?> 
											<i class="fa fa-check"></i>
											<?php
										}
									?> 
								</div>
								<div class="table-cell text-xs-center vertical-middle has-permission">
									<?php 
										if (check_user_perm($user->aauth_user_id,"view")) {
											?> 
											<i class="fa fa-check"></i>
											<?php
										}
									?> 
								</div>
								<div class="table-cell text-xs-center vertical-middle has-permission">
									<?php 
										if (check_user_perm($user->aauth_user_id,"settings")) {
											?> 
											<i class="fa fa-check"></i>
											<?php
										}
									?> 
								</div>
								<div class="table-cell text-xs-center vertical-middle has-permission">
									<?php 
										if (check_user_perm($user->aauth_user_id,"billing")) {
											?> 
											<i class="fa fa-check"></i>
											<?php
										}
									?> 
								</div> 
							</div> 
							<?php
						} 
					}
				?>
			</div>
			<a href="#addUser" id="addUserLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addUserLink, #outletStep3Btns, #userPermissionsList" data-show="#addNewUser, #addUserBtns"><i class="tf-icon circle-border">+</i>Add User</a>
			<?php $this->load->view('partials/add_new_user'); ?>
			<?php $this->load->view('partials/add_user_roles'); ?>
		</div>
		<footer class="post-content-footer">
			<div id="outletStep3Btns">
				<button type="button" class="btn btn-sm btn-default close_brand"  data-step-no="3">Cancel</button>
				<button type="submit"" class="btn btn-sm pull-sm-right btn-secondary"  data-step-no="3" >Save</button>
			</div>
			<div class="hidden" id="addUserBtns">
				<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addNewUser, #addUserBtns" data-show="#addUserLink, #outletStep3Btns, #userPermissionsList">Cancel</button>
				<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole" disabled="disabled">Role</button>
			</div>
			<div class="hidden" id="userRoleBtns">
				<p class="disclaimer">Upon clicking ‘Add,’ a registration link will be sent to this user.</p>
				<button type="button" class="btn btn-sm btn-default btn-cancel show-hide go-to-userlist" data-hide="#addUserRole, #userRoleBtns" data-show="#addUserLink, #outletStep3Btns, #userPermissionsList">Cancel</button>
				<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide addUserToBrand" disabled id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole">Add</button>
			</div>
		</footer>
	</form>
</div>

<?php       
if(isset($js_files))
{
    foreach ($js_files as $js_src) 
    {
        ?>
        <script src="<?php echo $js_src; ?>"></script>
        <?php
    }
}
?>
<script type="text/javascript">
	fileDragNDrop();
</script>

<style type="text/css" media="screen">

	
</style>
