<div class="linkedin-post" >
	<div class="linkedin-profile">
		<img src="<?php echo img_url(); ?>default_profile_linkedin.png">
	</div>
	<div class="linkedin-content">
		<div class="linkedin-user-detail">
			<span><?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?></span>
			<p>Software Developer at Techfive</p>
		</div>
		<div class="post_copy_text">
			<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
		</div>
		<div class="likedin-img-div">
			<?php
				if(!empty($post_images)){
					foreach ($post_images as $key) {
						if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
	                    	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"	/>';
	                    	break;
	                    }
					}
				}
			?>
		</div>
		<ul class="actions">
			<li>like</li>
			<li>Comment</li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>