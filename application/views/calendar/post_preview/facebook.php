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
<div id="facebook" class="fb_post">
	<div class="post-container">
		<div class="clearfix">
			<div class="pull-left">
				<?php 
					if (file_exists(upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png')) {
                       	echo '<img src="'.upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png" alt="" class="user-profile-img" />';
                       }else{
                       	echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg">';	
                       }
				?>
			</div>
			<div class="pull-left">
				<span class="post-user-name">
					<?php echo (!empty($post_details->user))? $post_details->user :''; ?>
					<span class="no-of-photos"></span>
				</span>
				<span class="time-color">
					Just now
				</span>
			</div>
		</div>
		<span class="post_copy_text">
			<?php 
				$content = $post_details->content;
				$content = replace_with_expression($content);
				echo (!empty($content)) ? $content : '';
			?>
		</span>
		<div class="img-div">
			<?php 
				$i = 0;
				$more_txt = '';
				if(!empty($post_images)){
					foreach ($post_images as $key) {
						$cls = '';
						if($img_count == 2 ){
							$cls = 'width_50';
						}
						if($img_count == 3 ){
							if($i < 1){
								$cls = 'width_50';
								if($key->type == 'images'){
									echo '<div class="pull-left section1">';
                               		echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"class="'. $cls .'" style="height: 150px;"/>';
                               		echo '</div>';
                               	}
							}else{
								$cls = 'width_33';
								if($key->type == 'images'){
									//echo 'I : '.$i;
									if($i == 1){
										echo '<div class="pull-left width_50 section2">';
									}
									echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"class="'. $cls .'" />';
									if($i == 2){
										echo '</div>';	
										echo '<div class="clearfix"></div>';
									}
                               	}
							}
						}
						if($img_count == 4 ){
							if($i < 1){
								$cls = 'post-img';
							}else{
								$cls = 'width_33';
							}
						}
						if($img_count > 4 ){
							if($i < 2){
								$cls = 'width_50';
							}else{
								$cls = 'width_33';	
							}
							if($img_count > 5 ){
								$img_more  = $i -4;
								$more_txt = '<div id="5" class="more-images">+'.$img_more.'</div>';
							}
						}
						if($i < 5 && $img_count !==3 ){
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
						}else{
							echo $more_txt ;
						}
							
						$i ++;
					}	
				}
			?>
		</div>	
	</div>
</div>