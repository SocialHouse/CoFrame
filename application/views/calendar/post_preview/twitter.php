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
<div id="outlet_2" class="tw_post">
	<div class="post-container">
		<div class="clearfix">
			<div class="pull-left user-profile-img">
				<?php 
					if (file_exists(upload_url().$this->user_data['account_id'].'/users/'.$post_details->user_id.'.png')) {
						echo '<img src="'.upload_url().$this->user_data['account_id'].'/users/'.$post_details->user_id.'.png" />';
					   }else{
						echo '<img src="'.img_url().'default_profile_twitter.png">';	
					   }
				?>
			</div>
			<div class="user-profile-details">
				<div class="post-user-name">
					<?php echo (!empty($post_details->user))? $post_details->user :''; ?> 
					<span class="time-color"></span>
				</div>
				<div class="post_copy_text">
					<?php 
					$content = $post_details->content;
					$content = replace_with_expression($content);
					echo (!empty($content)) ? $content : '';
					?>
				</div>
				<div class="twitter-img-div img-div">
					<?php 
						$i = 1;
						$more_div = '';
						if(!empty($post_images)){
							if($img_count == 1 && $post_images[0]->type == 'video'){
								echo '<video autobuffer autoloop loop controls width="100%" >
									<source src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $post_images[0]->name.'">
										<object type="'.$post_images[0]->mime.'">
											<param name="src" value="/media/video.oga">
											<param name="autoplay" value="false">
											<param name="autoStart" value="0">
											<p><a href="/media/video.oga">Download this video file.</a></p>
										</object>
									</video>';
							}
							if($img_count == 1 && $post_images[0]->type == 'images'){
								if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$post_images[0]->name)){
									echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $post_images[0]->name.'" />';
								}
							}
							if($img_count == 2 ){
								foreach ($post_images as $key) {					
									echo '<div class="width_50 img-item">';
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" />';
									}else{
										echo '<img src="'.img_url().'default_profile.jpg" />';	
									}
									echo '</div>';
									$i++;
								}
							}
							if($img_count == 3){
								$i = 1;
								foreach ($post_images as $key) {
									if($i == 1) {
										echo '<div class="section1 pull-left width_twothirds" >';
										if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
											echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" />';
										}else{
											echo '<img src="'.img_url().'default_profile.jpg" />';	
										}
										echo '</div>';
										echo '<div class="section2 pull-left img-wrapper width_33">';
									}
									else {
										if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
											echo '<div class="img-wrapper height_50"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" /></div>';
										}else{
											echo '<div class="img-wrapper height_50"><img src="'.img_url().'default_profile.jpg" /></div>';	
										}
									}
									$i++;
								}
								echo '</div>';
							}
							if($img_count > 3){
								$i = 1;
								foreach ($post_images as $key) {
									if($i == 1) {
										echo '<div class="section1 pull-left width_twothirds">';
	
										if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
											echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" />';
										}else{
											echo '<img src="'.img_url().'default_profile.jpg" />';	
										}	
										echo '</div>';
										echo '<div class="section2 pull-left img-wrapper width_33"> ';
									}
									else {
										if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
											echo '<div class="img-wrapper height_33"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" /></div>';
										}else{
											echo '<div class="img-wrapper height_33"><img src="'.img_url().'default_profile.jpg" /></div>';	
										}
									}
									$i++;
								}
							echo '</div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>