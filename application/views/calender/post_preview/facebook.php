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
<div id="facebook">
	<div class="post-container">
		<div class="padding_5">
			<div class="margin-bottom-10">
				<div class="pull-left user-img-border">
					<?php 
						if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
                        	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png" width="406" height="506" alt="" class="center-block" />';
                        }else{
                        	echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg">';	
                        }
					?>
					
				</div>
				<div class="pull-left padding-left-5">
					<span class="post-user-name">
						<?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?>
						<span class="no-of-photos"></span>
					</span><br/>
					<span class="time-color">
						Just now
					</span>
				</div>
				<div class="clearfix"></div>
				<br>
				<span class="post_copy_text">
					<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
				</span>
				<div class="img-div">
					<?php 

						$i = 0;
						$more_txt = '';
						if(!empty($post_images)){
							foreach ($post_images as $key) {
								$cls = 'center-block';
								if($img_count == 2 ){
									$cls = 'width_50';
								}
								if($img_count == 3 ){
									if($i < 1){
										$cls = 'post-img';
									}else{
										$cls = 'width_50';	
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
								if($i < 5){
									if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
	                                	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"class="'. $cls .'" />';
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
			<div class="bottom-div">
				<div>
					<div class="pull-left"><i class="fa fa-thumbs-up"></i> <span>Like</span>
					</div>
					<div class="pull-left margin-left-15">
						<i class="fa fa-comment-o"></i> Comment
					</div>
					<div class="pull-left margin-left-15">
						<i class="fa fa-share"></i> Share
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>