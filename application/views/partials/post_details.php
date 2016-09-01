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
							<li class="disabled" data-selected-outlet="<?php echo $outlet->id; ?>" data-outlet-const="<?php echo strtolower($outlet->outlet_constant); ?>"><i class="fa fa-<?php echo $class; ?>" title="<?php echo $outlet->outlet_name; ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>
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
		<div id="tumblrContentTypes" class="hidden extra-outlet-fields">
			<div class="content-list clearfix">
				<label for="tumblrContent" class="pull-sm-left">Content Type: </label>
				<ul class="pull-sm-left">
					<li class="disabled" data-selected-content="Text"><i class="tf-icon-text bg-tumblr show-hide" data-show="#tumblrTextPost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Text"></i></li>
					<li class="disabled" data-selected-content="Photo"><i class="tf-icon-photo bg-tumblr show-hide" data-show="#tumblrPhotoPost, #mediaUpload" data-hide="#defaultPostCopy, .extra-tb-fields" title="Photo"></i></li>
					<li class="disabled" data-selected-content="Quote"><i class="tf-icon-quote bg-tumblr show-hide" data-show="#tumblrQuotePost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Quote"></i></li>
					<li class="disabled" data-selected-content="Link"><i class="tf-icon-link bg-tumblr show-hide" data-show="#tumblrLinkPost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Link"></i></li>
					<li class="disabled" data-selected-content="Chat"><i class="tf-icon-tumblrchat bg-tumblr show-hide" data-show="#tumblrChatPost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Chat"></i></li>
					<li class="disabled" data-selected-content="Audio"><i class="tf-icon-audio bg-tumblr show-hide" data-show="#tumblrAudioPost, #mediaUpload" data-hide="#defaultPostCopy, .extra-tb-fields" title="Audio"></i></li>
					<li class="disabled" data-selected-content="Video"><i class="tf-icon-tumblrvideo bg-tumblr show-hide" data-show="#tumblrVideoPost, #mediaUpload" data-hide="#defaultPostCopy, .extra-tb-fields" title="Video"></i></li>
				</ul>
				<input type="hidden" id="tumblrContent" name="tumblrContent">
			</div>
			<label id="tumblr_content_error" class="error hide"></label>
		</div>
		<div class="form-group" id="defaultPostCopy">
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
		<div class="media-type clearfix hidden extra-outlet-fields" id="facebookMediaUpload">
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
		<div class="clearfix hidden extra-outlet-fields" id="albumType">
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
		<div id="linkedinPostFields" class="hidden form-group extra-outlet-fields">
			<label for="shareWithLinkedin">Share with:</label>
			<select class="form-control" name="shareWithLinkedin" id="shareWithLinkedin">
				<option value="public">Public</option>
				<option value="group 2">Group 2</option>
			</select>
		</div>
		<div id="pinterestPostFields" class="hidden form-group extra-outlet-fields">
			<div class="form-group">
				<label for="pinterestBoard">Board:</label>
				<select class="form-control" name="pinterestBoard" id="pinterestBoard">
					<option value="">Select Board</option>
					<option value="board name">Board Name</option>
					<option value="board name">Board Name 2</option>
				</select>
				<label id="pinterest_bord_error" class="youtube_error error hide"></label>
			</div>
			<div class="form-group">
				<label for="pinSource">Source (Optional):</label>
				<input type="url" placeholder="http://" class="form-control" name="pinSource" id="pinSource">
			</div>
		</div>
		<div id="youtubePostFields" class="hidden form-group extra-outlet-fields">
			<label for="ytVideoTitle">Video Title:</label>
			<input type="text" placeholder="Title Here" class="form-control" name="ytVideoTitle" id="ytVideoTitle">
			<label id="youtube_title_error" class="youtube_error error hide"></label>
		</div>
		
		<?php $this->load->view('partials/tumblr_post_types'); ?>

		<div class="clearfix">
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
				<div class="slate-post-errors">
					<div id="date_error" class="error"></div>
					<div id="hm_error" class="error"></div>
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
				<div class="form-group form-inline pull-xl-right">
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