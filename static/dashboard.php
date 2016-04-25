<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all">
<link type="text/css" rel="stylesheet" href="assets/css/fullcalendar.css" media="all">
<script type='text/javascript' src='http://fast.fonts.net/jsapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.js'></script>
<script type='text/javascript' src='assets/js/vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global" style="background-image: url(assets/images/bg-brand-management.jpg);">
	<div class="container container-head">
		<?php include("lib/global-navigation.php"); ?>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<section class="brand-navigation bg-white opaque-88 col-sm-2">
				<?php include("lib/brand-navigation.php"); ?>
				<div class="current-user-details">
					<div class="user-name">Master</div>
					<div class="user-time row">
						<div class="col-md-5">Current Brand Time </div>
						<div class="col-md-7 text-md-right current-time">
							<strong id="userTime"></strong><br>
							<?php echo date('a T'); ?>
						</div>
					</div>
				</div>
			</section>
			<section id="brand-manage" class="page-main bg-white col-sm-10">
				<header class="page-main-header">
					<h1 class="center-title section-title">Brand Dashboard</h1>
					<h2 class="date-header"><strong><?php echo date('F'); ?></strong> <?php echo date('d') . ", " . date('Y'); ?></h2>
				</header>
				<div class="row equal-cols">
					<div class="col-md-6">
						<?php include("lib/reminder-list.php"); ?>
					</div>
					<div class="col-md-3">
						<?php include("lib/summary-list.php"); ?>
					</div>
					<div class="col-md-3">
						<?php include("lib/calendar-today-summary.php"); ?>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/moment.min.js?ver=2.11.0'></script>
	<script type='text/javascript' src='assets/js/vendor/fullcalendar.min.js?ver=2.6.1'></script>
	<script type='text/javascript' src='assets/js/calendar-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
</body>
</html>
