<?php 
if(!empty($post_details->brand_id)){
	$brand_id = $post_details->brand_id;
}
?>
<div class="col-sm-4 equal-height">
	<div class="container-approvals">
		<div class="dafault-phase">
			<h4 class="text-xs-center">Mandatory Approvals</h4>
			<div class="border-gray-lighter border-all padding-22px text-xs-center add-phases-footer">
				<label>Approval Phases (Optional):</label>
				<a href="#" class="btn btn-sm btn-default" data-toggle="addPhases" data-div-src="<?php echo 'posts/add_phase_details/'.$brand_id; ?>">Add Approval Phase(s)</a>
			</div>
				<label>Check all that apply:</label>
				<ul class="timeframe-list user-list first-phase">
					<?php 
					if($this->user_id != $this->user_data['account_id'])
					{
						$master_user = get_master_user($this->user_data['account_id']);
						if(!empty($master_user))
						{
							?>										
							<li>
								<div class="pull-sm-left">
									<input type="checkbox" class="hidden-xs-up approvers" name="phase[0][approver][]" value="<?php echo $master_user[0]->aauth_user_id; ?>"><i class="tf-icon check-box circle-border user-list" data-value="<?php echo $master_user[0]->aauth_user_id; ?>" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i>
								</div>
								<div class="pull-sm-left">
									<?php
									$path = img_url()."default_profile.jpg";
									
									if(file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$master_user[0]->aauth_user_id.'.png'))
									{
										$path = upload_url().$this->user_data['img_folder'].'/users/'.$master_user[0]->aauth_user_id.'.png';
									}
									?>
									<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $master_user[0]->first_name; ?>" class="circle-img"/>
								</div>
								<div class="post-approver-name">
									<strong><?php echo ucfirst($master_user[0]->first_name)." ".ucfirst($master_user[0]->last_name); ?></strong>
									Master Admin
								</div>
							</li>
							<?php
						}			
					}
					if(!empty($users))
					{
						foreach ($users as $user)
						{
							?>
							<li>
								<div class="pull-sm-left">
									<input type="checkbox" data-clear-phase="first" class="hidden-xs-up" name="phase[0][approver][]" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $user->aauth_user_id; ?>" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i>
								</div>
								<div class="pull-sm-left">
									<?php
									$path = img_url()."default_profile.jpg";
									if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png'))
									{
										$path = upload_url().$this->user_data['account_id'].'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png';
									}
									?>
									<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
								</div>
								<div class="post-approver-name">
									<strong>
									<?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
									</strong>
									<?php echo get_user_groups($user->aauth_user_id,$brand_id); ?>
								</div>
							</li>										
							<?php									
						}
						?>
						<li class="option-all-users">
							<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i></div>
							<div class="pull-sm-left"><div class="circle-border bg-black tf-icon">All</div></div>
							<div class="post-approver-name">Check<br>All</div>
						</li>
					<?php
					}
					?>
				</ul>
				<label>Must approve by:</label>
				<div class="clearfix">
					<div class="form-group form-inline pull-sm-left date-time-div">
						<div class="hide-top-bx-shadow">
							<input type="text" id="only_ph_one_date" class="form-control form-control-sm popover-toggle single-date-select" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="#edit-post-details" name="phase[0][approve_date]">
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<div class="pull-xs-left">
							<div class="time-select form-control form-control-sm default_approver_time">
								<input type="text" id="only_ph_one_hour" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[0][approve_hour]">
								<input type="text" id="only_ph_one_minute" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM"  name="phase[0][approve_minute]">
								<input type="text" id="only_ph_one_ampm" class="time-input amselect" value="am"  name="phase[0][approve_ampm]">
							</div>
						</div>
					</div>
				</div>
				<div class="phase-one-error error hide clearfix"></div>
				<div class="form-group slate-post-tz">
					<select class="form-control form-control-sm approval_timezone" name="phase[0][time_zone]">
						<?php 
							// Display remaining timezones
							foreach ($timezones as $key => $obj) 
							{
								$selected ='';
								if(!empty( $brand))
								{
									if( $obj->value == $brand->timezone)
									{
										$selected = 'selected = "selected"';
									}
								}								
								?>
								<option value="<?php echo $obj->value; ?>" <?php echo $selected; ?>><?php echo $obj->timezone; ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="approvalNotes">Note to Approvers (optional):</label>
					<textarea class="form-control" id="approvalNotes" name="phase[0][note]" rows="2" placeholder="Type your note here..."></textarea>
				</div>
			<footer class="post-content-footer">
				<?php
					// if(empty($is_edit))
					// {
						?>
						<button class="btn btn-sm save-draft-btn btn-default submit-btn" id="draft">Save Draft</button>
						<?php
					// }
				?>
				<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn pull-sm-right" id="submit-approval"> Slate Post </button>
			</footer>
		</div>
	</div>
</div>
