	<ul class="timeframe-list user-list">
		<?php 
			if(!empty($users)){
				foreach ($users as $obj => $user) {
					$cls ='';
					$checked = '';
					?>
					<li>
						<div class="pull-sm-left">
						<?php 
						if(!empty($phases['hidden'])){
							if (in_array($user->aauth_user_id, $phases['hidden']))
							{
								$cls = " selected disabled";
								$checked = 'checked="checked"';
							}
						}
						if(!empty($phases['selceted'])){
							if (in_array($user->aauth_user_id, $phases['selceted'])){
								$cls = " selected";
								$checked = 'checked="checked"';
							}
						}
						?>
							
							<input type="checkbox" class="hidden-xs-up approvers"  name="phase[<?php echo $phase_details->phase; ?>][approver][]" value="<?php echo $user->aauth_user_id; ?> <?php echo $checked; ?>">
							<i data-group="post-approver" class="tf-icon check-box circle-border user-list <?php echo $cls?>" data-value="<?php echo $user->aauth_user_id; ?>">
								<i class="fa fa-check"></i>
							</i>
						</div>
						<div class="pull-sm-left">
						<?php
							$path = img_url()."default_profile.jpg";
							if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png'))
							{
								$path = upload_url().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png';
							}
						?>
						<img width="36" height="36" class="circle-img" alt="<?php echo $user->first_name.' '.$user->last_name?>" src="<?php echo $path; ?>" />
						</div>
						<div class="pull-sm-left post-approver-name">
							<strong><?php echo $user->first_name.' '.$user->last_name?></strong>
							<?php echo get_user_groups($user->aauth_user_id,$brand_id); ?>
						</div>
					</li>					
					<?php
				}
			}
		?>
		
		<li class="option-all-users">
			<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="post-approver"><i class="fa fa-check"></i></i></div>
			<div class="pull-sm-left"><div class="circle-border bg-black tf-icon">All</div></div>
			<div class="pull-sm-left post-approver-name">Check<br>All</div>
		</li>
	</ul>
