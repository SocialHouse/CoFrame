<?php 
if(!empty($post_images)){
		$img_count = count($post_images);
	}else{
		$img_count = '';
	}
	if(!empty($post_deatils)){
		$outlet_name = $post_deatils->outlet_name;
		$brand_onwer = $post_deatils->created_by;
		$brand_id = $post_deatils->brand_id;
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
				<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
			</div>
			<div class="youtube-sharing-option">
				<span>21 views</span>
				<span>1 week ago</span>
			</div>
			
		</div>
	</div>
</div>
