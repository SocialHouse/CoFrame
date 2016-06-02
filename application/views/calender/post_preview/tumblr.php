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
<div class="tumblr-post" style="width:100%">
	<div>	
		<div class="tumblr-title" >
			Here's a blog: psych-facts
		</div>
		<div class="tumblr-img-div">
			<?php
				if(!empty($post_images)){
					foreach ($post_images as $key) {
						if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
	                    	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"	/>';
	                    }
					}
				}
			?>
		</div>
		<div class="tumblr-user">
			<div class="tumblr-user-profile" >
				<?php 
					if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
		            	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png"class="default-img img-circle" />';
		            }else{
		            	echo '<img class="default-img reblog-avatar-image-thumb" src="'.img_url().'default_profile.jpg" width="40">';	
		            }
				?>
			</div>
			<div class="tumblr-user-info" >
				<span>Tragic Tofu</span>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="content">
			<div class="tumblr-comment-div">
				<div class="post_copy_text">
					<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
				</div>
				<div class="tumblr-sharing-option">
					<span >654 notes</span>
					<div class="pull-right">
						<i class="fa fa-heart" aria-hidden="true"></i>
						<i class="fa fa-refresh" aria-hidden="true"></i>
						<i class="fa fa-share-square-o" aria-hidden="true"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
