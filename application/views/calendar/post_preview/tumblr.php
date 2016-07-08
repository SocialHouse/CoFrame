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
<div class="tumblr-post" class="tb_post clearfix">
	<div class="pull-left">
		<?php 
			if (file_exists(upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png')) {
	           	echo '<img src="'.upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png"class="default-img img-circle" />';
	           }else{
	           	echo '<img class="default-img reblog-avatar-image-thumb" src="'.img_url().'default_profile.jpg" width="40">';	
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
