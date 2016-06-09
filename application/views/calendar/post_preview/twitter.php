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
<div id="outlet_2">
	<div class="twitter-post">
		<div class="pull-left" style="margin-right: 8px">
			<?php 
				if (file_exists(upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png')) {
                	echo '<img src="'.upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png" class="center-block" />';
                }else{
                	echo '<img class="twitter-default-img" src="'.img_url().'default_profile_twitter.png">';	
                }
			?>
		</div>
		<div  style="margin-bottom:2px">
			<div >
				<div class="twitter-user-info">
					<?php echo (!empty($post_details->user))? $post_details->user :''; ?> 
					<span class="twitter_username">@ninadgaikwad - 1s</span>
				</div>
			</div>
			<div class="post_copy_text">
				<?php echo (!empty($post_details->content)) ? $post_details->content : '';?>
			</div>
			<div class="twitter-img-div twitter-post-img img-div" style="margin-left:40px;">
				<?php 
					$i = 1;
					$more_div = '';
					if(!empty($post_images)){
						if($img_count == 1 ){
							if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$post_images[0]->name)){
								echo '<div class="pull-left">';
	                        		echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $post_images[0]->name.'"  class="img-radious" />';
	                        	echo '</div>';
	                        }
						}
						if($img_count == 2 ){
							foreach ($post_images as $key) {
								if($i == 0) {
									$type = 'left' ;
								}else{
									$type = 'right' ;
								}

								echo '<div class="pull-'.$type.'  width_50">';
								if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
	                            	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class=" height_135 img-radious-'.$type.'" />';
	                            }else{
	                            	echo '<img src="'.img_url().'default_profile.jpg" class=" height_135 img-radious-'.$type.'" />';	
	                            }
	                        	echo '</div>';
	                        	$i++;
							}
						}
						if($img_count == 3){
							$i = 1;
							foreach ($post_images as $key) {
								if($i == 1) {
									echo '<div class="pull-left section1" >';
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="height_135 img-radious-left" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="height_135 img-radious-left" />';	
	                                }
	                        		echo '</div>';
	                        		echo '<div class="pull-left width_50 section2">';
								}
								if($i == 2) {
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="img-radious-right-top width_30 section_2_img padding_bottom" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="img-radious-right-top width_30 section_2_img padding_bottom"  />';	
	                                }
								}
								if($i == 3) {
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="width_30 section_2_img img-radious-right-bottom" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_2_img img-radious-right-bottom"  />';	
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
									echo '<div class="pull-left section1" style="width: 75%;" >';

									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="height_135 img-radious-left" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="height_135 img-radious-left"  />';	
	                                }	
	                        		echo '</div>';
	                        		echo '<div class="pull-left width_50 section2" style="width: 25%;" > ';
								}
								if($i == 2) {
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="width_30 section_3_img padding_bottom" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_3_img padding_bottom"  />';	
	                                }
								}
								if($i == 3) {
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="width_30 section_3_img padding_bottom" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_3_img padding_bottom"  />';	
	                                }
								}
								if($i == 4 ) {
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"  class="width_30 section_3_img" />';
	                                }else{
	                                	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_3_img"  />';	
	                                }
								}
	                        	$i++;
							}
						echo '</div>';
						}
					}
				?>
			</div>
			<div class="clearfix"></div>
			<div class="twitter-bottom-div" style="margin-left:40px;">
				<div class="pull-left">
					<i class="fa fa-mail-reply"></i>
					<span></span>
				</div>
				<div class="pull-left margin-left-15">
					<i class="fa fa-refresh"></i>
				</div>
				<div class="pull-left margin-left-15">
					<i class="fa fa-heart"></i>
				</div>
				<div class="pull-left margin-left-15">
					<i class="fa fa-ellipsis-h"></i>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>