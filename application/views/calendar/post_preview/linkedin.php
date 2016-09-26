<?php 
if(!empty($post_images)){
		$img_count = count($post_images);
	}else{
		$img_count = '';
	}
	if(!empty($post_details)){
		$outlet_name = $post_details->outlet_name;
		$brand_onwer = $this->user_data['account_id'];
		$brand_id = $post_details->brand_id;
	}
?>
<div class="linkedin-post in_post">
	<div class="post-container">
		<div class="clearfix" >
			<div class="pull-left">
				<img src="<?php echo img_url(); ?>default_profile_linkedin.png" class="user-profile-img">
			</div>
			<div class="user-profile-details">
				<div class="post-header">
					<div class="post-user-name pull-left"><?php echo get_company_name($this->user_data['account_id']); ?></div>
					<span class="time-color pull-right">0s</span>
				</div>
				<div class="post_copy_text">
					<?php 
						$content = $post_details->content;
						$content = replace_with_expression($content);
						echo (!empty($content)) ? $content : '';
					?>
				</div>
				<div class="likedin-img-div img-div">
					<?php
						if(!empty($post_images)){
							$folder = 'posts';
							if(isset($is_cocreate) AND !empty($is_cocreate))
							{
								$folder = 'posts/co_create';
							}
							foreach ($post_images as $key) {
								if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'.$key->name)) {
									if($key->type  == 'images' ){
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'. $key->name.'"	/>';
										break;
									}elseif ($key->type == 'video') {
										echo '<video autobuffer autoloop loop controls width="100%" >
											<source src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'. $key->name.'">
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
			</div>
		</div>
	</div>
</div>