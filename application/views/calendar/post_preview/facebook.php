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
<div id="facebook" class="fb_post">
	<div class="post-container">
		<div class="clearfix">
			<div class="pull-left">
				<?php 
					if (file_exists(upload_url().$this->user_data['account_id'].'/users/'.$post_details->user_id.'.png')) {
                       	echo '<img src="'.upload_url().$this->user_data['account_id'].'/users/'.$post_details->user_id.'.png" alt="" class="user-profile-img" />';
                       }else{
                       	echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg">';	
                       }
				?>
			</div>
			<div class="user-profile-details">
				<span class="post-user-name">
					<?php echo (!empty($post_details->user))? $post_details->user :''; ?>
					<span class="no-of-photos">added <span class="photos_count"><?php echo $img_count; ?> new photo<?php if($img_count > 1) echo 's';?></span></span>
				</span>
				<span class="time-color">
					Just now
				</span>
			</div>
		</div>
		<span class="post_copy_text">
			<?php 
				$content =$post_details->content;
				$content = replace_with_expression($content);
				echo (!empty($content)) ? $content : '';
			?>
		</span>
		<div class="img-div">
			<?php 
				$i = 0;
				$more_txt = '';
				if(!empty($post_images)){
					$cls = '';
					foreach ($post_images as $key) {
						if($img_count == 2 ){
							echo '<div class="width_50 img-item"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" /></div>';
						}
						else if($img_count == 3 ){
							if($i < 1){
								if($key->type == 'images'){
									echo '<div class="img-wrapper section1">';
                               		echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"/>';
                               		echo '</div>';
                               	}
							}else{
								if($key->type == 'images'){
									//echo 'I : '.$i;
									if($i == 1){
										echo '<div class="img-wrapper section2">';
									}
									echo '<div class="width_50 img-item"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" /></div>';
									if($i == 2){
										echo '</div>';	
									}
                               	}
							}
						}
						else if($img_count == 4 ){
							if($i < 1){
								if($key->type == 'images'){
									echo '<div class="img-wrapper section1">';
                               		echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"/>';
                               		echo '</div>';
                               	}
							}else{
								if($key->type == 'images'){
									if($i == 1){
										echo '<div class="img-wrapper section2">';
									}
									echo '<div class="width_33 img-item"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" /></div>';
									if($i == 3){
										echo '</div>';
									}
                               	}
							}
						}
						else if($img_count > 4 ){
							if($i < 1){
								if($key->type == 'images'){
									echo '<div class="img-wrapper section1">';
                               		echo '<div class="width_50 img-item"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"/></div>';
                               	}
							}elseif($i==1){
								echo '<div class="width_50 img-item"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"/></div>';
								echo '</div>';								
							}elseif($i>1 && $i < 5){
								if($key->type == 'images'){
									//echo 'I : '.$i;
									if($i == 2){
										echo '<div class="img-wrapper section2">';
									}
									echo '<div class="width_33 img-item"><img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'" />';
										if($img_count > 5 && $i ==4 ){
											$img_more  = $img_count - 5;
											echo '<div class="more-images"><span class="vertical-center">+'.$img_more.'</span></div>';
										}
									echo '</div>';
									if($i == 4){
										echo '</div>';	
									}
                               	}
							}
						}
						else if($i < 5 && $img_count !==3 ){
							if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
								if($key->type == 'images'){
                               		echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"class="'. $cls .'" />';
                               	}elseif ($key->type == 'video') {
									echo '<video autobuffer autoloop loop controls width="100%" class="'. $cls .'" >
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
						$i ++;
					}	
				}
			?>
		</div>	
	</div>
</div>