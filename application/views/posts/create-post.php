<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">New Post</h1>
	</header>
	<form action="<?php echo base_url().'posts/save_post' ?>" method="POST" id="post-details" class="file-upload clearfix" upload="<?php echo base_url()."posts/upload"; ?>" autocomplete="off">
		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $this->user_data['account_id']; ?>">
		<input type="hidden" name="save_as" id="save_as" value="">
		<input type="hidden" name="slug" id="slug" value="<?php echo $brand->slug; ?>">

		<input type="hidden" name="uploaded_files[]" id="uploaded_files">
		<input type="hidden" id="all_files">
		<div class="row equal-columns create">
			<div class="col-md-4 equal-height">
				<div class="container-post-preview post-content">
					<h4 class="text-xs-center">Live Preview</h4>
					<div id="live-post-preview">
						<img src="<?php echo img_url(); ?>post-preview.png" width="406" height="506" alt="" class="center-block"/>
						
					</div>
					<footer class="post-content-footer">
					<!-- 	<a href="#" class="btn btn-default btn-xs">Delete</a> -->
					</footer>
				</div>
			</div>

			<?php $this->load->view('partials/post_details'); ?>

			<div class="col-md-4 equal-height">
				<div class="container-approvals">
					<div class="dafault-phase">
						<?php
						if($this->plan_data['phase_approvals'] == 1)
						{
							?>
							<h4 class="text-xs-center">Mandatory Approvals</h4>
								<div class="border-gray-lighter border-all padding-22px text-xs-center add-phases-footer">
									<label>Approval Phases (Optional):</label>
									<a href="#" class="btn btn-sm btn-default" data-toggle="addPhases" data-div-src="<?php echo 'posts/add_phase_details/'.$brand_id; ?>">Create Approval Phase(s)</a>
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
													<input type="checkbox" class="hidden-xs-up approvers" name="single_phase[0][approver][]" value="<?php echo $master_user[0]->aauth_user_id; ?>"><i class="tf-icon check-box circle-border user-list" data-value="<?php echo $master_user[0]->aauth_user_id; ?>" data-group="single_phase[0][approver][]"><i class="fa fa-check"></i></i>
												</div>
												<div class="pull-sm-left">
													<?php
													echo print_user_image($master_user[0]->img_folder, $this->user_id);
													?>
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
														<input type="checkbox" data-clear-phase="first" class="hidden-xs-up" name="single_phase[0][approver][]" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $user->aauth_user_id; ?>" data-group="single_phase[0][approver][]"><i class="fa fa-check"></i></i>
													</div>
													<div class="pull-sm-left">
														<?php
															echo print_user_image($user->img_folder, $user->aauth_user_id);
														?>
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
												<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="single_phase[0][approver][]"><i class="fa fa-check"></i></i></div>
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
											<input type="text" id="only_ph_one_date" class="form-control form-control-sm popover-toggle single-date-select" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="single_phase[0][approve_date]">
										</div>
									</div>
									<div class="form-group pull-sm-left">
										<div class="pull-xs-left">
											<div class="time-select form-control form-control-sm default_approver_time">
												<input type="text" id="only_ph_one_hour" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="single_phase[0][approve_hour]">
												<input type="text" id="only_ph_one_minute" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM"  name="single_phase[0][approve_minute]">
												<input type="text" id="only_ph_one_ampm" class="time-input amselect" value="am"  name="single_phase[0][approve_ampm]">
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group slate-post-tz">
									<select class="form-control form-control-sm approval_timezone" name="single_phase[0][time_zone]">
										<option selected="selected"  data-abbreviation="<?php echo get_abbreviation($brand_timezone['value']); ?>"  value="<?php echo  $brand_timezone['value']; ?>" ><?php echo $brand_timezone['name']; ?></option>
										<?php 
											//  If brand time zone and  user time are not same 
											if($brand_timezone['value'] != $user_timezone['value'] )
											{
												?>
												<option  data-abbreviation="<?php echo get_abbreviation($user_timezone['value']); ?>" value="<?php echo $user_timezone['value']; ?>"><?php echo $user_timezone['name']; ?></option>
												<?php 
											}
											
											// Display remaining timezones
											foreach ($timezones as $key => $obj) 
											{
												?>
												<option data-abbreviation="<?php echo $obj->abbreviation; ?>" value="<?php echo $obj->value; ?>"><?php echo $obj->timezone; ?></option>
												<?php
											}
										?>
									</select>
								</div>
								<div class="phase-one-error error hide clearfix"></div>
								<div class="form-group">
									<label for="approvalNotes">Note to Approvers (optional):</label>
									<textarea class="form-control" id="approvalNotes" name="single_phase[0][note]" rows="2" placeholder="Type your note here..."></textarea>
								</div>
						<?php
						}
						?>
						<footer class="post-content-footer">
						<button class="btn btn-sm save-draft-btn btn-default submit-btn" id="draft">Save Draft</button>
						<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn pull-sm-right" id="submit-approval"> Slate Post </button>
						</footer>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<!-- Select Date Calendar -->
<?php
$this->load->view('partials/previews');
?>