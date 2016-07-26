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
<div class="tumblr-post tb_post">
	<div class="post-container clearfix">
		<div class="pull-left">
			<?php 
				if (file_exists(upload_url().$this->user_data['account_id'].'/users/'.$post_details->user_id.'.png')) {
					echo '<img src="'.upload_url().$this->user_data['account_id'].'/users/'.$post_details->user_id.'.png" class="user-profile-img" />';
				   }else{
					echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg" width="40">';	
				}
			?>
		</div>
		<div class="post-details">
			<div class="post-user-name">
				Tragic Tofu
			</div>
			<div class="img-div">
				<?php
					if(!empty($post_images)){
						foreach ($post_images as $key) {
							if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
								if($key->type =='images'){
									echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"	/>';
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
			<div class="post_copy_text">
				<?php 
					$content = $post_details->content;
					$content = replace_with_expression($content);
					echo (!empty($content)) ? $content : '';
				?>
			</div>
		</div>
	</div>
</div>
