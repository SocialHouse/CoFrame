<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<title>CoFrame | Create, Manage &amp; Approve Your Social Media Calendars, All On One Easy-To-Use Platform.</title>
	  	<link rel="profile" href="http://gmpg.org/xfn/11">
		<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
		<link rel="shortcut icon" href="<?php echo img_url(); ?>ico/favicon.ico" ><meta name='robots' content='noindex,follow' />
		<link rel='stylesheet' id='style-css'  href='<?php echo css_url(); ?>tour_style.css?ver=1.0' type='text/css' media='all' />
		<link rel='stylesheet' href='<?php echo css_url(); ?>custom.css?ver=1.0' type='text/css' media='all' />

		<style id='style-inline-css' type='text/css'>
		    /* Body Style */
		    body{
				background: #ffffff;color: #ffffff;font-size: 26px;	}
			
			 /* Heading Style */
			h1, h2, h3, h4, h5, h6{ 
				font-weight: 400;	}
			/* Custom CSS */
		</style>
		<?php
		if($this->config->item('compile_json_message_js')){
			$msg_file = $this->config->item('json_msg_file');
			$json_message = $this->lang->language;
			$json_str = 'var language_message = '.json_encode($json_message);
			@unlink($msg_file);
			file_put_contents($msg_file, $json_str);
		}
		?>
		<script type="text/javascript">
			var base_url = "<?php echo base_url(); ?>";
		</script>
		
		<script type='text/javascript' src='<?php echo js_url(); ?>json_message.json'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.js?ver=1.11.3'></script>
		<!--[if lt IE 9]><script src="assets/js/html5shiv.js"></script><![endif]-->	
	</head><!--/head-->
<body class="home page page-id-6 page-template-default" data-spy="scroll" data-target=".navbar-main">
	<div id="loading_main">
        <img class="loading" src="<?php echo img_url(); ?>bx_loader.gif" >
    </div>
    <div class="container-fluid container-head">
	  	<nav class="navbar-fixed-top home">
			<div class="col-sm-12">
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".nav-toggle">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
		        <a class="navbar-brand hidden-print" href="<?php echo base_url(); ?>">
	            	<span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">CoFrame</span>
	        	</a>
				<div class="visible-print-block logo-print">
		       		<img src="<?php echo base_url(); ?>assets/uploads/2016/02/logo.png" height="136" width="125" alt="">
				</div>
				<div class="pull-right btn-login"><a class="btn btn-default btn-sm" href="#" data-backdrop="static" data-toggle="modal" data-target="#loginModal">Log in</a></div>
				<div class="collapse navbar-main-wrapper nav-toggle navbar-toggleable-lg">
					<ul id="menu-global-navigation" class="nav navbar-nav navbar-main">
						<li id="menu-item-26" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-26 nav-item"><a title="Home" href="#home" class="nav-link">Home</a></li>
						<li id="menu-item-27" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-27 nav-item"><a title="Features" href="#features" class="nav-link">Features</a></li>
						<li id="menu-item-28" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-28 nav-item"><a title="Pricing" href="#pricing" class="nav-link">Pricing</a></li>
						<li id="menu-item-29" class="btn btn-primary menu-item menu-item-type-custom menu-item-object-custom menu-item-29 nav-item"><a title="Get Started" href="#get-started" class="nav-link">Get Started</a></li>
					</ul>
					<div class="copyright">
						<ul id="menu-footer-menu" class="nav navbar-nav navbar-footer">
							<li id="menu-item-34" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-34 nav-item"><a title="Privacy Policy" href="/public/privacy-policy/" class="nav-link">Privacy Policy</a></li>
						</ul>
						|  &copy; <?php echo date('Y'); ?> Social House, Inc.
					</div>
					<div class="overlay"></div>
			  	</div>
			</div>
		</nav>
  	</div>
  	<div class="container-fluid content-container">
    	<div class="content-area row">
			<section id="home" class="page-section animated" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/bg-home.jpg);" data-animation="fadeIn">
				<div class="section-content">
					<div class="row row-sm-12 home">
						<div class="col-md-6">
							<div class="intro-content">
								<h1>Create, manage &amp; approve<br>
								your social media calendars <br>
								across multiple outlets, <br>
								in real­time, all on one <br>
								easy-to-use platform.
</h1>
								<p><a class="btn btn-primary btn-lg" href="#get-started">Get Started</a></p>
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
									<a href="#features"><h2>Features</h2>
										<div class="hover-item-content vertical-center">
											<p><div class="circle-img create"><img src="/assets/images/slate.png" alt="Create"></div>
											<div class="circle-img collaborate"><img src="/assets/images/collaborate.png" alt="Collaborate"></div>
											<div class="circle-img approve"><img src="/assets/images/approve.png" alt="Approve"></div>
											<div class="circle-img publish"><img src="/assets/images/publish.png" alt="Publish"></div></p>
										</div>
									</a>
								</div>
								<div class="col-sm-6 row-sm-6 hover-item">
									<a href="#pricing"><h2>Pricing</h2>
										<div class="hover-item-content vertical-center">
											<p>Whether you’re a small business or a Fortune 500 company, we have plans that match your needs. Explore our plans to learn more and begin your free trial.</p>
											<p class="btn btn-default">Get Started</p>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<nav class="page-next-prev home-next">
					<div class="row row-sm-12">
						<div class="col-md-6 border-right">
							<a href="#next" class="next"><i class="fa fa-caret-down"></i></a>
						</div>
						<div class="col-md-6">
						</div>
					</div>
				</nav>
				<img width="1920" height="1080" src="<?php echo base_url(); ?>assets/uploads/2016/02/bg-home.jpg" class="section-background wp-post-image" alt="bg-home" srcset="<?php echo base_url(); ?>assets/uploads/2016/02/bg-home-300x169.jpg 300w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-home-768x432.jpg 768w, assets/uploads/2016/02/bg-home-1024x576.jpg 1024w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-home.jpg 1920w" sizes="(max-width: 1920px) 100vw, 1920px" />				</section>
				<section id="features" class="page-section" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/bg-features.jpg);">
					<div class="section-content">
						<div class="row feature-list animated" data-animation="fadeIn">
							<div class="col-md-3 text-center box-create animated" data-animation="fadeInUp"></p>
								<h2>Create</h2>
								<p>Upload content and write copy to see a live preview of your content before it is posted.
							</div>
							<div class="col-md-3 text-center box-collaborate animated" data-animation="fadeInUp animate-delay-300"></p>
								<h2>Collaborate</h2>
								<p>Bring everyone together in one virtual war room to CoCreate a post, while talking live via chat, video or call.
							</div>
							<div class="col-md-3 text-center box-approve animated" data-animation="fadeInUp animate-delay-600"></p>
								<h2>Approve</h2>
								<p>Track your team’s realtime edits, leave feedback and utilize phased approvals to make sure you get all the approvals you need before going live.
							</div>
							<div class="col-md-3 text-center box-publish animated" data-animation="fadeInUp animate-delay-600"></p>
								<h2>Publish</h2>
								<p>Schedule or post your content live to multiple social channels, while also archiving calendars for future reference.
							</div>
						</div>
						<div class="row feature-list-btn" data-animation="">
							<div class="col-md-12 text-center animated" data-animation="fadeInUp animate-delay-900"><a class="btn btn-primary btn-lg" href="#pricing">See Plans</a>
							</div>
						</div>
					</div>
					<nav class="page-next-prev">
						<div class="row row-sm-12">
							<div class="col-md-6 border-right">
								<a href="#prev" class="prev"><i class="fa fa-caret-up"></i></a>								 <a href="#next" class="next"><i class="fa fa-caret-down"></i></a>							</div>
							<div class="col-md-6">
							</div>
						</div>
					</nav>
					<img width="1920" height="1080" src="<?php echo base_url(); ?>assets/uploads/2016/02/bg-features.jpg" class="section-background wp-post-image" alt="bg-features" srcset="<?php echo base_url(); ?>assets/uploads/2016/02/bg-features-300x169.jpg 300w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-features-768x432.jpg 768w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-features-1024x576.jpg 1024w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-features.jpg 1920w" sizes="(max-width: 1920px) 100vw, 1920px" />
				</section>
				<section id="pricing" class="page-section" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/bg-pricing.jpg);">
					<div class="section-content">
						<div class="row feature-list pricing-list animated" data-animation="fadeIn">
							<div class="col-md-3 text-center animated col-sm-6" data-animation="fadeInRight"></p>
								<header class="price-title">
									<h2>Start-Up</h2>
									<h3>$99 <small>per month</small></h3>
								</header>
								<ul>
									<li>Lorem ipsum dolor sit</li>
									<li>Amet consectetur</li>
									<li>Adipiscing elit sed do euis</li>
									<li>Mod tempor incididunt</li>
								</ul>
								<p><a class="btn btn-primary btn-lg btn-choose-plan" href="#get-started" data-plan="Start-Up" data-price="$99.00">Get Started</a><br />
							</div>
							<div class="col-md-3 text-center animated col-sm-6" data-animation="fadeInRight animate-delay-300"></p>
								<header class="price-title">
									<h2>Business</h2>
									<h3>$199 <small>per month</small></h3>
								</header>
								<ul>
									<li>Lorem ipsum dolor sit</li>
									<li>Amet consectetur</li>
									<li>Adipiscing elit sed do euis</li>
									<li>Mod tempor incididunt</li>
									<li>Ut labore et dolore magn</li>
								</ul>
								<p><a class="btn btn-primary btn-lg btn-choose-plan" href="#get-started" data-plan="Business" data-price="$199.00">Get Started</a><br />
							</div>
							<div class="col-md-3 text-center animated col-sm-6" data-animation="fadeInRight animate-delay-600"></p>
								<header class="price-title">
									<h2>Corporate</h2>
									<h3>$299 <small>per month</small></h3>
								</header>
								<ul>
									<li>Lorem ipsum dolor sit</li>
									<li>Amet consectetur</li>
									<li>Adipiscing elit sed do euis</li>
									<li>Mod tempor incididunt</li>
									<li>ut labore et dolore magn</li>
									<li>aliqua ut enim ad minim</li>
								</ul>
								<p><a class="btn btn-primary btn-lg btn-choose-plan" href="#get-started" data-plan="Corporate" data-price="$299.00">Get Started</a><br />
							</div></p>
								<p>
							<div class="col-md-3 text-center animated col-sm-6" data-animation="fadeInRight animate-delay-900">
								</p>
								<header class="price-title">
									<h2>Premiere</h2>
									<h3>$499 <small>per month</small></h3>
								</header>
								<ul>
									<li>Lorem ipsum dolor sit</li>
									<li>Amet consectetur</li>
									<li>Adipiscing elit sed do euis</li>
									<li>Mod tempor incididunt</li>
									<li>ut labore et dolore magn</li>
									<li>aliqua ut enim ad minim</li>
									<li>veniam quis nostrud</li>
								</ul>
								<p><a class="btn btn-primary btn-lg btn-choose-plan" href="#get-started" data-plan="Premiere" data-price="$499.00">Get Started</a><br />
							</div></p><p>
						</div>
					</div>
					<nav class="page-next-prev">
						<div class="row row-sm-12">
							<div class="col-md-6 border-right">
								<a href="#prev" class="prev"><i class="fa fa-caret-up"></i></a>
								<a href="#next" class="next"><i class="fa fa-caret-down"></i></a>
							</div>
							<div class="col-md-6">
							</div>
						</div>
					</nav>
					<img width="1920" height="1080" src="<?php echo base_url(); ?>assets/uploads/2016/02/bg-pricing.jpg" class="section-background wp-post-image" alt="bg-pricing" srcset="<?php echo base_url(); ?>assets/uploads/2016/02/bg-pricing-300x169.jpg 300w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-pricing-768x432.jpg 768w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-pricing-1024x576.jpg 1024w, <?php echo base_url(); ?>assets/uploads/2016/02/bg-pricing.jpg 1920w" sizes="(max-width: 1920px) 100vw, 1920px" />
				</section>
				<section id="get-started" class="page-section" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/bg-start.jpg);">
					<div class="section-content">
						<div class="row bg-white get-started-detail animated register_form_height" data-animation="fadeInUp">
							<div class="col-md-4 " data-animation="">
								<h1>Start your free<br>
								30-day trial</h1>
								<hr />
								<div>Selected Plan:</div>
								<div id="selected-plan"><span class="highlight">None</span></div>
								<p>Accounts can be upgraded,<br />
								downgraded or canceled<br />
								at any time.</p>
								<p><a class="btn btn-default btn-sm" href="#pricing">Change</a></p>
							</div>
							<div class="col-md-4 " data-animation="">
								<div class="hide register-response"></div>
								<form action="" id="register_form">
									<div class="field-group clearfix">
										<fieldset class="form-group float-md">
											<label class="sr-only" for="firstName">First Name*</label>
										 	<input type="text" class="form-control" id="firstName" placeholder="First Name*" name="first_name">
										</fieldset>

										<fieldset class="form-group float-md">
											<label class="sr-only" for="lastName">Last Name*</label>
											<input type="text" class="form-control" id="lastName" placeholder="Last Name*" name="last_name">
										</fieldset>
									</div>

									<div class="field-group clear">
										<fieldset class="form-group">
											<label class="sr-only" for="companyName">Company Name</label>
											<input type="text" class="form-control" id="companyName" placeholder="Company Name" name="company_name">
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="title">Title</label>
											<input type="text" class="form-control" id="title" placeholder="Title" name="title">
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="emailAddress">Email address*</label>
											<input type="email" class="form-control" id="emailAddress" placeholder="Email*" name="email">
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="password">Create A Password*</label>
											<input type="password" class="form-control" id="password" placeholder="Create A Password*" name="password">
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="confirmPassword">Confirm Password*</label>
											<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password*" name="confirm_password">
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="phoneNumber">Phone Number</label>
											<input type="tel" id="phone" data-error='false' class="form-control" name="phone">
											 <input type="hidden" name="dialcode" value="" id="dialcode"> 
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="plan">Plan*</label>
											<select class="form-control" id="plan" name="plan">
												<option value="">Plan*</option>
												<option data-price="$99" value="START-UP">START-UP</option>
												<option data-price="$199" value="BUSINESS">BUSINESS</option>
												<option data-price="$299" value="CORPORATE">CORPORATE</option>
												<option data-price="$499" value="PREMIERE">PREMIERE</option>
											</select>
										</fieldset>
										<fieldset class="form-group">
											<label class="sr-only" for="timeZone">Time Zone*</label>
											<select class="form-control" id="timeZone" name="timezone">
												<option value="">Time Zone*</option>
												<?php
											    foreach($timezones as $timezone)
											    {
											    	?>
											    	<option value="<?php echo $timezone->value ?>" <?php echo set_select('timezone', $timezone->value); ?>><?php echo $timezone->timezone; ?></option>
											    	<?php
											    }
											    ?>
											</select>
										</fieldset>
									</div>

									<p class="disclaimer">Your 30-day free trial lasts until midnight on <?php echo date('M d Y',strtotime('+30 days')); ?>. By clicking the button BELOW, you are agreeing to the Terms of Service and Privacy Policy.</p>
									<div class="text-center">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</form>
							</div>
							<div class="col-md-4 faq" data-animation=""></p>
								<p><strong>Will I have to enter my payment details?</strong><br />
								Yes, but you won&#8217;t be billed unless you keep your account open beyond the free trial.</p>
								<hr />
								<p><strong>Need help signing up?</strong><br />
								If you have any questions please email us at: <a href="mailto:support@timeframe.com">support@TIMEFRAME.com</a>.</p>
								<hr />
								<p>At CoFrame, we value your privacy and will never share your personal data with any 3rd parties. 
							</div>
							<footer id="global-footer" class="col-sm-12">
								<div class="row">
									<div class="col-sm-6">
										<a class="navbar-brand hidden-print" href="/">
											<span class="brand-logo hide-text" style="background-image: url(<?php echo base_url(); ?>assets/uploads/2016/02/logo.png);">CoFrame</span>
										</a>
									</div>
									<div class="col-sm-6 text-sm-right">
										<ul class="social-media">
											<li><a href="#" target="_blank"><i class="fa fa-facebook"><span class="bg-outlet"></span></i></a></li>
											<li><a href="#" target="_blank"><i class="fa fa-twitter"><span class="bg-outlet"></span></i></a></li>
											<li><a href="#" target="_blank"><i class="fa fa-instagram"><span class="bg-outlet"></span></i></a></li>
											<li><a href="#" target="_blank"><i class="fa fa-linkedin"><span class="bg-outlet"></span></i></a></li>
										</ul>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-5">
									COPYRIGHT &copy; <?php echo date('Y'); ?> SOCIAL HOUSE, INC. ALL RIGHTS RESERVED.
									</div>
									<div class="col-sm-7 text-sm-right">
										<ul class="nav navbar-nav">
											<li><a href="#" target="_blank">Contact Us</a></li>
											<li><a href="#" target="_blank">Terms of Use</a></li>
											<li><a href="#" target="_blank">Privacy Policy</a></li>
											<li><a href="#" target="_blank">FAQ</a></li>
											<li><a href="#" target="_blank">Careers</a></li>
											<li><a href="#" target="_blank">Help Center</a></li>
										</ul>
									</div>
								</div>
							</footer>			
						</div>
					</div>
					<nav class="page-next-prev">
						<div class="row row-sm-12">
							<div class="col-md-6 border-right">
								<a href="#prev" class="prev"><i class="fa fa-caret-up"></i></a>															</div>
							<div class="col-md-6">
							</div>
						</div>
					</nav>
				</section>
				<button type="button" class="modal-toggler">
					<span class="sr-only">Toggle Modal</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>			

			</div><!--/.content-area.row-->
		</div><!--/.container-fluid-->
		<p><a href="#registerResponse" class="btn btn-warning btn-sm pull-right hide" data-backdrop="static" data-toggle="modal" id="regResponseBtn">Go to login</a></p>

		<script type='text/javascript' src='<?php echo js_url(); ?>vendor/tether.min.js?ver=3.0.0'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>vendor/bootstrap.min.js?ver=3.0.0'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.scrollify.min.js?ver=0.1.12'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>vendor/intlTelInput.min.js?ver=9.0.2'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>jquery.validate.min.js'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>jquery.mask.min.js'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>tour_main.js?ver=1.0.0'></script>
		<script type='text/javascript' src='<?php echo js_url(); ?>timeframe_forms.js'></script>

		<script type="text/javascript">
			var token = "<?php echo isset($token) ? $token : ''; ?>";
			var error = "<?php echo isset($error) ? $error : ''; ?>";
			var verify = "<?php echo isset($verify) ? $verify : ''; ?>";
			var user_id = "<?php echo isset($user_id) ? $user_id : ''; ?>";
			var verification_code = "<?php echo isset($verification_code) ? $verification_code : ''; ?>";
			var is_user = "<?php echo isset($is_user) ? $is_user : ''; ?>";
			var request_id = "<?php echo isset($request_id) ? $request_id : ''; ?>";request_error
			var request_error = "<?php echo isset($request_error) ? $request_error : ''; ?>";

			jQuery(document).ready(function(){
				if(token)
				{
					jQuery('#savePassword').modal('show');
				}
				if(error)
				{
					jQuery('#go_login').hide();
					jQuery('#recovery_header').html('');
	        		jQuery('#recoverPassSuccessBtn').html(language_message.try_again);
	        		jQuery('#go_to_revover_pass').show();
	        		jQuery('#dismissBtn').hide();
	        		jQuery('#recovery_message').html(language_message.link_expired);
	        		jQuery('#savePassword').modal('hide');	        		
	        		jQuery('#recoverPasswordSuccess').modal('show');
				}

				if(verify && verify == 'success')
				{
					jQuery('#responseHeader').html(language_message.successful);
					jQuery('#responseMessage').html(language_message.verification_successful);
					jQuery('#verifyResponse').modal('show');
					jQuery('#verifyResponseBtn').html(language_message.go_to_login);
				}

				if(verify && verify == 'fail')
				{
					jQuery('#responseHeader').html(language_message.error);
					jQuery('#responseMessage').html(language_message.unable_to_verify_account);
					jQuery('#verifyResponse').modal('show');
					jQuery('#verifyResponseBtn').hide();
				}

				if(verification_code && user_id && is_user == 'success')
				{
					jQuery('#registerModal').modal('show');				
				}

				if(is_user == 'fail')
				{
					jQuery('#responseHeader').html(language_message.error);
					jQuery('#responseMessage').html(language_message.wrong_url);
					jQuery('#verifyResponse').modal('show');
					jQuery('#verifyResponseBtn').hide();
				}

				if(request_id)
				{
					jQuery('#loginModal').modal('show');
				}

				if(request_error == 'error')
				{
					jQuery('#go_login').hide();
					jQuery('#recovery_header').html('');
	        		jQuery('#recoverPassSuccessBtn').html(language_message.try_again);
	        		jQuery('#go_to_revover_pass').show();
	        		jQuery('#dismissBtn').hide();
	        		jQuery('#recovery_message').html(language_message.link_expired);
	        		jQuery('#savePassword').modal('hide');	        		
	        		jQuery('#recoverPasswordSuccess').modal('show');
				}
				
			});
		</script>		
	</body>
</html>
