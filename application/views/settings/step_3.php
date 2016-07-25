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
				<div class="table-header">
					<div class="permission">Master</div>
				</div>
			</div>
		</div>
		<?php 
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
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"edit",$brand->id)) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
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