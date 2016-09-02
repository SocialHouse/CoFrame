<div class="hide">
	<div id="outlet_facebook">
		<div class="fb_post">
			<div class="post-container">
				<div class="clearfix">
					<div class="pull-left">
						<img class="user-profile-img" src="<?php echo img_url().'default_profile.jpg'; ?>">	
					</div>
					<div class="user-profile-details">
						<span class="post-user-name">
							<?php echo get_company_name($this->user_data['account_id']); ?><span class="no-of-photos"></span>
						</span>
						<span class="time-color">
							Just now
						</span>
					</div>
				</div>
				<span class="post_copy_text">					
				</span>
				<div class="img-div">
				</div>			
			</div>
		</div>
	</div>

	<div id="outlet_instagram">
		<div class="ig_post">
			<div class="post-container">
				<div class="clearfix post-header">
					<div class="pull-left">
						<img src="<?php echo img_url().'default_profile.jpg'; ?>" class="img-circle user-profile-img">
					</div>
					<span class="post-user-name pull-left"><?php echo get_company_name($this->user_data['account_id']); ?></span>
					<div class="pull-right time-color">0m</div>
				</div>
				<div class="insta-img-div img-div">
					<!-- <img src="<?php echo img_url().'1.jpg'; ?>" > -->
				</div>	
					
				<div class="insta-post-copy">
					<span class="post-user-name"><?php echo get_company_name($this->user_data['account_id']); ?></span>
					<span class="post_copy_text"></span>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_twitter">
		<div class="tw_post">
			<div class="post-container">
				<div class="clearfix">
					<div class="pull-left user-profile-img">
						<img src="<?php echo img_url(); ?>default_profile_twitter.png">
					</div>
					<div class="user-profile-details">
						<div class="post-user-name"><?php echo get_company_name($this->user_data['account_id']); ?> <span class="time-color">@<?php echo get_company_name($this->user_data['account_id']); ?> - 1s</span></div>
						<div class="post_copy_text">
						</div>
						<div class="twitter-img-div img-div">			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_linkedin">
		<div class="in_post">
			<div class="post-container">
				<div class="clearfix" >
					<div class="pull-left">
						<img src="<?php echo img_url(); ?>default_profile_linkedin.png" class="user-profile-img">
					</div>
					<div class="user-profile-details">
						<div class="post-header">
							<div class="post-user-name pull-left"><?php echo get_company_name($this->user_data['account_id']); ?></div>
							<span class="time-color pull-right">0s</span>
						</div>
						<div class="post_copy_text"></div>
						<div class="likedin-img-div img-div"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_vine">
		<div class="vn_post">
			<div class="post-container">
				<div class="user-profile-details clearfix">
					<div class="pull-left">
						<img class="user-profile-img circle-img" src="<?php echo img_url(); ?>default_profile.jpg">
					</div>
					<div class="pull-left">
						<div class="post-user-name"><?php echo get_company_name($this->user_data['account_id']); ?></div>
						<div class="time-color">May 5, 2016</div>
					</div>
				</div>
				<div class="video-div">
				</div>
				<div class="post_copy_text">
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_tumblr">
		<div class="tb_post">
			<div class="post-container clearfix">
				<div class="pull-left">
					<img class="user-profile-img" src="<?php echo img_url(); ?>default_profile.jpg">
				</div>
				<div class="post-details">
					<div class="post-user-name">
						<?php echo get_company_name($this->user_data['account_id']); ?>
					</div>
					<div class="img-div">
					</div>
					<div class="post-title">
					</div>
					<div class="link"> <a href=""></a>
					</div>
					<div class="source">
					</div>
					<div class="post_copy_text">
					</div>
					<div class="tags">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_youtube">
		<div class="yu_post">
			<div class="post-container">
				<div class="video-div">
				</div>
				<div class="clearfix post-section">
					<h1 class='video-title'></h1>
					<div class="pull-left">
						<img class="user-profile-img" src="<?php echo img_url(); ?>default_profile.jpg">
					</div>
					<div class="pull-left">
						<div class="post-user-name"><?php echo get_company_name($this->user_data['account_id']); ?></div>
					</div>
				</div>
				<div class="post-section">
					<div class="time-color">Posted on <?php echo date('j, Y'); ?></div>
					<div class="post_copy_text">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_pinterest">
		<div class="pn_post">
			<div class="post-container">
				<div class="pinterest-img-div img-div">
				</div>
				<div class="post-details">
					<div class="clearfix post-header">
						<div class="pull-left">
							<img class="user-profile-img" src="<?php echo img_url(); ?>default_profile.jpg" width="40">
						</div>
						<div class="post-user-name pull-left">
							by <?php echo get_company_name($this->user_data['account_id']); ?>
						</div>
					</div>
					<div class="post_copy_text"></div>
				</div>
				<div class="post-credits">
					<a href="#" target="_blank">
						<div class="pinterest-user-avatar row">
							<div class="col-md-3">
							<?php 
								echo print_user_image($this->user_data['account_id'],$this->user_id);
							?>
							</div>
							<div class="col-md-9">
								<?php
								echo 'Saved by <br/>';
								echo '<strong >'.$this->user_data['first_name'].' '.$this->user_data['last_name'].'</strong>';
								?>
							</div>
						</div>
						<div class="pinterest-source hide">
							<strong>Saved from</strong><br><span></span>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>

</div>
