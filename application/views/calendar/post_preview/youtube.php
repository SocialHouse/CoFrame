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
		<?php
			if(!empty($post_images)){
				foreach ($post_images as $key) {
					if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
						if ($key->type == 'video') {
							echo '<video autobuffer autoloop loop controls width="100%" >
								<source src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'">
								<object type="'.$key->mime.'">
									<param name="src" value="/media/video.oga">
									<param name="autoplay" value="false">
									<param name="autoStart" value="0">
									<p><a href="/media/video.oga">Download this video file.</a></p>
								</object>
							</video>';
							break;
						}
                    }
				}
			}
		?>

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
