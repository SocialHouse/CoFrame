<?php
if(!empty($users))
{
	?>
	<ul class="timeframe-list user-list">
	<?php
	foreach($users as $user)
	{
		$selected = '';
		$phase_num = '';
		$disabled = '';
		if(!empty($phases))
		{
			foreach($phases as $key=>$phase)
			{
				foreach($phase as $phase_user)
				{
					if($phase_user->user_id == $user->aauth_user_id)
					{
						$selected = 'selected';
						$phase_num = 'approvalPhase'.$key;
						if($current_phase != $key)
						{
							$disabled = 'disabled';
						}
					}
				}
			}
		}
		?>
		<li>
			<div class="pull-sm-left">
				<input type="checkbox" class="hidden-xs-up approvers" name="post-approver" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border <?php echo $selected.' '.$disabled; ?>" data-value="<?php echo $user->aauth_user_id; ?>" data-group="post-approver" data-linked-phase="<?php echo $phase_num; ?>" ><i class="fa fa-check"></i></i>
			</div>
			<div class="pull-sm-left user-img">
				<?php
				$path = img_url()."default_profile.jpg";
				
				if(file_exists(upload_path().$this->user_data['account_id'].'/users/'.$user->aauth_user_id.'.png'))
				{
					$path = upload_url().$this->user_data['account_id'].'/users/'.$user->aauth_user_id.'.png';
				}
				?>
				<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
			</div>
			<div class="pull-sm-left post-approver-name">
				<strong><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?></strong>
				<?php echo get_user_groups($user->aauth_user_id,$brand_id); ?>
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

	
