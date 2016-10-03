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
<div id="outlet_3" class="ig_post">
	<div class="post-container">
		<div class="clearfix post-header">
			<div class="pull-left">
				<?php 
					if (file_exists(upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png')) {
						echo '<img src="'.upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png" class="img-circle user-profile-img" />';
					   }else{
						echo '<img class="img-circle user-profile-img" src="'.img_url().'default_profile.jpg">';	
					}
				?>
			</div>
			<span class="post-user-name pull-left"><?php echo get_company_name($this->user_data['account_id']); ?></span>
			<div class="pull-right time-color">0m</div>
		</div>
	
		<div class="insta-img-div img-div">
			<?php 
				if(!empty($post_images)){
					$class = 1;
					$folder = 'posts';
					if(isset($is_cocreate) AND !empty($is_cocreate))
					{
						$folder = 'posts';
					}
					foreach ($post_images as $key) {

						if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'.$key->name)) {
							if($key->type == 'images'){
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
			
		<div class="insta-post-copy">
			<span class="post-user-name"><?php echo get_company_name($this->user_data['account_id']); ?></span>
			<span class="post_copy_text">
			<?php 
				$content = $post_details->content;
				$content = replace_with_expression(strip_tags($content));
				echo (!empty($content)) ? $content : '';
			?>
			</span>
		</div>
	</div>
</div>