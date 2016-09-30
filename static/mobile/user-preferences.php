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
					<a href="user-preferences.php" class="btn btn-sm active">My Info</a>
					<a href="user-plan.php" class="btn btn-sm ">Plan</a>
					<a href="user-billing.php" class="btn btn-sm ">Billing</a>
					</div>
				</div>
				<div class="bg-white col-sm-12 content-shadow brand-main">
					<form action="https://timeframe-dev.blueshoon.com/User_preferences/edit_my_info" method="post" id="edit_user_info" novalidate="novalidate">
						<input type="hidden" name="aauth_user_id" id="aauth_user_id" value="7">
						<div class="form-group brand-image row border-bottom border-black">
							<div class="new-user-pic col-xs-3" id="img_div">
								<input type="file" id="userfileInput" name="files" accept="image/*" class="form-control invisible pos-absolute">
								<div class="cropme" id="new_user_pic" style="width: 70px; height: 70px;">
									<img src="assets/images/fpo/norel.jpg" class="circle-img">	
								</div>
								<input type="hidden" name="user_pic_base64" value="" id="user_pic_base64">
								<input id="is_user_image" type="hidden" value="yes" name="is_user_image">
							</div>
							<div class="col-xs-9">
								<a href="#userfileInput" class="target-hidden btn btn-default btn-sm btn-block">Change Photo</a>
							</div>
						</div>
							
						<label class="section-label">Personal Info</label>
						<div class="field-group">
							<div class="clearfix">
								<fieldset class="form-group pull-xs-left width-50">
									<label class="sr-only" for="firstName">First Name</label>
									<input type="text" class="form-control" id="firstName" placeholder="First Name" name="first_name" value="Roy">
								</fieldset>
								<fieldset class="form-group pull-xs-left width-50">
									<label class="sr-only" for="lastName">Last Name</label>
									<input type="text" class="form-control" id="lastName" placeholder="Last Name" name="last_name" value="Palondikar">
								</fieldset>
							</div>
							<fieldset class="form-group">
								<label class="sr-only" for="emailAddress">Email address</label>
								<input type="email" class="form-control" readonly="readonly" id="emailAddress" placeholder="Email" name="email" value="roy@blueshoon.com">
							</fieldset>
														<fieldset class="form-group">
								<label class="sr-only" for="phoneNumber">Phone Number</label>
								<input type="tel" id="phone" name="phone" data-error="true" class="form-control" value="+17739684230">
								<input type="hidden" name="phoneNumber" id="phoneNumber" value="+17739684230">
							</fieldset>
							<fieldset class="form-group">
								<label class="sr-only" for="timeZone">Time Zone</label>
								<select class="form-control" id="timeZone" name="timezone">
									<option value="">Time Zone</option>
									<option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option><option value="-11">(GMT -11:00) Midway Island, Samoa</option><option value="-10">(GMT -10:00) Hawaii</option><option value="-9">(GMT -9:00) Alaska</option><option value="-8">(GMT -8:00) Pacific Time (US &amp; Canada)</option><option value="-7">(GMT -7:00) Mountain Time (US &amp; Canada)</option><option value="-6" selected="selected">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option><option value="-5">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option><option value="-4">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option><option value="-3.5">(GMT -3:30) Newfoundland</option><option value="-3">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option><option value="-2">(GMT -2:00) Mid-Atlantic</option><option value="-1">(GMT -1:00 hour) Azores, Cape Verde Islands</option><option value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option><option value="1">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option><option value="2">(GMT +2:00) Kaliningrad, South Africa</option><option value="3">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option><option value="3.5">(GMT +3:30) Tehran</option><option value="4">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option><option value="4.5">(GMT +4:30) Kabul</option><option value="5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option><option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option><option value="5.75">(GMT +5:45) Kathmandu</option><option value="6">(GMT +6:00) Almaty, Dhaka, Colombo</option><option value="7">(GMT +7:00) Bangkok, Hanoi, Jakarta</option><option value="8">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option><option value="9">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option><option value="9.5">(GMT +9:30) Adelaide, Darwin</option><option value="10">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option><option value="11">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option><option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>								</select>
							</fieldset>
						</div>
						<label class="section-label">Login Info</label>
						<div class="field-group">
							<fieldset class="form-group">
								<label class="sr-only" for="password">Current Password</label>
								<input type="password" class="form-control" id="current_password" placeholder="Current Password" name="current_password">
							</fieldset>
							<fieldset class="form-group">
								<label class="sr-only" for="password">New Password</label>
								<input type="password" class="form-control" id="new_password" placeholder="New Password" name="new_password">
							</fieldset>
							<fieldset class="form-group">
								<label class="sr-only" for="password">Confirm new Password</label>
								<input type="password" class="form-control" id="confirm_password" placeholder="Confirm new Password" name="confirm_password">
							</fieldset>
						</div>
						<div class="">
							<label class="section-label">Master Admin Info</label>
							<div class="field-group">
								<fieldset class="form-group">
									<label class="sr-only" for="companyName">Company Name</label>
									<input type="text" class="form-control" id="companyName" placeholder="Company Name" name="company_name" value="Blueshoon, inc">
								</fieldset>
								<fieldset class="form-group">
									<label class="sr-only" for="companyEmail">Company Email</label>
									<input type="email" class="form-control" id="companyEmail" placeholder="Company Email" name="company_email" value="">
								</fieldset>
								<fieldset class="form-group">
									<label class="sr-only" for="companyURL">Company URL</label>
									<input type="text" class="form-control" id="companyURL" placeholder="Company URL" name="company_url" value="">
								</fieldset>
							</div>
						</div>
						<label class="section-label">Notification</label>
						<div class="field-group text-xs-left">
							<fieldset class="form-group">
								<label>
									<input type="checkbox" value="yes" checked="checked" name="email_notification">&nbsp;Email &nbsp;
								</label>
								<label>
									<input type="checkbox" value="yes" checked="checked" name="desktop_notification">&nbsp;Desktop &nbsp;
								</label>
								<label>
									<input type="checkbox" value="yes" checked="checked" name="urgent_notification">&nbsp;Urgent &nbsp;
								</label>
							</fieldset>
						</div>
						<button type="submit" class="btn btn-secondary btn-sm btn-block">Save Changes</button>
					</form>
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
