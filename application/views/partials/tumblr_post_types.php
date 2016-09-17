<!--All of the Tumblr things, should probably move to a separate file-->
<!-- Tumblr Text Post -->
<?php
$text_style = '';
$photo_style = '';
$quote_style = '';
$link_style = '';
$chat_style = '';
$audio_style = '';
$video_style = '';
if(isset($post_details))
{	
	switch ($post_details->tumblr_content_type) {
		case 'Text':
			$text_style = 'display: block;';
			break;
		case 'Photo':
			$photo_style = 'display: block;';
			break;
		case 'Quote':
			$quote_style = 'display: block;';
			break;
		case 'Link':
			$link_style = 'display: block;';
			break;
		case 'Chat':
			$chat_style = 'display: block;';
			break;
		case 'Audio':
			$audio_style = 'display: block;';
			break;
		case 'Video':
			$video_style = 'display: block;';
			break;
	}

}
?>
<div id="tumblrTextPost" class="hidden form-group extra-outlet-fields extra-tb-fields" style="<?php echo $text_style; ?>" >
	<div class="form-group">
		<label for="tb_text_title">Title (Optional):</label>
		<input type="text" placeholder="Post Title" class="form-control" name="tb_text_title" id="tb_text_title" value="<?php if(!empty($text_style) AND !empty($post_details)) { echo $post_details->tumblr_title; } ?>">
	</div>
	<div class="form-group">
		<label for="tumblrPostCopy">Post Copy</label>
		<textarea class="form-control" id="tumblrPostCopy" rows="5" placeholder="Type your copy here..." name="tumblr_post_copy"><?php if(!empty($text_style) AND !empty($post_details)) { echo $post_details->tumblr_text_content; } ?></textarea>
		<label id="tb_text_error" class="tumblr_error error hide"></label>
	</div>
	<div class="form-group">
		<label for="tb_text_tags">#Tags (Optional):</label>
		<input type="text" placeholder="#tags" class="form-control tb_tags" name="tb_text_tags" id="tb_text_tags" value="<?php if(!empty($text_style) AND !empty($post_details)) { echo $post_details->tumblr_tags; } ?>">
	</div>
	<div class="form-group">
		<label for="tbUrl">Custom URL (Optional):</label>
		<input type="text" placeholder="/post/123/" class="form-control" name="tb_text_url" id="tbUrl" value="<?php if(empty(!$text_style) AND !empty($post_details)) { echo $post_details->tumblr_custom_url; } ?>">
	</div>
</div>

<!-- Tumblr Photo Post -->
<div id="tumblrPhotoPost" class="hidden form-group extra-outlet-fields extra-tb-fields"  style="<?php echo $photo_style; ?>" >
	<!-- <div class="form-group">
		<label>Photo(s): <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Images (jpg,gif,png) should be less than 2MB in size, and videos (.mp4) should be less than 100MB in size." data-popover-arrow="true"></i></label>
	</div> -->
	<div class="form-group">
		<label for="tbCaption">Caption (Optional):</label>
		<input type="text" placeholder="Photo Caption" class="form-control" name="tbCaption" id="tbCaption" value="<?php if(!empty($photo_style) AND !empty($post_details)) { echo $post_details->tumblr_caption; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_photo_tags">#Tags (Optional):</label>
		<input type="text" placeholder="#tags" class="form-control tb_tags" name="tb_photo_tags" id="tb_photo_tags" value="<?php if(!empty($photo_style) AND !empty($post_details)) { echo $post_details->tumblr_tags; } ?>">
	</div>
	<div class="form-group">
		<label for="tbPhotoSource">Content Source (Optional):</label>
		<input type="url" placeholder="http://" class="form-control" name="tbPhotoSource" id="tbPhotoSource" value="<?php if(!empty($photo_style) AND !empty($post_details)) { echo $post_details->tumblr_content_source; } ?>">
		<label id="tb_photo_error" class="tumblr_error error hide"></label>
	</div>
</div>

<!-- Tumblr Quote Post -->
<div id="tumblrQuotePost" class="hidden form-group extra-outlet-fields extra-tb-fields" style="<?php echo $quote_style; ?>" >
	<div class="form-group">
		<label for="tumblrQuoteCopy ">Quote</label>
		<textarea class="form-control" id="tumblrQuoteCopy" rows="5" placeholder="Type quote here..." name="tumblr_quote_post_copy"><?php if(!empty($quote_style) AND !empty($post_details)) { echo $post_details->tumblr_quote; } ?></textarea>
		<label id="tb_quote_error" class="tumblr_error error hide"></label>
	</div>
	<div class="form-group">
		<label for="tbSource">Source (Optional):</label>
		<input type="text" placeholder="Source" class="form-control" name="tbSource" id="tbSource" value="<?php if(!empty($quote_style) AND !empty($post_details)) { echo $post_details->tumblr_source; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_quote_tags">#Tags (Optional):</label>
		<input type="text" placeholder="#tags" class="form-control tb_tags" name="tb_quote_tags" id="tb_quote_tags" value="<?php if(!empty($quote_style) AND !empty($post_details)) { echo $post_details->tumblr_tags; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_quote_url">Custom URL (Optional):</label>
		<input type="text" placeholder="/post/123/" class="form-control" name="tb_quote_url" id="tb_quote_url" value="<?php if(!empty($quote_style) AND !empty($post_details)) { echo $post_details->tumblr_custom_url; } ?>">
	</div>
</div>

<!-- Tumblr Link Post -->
<div id="tumblrLinkPost" class="hidden form-group extra-outlet-fields extra-tb-fields" style="<?php echo $link_style; ?>" >
	<div class="form-group">
		<label for="tbLink">Link:</label>
		<input type="url" placeholder="Type or paste a URL..." class="form-control" name="tbLink" id="tbLink" value="<?php if(!empty($link_style) AND !empty($post_details)) { echo $post_details->tumblr_link; } ?>">
		<label id="tb_link_error" class="tumblr_error error hide"></label>
	</div>
	<div class="form-group">
		<label>Change Thumbnail (Optional):</label>
		<!--Upload field here-->
	</div>
	<div class="form-group">
		<label for="tbLinkDesc">Description (Optional):</label>
		<input type="text" placeholder="Type description here..." class="form-control" name="tbLinkDesc" id="tbLinkDesc" value="<?php if(!empty($link_style) AND !empty($post_details)) { echo $post_details->tumblr_link_description; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_link_url">Custom URL (Optional):</label>
		<input type="text" placeholder="/post/123/" class="form-control" name="tb_link_url" id="tb_link_url" value="<?php if(!empty($link_style) AND !empty($post_details)) { echo $post_details->tumblr_custom_url; } ?>">
	</div>
</div>

<!-- Tumblr Chat Post -->
<div id="tumblrChatPost" class="hidden form-group extra-outlet-fields extra-tb-fields" style="<?php echo $chat_style; ?>" >
	<div class="form-group">
		<label for="tb_chat_title">Title (Optional):</label>
		<input type="text" placeholder="Chat Title" class="form-control" name="tb_chat_title" id="tb_chat_title" value="<?php if(!empty($chat_style) AND !empty($post_details)) { echo $post_details->tumblr_chat_title; } ?>">
	</div>
	<div class="form-group">
		<label for="tumblrChatCopy">Chat</label>
		<textarea class="form-control" id="tumblrChatCopy" rows="5" placeholder="Type chat here..." name="tumblr_chat_post_copy"><?php if(!empty($chat_style) AND !empty($post_details)) { echo $post_details->tumblr_chat; } ?></textarea>
		<label id="tb_chat_error" class="tumblr_error error hide"></label>
	</div>
	<div class="form-group">
		<label for="tb_chat_tags">#Tags (Optional):</label>
		<input type="text" placeholder="#tags" class="form-control tb_tags" name="tb_chat_tags" id="tb_chat_tags" value="<?php if(!empty($chat_style) AND !empty($post_details)) { echo $post_details->tumblr_tags; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_chat_url">Custom URL (Optional):</label>
		<input type="text" placeholder="/post/123/" class="form-control" name="tb_chat_url" id="tb_chat_url" value="<?php if(empty($chat_style) AND !empty($post_details)) { echo $post_details->tumblr_custom_url; } ?>">
	</div>
</div>

<!-- Tumblr Audio Post -->
<div id="tumblrAudioPost" class="hidden form-group extra-outlet-fields extra-tb-fields" style="<?php echo $audio_style; ?>" >
	<div class="form-group">
		<label for="tbAudio">Audio:</label>
		<!--File upload here-->
	</div>
	<div class="form-group">
		<label for="tbAudioDescr">Description (Optional):</label>
		<input type="text" placeholder="Type description here..." class="form-control" name="tbAudioDescr" id="tbAudioDescr" value="<?php if(!empty($audio_style) AND !empty($post_details)) { echo $post_details->tumblr_audio_description; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_audio_tags">#Tags (Optional):</label>
		<input type="text" placeholder="#tags" class="form-control tb_tags" name="tb_audio_tags" id="tb_audio_tags" value="<?php if(!empty($audio_style) AND !empty($post_details)) { echo $post_details->tumblr_tags; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_audio_url">Custom URL (Optional):</label>
		<input type="text" placeholder="/post/123/" class="form-control" name="tb_audio_url" id="tb_audio_url" value="<?php if(!empty($audio_style) AND !empty($post_details)) { echo $post_details->tumblr_custom_url; } ?>">
		<label id="tb_audio_error" class="tumblr_error error hide"></label>
	</div>
</div>

<!-- Tumblr Video Post -->
<div id="tumblrVideoPost" class="hidden form-group extra-outlet-fields extra-tb-fields" style="<?php echo $video_style; ?>" >
	<!-- <div class="form-group">
		<label for="tbAudio">Video:</label>
	</div> -->
	<div class="form-group">
		<label for="tbVideoDescr">Caption (Optional):</label>
		<input type="text" placeholder="Video Caption" class="form-control" name="tbVideoDescr" id="tbVideoDescr" value="<?php if(!empty($video_style) AND !empty($post_details)) { echo $post_details->tumblr_video_caption; } ?>">
	</div>
	<div class="form-group">
		<label for="tb_video_tags">#Tags (Optional):</label>
		<input type="text" placeholder="#tags" class="form-control tb_tags" name="tb_video_tags" id="tb_video_tags" value="<?php if(!empty($video_style) AND !empty($post_details)) { echo $post_details->tumblr_tags; } ?>">
	</div>
	<div class="form-group">
		<label for="tbVideoSource">Content Source (Optional):</label>
		<input type="url" placeholder="http://" class="form-control" name="tbVideoSource" id="tbVideoSource" value="<?php if(!empty($video_style) AND !empty($post_details)) { echo $post_details->tumblr_source; } ?>">
	</div>
	<label id="tb_video_error" class="tumblr_error error hide"></label>
</div>
<!-- End Tumblr things -->