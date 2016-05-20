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
						<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-month" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
						<h2 class="date-header pull-xs-left">Approvals</h2>
						<div class="pull-md-right toolbar">
							<a href="#" class="tf-icon-circle pull-xs-left"><i class="tf-icon-search"></i></a>
							<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="lib/post-filters.php" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70"><i class="tf-icon-filter"></i></a>
							<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="lib/print-posts.php" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20"><i class="tf-icon-print"></i></a>
						</div>
					</div>
					<div id="selectedFilters" class="clearfix border-top border-black hidden">
						<strong class="uppercase">Filters: </strong>
						<ul class="filter-list tag-list">
						</ul>
						<button type="button" class="btn btn-sm btn-secondary reset-filter pull-sm-right" data-filter="*">Reset Filters</button>
					</div>
					<div id="calendar-change-month" class="hidden calendar-select-date">
						<div class="date-select-calendar"></div>
						<div class="text-xs-center">
							<hr>
							<button type="button" class="btn btn-sm btn-default qtip-hide">Cancel</button>
							<button type="button" id="getPostsByDate" class="btn btn-sm btn-default btn-disabled qtip-hide" disabled>Apply</button>
						</div>
					</div>
				</header>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-approvals">
							<tbody>
								<tr>
									<th>Post Day</th>
									<th>Post Time</th>
									<th>Tags</th>
									<th>Outlet</th>
									<th>Status</th>
									<th>Post Copy</th>
									<th>Approvals</th>
									<th>Schedule / View Edit Requests</th>
								</tr>
								<tr>
									<td>Tue 5/12</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div tabindex="0" class="post-tags" data-toggle="popover-inline" data-popover-id="tags-postid-1223" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center">
											<i class="fa fa-circle tag-green"></i><i class="fa fa-circle tag-orange"></i><i class="fa fa-circle tag-red"></i>
						<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
											<div id="tags-postid-1223" class="hidden">
												<div class="tag-list">
													<ul>
														<li class="tag"><i class="fa fa-circle tag-red"></i>Brand Building / Product Education</li>
														<li class="tag"><i class="fa fa-circle tag-orange"></i>Orange Tag</li>
														<li class="tag"><i class="fa fa-circle tag-green"></i>Marketing</li>
													</ul>
												</div>
											</div>								
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>
									</td>
									<td class="text-xs-center">Scheduled</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">
										<ul class="timeframe-list approval-list">
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="pending">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
										</ul>
									</td>
									<td class="text-xs-center"><a class="btn btn-xs btn-disabled btn-secondary">Scheduled</a> <a href="edit-requests.php" class="btn btn-xs btn-wrap btn-disabled btn-default">View Edit<br>Requests</a></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div tabindex="0" class="post-tags" data-toggle="popover-inline" data-popover-id="tags-postid-1225" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center">
											<i class="fa fa-circle tag-red"></i><i class="fa fa-circle tag-orange"></i>
						<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
											<div id="tags-postid-1225" class="hidden">
												<div class="tag-list">
													<ul>
														<li class="tag"><i class="fa fa-circle tag-red"></i>Brand Building / Product Education</li>
														<li class="tag"><i class="fa fa-circle tag-orange"></i>Orange Tag</li>
													</ul>
												</div>
											</div>								
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>
									</td>
									<td class="text-xs-center">Scheduled</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">
										<ul class="timeframe-list approval-list">
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="pending">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
										</ul>
									</td>
									<td class="text-xs-center"><a class="btn btn-xs btn-disabled btn-secondary">Scheduled</a> <a href="edit-requests.php" class="btn btn-xs btn-wrap btn-disabled btn-default">View Edit<br>Requests</a></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div tabindex="0" class="post-tags" data-toggle="popover-inline" data-popover-id="tags-postid-1226" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center">
											<i class="fa fa-circle tag-red"></i>
						<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
											<div id="tags-postid-1226" class="hidden">
												<div class="tag-list">
													<ul>
														<li class="tag"><i class="fa fa-circle tag-red"></i>Brand Building / Product Education</li>
													</ul>
												</div>
											</div>								
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i>
									</td>
									<td class="text-xs-center">Scheduled</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">
										<ul class="timeframe-list approval-list">
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="pending">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
										</ul>
									</td>
									<td class="text-xs-center"><a class="btn btn-xs btn-secondary">Schedule</a> <a href="edit-requests.php" class="btn btn-xs btn-wrap btn-default">View Edit<br>Requests</a></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div tabindex="0" class="post-tags" data-toggle="popover-inline" data-popover-id="tags-postid-1227" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center">
											<i class="fa fa-circle tag-orange"></i><i class="fa fa-circle tag-green"></i>
						<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
											<div id="tags-postid-1227" class="hidden">
												<div class="tag-list">
													<ul>
														<li class="tag"><i class="fa fa-circle tag-orange"></i>Orange Tag</li>
														<li class="tag"><i class="fa fa-circle tag-green"></i>Marketing</li>
													</ul>
												</div>
											</div>								
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-vine"><span class="bg-outlet bg-vine"></span></i>
									</td>
									<td class="text-xs-center">Scheduled</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">
										<ul class="timeframe-list approval-list">
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="pending">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
										</ul>
									</td>
									<td class="text-xs-center"><a class="btn btn-xs btn-disabled btn-secondary">Scheduled</a> <a href="edit-requests.php" class="btn btn-xs btn-wrap btn-disabled btn-default">View Edit<br>Requests</a></td>
								</tr>
								<tr>
									<td>Wed 5/13</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div tabindex="0" class="post-tags" data-toggle="popover-inline" data-popover-id="tags-postid-1228" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center">
											<i class="fa fa-circle tag-green"></i>
						<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
											<div id="tags-postid-1228" class="hidden">
												<div class="tag-list">
													<ul>
														<li class="tag"><i class="fa fa-circle tag-green"></i>Marketing</li>
													</ul>
												</div>
											</div>								
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i>
									</td>
									<td class="text-xs-center">Scheduled</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">
										<ul class="timeframe-list approval-list">
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="approved">
												<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
											<li class="pending">
												<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img">
											</li>
										</ul>
									</td>
									<td class="text-xs-center"><a class="btn btn-xs btn-disabled btn-secondary">Scheduled</a> <a href="edit-requests.php" class="btn btn-xs btn-wrap btn-disabled btn-default">View Edit<br>Requests</a></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>

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
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/calendar-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/post-filters.js?ver=1.0.0'></script>
</body>
</html>
