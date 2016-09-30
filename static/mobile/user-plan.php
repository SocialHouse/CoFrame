<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
<link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all">
<link type="text/css" rel="stylesheet" href="assets/css/intlTelInput.css" media="all">
<script type='text/javascript' src='assets/js/vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global">
	<div class="container container-head navbar-fixed-top bg-white">
		<?php include("lib/global-navigation.php"); ?>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<section id="user-preferences" class="page-main col-sm-12">
				<header class="page-main-header header-fixed-top bg-white row">
					<h1 class="center-title section-title border-none">Account Settings</h1>
				</header>
				<div class="text-xs-center">
					<div class="btn-group-background center-block">
					<a href="user-preferences.php" class="btn btn-sm">My Info</a>
					<a href="user-plan.php" class="btn btn-sm active">Plan</a>
					<a href="user-billing.php" class="btn btn-sm ">Billing</a>
					</div>
				</div>
				<div class="col-sm-12 brand-main">

					<div class="row content-shadow pricing-plans" id="pricingPlans">
						<div class="pricing-details panel">
							<header class="price-title" data-parent="#pricingPlans" data-toggle="collapse" data-target="#startupPlan">
								<h2>Start-Up</h2>
								<i class="fa fa-angle-right expand-collapse"></i>
							</header>
							<ul class="text-xs-center collapse" id="startupPlan">
								<li>3 Total Users: Includes 1 Master Admin</li>
								<li>Up to 3 Social Channels per brand</li>
								<li>1 Brand</li>
								<li>Email &amp; Desktop Notifications</li>
								<li>3 tags</li>
								<li>Phased Approvals</li>
								<li><a data-plan_change="downgrade" data-current_brand_count="1" data-current_users="1" data-current_master_users="1" data-master_users="1" data-users="3" data-tags="3" data-outlets="3" data-brands="1" class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="START-UP" data-price="$99.00">Select Plan ($99 Per Month)</a></li>
							</ul>
							
						</div>
						<div class="pricing-details panel">	
							<header class="price-title" data-parent="#pricingPlans" data-toggle="collapse" data-target="#businessPlan">
								<h2>Business</h2>
								<i class="fa fa-angle-right expand-collapse"></i>
							</header>
							<ul class="text-xs-center collapse" id="businessPlan">
								<li>12 Total Users: Includes 2 Master Admins</li>
								<li>Up to 5 Social Channels per brand</li>
								<li>Up to 3 brands </li>
								<li>Email Ticketing Support</li>
								<li>Email &amp; Desktop Notifications</li>
								<li>8 tags</li>
								<li>Phased Approvals</li>
								<li><a data-plan_change="downgrade" data-current_brand_count="1" data-current_users="1" data-current_master_users="1" data-master_users="2" data-users="12" data-tags="8" data-outlets="5" data-brands="3" class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="BUSINESS" data-price="$199.00">Select Plan ($199 Per Month)</a></li>
							</ul>
						</div>
						<div class="pricing-details active-plan panel">
							<header class="price-title" data-parent="#pricingPlans" data-toggle="collapse" data-target="#corporatePlan">
								<h2>Corporate (Your Plan)</h2>
								<i class="fa fa-angle-right expand-collapse"></i>
							</header>
							<ul class="text-xs-center collapse" id="corporatePlan">
								<li>Up to 35 Users: Includes Unlimited Master Admins</li>
								<li>Up to 8 Social Channels per brand</li>
								<li>Up to 8 brands</li>
								<li>Priority Email Ticketing Support</li>
								<li>Email &amp; Desktop Notifications</li>
								<li>Co-Create functionality</li>
								<li>Up to 15 Tags</li>
								<li>Phased Approvals</li>
								<li><a class="btn btn-secondary btn-sm btn-choose-plan btn-disabled" data-plan="CORPORATE" data-price="$299.00">Active</a></li>
							</ul>
						</div>
						<div class="pricing-details panel">
							<header class="price-title" data-parent="#pricingPlans" data-toggle="collapse" data-target="#premierePlan">
								<h2>Premiere</h2>
								<i class="fa fa-angle-right expand-collapse"></i>
							</header>
							<ul class="text-xs-center collapse" id="premierePlan">
								<li>Includes Unlimited Master Admins</li>
								<li>Unlimited Social Channels</li>
								<li>Email &amp; Desktop Notifications</li>
								<li>Co-Create functionality</li>
								<li>Up to 50 Tags</li>
								<li>Training (1 In-Person Training Session)</li>
								<li>High Priority Online Support </li>
								<li>Phased Approvals</li>
								<li class="disclaimer">Additional brands, users, upgrades and customizations are available. <a href="#">Contact for details</a></li>
								<li><a data-plan_change="upgrade" class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="PREMIERE" data-price="$499.00">Select Plan ($499 Per Month)</a></li>
							</ul>
						</div>
					</div>

				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/intlTelInput.min.js?ver=9.0.2'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/user_preference.js?ver=1.0.0'></script>
</body>
</html>
