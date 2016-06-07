<?php 
if(!empty($post_images)){
		$img_count = count($post_images);
	}else{
		$img_count = '';
	}
	if(!empty($post_details)){
		$outlet_name = $post_details->outlet_name;
		$brand_onwer = $post_details->created_by;
		$brand_id = $post_details->brand_id;
	}
?>
<div class="youtube-post" style="width:100%">
	<div class="clearfix"></div>
	<div class="content">
		<video autobuffer autoloop loop ontrols="true" width="100%">
			<source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4">
		</video>

		<div class="youtube-comment-div">
			<div class="post_copy_text">
				<?php echo (!empty($post_details->content)) ? $post_details->content : '';?>
			</div>
			<div class="youtube-sharing-option">
				<span>21 views</span>
				<span>1 week ago</span>
			</div>
			
		</div>
	</div>
</div>
