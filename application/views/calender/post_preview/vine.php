<div class="vine-post" style="width:100%">
	<div style="padding: 8px">
		<div class="vine-user-profile" >
			<?php 
				if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
	            	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png"class="default-img img-circle" />';
	            }else{
	            	echo '<img class="default-img img-circle" src="'.img_url().'default_profile.jpg" width="40">';	
	            }
			?>
		</div>
		<div class="vine-user-info" >
			<div>Tragic Tofu</div>
			<span>May 5, 2016</span>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="content">
		<video autobuffer autoloop loop ontrols="true" width="100%">
			<source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4">
		</video>

		<div class="vine-comment-div">
			<div class="post_copy_text">
				<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
			</div>
			<hr>
			<div class="post-actions">
				<span><i class="fa fa-heart" aria-hidden="true"></i></span>21
				<span><i class="fa fa-refresh" aria-hidden="true"></i></span>32
				<span><i class="fa fa-share-square-o" aria-hidden="true"></i></span>share
				<span class="pull-right">654 Loops</span>
			</div>
			
		</div>
	</div>
</div>
