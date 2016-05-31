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
				<header class="page-main-header calendar-header">
					<div class="clearfix">
						<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-week" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
						<h2 class="date-header pull-xs-left">Calendar | <strong id="calendarCurrentMonth"><?php echo date('F'); ?></strong> <span id="calendarDateRange"></span> <span id="calendarCurrentYear"><?php echo date('Y'); ?></span></h2>
						<div class="btn-group-calendar pull-sm-left">
							<a href="calendar.php" class="btn btn-sm">Day</a>
							<a href="calendar-week.php" class="btn btn-sm active">Week</a>
							<a href="calendar-month.php" class="btn btn-sm">Month</a>
						</div>
						<div class="btn-group-calendar pull-sm-left">
							<a href="#" class="btn btn-sm active" id="calendarBtnToday">Today</a>
						</div>
						<div class="pull-md-right toolbar">
							<a href="#" class="tf-icon-circle pull-xs-left"><i class="tf-icon-search"></i></a>
							<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="lib/post-filters.php" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70"><i class="tf-icon-filter"></i></a>
							<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="lib/print-posts.php" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20" data-hide="false"><i class="tf-icon-print"></i></a>
						</div>
					</div>
					<div id="selectedFilters" class="clearfix border-top border-black hidden">
						<strong class="uppercase">Filters: </strong>
						<ul class="filter-list tag-list">
						</ul>
						<button type="button" class="btn btn-sm btn-secondary reset-filter pull-sm-right" data-filter="*">Reset Filters</button>
					</div>
					<div id="calendar-change-week" class="hidden calendar-select-date">
						<div class="date-select-calendar"></div>
						<div class="text-xs-center">
							<hr>
							<button type="button" class="btn btn-sm btn-default btn-cancel qtip-hide">Cancel</button>
							<button type="button" id="getPostsByDate" class="btn btn-sm btn-default btn-disabled qtip-hide" disabled>Apply</button>
						</div>
					</div>
				</header>
				<div class="row">
					<div class="col-md-12">
						<div id="calendar-week"></div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<button type="button" class="modal-toggler">
		<span class="sr-only">Toggle Modal</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<!-- Blank Modal -->
	<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content bg-white">
		  <div class="modal-body">
		  </div>
		</div>
	  </div>
	</div>
	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/isotope.pkgd.min.js?ver=3.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/moment.min.js?ver=2.11.0'></script>
	<script type='text/javascript' src='assets/js/vendor/fullcalendar.min.js?ver=2.6.1'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.dotdotdot.min.js?ver=1.8.1'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/calendar-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/post-filters.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/drag-drop-file-upload.js?ver=1.0.0'></script>
</body>
</html>