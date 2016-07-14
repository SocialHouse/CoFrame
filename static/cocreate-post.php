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
			<section id="brand-manage" class="page-main bg-white col-sm-10 cocreate-post">
				<div class="row">
					<div class="col-sm-8">
						<header class="page-main-header">
							<h1 class="center-title section-title">Co-Create</h1>
						</header>
					</div>
					<div class="col-sm-4">
						<header class="page-main-header">
							<h1 class="center-title section-title">Discussion</h1>
						</header>
						<div class="cocreate-opts text-xs-center">
							<i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-tele"></i></i>
							<i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-video"></i></i>
						</div>
					</div>
				</div>
					<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="post-details" class="file-upload clearfix">	
						<div class="row equal-columns">
							<div class="col-md-4 equal-height">
								<?php include("lib/post-preview.php"); ?>
							</div>
							<div class="col-md-4 equal-height">
								<?php include("lib/add-post-details.php"); ?>
							</div>
							<div class="col-md-4 equal-height">
								<?php include("lib/cocreate-post-discussion.php"); ?>
							</div>
						</div>
					</form>
			</section>
		</div>
	</div>

	<!-- Blank Modal -->
	<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		  </div>
		  <div class="modal-body">
		  </div>
		</div>
	  </div>
	</div>
	<!-- Select Date Calendar -->
	<div id="calendar-select-date" class="hidden calendar-select-date">
		<div class="date-select-calendar"></div>
	</div>
	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/moment.min.js?ver=2.11.0'></script>
	<script type='text/javascript' src='assets/js/vendor/fullcalendar.min.js?ver=2.6.1'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/calendar-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/drag-drop-file-upload.js?ver=1.0.0'></script>
	<script>fileDragNDrop();</script>
</body>
</html>