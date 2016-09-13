<?php $this->load->view('partials/brand_nav'); ?>

<input type="hidden" id="request-string" value="<?php echo uniqid(); ?>">
<input type="hidden" id="user_id" value="<?php echo $this->user_id; ?>">
<input type="hidden" id="brand_id" value="<?php echo $brand_id; ?>">
<input type="hidden" id="account_id" value="<?php echo $this->user_data['account_id']; ?>">
<input type="hidden" id="slug" value="<?php echo $slug; ?>">

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">Co-Create</h1>
	</header>	
	<div class="row equal-columns relative-wrapper cocreate">
		<div class="col-lg-6 center-block">
			<div class="col-sm-6 equal-height">
				<div class="container-cocreate">
					<h2 class="text-xs-center">Step 1</h2>
					<p class="text-xs-center">Select users that you want to co-create with</p>
					<?php 
					if(!empty($users))
					{
						?>
						<ul class="timeframe-list user-list first-phase">
							<?php
							foreach ($users as $user)
							{
								$email = get_email($user->aauth_user_id);
								?>
								<li>
									<div class="pull-sm-left">
										<input type="checkbox" data-clear-phase="first" class="hidden-xs-up" name="join_req[]" value="<?php echo $email; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $email; ?>" data-group="join_req[]"><i class="fa fa-check"></i></i>
									</div>
									<div class="pull-sm-left">
										<?php
										$path = img_url()."default_profile.jpg";
										if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png'))
										{
											$path = upload_url().$brand->created_by.'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png';
										}
										?>
										<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
									</div>
									<div class="pull-sm-left post-approver-name">
										<strong>
										<?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
										</strong>
										<?php echo get_user_groups($user->aauth_user_id,$brand_id); ?>
									</div>
								</li>										
								<?php									
							}
							?>

							<li class="option-all-users">
								<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="join_req[]"><i class="fa fa-check"></i></i></div>
								<div class="pull-sm-left"><div class="circle-border bg-black tf-icon">All</div></div>
								<div class="pull-sm-left post-approver-name">Check<br>All</div>
							</li>
						</ul>
						<?php
					}
					?>
					<footer class="post-content-footer"></footer>
				</div>

			</div>
			<div class="col-sm-6 equal-height">
				<div class="container-cocreate">
					<h2 class="text-xs-center">Step 2</h2>
					<p class="text-xs-center">Select an option below to start</p>
					<ul class="cocreate-list text-xs-center">
						<li>
							<a class="cocreate-option" data-option="chat"><i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-chat"></i></i></a>
						</li>
						<li>
							<a class="cocreate-option" data-option="audio"><i class="tf-icon circle-border" data-value="audio" data-group="post-outlet"><i class="tf-icon-tele"></i></i></a>
						</li>
						<li>
							<a class="cocreate-option" data-option="video"><i class="tf-icon circle-border" data-value="video" data-group="post-outlet"><i class="tf-icon-video"></i></i></a>
						</li>
					</ul>
					<footer class="post-content-footer"></footer>
				</div>
			</div>
		</div>
	</div>
</section>