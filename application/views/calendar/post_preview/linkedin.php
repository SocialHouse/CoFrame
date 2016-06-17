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
<div class="linkedin-post" >
	<div class="linkedin-profile">
		<img src="<?php echo img_url(); ?>default_profile_linkedin.png">
	</div>
	<div class="linkedin-content">
		<div class="linkedin-user-detail">
			<span><?php echo (!empty($post_details->user))? $post_details->user :''; ?></span>
			<p>Software Developer at Techfive</p>
		</div>
		<div class="post_copy_text">
			<?php echo (!empty($post_details->content)) ? $post_details->content : '';?>
		</div>
		<div class="likedin-img-div">
			<?php
				if(!empty($post_images)){
					foreach ($post_images as $key) {
						if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
							if($key->type  == 'images' ){
		                    	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"	/>';
		                    	break;
	                    	}elseif ($key->type == 'video') {
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
		</div>
		<ul class="actions">
			<li>like</li>
			<li>Comment</li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>