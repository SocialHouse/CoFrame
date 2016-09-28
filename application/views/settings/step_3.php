<div class="container-brand-step">
	<h4 class="text-xs-center">
		<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="3">Manage Users</button>
	</h4>
	<div class="user-permissions-list">
		<div class="clearfix">
			<div class="pull-sm-right">
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
			$master_user = get_master_user($this->user_data['account_id']);
			if(!empty($master_user))
			{
				?>
				<div class="table">
					<div class="table-cell">
						<div class="pull-sm-left post-approver-img">
							<?php echo print_user_image($master_user[0]->aauth_user_id,$master_user[0]->aauth_user_id); ?>
						</div>
						<div class="pull-sm-left post-approver-name">
							<strong>
								<span class="first_name"><?php echo $master_user[0]->first_name; ?></span>
								&nbsp;
								<span class="last_name"><?php echo $master_user[0]->last_name; ?></span>
							</strong>
								<span class="role pull-sm-left role">Master Admin</span>
						</div>

					</div>
					
					<div class="table-cell text-xs-center vertical-middle has-permission">
						<i class="fa fa-check"></i>										 
					</div>								
					<div class="table-cell text-xs-center vertical-middle has-permission">
						<i class="fa fa-check"></i>
					</div>									
					<div class="table-cell text-xs-center vertical-middle has-permission">
						<i class="fa fa-check"></i>
					</div>
					<div class="table-cell text-xs-center vertical-middle has-permission">
						<i class="fa fa-check"></i>										
					</div>
					<div class="table-cell text-xs-center vertical-middle has-permission">
						<i class="fa fa-check"></i>
					</div>
					<div class="table-cell text-xs-center vertical-middle has-permission">
						<i class="fa fa-check"></i>
					</div>
				</div>						
				<?php
			}
			if(!empty($account_users))
			{
				foreach($account_users as $user)
				{
					?>
					<div class="table" id="table_id_<?php echo $user->aauth_user_id; ?>">
						<div class="table-cell">
							<div class="pull-sm-left post-approver-img">
								<!-- <a href="#" class="btn-icon btn-gray edit-user-permission show-hide" href="#addUser" data-hide="#users_list,#addUserLink,#addUserBtns,#userDropdown" data-show="#addNewUser, #updateUserBtns,#addUserInfo" data-user-id="<?php echo $user->aauth_user_id; ?>">
									<i class="fa fa-pencil"></i>
								</a>
								<i class="tf-icon-circle remove-item remove-user" data-user-id="<?php echo $user->aauth_user_id; ?>" title="Remove User">x</i> -->
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
				}
			}
			if(!empty($added_users))
			{ 
				$num_users = count($added_users);
				$u = 1;
				foreach($added_users as $user)
				{
					?> 
					<div class="table<?php if($num_users == $u) {echo ' border-bottom border-black';} ?>">
						<div class="table-cell">
							
							<div class="pull-sm-left">
								<?php echo print_user_image($user->img_folder,$user->aauth_user_id); ?>
							</div>
							<div class="pull-sm-left post-approver-name"><strong><?php echo $user->first_name . " " . $user->last_name; ?></strong><?php echo get_user_groups($user->aauth_user_id,$brand->id); ?></div>
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"create",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<!-- <div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"edit",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div> -->
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"approve",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"view",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"settings",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"billing",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div> 
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"master",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div> 
					</div> 
					<?php
					$u++;
				} 
			}
		?>
	</div>
	<footer class="post-content-footer">
		<div class="text-xs-center">
			<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="3">Manage Users</button>
		</div>
	</footer>
</div>