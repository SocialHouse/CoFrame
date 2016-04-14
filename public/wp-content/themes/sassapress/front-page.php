<?php get_header(); ?>
	<?php /* The loop */ ?>
	<?php if(have_posts()){ while ( have_posts() ) { the_post(); ?>
		<?php
			$menu = wp_get_nav_menu_object ('Page Menu');			
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			$num_items = count($menu_items);
			$i = 1;
			foreach ($menu_items as $item) :
				$id = $item->object_id;
				$post=get_post($id);
				$slug = $post->post_name;
				$thumb_id = get_post_thumbnail_id($id);
				$thumb_url = wp_get_attachment_url($thumb_id);
				$bg = get_the_post_thumbnail($id, 'full', array('class'=>'section-background'));
				$content = apply_filters('the_content', $post->post_content);
				
			?>
				<section id="<?php echo $slug; ?>" class="page-section<?php if($id == 6) {?> animated<?php } ?>" style="background-image: url(<?php echo $thumb_url; ?>);"<?php if($id == 6) {?> data-animation="fadeIn"<?php } ?>>
					<div class="section-content">
					<?php 
						/*Homepage*/
						if($id == 6) {
							$features = get_post(8);
							$pricing = get_post(10);
							$f_title = $features->post_title;
							$f_excerpt = $features->post_excerpt;
							$p_title = $pricing->post_title;
							$p_excerpt = $pricing->post_excerpt;
					?>
						<div class="row row-sm-12 home">
							<div class="col-md-6">
								<div class="intro-content">
									<?php echo $content; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row row-sm-6">
									<div class="col-sm-12 border-bottom home-video">
										<div class="play-btn">
											<i class="fa fa-play"></i>
										</div>
										<div class="embed-responsive">
											<div id="player"></div>
										</div>
									</div>
								</div>
								<div class="row row-sm-6 ">
									<div class="col-sm-6 hover-item border-right">
										<a href="#features"><h2><?php echo $f_title; ?></h2>
											<div class="hover-item-content vertical-center">
											<p><?php echo $f_excerpt; ?></p>
											<p class="btn btn-default">View More</p>
											</div>
										</a>
									</div>
									<div class="col-sm-6 row-sm-6 hover-item">
										<a href="#pricing"><h2><?php  echo $p_title; ?></h2>
											<div class="hover-item-content vertical-center">
											<p><?php echo $p_excerpt; ?></p>
											<p class="btn btn-default">View More</p>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					<?php } else {?>
						<?php echo $content; ?>
					<?php }?>
					</div>
					<nav class="page-next-prev<?php if($id == 6) {echo ' home-next';} ?>">
						<div class="row row-sm-12">
							<div class="col-md-6 border-right">
								<?php if($i != 1) { ?><a href="#prev" class="prev"><i class="fa fa-caret-up"></i></a><?php } ?>
								<?php if($i != $num_items) { ?> <a href="#next" class="next"><i class="fa fa-caret-down"></i></a><?php } ?>
							</div>
							<div class="col-md-6">
							</div>
						</div>
					</nav>
					<?php echo $bg; ?>
				</section>
		<?php
			$i++;
			endforeach;
		?>
	<?php } } ?>
	
<button type="button" class="modal-toggler">
	<span class="sr-only">Toggle Modal</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>

<!--Login Modal-->
<div class="modal login-modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
		<?php logo();?>
	  	<h3>Log In</h3>
        <form>
			<div class="form-group">
				<label class="sr-only" for="loginEmail">Email Address</label>
				<input type="email" class="form-control" id="loginEmail" placeholder="Email">
			</div>
			<div class="form-group">
				<label class="sr-only" for="loginPassword">Password</label>
				<input type="email" class="form-control" id="loginPassword" placeholder="Password">
			</div>
			<div class="form-group">
				<div class="checkbox pull-left">
					<label>
						<input type="checkbox"> Remember password
					</label>
				</div>
				<a href="#recoverPassword" data-backdrop="static" data-toggle="modal" class="pull-right">Forgot password?</a>
			</div>
			<div class="text-center clear">
				<a href="#invalidEmail" class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="static">Submit</a>
			</div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Invalid Login Modal-->
<div class="modal fade" id="invalidEmail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		<?php logo();?>
      <div class="modal-body text-center bg-white">
	  	<h5>Invalid Email or Password</h5>
		<hr>
		<p>The email and/or password you entered did not match our records. Please try again.</p>
		<hr>
		<p><a href="#loginModal" class="btn btn-warning btn-sm" data-backdrop="static" data-toggle="modal">Try again</a></p>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Password Recovery Modal-->
<div class="modal fade" id="recoverPassword" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		<?php logo();?>
      <div class="modal-body text-center bg-white">
	  	<h5>Password Recovery</h5>
		<hr>
		<p>Enter the email address associated with your account, and we’ll send you an email with instructions on resetting your password.</p>
        <form>
			<div class="form-group">
				<label class="sr-only" for="loginEmail">Email Address</label>
				<input type="email" class="form-control" id="loginEmail" placeholder="Email">
			</div>
			<hr>
			<div class="clearfix">
				<a href="#" class="btn btn-default btn-sm pull-left" data-dismiss="modal" aria-label="Close">Cancel</a>
				<a href="#recoverPasswordSuccess" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-backdrop="static">Submit</a>
			</div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Password Recovery Success Modal-->
<div class="modal fade" id="recoverPasswordSuccess" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		<?php logo();?>
      <div class="modal-body text-center bg-white">
	  	<h5>Password Recovery</h5>
		<hr>
		<p>We’ve sent an email to norel@socialhouseinc.com with instructions on resetting your password.</p>
		<hr>
		<div class="text-center">
			<a href="#" class="btn btn-default btn-sm" data-dismiss="modal" aria-label="Close">Dismiss</a>
		</div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php get_footer();