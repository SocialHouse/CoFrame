<?php 
	if(!empty($post_images)){
		$img_count = count($post_images);
	}else{
		$img_count = '';
	}
	if(!empty($post_details)){
		$outlet_name = $post_details->outlet_name;
		$brand_onwer = $this->user_data['account_id'];
		$brand_id = $post_details->brand_id;
	}
?>
<div class="tumblr-post tb_post">
	<div class="post-container clearfix">
		<div class="pull-left">
			<?php 
				if (file_exists(upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png')) {
					echo '<img src="'.upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png" class="user-profile-img" />';
				   }else{
					echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg" width="40">';	
				}
			?>
		</div>
		<div class="post-details">
			<div class="post-user-name">
				<?php echo get_company_name($this->user_data['account_id']); ?>
			</div>
			<div class="img-div">
				<?php
					if(!empty($post_images)){
						$folder = 'posts';
						if(isset($is_cocreate) AND !empty($is_cocreate))
						{
							$folder = 'posts';
						}
						foreach ($post_images as $key) {
							if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'.$key->name)) {
								if($key->type =='images'){
									echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'. $key->name.'"	/>';
								}elseif ($key->type == 'video') {
									echo '<video autobuffer autoloop loop controls width="100%" >
										<source src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'. $key->name.'">
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
			<?php 
			$title = '';
			$custom_class ='';
			if(!empty($post_details->tumblr_content_type))
			{
				if($post_details->tumblr_content_type == 'Photo')
				{
					$title = $post_details->tumblr_caption;
				}
				else if($post_details->tumblr_content_type == 'Text')
				{
					$title = $post_details->tumblr_title;
				}
				else if($post_details->tumblr_content_type == 'Quote')
				{
					$title = $post_details->tumblr_quote;
				}
				else if($post_details->tumblr_content_type == 'Link')
				{
					$title = $post_details->tumblr_custom_url;
				}
				else if($post_details->tumblr_content_type == 'chat')
				{
					$title = $post_details->tumblr_chat_title;
				}
				else if($post_details->tumblr_content_type == 'Video')
				{
					$title = $post_details->tumblr_video_caption;
				}
			}
			?>
			<div class="post-title">
			<?php 
			if(!empty($title))
			{
				echo read_more(nl2br(strip_tags($title)), 100);
			}
			?>
			</div>
			<?php 
			$link_class ='';
			if($post_details->tumblr_content_type == "Link" && !empty($post_details->tumblr_link)){
				$link_class = 'link-url';
			}
			?>
			<div class="link <?php echo $link_class; ?>"> <a href="<?php echo $post_details->tumblr_link;?>"><?php echo $post_details->tumblr_link;?></a></div>
			<div class="source"></div>			
			<div class="post_copy_text">
				<?php 
					$content = $post_details->content;
					$content = replace_with_expression($content);
					echo (!empty($content)) ? $content : '';
				?>
			</div>
			<div class="tags"><?php echo (!empty($post_details->tumblr_tags))? $post_details->tumblr_tags : '';?></div>
		</div>
	</div>
</div>
