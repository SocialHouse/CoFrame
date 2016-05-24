<div class="hide">
	<div id="outlet_1">
		<div class="post-container">
			<div class="padding_5">
				<div class="margin-bottom-10">
					<div>
						<div class="pull-left user-img-border">
							<img class="user-profile-img" src="<?php echo img_url().'default_profile.jpg'; ?>">	
						</div>
						<div class="pull-left padding-left-5">
							<span class="post-user-name">
								<?php echo $this->user_data['first_name'].' '.$this->user_data['last_name'] ?><span class="no-of-photos"></span>
							</span><br/>
							<span class="time-color">
								Just now
							</span>
						</div>
					</div>
					<div class="clearfix"></div>
					<br>
					<span class="post_copy_text">					
					</span>
					<div class="img-div">
						<!-- <img src="<?php echo img_url().'1.jpg'; ?>" style="max-height: 200px;max-width: 100%;"> -->
					</div>			
				</div>
				<div class="bottom-div">
					<div>
						<div class="pull-left"><i class="fa fa-thumbs-up"></i> <span>Like</span>
						</div>
						<div class="pull-left margin-left-15">
							<i class="fa fa-comment-o"></i> Comment
						</div>
						<div class="pull-left margin-left-15">
							<i class="fa fa-share"></i> Share
						</div>
					</div>
				</div>

			</div>	
		</div>
	</div>

	<div id="outlet_3">
		<div class="insta-post-div">
			<div class="insta-profile-div">		
				<div class="pull-left">
					<img src="<?php echo img_url().'default_profile.jpg'; ?>" class="img-circle insta-profile">
				</div>
				<div class="margin-left-5 insta-username pull-left"><b>Ninad</b></div>
				<div class="pull-right insta-time insta-username">0m</div>
			</div>
			<div class="clearfix"></div>

			<div class="insta-img-div">
				<!-- <img src="<?php echo img_url().'1.jpg'; ?>" > -->
			</div>	
			
			<div class="insta-post-copy">		
				<div class="insta-comment-div">
					<span class="insta-comment-user-name">Ninad</span>
					<span class="post_copy_text"></span>
				</div>
			</div>
			<div class="insta-add-comment">
				<i class="fa fa-heart-o" aria-hidden="true"></i><span class="margin-left-5 ">Add a comment...</span>		
			</div>
		</div>
	</div>

	<div id="outlet_2">
		<div class="twitter-post">
			<div class="pull-left" style="margin-right: 8px">
				<img src="<?php echo img_url(); ?>default_profile_twitter.png" class="twitter-default-img">
			</div>
			<div class="pull-left">
				<div  style="margin-bottom:2px">
					<div class="twitter-user-info"><?php echo $this->user_data['first_name'].' '.$this->user_data['last_name'] ?> <span class="twitter_username">@ninadgaikwad - 1s</span></div>
				</div>
				<div class="post_copy_text">
				</div>
				<div class="twitter-img-div twitter-post-img img-div">					
				</div>
				<div class="clearfix"></div>
				<div class="twitter-bottom-div">					
					<div class="pull-left"><i class="fa fa-mail-reply"></i> <span></span>
					</div>
					<div class="pull-left margin-left-15">
						<i class="fa fa-refresh"></i>
					</div>
					<div class="pull-left margin-left-15">
						<i class="fa fa-heart"></i>
					</div>
					<div class="pull-left margin-left-15">
						<i class="fa fa-ellipsis-h"></i>
					</div>					
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>