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

			<div class="col-md-4 equal-height">
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
							<div id="outlet_error" class="error"></div>
							<input type="hidden" id="postOutlet" name="post_outlet">
						</div>
					</div>
					<div class="form-group">
						<label for="postCopy">Post Copy</label>
						<textarea class="form-control" id="postCopy" rows="5" placeholder="Type your copy here..." name="post_copy"></textarea>
						<div id="post_copy_error" class="error"></div>
					</div>
					<div class="form-group" id="mediaUpload">
						<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Images (jpg,gif,png) should be less than 2MB in size, and videos (.mp4) should be less than 100MB in size." data-popover-arrow="true"></i></label>
						<div class="form__input">
							<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple />
							<label for="postFile" id="postFileLabel" class="file-upload-label"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>
							<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
						</div>
						<div class="upload-error error hide">Wrong file type uploaded</div>
						<div class="form__uploading">Uploading ...</div>
						<div class="form__success">Done!</div>
						<div class="form__error">Error! <span></span>.</div>
						<div id="img_error" class="error"></div>
					</div>					
					<div class="media-type clearfix hidden" id="facebookMediaUpload">
						<div class="clearfix">
							<div class="col-md-6">
								<input type="radio" name="media-type" value="Photos" class="hidden-xs-up">
								<figure class="media-item clearfix" data-value="Photos">
									<img src="assets/images/icons/photos-video.png" alt="Photos or Video" class="pull-sm-left">
									<figcaption class="media-caption">
										<h5>Photos/Video</h5>
										Add photos or video to your status
									</figcaption>
								</figure>
							</div>
							<div class="col-md-6">
								<input type="radio" name="media-type" value="Album" class="hidden-xs-up">
								<figure class="media-item clearfix" data-value="Album">
									<img src="assets/images/icons/photos-video.png" alt="Photo Album" class="pull-sm-left">
									<figcaption class="media-caption">
										<h5>Photo Album</h5>
										Build an album out of multiple photos
									</figcaption>
								</figure>
							</div>
						</div>
						<div class="clearfix">
							<div class="col-md-6">
								<input type="radio" name="media-type" value="Carousel" class="hidden-xs-up">
								<figure class="media-item clearfix" data-value="Carousel">
									<img src="assets/images/icons/photos-video.png" alt="Photo Carousel" class="pull-sm-left">
									<figcaption class="media-caption">
										<h5>Photo Carousel</h5>
										Build a scrolling photo carousel with a link
									</figcaption>
								</figure>
							</div>
							<div class="col-md-6">
								<input type="radio" name="media-type" value="Slideshow" class="hidden-xs-up">
								<figure class="media-item clearfix" data-value="Slideshow">
									<img src="assets/images/icons/photos-video.png" alt="Slideshow" class="pull-sm-left">
									<figcaption class="media-caption">
										<h5>Slideshow</h5>
										Add 3 to 7 photos to create a video
									</figcaption>
								</figure>
							</div>
						</div>
					</div>
					<div class="clearfix hidden" id="albumType">
						<div class="form-group pull-sm-left">
							<div class="radio">
							<label>
							<input type="radio" name="albumType" value="newAlbum">
							Create New Album</label>
							</div>
							<input type="text" class="form-control" name="albumName" id="albumName" placeholder="Album Title">
						</div>
						<div class="or-label pull-sm-left">
							Or
						</div>
						<div class="form-group pull-sm-right">
							<div class="radio">
							<label>
							<input type="radio" name="albumType" value="existingAlbum">
							Add to Existing Album</label>
							</div>
							<select class="form-control" name="existingAlbum" id="existingAlbum">
								<option value="">Select Existing Album</option>
								<option value="01">Album Title</option>
								<option value="02">Album Title 2</option>
								<option value="03">Album Title 3</option>
								<option value="04">Album Title 4</option>
								<option value="05">Album Title 5</option>
							</select>
						</div>
					</div>
					<div class="clearfix">
						<div id="hm_error" class="error"></div>
						<div id="date_error" class="error"></div>
						<div class="pull-sm-left">
							<label>Slate Post:</label>
							<div class="clearfix slate-post">
								<div class="form-group form-inline pull-sm-left">
									<div class="hide-top-bx-shadow">
										<input  type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
									</div>
								</div>
								<div class="form-group pull-sm-left">
									<div class="pull-xs-left">
										<label class="hidden">Post Time</label>
										<div class="time-select form-control">
											<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" max="12" min="00" placeholder="HH">
											<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" max="59" min="00"  placeholder="MM">
											<input type="text" class="time-input amselect" name="post-ampm" value="am">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group slate-post-tz">
								<select class="form-control" name="time_zone">
									<!--  By default brand_timezone is selcted  -->
									<option selected="selected" data-abbreviation="<?php echo get_abbreviation($brand_timezone['value']); ?>"  value="<?php echo  $brand_timezone['value']; ?>" ><?php echo $brand_timezone['name']; ?></option>
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
						</div>
						<?php
						if(!empty($tags))
						{
							?>
							<div class="form-group form-inline pull-sm-right">
								<label>Tags:</label><br>
								<?php
								$title = "You have not set up any tags";
								if(!empty($tags))
								{
									$title = "Select all that apply:";
								}
								?>
								<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'posts/tag_list/'.$brand_id; ?>" data-title="<?php echo $title; ?>" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-offset-x="0" data-offset-y="-2">
									<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
								</div>
							</div>
							<?php
						}
						?>						
					</div>

					<footer class="post-content-footer">
						<div class="auto-save text-xs-center hidden-xs-up">Auto Saving ...</div>
					</footer>
				</div>
			</div>

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
													<input type="checkbox" class="hidden-xs-up approvers" name="phase[0][approver][]" value="<?php echo $master_user[0]->aauth_user_id; ?>"><i class="tf-icon check-box circle-border user-list" data-value="<?php echo $master_user[0]->aauth_user_id; ?>" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i>
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
														<input type="checkbox" data-clear-phase="first" class="hidden-xs-up" name="phase[0][approver][]" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $user->aauth_user_id; ?>" data-group="phase[0][approver][]"><i class="fa fa-check"></i></i>
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
											<input type="text" id="only_ph_one_date" class="form-control form-control-sm popover-toggle single-date-select" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[0][approve_date]">
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
								
								<div class="form-group slate-post-tz">
									<select class="form-control form-control-sm approval_timezone" name="phase[0][time_zone]">
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
								<label class="phase-one-error error hide clearfix"></label>
								<div class="form-group">
									<label for="approvalNotes">Note to Approvers (optional):</label>
									<textarea class="form-control" id="approvalNotes" name="phase[0][note]" rows="2" placeholder="Type your note here..."></textarea>
								</div>
						<?php
						}
						?>
						<footer class="post-content-footer">
						<button class="btn btn-sm save-draft-btn btn-default submit-btn" id="draft">Save Draft</button>
						<button type="submit" class="btn btn-sm btn-secondary btn-disabled submit-approval submit-btn pull-sm-right" id="submit-approval" disabled> Slate Post </button>
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