<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">New Post</h1>
	</header>
	<form action="<?php echo base_url().'posts/save_post' ?>" method="POST" id="post-details" class="file-upload clearfix" upload="<?php echo base_url()."posts/upload"; ?>">
		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $brand->created_by; ?>">

		<input type="hidden" name="uploaded_files[]" id="uploaded_files">
		<input type="hidden" id="all_files">
		<div class="row equal-cols">
			<div class="col-md-4">
				<div class="container-post-preview post-content">
					<h4 class="text-xs-center">Live Preview</h4>
					<div id="live-post-preview">
						<img src="<?php echo img_url(); ?>post-preview.png" width="406" height="506" alt="" class="center-block"/>
						
					</div>
					<footer class="post-content-footer">
						<a href="#" class="btn btn-default btn-xs">Delete</a>
					</footer>
				</div>
			</div>

			<div class="col-md-4">
				<div class="container-post-details post-content">
					<h4 class="text-xs-center">Post Details</h4>
					<div class="form-group">
						<div class="outlet-list clearfix">
							<label for="postOutlet" class="pull-sm-left">Outlet: </label>
							<?php 
								if(!empty($outlets))
								{
									?>
									<ul class="pull-sm-left outlet_ul">
									<?php
									foreach($outlets as $outlet)
									{
										$class = strtolower($outlet->outlet_name);
										if(strtolower($outlet->outlet_name) == 'youtube')
										{
											$class = 'youtube-play';
										}
										?>
										<li class="disabled" data-selected-outlet="<?php echo $outlet->id; ?>" data-outlet-const="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo $class; ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>
										<?php
									}
									?>
									</ul>
									<?php
								}
							?>								
							<input type="hidden" id="postOutlet" name="post_outlet">
						</div>
					</div>
					<div class="form-group">
						<label for="postCopy">Post Copy</label>
						<textarea class="form-control" id="postCopy" rows="5" placeholder="Type your copy here..." name="post_copy"></textarea>
					</div>
					<div class="form-group">
						<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></label>
						<div class="form__input">
							<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple />
							<label for="postFile" id="postFileLabel" class="file-upload-label"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>
							<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
						</div>
						<div class="form__uploading">Uploading ...</div>
						<div class="form__success">Done!</div>
						<div class="form__error">Error! <span></span>.</div>
					</div>					
					
					<div class="form-group form-inline pull-sm-left">
						<label>Slate Post:</label><br>
						<div class="hide-top-bx-shadow">
							<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<div class="pull-xs-left">
							<label class="invisible">Post Time</label>
							<div class="time-select form-control">
								<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH">
								<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM">
								<input type="text" class="time-input amselect" name="post-ampm" value="am">
							</div>
						</div>
						<span class="timezone pull-xs-right margin-top-30">PST</span>
					</div>
					<div class="form-group form-inline">
						<label>Tags:</label><br>
						<div class="hide-top-bx-shadow">
							<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'posts/tag_list/'.$brand_id; ?>" data-title="Select all that apply:" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-offset-x="0" data-offset-y="-2">
								<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
							</div>
						</div>
					</div>

					<footer class="post-content-footer">
						<div class="auto-save text-xs-center hidden-xs-up">Auto Saving ...</div>
					</footer>
				</div>
			</div>

			<div class="col-md-4">
				<div class="container-approvals">
					<div class="dafault-phase">
						<div>
							<h4 class="text-xs-center">Mandatory Approvals</h4>
							<label>Check all that apply:</label>
							<?php 
							if(!empty($users))
							{
								?>
								<ul class="timeframe-list user-list">
									<?php
									foreach ($users as $user)
									{
										?>
										<li>
											<div class="pull-sm-left">
												<input type="checkbox" class="hidden-xs-up" name="phase[0][approver][]" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $user->aauth_user_id; ?>" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i>
											</div>
											<div class="pull-sm-left">
												<?php
												$path = img_url()."default_profile.jpg";
												if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png'))
												{
													$path = upload_url().$brand->created_by.'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png';
												}
												?>
												<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
											</div>
											<div class="pull-sm-left post-approver-name">
												<strong>
												<?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
												</strong>
												<?php echo get_user_groups($user->aauth_user_id); ?>
											</div>
										</li>										
										<?php									
									}
									?>

									<li class="option-all-users">
										<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i></div>
										<div class="pull-sm-left"><div class="circle-border bg-black tf-icon">All</div></div>
										<div class="pull-sm-left post-approver-name">Check<br>All</div>
									</li>
								</ul>
								<?php
							}
							?>
							<label>Must approve by:</label>
							<div class="clearfix">
								<div class="form-group form-inline pull-sm-left">
									<div class="hide-top-bx-shadow">
										<input type="text" class="form-control form-control-sm popover-toggle single-date-select" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[0][approve_date]">
									</div>
								</div>
								<div class="form-group pull-sm-left">
									<div class="pull-xs-left">
										<div class="time-select form-control form-control-sm">
											<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[0][approve_hour]">
											<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM"  name="phase[0][approve_minute]">
											<input type="text" class="time-input amselect" value="am"  name="phase[0][approve_ampm]">
										</div>
									</div>
									<span class="timezone pull-xs-right form-control-sm">PST</span>
								</div>
							</div>
							<div class="form-group">
								<label for="approvalNotes">Note to Approvers (optional):</label>
								<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
							</div>
						</div>
						<div class="border-gray-lighter border-all padding-22px text-xs-center add-phases-footer">
							<label>Approval Phases (Optional):</label>
							<a href="#" class="btn btn-sm btn-default" data-toggle="addPhases" data-div-src="<?php echo 'posts/add_phase_details/'.$brand_id; ?>">Add Approval Phase(s)</a>
						</div>
						<footer class="post-content-footer">
						<button class="btn btn-sm btn-disabled save-draft-btn" disabled data-active-class="btn-default">Save Draft</button>
						<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn" data-active-class="btn-secondary">Submit for Approval</button>

						</footer>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<!-- Select Date Calendar -->
	<div id="calendar-select-date" class="hidden calendar-select-date">
		<div class="date-select-calendar"></div>
	</div>
<?php
$this->load->view('partials/previews');
?>