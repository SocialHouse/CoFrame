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