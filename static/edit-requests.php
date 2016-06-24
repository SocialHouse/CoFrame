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
					<h1 class="center-title section-title">Post Approval</h1>
				</header>
					<div class="row equal-columns">
						<div class="col-md-4 equal-height">
							<?php include("lib/post-preview-approval.php"); ?>
						</div>
						<div class="col-md-4 equal-height">
							<?php include("lib/post-approval-view-phases.php"); ?>
						</div>
						<div class="col-md-4 equal-height">
							<?php include("lib/edit-requests.php"); ?>
						</div>
					</div>
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
	<!-- Undo Approval Modal -->
	<div class="modal alert-modal fade" id="undoApproval" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content bg-white">
				<div class="modal-body">
					<h2 class="text-xs-center">Undo Approval</h2>
					<p class="text-xs-center">Are you sure you want to undo your approval?
					You will have to approve this again.</p>
					<footer class="overlay-footer">
					<button type="button" class="btn btn-sm btn-default modal-hide">Go Back</button>
					<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Undo</button>
					</footer>
				</div>
			</div>
		</div>
	</div>
	<!-- Submit For Approval Modal -->
	<div class="modal alert-modal fade" id="submitApproval2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content bg-white">
				<div class="modal-body">
					<h2 class="text-xs-center">Submit to Phase 2</h2>
					<p class="text-xs-center">You are about to submit this post to Phase 2 approvers.</p>
					<footer class="overlay-footer">
					<button type="button" class="btn btn-sm btn-default modal-hide">Go Back</button>
					<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Submit</button>
					</footer>
				</div>
			</div>
		</div>
	</div>
	<!-- Submit For Approval #3 Modal -->
	<div class="modal alert-modal fade" id="submitApproval3" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content bg-white">
				<div class="modal-body">
					<h2 class="text-xs-center">Submit to Phase 3</h2>
					<p class="text-xs-center">You are about to submit this post to Phase 3 approvers.</p>
					<footer class="overlay-footer">
					<button type="button" class="btn btn-sm btn-default modal-hide">Go Back</button>
					<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Submit</button>
					</footer>
				</div>
			</div>
		</div>
	</div>
	<!-- Post Now Modal -->
	<div class="modal alert-modal fade" id="postNow" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content bg-white">
				<div class="modal-body">
					<h2 class="text-xs-center">Post Now</h2>
					<p class="text-xs-center">You are about to post to an outlet. You can’t undo this action.</p>
					<footer class="overlay-footer">
					<button type="button" class="btn btn-sm btn-default modal-hide">Go Back</button>
					<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Post Now</button>
				</footer>
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
