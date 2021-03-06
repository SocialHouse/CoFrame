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
<div class="pn_post">
	<div class="post-container">
		<div class="pinterest-img-div img-div">
			<?php
				if(!empty($post_images)){
					$folder = 'posts';
					if(isset($is_cocreate) AND !empty($is_cocreate))
					{
						$folder = 'posts';
					}
					foreach ($post_images as $key) {
						if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'.$key->name)) {
							if($key->type  == 'images' ){
								echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/'.$folder.'/'. $key->name.'"	/>';
								break;
							}
						}
					}
				}
			?>
		</div>
		<div class="post-details">
			<div class="clearfix post-header">
				<div class="pull-left">
					<?php 
						if (file_exists(upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png')) {
							echo '<img src="'.upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png" class="user-profile-img" />';
						}else{
							echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg" width="40">';	
						}
					?>	
				</div>
				<div class="post-user-name pull-left">
					by <?php echo get_company_name($this->user_data['account_id']); ?>
				</div>
			</div>
			<div class="post_copy_text">
				<?php 
					$content = $post_details->content;
					$content = replace_with_expression($content);
					echo (!empty($content)) ? $content : '';
				?>
			</div>
		</div>
		<div class="post-credits">
		<a href="#" target="_blank">
			<?php 
				if(!empty($post_details->pinterest_source))
				{
					?>
					<div class="pinterest-source hide">
						<strong>Saved from</strong><br>
						<?php echo $post_details->pinterest_source; ?>
					</div>
					<?php
				}
				else
				{
					?>
					<div class="pinterest-user-avatar row">
						<div class="col-sm-3">
						<?php 
							echo print_user_image($this->user_data['account_id'],$this->user_id);
						?>
						</div>
						<div class="col-sm-9">
							<?php
							echo 'Saved by <br/>';
							echo '<strong >'.$this->user_data['first_name'].' '.$this->user_data['last_name'].'</strong>';
							?>
						</div>
					</div>
					<?php
				}
			?>
		</a>
		</div>
	</div>
</div>