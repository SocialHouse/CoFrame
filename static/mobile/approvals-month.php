<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
<link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all">
<link href="assets/css/fullcalendar.css" rel="stylesheet">
<script type='text/javascript' src='assets/js/vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global">
	<div class="container container-head navbar-fixed-top bg-white">
		<?php include("lib/global-navigation.php"); ?>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<section id="overview" class="page-main col-sm-12">
				<header class="page-main-header header-fixed-top bg-white row">
					<h1 class="center-title section-title border-none">Approvals by Month</h1>
				</header>
				<div class="bg-white col-sm-12 content-shadow brand-main">
					<div class="content-shadow brand-header row">
						<div class="col-sm-12">
							<img src="assets/images/fpo/jbrand-brand-logo.png" class="circle-img pull-xs-left" height="75" width="75"> J Brand
						</div>
					</div>
					<div class="date-header row">
						<div class="col-sm-12">
							<div class="pull-xs-left">
								<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '-1 month' ) ); ?>" class="next-date"><i class="fa fa-angle-left fa-custom-circle bg-black"></i></a>
							</div>
							<div class="pull-xs-right">
								<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '+1 month' ) ); ?>" class="next-date"><i class="fa fa-angle-right fa-custom-circle bg-black"></i></a>
							</div>
							<div class="center-title"><a href="#approvalMonth" class="target-hidden"><?php echo date('F, Y'); ?></a></div>
							<input type="month" id="approvalMonth" class="invisible pos-absolute" name="approvalMonth">
						</div>
					</div>
					<ul class="my-approvals">
						<li>
							<div class="post-meta clearfix pos-relative">
								<a href="edit-requests.php">
								<div class="outlet-list pull-xs-left">
									<i class="fa fa-twitter" title="twitter"><span class="bg-outlet bg-twitter"></span></i>
								</div>
								<div class="post-meta-content">
									<span class="post-author">twitter Post By John Honkala:</span>
									<span class="post-date">Thursday, 09/22/16 at 09:00 AM PST</span>
								</div>
								<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
								</a>
							</div>
							<div class="post-content clearfix">
								<img src="assets/images/fpo/post-img-2.jpg" class="pull-xs-left" width="420">
								<div class="post-body">
									<p>Nail the relaxed look with #CDenim ripped jeans.</p>
								</div>
							</div>
							<div class="post-footer clearfix">
								<span class="pull-xs-left post-actions">
									<div class="before-approve">
										<a class="btn btn-sm btn-secondary change-approve-status" data-post-id="28" data-phase-id="" data-phase-status="approved">Approve</a>
									</div>
									<div class="after-approve hidden">
										<button class="btn btn-secondary btn-disabled btn-sm" disabled="">Approved</button>
									</div>
								</span>
								<button class="btn-icon btn-icon-lg btn-menu popover-toggle pull-xs-right" data-toggle="popover-ajax" data-hide="false" data-content-src="lib/calendar-edit-menu.php" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day">
									<i class="fa fa-circle-o"></i> 
									<i class="fa fa-circle-o"></i> 
									<i class="fa fa-circle-o"></i>
								</button>
							</div>
						</li>
						<li>
							<div class="post-meta clearfix pos-relative">
								<a href="edit-requests.php">
								<div class="outlet-list pull-xs-left">
									<i class="fa fa-twitter" title="twitter"><span class="bg-outlet bg-twitter"></span></i>
								</div>
								<div class="post-meta-content">
									<span class="post-author">twitter Post By John Honkala:</span>
									<span class="post-date">Thursday, 09/22/16 at 09:00 AM PST</span>
								</div>
								<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
								</a>
							</div>
							<div class="post-content clearfix">
								<img src="assets/images/fpo/post-img-2.jpg" class="pull-xs-left" width="420">
								<div class="post-body">
									<p>Nail the relaxed look with #CDenim ripped jeans.</p>
								</div>
							</div>
							<div class="post-footer clearfix">
								<span class="pull-xs-left post-actions">
									<div class="after-approve">
										<button class="btn btn-secondary btn-disabled btn-sm" disabled="">Approved</button>
									</div>
								</span>
								<button class="btn-icon btn-icon-lg btn-menu popover-toggle pull-xs-right" data-toggle="popover-ajax" data-hide="false" data-content-src="lib/calendar-edit-menu.php" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day">
									<i class="fa fa-circle-o"></i> 
									<i class="fa fa-circle-o"></i> 
									<i class="fa fa-circle-o"></i>
								</button>
							</div>
						</li>
					</ul>
				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
</body>
</html>
