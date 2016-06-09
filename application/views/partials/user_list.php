<?php
if(!empty($users))
{
	?>
	<ul class="timeframe-list user-list">
	<?php
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
				
				if(file_exists(upload_path().$brand[0]->created_by.'/users/'.$user->aauth_user_id.'.png'))
				{
					$path = upload_url().$brand[0]->created_by.'/users/'.$user->aauth_user_id.'.png';
				}
				?>
				<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
			</div>
			<div class="pull-sm-left post-approver-name">
				<strong><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?></strong>
				<?php echo get_user_groups($user->aauth_user_id); ?>
			</div>
		</li>
		<?php
	}
	?>
	</ul>
	<?php
}
else
{
	echo "Currently no users avaialable";
}

	
