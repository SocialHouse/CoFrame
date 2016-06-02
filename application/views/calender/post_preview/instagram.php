<div id="outlet_3">
	<div class="insta-post-div">
		<div class="insta-profile-div">
			<div class="pull-left">
				<?php 
					if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
                    	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png" class="img-circle insta-profile" />';
                    }else{
                    	echo '<img class="img-circle insta-profile" src="'.img_url().'default_profile.jpg">';	
                    }
				?>
			</div>
			<div class="margin-left-5 insta-username pull-left"><b><?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?></b></div>
			<div class="pull-right insta-time insta-username">0m</div>
		</div>
		<div class="clearfix"></div>

		<div class="insta-img-div">
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
		
		<div class="insta-post-copy">
			<div class="insta-comment-div">
				<span class="insta-comment-user-name"><?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?> </span>
				<span class="post_copy_text"><?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?></span>
			</div>
		</div>
		<div class="insta-add-comment">
			<i class="fa fa-heart-o" aria-hidden="true"></i><span class="margin-left-5 ">Add a comment...</span>
		</div>
	</div>
</div>