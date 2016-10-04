<div class="col-sm-4 equal-height insert_after">
	<div class="container-post-details post-content">
		<h4 class="text-xs-center">Post Details</h4>
		<div class="form-group">
			<input type="hidden" name="brand_slug" value="<?php echo $slug ; ?>">
			<div class="outlet-list clearfix">
				<label for="postOutlet" class="pull-sm-left">Outlet: </label>
					<?php 
					if(!empty($outlets)){
						echo '<ul class="pull-sm-left outlet_ul">';
						foreach($outlets as $outlet)
						{
							//echo '<pre>'; print_r($outlet);echo '</pre>';
							$class = strtolower($outlet->outlet_name);
							if(strtolower($outlet->outlet_name) == 'youtube')
							{
								$class = 'youtube-play';
							}
							$selected ='class= "disabled" ';
							if( $post_details->outlet_id == $outlet->id){
								$selected = '';
							}
							?>
								<li <?php echo $selected; ?>   data-selected-outlet="<?php echo $outlet->id; ?>" data-outlet-const="<?php echo strtolower($outlet->outlet_constant); ?>">
									<i class="fa fa-<?php echo $class; ?>">
										<span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span>
									</i>
								</li>
							<?php
						}
						echo '</ul>';
					}
				?>
				<input type="hidden" name="post_outlet" id="postOutlet" value="<?php echo $post_details->outlet_id; ?>" data-outlet-const="<?php echo strtolower($post_details->outlet_constant); ?>">
				<div id="outlet_error" class="error"></div>
			</div>
		</div>

		<?php
			$tumblr_content_style = '';
			if(strtolower($post_details->outlet_constant) == 'tumblr')
			{
				$tumblr_content_style = 'display: block;';
			}

			$text_class = 'hidden';
			$text_li_class = 'disabled';
			$photo_class = 'hidden';
			$photo_li_class = 'disabled';
			$quote_class = 'hidden';
			$quote_li_class = 'disabled';
			$link_class = 'hidden';
			$link_li_class = 'disabled';
			$chat_class = 'hidden';
			$chat_li_class = 'disabled';
			$audio_class = 'hidden';
			$audio_li_class = 'disabled';
			$video_class = 'hidden';
			$video_li_class = 'disabled';
			$mediaUpload = '';
			switch ($post_details->tumblr_content_type) {
				case 'Text':
					$text_class = '';
					$text_li_class = '';
					$mediaUpload = 'hidden';
					break;
				case 'Photo':
					$photo_class = '';
					$photo_li_class = '';
					break;
				case 'Quote':
					$quote_class = '';
					$quote_li_class = '';
					$mediaUpload = 'hidden';
					break;
				case 'Link':
					$link_class = '';
					$link_li_class = '';
					$mediaUpload = 'hidden';
					break;
				case 'Chat':
					$chat_class = '';
					$chat_li_class = '';
					$mediaUpload = 'hidden';
					break;
				case 'Audio':
					$audio_class = '';
					$audio_li_class = '';
					break;
				case 'Video':
					$video_class = '';
					$video_li_class = '';
					break;
			}
		?>
		<div id="tumblrContentTypes" class="hidden form-group extra-outlet-fields" style="<?php echo $tumblr_content_style; ?>">
			<div class="content-list clearfix">
				<label for="tumblrContent" class="pull-sm-left">Content Type: </label>
				<ul class="pull-sm-left">
					<li class="<?php echo $text_li_class; ?>" data-selected-content="Text"><i class="tf-icon-text bg-tumblr show-hide" data-show="#tumblrTextPost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Text"></i></li>
					<li class="<?php echo $photo_li_class; ?>" data-selected-content="Photo"><i class="tf-icon-photo bg-tumblr show-hide" data-show="#tumblrPhotoPost, #mediaUpload" data-hide="#defaultPostCopy, .extra-tb-fields" title="Photo"></i></li>
					<li class="<?php echo $quote_li_class; ?>" data-selected-content="Quote"><i class="tf-icon-quote bg-tumblr show-hide" data-show="#tumblrQuotePost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Quote"></i></li>
					<li class="<?php echo $link_li_class; ?>" data-selected-content="Link"><i class="tf-icon-link bg-tumblr show-hide" data-show="#tumblrLinkPost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Link"></i></li>
					<li class="<?php echo $chat_li_class; ?>" data-selected-content="Chat"><i class="tf-icon-tumblrchat bg-tumblr show-hide" data-show="#tumblrChatPost" data-hide="#defaultPostCopy, #mediaUpload, .extra-tb-fields" title="Chat"></i></li>
					<!-- <li class="<?php echo $audio_li_class; ?>" data-selected-content="Audio"><i class="tf-icon-audio bg-tumblr show-hide" data-show="#tumblrAudioPost, #mediaUpload" data-hide="#defaultPostCopy, .extra-tb-fields" title="Audio"></i></li> -->
					<li class="<?php echo $video_li_class; ?>" data-selected-content="Video"><i class="tf-icon-tumblrvideo bg-tumblr show-hide" data-show="#tumblrVideoPost, #mediaUpload" data-hide="#defaultPostCopy, .extra-tb-fields" title="Video"></i></li>
				</ul>
				<input type="hidden" id="tumblrContent" name="tumblrContent" value="<?php if(isset($post_details)){ echo $post_details->tumblr_content_type; } ?>">
			</div>
			<label id="tumblr_content_error" class="error hide"></label>
		</div>
		<?php
			$defaultPostCopy = 'hidden';
			$defaultPostCopy_style = '';
			if(strtolower($post_details->outlet_constant) != 'tumblr')
			{
				$defaultPostCopy = 'hidden';
				$defaultPostCopy_style ='display: block;'; 
			}
		?>
		<div id="defaultPostCopy" class="form-group <?php echo $defaultPostCopy; ?>" style="<?php echo $defaultPostCopy_style; ?>" >
			<label for="postCopy">Post Copy</label>
			<textarea class="form-control" id="postCopy" name ="post_copy" rows="5" placeholder="Type your copy here..."><?php echo (!empty($post_details->content)) ? $post_details->content : '';?></textarea>
			<div id="post_copy_error" class="error"></div>
		</div>
		<div id="mediaUpload" class="form-group <?php echo $mediaUpload; ?>">
			<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></label>
			<input type="hidden" name="delete_img" id="delete_img" />
			<div class="form__input has-files">
				<?php 
					if(!empty($post_images)){
						$class = 1;
						foreach ($post_images as $key) {
							if($key->type =='images'){
								echo '<div class="form__preview-wrapper"><i data-delete-id="'.$key->id.'" class="tf-icon-circle remove-upload">x</i><img src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'" class="form__file-preview delete-img" data-delete="'.$class.'" /></div>';
								$class++;
							}else if($key->type =='video'){
								echo '<video class="form__file-preview"src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'"></video>';
							}										
                        }
                        echo '<label class="file-upload-label" id="postFileLabel" for="postFile"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>';
					}else{?>
						<label for="postFile" id="postFileLabel" class="file-upload-label">
							<i class="tf-icon circle-border">+</i>
							<span class="form__label-text">Click to upload
								<span class="form__dragndrop"> or drag &amp; drop here ...</span>
							</span>
						</label>
						<?php
					}
				?>
				<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple />
				<button type="button" class="form__button btn btn-sm btn-default">Upload</button>
			</div>
			<div class="form__uploading">Uploading ...</div>
			<div class="form__success">Done!</div>
			<div class="form__error">Error! <span></span>.</div>
			<div id="img_error" class="error"></div>
		</div>

		<div id="facebookMediaUpload" class="media-type clearfix hidden extra-outlet-fields" style="" >
			<div class="clearfix">
				<div class="col-sm-6">
					<input type="radio" name="media-type" value="Photos" class="hidden-xs-up">
					<figure class="media-item clearfix" data-value="Photos">
						<img src="assets/images/icons/photos-video.png" alt="Photos or Video" class="pull-sm-left">
						<figcaption class="media-caption">
							<h5>Photos/Video</h5>
							Add photos or video to your status
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-6">
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
				<div class="col-sm-6">
					<input type="radio" name="media-type" value="Carousel" class="hidden-xs-up">
					<figure class="media-item clearfix" data-value="Carousel">
						<img src="assets/images/icons/photos-video.png" alt="Photo Carousel" class="pull-sm-left">
						<figcaption class="media-caption">
							<h5>Photo Carousel</h5>
							Build a scrolling photo carousel with a link
						</figcaption>
					</figure>
				</div>
				<div class="col-sm-6">
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

		<?php
			$linkedin_content_style = '';
			if(strtolower($post_details->outlet_constant) == 'linkedin')
			{
				$linkedin_content_style = 'display: block;';
			}
		?>
		<div id="linkedinPostFields" class="hidden form-group extra-outlet-fields" style="<?php echo $linkedin_content_style; ?> ">
			<label for="shareWithLinkedin">Share with:</label>
			<select class="form-control" name="shareWithLinkedin" id="shareWithLinkedin">
				<option value="public" <?php if($post_details->share_with == 'public') { echo 'selected="selected"'; } ?>>Public</option>
				<option value="group 2" <?php if($post_details->share_with == 'group 2') { echo 'selected="selected"'; } ?>>Group 2</option>
			</select>
		</div>

		<?php
			$pinterest_content_style = '';
			if(strtolower($post_details->outlet_constant) == 'pinterest')
			{
				$pinterest_content_style = 'display: block;';
			}
		?>
		<div id="pinterestPostFields" class="hidden form-group extra-outlet-fields" style="<?php echo $pinterest_content_style; ?>">
			<div class="form-group">
				<label for="pinterestBoard">Board:</label>
				<select class="form-control" name="pinterestBoard" id="pinterestBoard">
					<option value="">Select Board</option>
						<option value="board name" <?php if($post_details->pinterest_board == 'board name') { echo 'selected="selected"'; } ?>>Board Name</option>
						<option value="board name 2" <?php if($post_details->pinterest_board == 'board name 2') { echo 'selected="selected"'; } ?>>Board Name 2</option>
				</select>
				<label id="pinterest_bord_error" class="pinterest_error error hide"></label>
			</div>
			<div class="form-group">
				<label for="pinSource">Source (Optional):</label>
				<input type="url" placeholder="http://" class="form-control" name="pinSource" id="pinSource" value="<?php echo $post_details->pinterest_source; ?>">
			</div>
		</div>

		<?php
			$youtube_content_style = '';
			if(strtolower($post_details->outlet_constant) == 'youtube')
			{
				$youtube_content_style = 'display: block;';
			}
		?>
		<div id="youtubePostFields" class="hidden form-group extra-outlet-fields" style="<?php echo $youtube_content_style; ?>">
			<label for="ytVideoTitle">Video Title:</label>
			<input type="text" placeholder="Title Here" class="form-control" name="ytVideoTitle" id="ytVideoTitle" value="<?php echo $post_details->video_title; ?>">
			<label id="youtube_title_error" class="youtube_error error hide"></label>					
		</div>

		<?php $this->load->view('partials/tumblr_post_types'); ?>
		
		<div class="clearfix">
			<div class="pull-sm-left">
				<label>Slate Post:</label>
				<div class="slate-post clearfix">
					<div class="form-group form-inline pull-sm-left">
						<div class="hide-top-bx-shadow">
							<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="#edit-post-details" value="<?php echo !empty($post_details->slate_date_time) ? date('m/d/Y' , strtotime($post_details->slate_date_time)) : ''; ?>" >
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<div class="pull-xs-left">
							<label class="hidden">Post Time</label>
							<div class="time-select form-control slate-time-div">
								<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH" value="<?php echo date('h' , strtotime($post_details->slate_date_time)); ?>">
								<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM" value="<?php echo date('i' , strtotime($post_details->slate_date_time)); ?>">
								<input type="text" class="time-input amselect" name="post-ampm"  value="<?php echo date('A' , strtotime($post_details->slate_date_time)); ?>">
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
						<?php 
						foreach ($timezones as $key => $obj) {
							$selected_tz = '';
							if(!empty($post_details->time_zone))
							{
								if( $obj->value == $post_details->time_zone ){
									$selected_tz = 'selected="selected"';
								}
							}
							else
							{
								if( $obj->value == $this->user_data['timezone'])
								{
									$selected_tz = 'selected = "selected"';
								}
							}
							?>
							<option <?php echo $selected_tz ;?> data-abbreviation="<?php echo $obj->abbreviation; ?>" value="<?php echo $obj->value; ?>"><?php echo $obj->timezone; ?></option>
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
					<div class="hide-top-bx-shadow">
						<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/selected_tag_list/'.$post_details->brand_id.'/'.$post_details->id; ?>" data-title="Select all that apply:" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-popover-container="#edit-post-details">
							<?php
							$style = ''; 
							if(!empty($selected_tags)){
								$style = ' style="display: none;" ';
								foreach ($selected_tags as $stag) {
									?>
									<i style="color:<?php echo $stag['tag_color']; ?>" data-tag="<?php echo $stag['id']; ?>" class="fa fa-circle"><input type="checkbox" value="<?php echo $stag['id']; ?>" name="post_tag[]" class="hidden-xs-up" checked="checked"></i>
									<?php
									}
							}
							?>
							<i class="fa fa-circle color-gray-lighter"  <?php echo $style; ?>></i> | <i class="fa fa-caret-down color-black"></i>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<footer class="post-content-footer">
			<div class="auto-save text-xs-center hidden">Auto Saving ...</div>
		</footer>
	</div>			
</div>