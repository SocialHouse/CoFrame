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
<div class="vine-post" style="width:100%">
	<div style="padding: 8px">
		<div class="vine-user-profile" >
			<?php 
				if (file_exists(upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png')) {
	            	echo '<img src="'.upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png"class="default-img img-circle" />';
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
		<?php
			if(!empty($post_images)){
				foreach ($post_images as $key) {
					if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
						if ($key->type == 'video') {
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
		<div class="vine-comment-div">
			<div class="post_copy_text">
				<?php echo (!empty($post_details->content)) ? $post_details->content : '';?>
			</div>
			<hr>
			<div class="vine-sharing-option">
				<span><i class="fa fa-heart" aria-hidden="true"></i></span>21
				<span><i class="fa fa-refresh" aria-hidden="true"></i></span>32
				<span><i class="fa fa-share-square-o" aria-hidden="true"></i></span>share
				<span class="pull-right">654 Loops</span>
			</div>
			
		</div>
	</div>
</div>
