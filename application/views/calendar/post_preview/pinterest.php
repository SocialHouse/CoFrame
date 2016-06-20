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
<div class="pinterest-post" style="width:100%">
	
	<div class="clearfix"></div>
	<div class="content">
		<div class="pinterest-img-div">
			<?php
			if(!empty($post_images)){
				foreach ($post_images as $key) {
					if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$key->name)) {
						if($key->type  == 'images' ){
							echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $key->name.'"	/>';
							break;
						}
					}
				}
			}
			?>
		</div>
		<div style="border-radius: 15px; border-color: #777;">
			<div class="pinterest-comment-div">
				<p class="post_copy_text">
					<?php echo (!empty($post_details->content)) ? $post_details->content : '';?>
				</p>
			</div>
			<div class="pinterest-sharing-option">
				<i class="fa fa-thumb-tack" aria-hidden="true"></i>
				<i class="fa fa-thumb-tack fa-rotate-180" aria-hidden="true"></i>&nbsp;4.5k
				<i class="fa fa-heart" aria-hidden="true"></i>&nbsp;969
			</div>
			<div class="pull-left">
				<?php 
					if (file_exists(upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png')) {
	                	echo '<img src="'.upload_url().$post_details->created_by.'/users/'.$post_details->user_id.'.png"class="default-img img-circle" />';
	                }else{
	                	echo '<img class="default-img img-circle" src="'.img_url().'default_profile.jpg" width="40">';	
	                }
				?>	
				
			</div>
			<div class="clearfix pinterest-userinfo ">
					<div class="creditTitle">Saved by</div>
					<div  class="creditTitle"><?php echo (!empty($post_details->user))? $post_details->user :''; ?> </div>				
			</div>
			
		</div>
			
	</div>
</div>
