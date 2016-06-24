<div class="hide">
	<div id="outlet_facebook">
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

	<div id="outlet_instagram">
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

	<div id="outlet_twitter">
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


	<div id="outlet_linkedin">		
		<div class="linkedin-post" >
			<div class="linkedin-profile">
				<img src="<?php echo img_url(); ?>default_profile_linkedin.png">
			</div>
			<div class="linkedin-content">
				<div class="linkedin-user-detail">
					<span>ninad g</span>
					<p>Software Developer at Techfive</p>
				</div>
				<div class="post_copy_text"></div>
				<div class="likedin-img-div" ></div>
				<ul class="actions">
					<li>like</li>
					<li>Comment</li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div id="outlet_vine">
		<div class="vine-post" style="width:100%">
			<div style="padding: 8px">
				<div class="vine-user-profile" >
					<img class="default-img img-circle" src="<?php echo img_url(); ?>default_profile.jpg" width="40">
				</div>
				<div class="vine-user-info" >
					<div>Tragic Tofu</div>
					<span>May 5, 2016</span>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="content">
				<div class="vine-comment-div">
					<div class="post_copy_text">
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
	</div>

	<div id="outlet_tumblr"  style="width:100%">
		<div class="tumblr-post">
			<div class="tumblr-title" >
				Here's a blog: psych-facts
			</div>
			<div class="tumblr-img-div">
			</div>
			<div class="tumblr-user">
				<div class="tumblr-user-profile" >
					<img class="default-img reblog-avatar-image-thumb" src="<?php echo img_url(); ?>default_profile.jpg" width="40">			        
				</div>
				<div class="tumblr-user-info" >
					<span>Tragic Tofu</span>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="content">
				<div class="tumblr-comment-div">
					<div class="post_copy_text">
					</div>
					<div class="tumblr-sharing-option">
						<span >654 notes</span>
						<div class="pull-right">
							<i class="fa fa-heart" aria-hidden="true"></i>
							<i class="fa fa-refresh" aria-hidden="true"></i>
							<i class="fa fa-share-square-o" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_youtube"  style="width:100%">
		<div class="youtube-post" style="width:100%">
			<div class="clearfix"></div>
			<div class="content">
				<div class="youtube-comment-div">
					<div class="post_copy_text">
					</div>
					<div class="youtube-sharing-option">
						<span>21 views</span>
						<span>1 week ago</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outlet_pinterest"  style="width:100%">
		<div class="pinterest-post>
		
		<div class="clearfix"></div>
		<div class="content">
			<div class="pinterest-img-div">
			</div>
				<div class="pintereat-comment">
					<div class="pinterest-comment-div">
						<p class="post_copy_text">
							
						</p>
					</div>
					<div class="pinterest-sharing-option">
						<i class="fa fa-thumb-tack" aria-hidden="true"></i>
						<i class="fa fa-thumb-tack fa-rotate-180" aria-hidden="true"></i>&nbsp;4.5k
						<i class="fa fa-heart" aria-hidden="true"></i>&nbsp;969
					</div>
					<div class="pull-left">
						<img class="default-img img-circle" src="<?php echo img_url(); ?>default_profile.jpg" width="40">
					</div>
					<div class="clearfix pinterest-userinfo ">
							<div class="creditTitle">Saved by</div>
							<div  class="creditTitle" id="pinterest_user_name"></div>				
					</div>
					
				</div>
					
			</div>
		</div>		
	</div>

</div>
