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
				<div class="row">
					<div class="col-md-3">
						<?php include("lib/search-filters.php"); ?>
					</div>
					<div class="col-md-9">
						<header class="page-main-header search-header">
							<div class="clearfix">
								<h1 class="pull-md-left title-search">5 refined search results for search term</h1>
								<div class="pull-md-right toolbar">
									<form class="form-inline pull-xs-left form-search">
									<input type="text" name="search" class="form-control input-search">
									<button type="submit" class="btn btn-search"><i class="tf-icon-search"></i></button>
									</form>
									<a href="#" class="tf-icon-circle pull-xs-left" id="showSearch"><i class="tf-icon-search"></i></a>
								</div>
							</div>
						</header>
						<table class="table table-striped table-approvals">
							<tbody>
								<tr>
									<th>Post Date</th>
									<th>Post Time</th>
									<th>Tags</th>
									<th>Outlet</th>
									<th>Post Copy</th>
									<th>Status</th>
								</tr>
								<tr onClick="showPostPopover(jQuery(this).find('.bg-outlet'), 1223, 'click', 'approvals-post');">
									<td>Tue 5/12</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div class="post-tags">
											<i class="fa fa-circle tag-green"></i><i class="fa fa-circle tag-orange"></i><i class="fa fa-circle tag-red"></i>
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>
									</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">Scheduled</td>
								</tr>
								<tr onClick="showPostPopover(jQuery(this).find('.bg-outlet'), 1224, 'click', 'approvals-post');">
									<td>Tue 5/12</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div class="post-tags">
											<i class="fa fa-circle tag-red"></i><i class="fa fa-circle tag-orange"></i>
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>
									</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">Scheduled</td>
								</tr>
								<tr onClick="showPostPopover(jQuery(this).find('.bg-outlet'), 1225, 'click', 'approvals-post');">
									<td>Tue 5/12</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div class="post-tags">
											<i class="fa fa-circle tag-red"></i>
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i>
									</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">Scheduled</td>
								</tr>
								<tr onClick="showPostPopover(jQuery(this).find('.bg-outlet'), 1226, 'click', 'approvals-post');">
									<td>Tue 5/12</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div class="post-tags">
											<i class="fa fa-circle tag-orange"></i><i class="fa fa-circle tag-green"></i>
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-vine"><span class="bg-outlet bg-vine"></span></i>
									</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">Scheduled</td>
								</tr>
								<tr onClick="showPostPopover(jQuery(this).find('.bg-outlet'), 1227, 'click', 'approvals-post');">
									<td>Wed 5/13</td>
									<td>12:55 PM</td>
									<td class="text-xs-center">
										<div class="post-tags">
											<i class="fa fa-circle tag-green"></i>
										</div>									
									</td>
									<td class="text-xs-center outlet-list">
										<i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i>
									</td>
									<td>Lorem ipsum dolor sit amet, consectetur adipisci...</td>
									<td class="text-xs-center">Scheduled</td>
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
								</tr>
								<tr>
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
