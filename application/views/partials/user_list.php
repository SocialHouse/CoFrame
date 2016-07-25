	<ul class="timeframe-list user-list">
		<?php
		$master_user = [];
		if($this->user_id != $this->user_data['account_id'])
		{
			$master_user = get_master_user($this->user_data['account_id']);
			if(!empty($master_user))
			{
				?>
				<li>
					<div class="pull-sm-left">
						<input type="checkbox" class="hidden-xs-up approvers" name="post-approver" value="<?php echo $master_user[0]->aauth_user_id; ?>"><i class="tf-icon check-box circle-border user-list" data-value="<?php echo $master_user[0]->aauth_user_id; ?>" data-group="post-approver"><i class="fa fa-check"></i></i>
					</div>
					<div class="pull-sm-left">
						<?php
						$path = img_url()."default_profile.jpg";
						
						if(file_exists(upload_path().$master_user[0]->img_folder.'/users/'.$master_user[0]->aauth_user_id.'.png'))
						{
							$path = upload_url().$this->user_data['img_folder'].'/users/'.$master_user[0]->aauth_user_id.'.png';
						}
						?>
						<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $master_user[0]->first_name; ?>" class="circle-img"/>
					</div>
					<div class="pull-sm-left post-approver-name">
						<strong><?php echo ucfirst($master_user[0]->first_name)." ".ucfirst($master_user[0]->last_name); ?></strong>
						Master Admin
					</div>
				</li>
				<?php
			}			
		}
		if(!empty($users))
		{

			foreach($users as $user)
			{
				?>
				<li>
					<div class="pull-sm-left">
						<input type="checkbox" class="hidden-xs-up approvers" name="post-approver" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border user-list" data-value="<?php echo $user->aauth_user_id; ?>" data-group="post-approver"><i class="fa fa-check"></i></i>
					</div>
					<div class="pull-sm-left">
						<?php
						$path = img_url()."default_profile.jpg";
						
						if(file_exists(upload_path().$user->img_folder.'/users/'.$user->aauth_user_id.'.png'))
						{
							$path = upload_url().$user->img_folder.'/users/'.$user->aauth_user_id.'.png';
						}
						?>
						<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
					</div>
					<div class="pull-sm-left post-approver-name">
						<strong><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?></strong>
						<?php echo get_user_groups($user->aauth_user_id,$brand[0]->id); ?>
					</div>
				</li>
				<?php
			}
		}
		?>
	</ul>
<?php
if(empty($users) && empty($master_user))
{
	echo "Currently no users avaialable";
}

	
