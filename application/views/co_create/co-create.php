<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10 cocreate-post">
	<div class="row">
		<div class="col-sm-8">
			<header class="page-main-header">
				<h1 class="center-title section-title">Co-Create</h1>
			</header>
		</div>
		<div class="col-sm-4">
			<header class="page-main-header">
				<h1 class="center-title section-title">Discussion</h1>
			</header>
			<div class="cocreate-opts text-xs-center">
				<a href="#"><i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-tele"></i></i></a>
				<a href="#"><i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-video"></i></i></a>
			</div>
		</div>
	</div>
	<form action="<?php echo base_url().'posts/save_post' ?>" method="POST" id="post-details" class="file-upload clearfix" upload="<?php echo base_url()."posts/upload"; ?>">
		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $this->user_data['account_id']; ?>">
		<input type="hidden" name="save_as" id="save_as" value="">
		<input type="hidden" name="slug" id="slug" value="<?php echo $brand->slug; ?>">
		<input type="hidden" name="request_string" id="request-string" value="<?php echo !empty($request_string) ? $request_string : ''; ?>">

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
						<a href="#" class="btn btn-default btn-xs">Delete</a>
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
							<input type="hidden" id="postOutlet" name="post_outlet">
						</div>
					</div>
					<div class="form-group">
						<label for="postCopy">Post Copy</label>
						<textarea class="form-control" id="postCopy" rows="5" placeholder="Type your copy here..." name="post_copy"></textarea>
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
						<div class="form-group form-inline pull-xl-right">						
							<label>Tags:</label><br>
							<div class="hide-top-bx-shadow">
								<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'posts/tag_list/'.$brand_id; ?>" data-title="Select all that apply:" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-offset-x="0" data-offset-y="-2">
									<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
								</div>
							</div>
						</div>
					</div>

					<footer class="post-content-footer">
						<div class="auto-save text-xs-center hidden-xs-up">Auto Saving ...</div>
					</footer>
				</div>
			</div>

			<div class="col-md-4 equal-height">
				<div class="container-cocreate-discussion">
					<div class="cocreate-participants"><strong>Participants:</strong> </div>
					<div class="dafault-phase">
						<h4 class="text-xs-center">Collaborate</h4>
							<?php 
							if(!empty($users))
							{
								?>
								<ul class="timeframe-list user-list first-phase">
									<?php
									foreach ($users as $user)
									{
										?>
										<li>
											<div class="pull-sm-left">
												<input type="checkbox" data-clear-phase="first" class="hidden-xs-up" name="join_req[]" value="<?php echo $user->aauth_user_id; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $user->aauth_user_id; ?>" data-group="join_req[]"><i class="fa fa-check"></i></i>
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
											<div class="pull-sm-left post-approver-name">
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
										<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="join_req[]"><i class="fa fa-check"></i></i></div>
										<div class="pull-sm-left"><div class="circle-border bg-black tf-icon">All</div></div>
										<div class="pull-sm-left post-approver-name">Check<br>All</div>
									</li>
								</ul>
								<?php
							}
							?>
							<button id="send-join" class="btn btn-sm btn-secondary submit-approval submit-btn">Send join request</button>
							<div id="videos" class="hidden">
						        <div id="subscriber"></div>
						        <div id="publisher"></div>
							</div>

						    <div class="chat-window discussion-list" id="chat_window_1">
					        	<div class="panel panel-default">
					                <div class="panel-heading top-bar hidden">
					                    <div class="col-md-4 col-xs-4" style="text-align: right;">
					                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
					                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
					                    </div>
					                </div>
					                <div class="panel-body msg_container_base">
					                </div>
					                <div class="panel-footer msg_container_base">
					                    <div class="input-group">
					                        <input id="btn-input" type="text" class="form-control chat_input" placeholder="Type a message..." />
					                    </div>
					                </div>
					    		</div>
						    </div>

						<footer class="post-content-footer">
						<button class="btn btn-sm save-draft-btn submit-btn btn-default"  id="draft">Save Draft</button>
						<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn "  id="submit-approval">Submit for Approval</button>
						</footer>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<script type="text/javascript">
	var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
	var sessionId = '<?php echo $sessionId; ?>';
	var token = '<?php echo $token; ?>';
</script>
<!-- Select Date Calendar -->
<?php
$this->load->view('partials/previews');
?>