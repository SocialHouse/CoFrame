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
		<?php include("lib/global-navigation-approvals.php"); ?>
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
								<div id="outlet-prev" class="next-outlet"></div>
							</div>
							<div class="pull-xs-right">
								<div id="outlet-next" class="next-outlet"></div>
							</div>
							<ul class="outlet-list bxslider">
								<li class="" data-value="check-all"><i class="fa"><span class="bg-outlet bg-all"></span><span class="outlet-text">All</span></i></li>
								<li class="disabled" data-selected-outlet="facebook"><i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i></li>
								<li class="disabled" data-selected-outlet="twitter"><i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i></li>
								<li class="disabled" data-selected-outlet="instagram"><i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i></li>
								<li class="disabled" data-selected-outlet="linkedin"><i class="fa fa-linkedin"><span class="bg-outlet bg-linkedin"></span></i></li>
								<li class="disabled" data-selected-outlet="vimeo"><i class="fa fa-vimeo"><span class="bg-outlet bg-vimeo"></span></i></li>
								<li class="disabled" data-selected-outlet="pinterest"><i class="fa fa-pinterest"><span class="bg-outlet bg-pinterest"></span></i></li>
								<li class="disabled" data-selected-outlet="tumblr"><i class="fa fa-tumblr"><span class="bg-outlet bg-tumblr"></span></i></li>
								<li class="disabled" data-selected-outlet="youtube"><i class="fa fa-youtube-play"><span class="bg-outlet bg-youtube"></span></i></li>
							</ul>
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
								<button class="btn-icon btn-icon-lg btn-menu popover-toggle pull-xs-right" data-toggle="modal-ajax" data-hide="false" data-modal-src="lib/calendar-edit-menu.php" data-modal-id="modal-post-menu">
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
								<button class="btn-icon btn-icon-lg btn-menu popover-toggle pull-xs-right" data-toggle="modal-ajax" data-hide="false" data-modal-src="lib/calendar-edit-menu.php" data-modal-id="modal-post-menu">
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

	<!-- Blank Modal -->
	<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
		  </div>
		</div>
	  </div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/isotope.pkgd.min.js?ver=3.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.bxslider.min.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/bxslider-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/modal-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/post-filters.js?ver=1.0.0'></script>
</body>
</html>
