<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
<link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all">
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
					<h1 class="center-title section-title border-none">Dashboard</h1>
				</header>
				<div class="bg-white col-sm-12 content-shadow brand-main">
					<div class="content-shadow brand-header row">
						<div class="col-sm-12">
							<img src="assets/images/fpo/jbrand-brand-logo.png" class="circle-img pull-xs-left" height="75" width="75"> J Brand
						</div>
					</div>
					<ul class="timeframe-list to-do-list">
						<li class="reminder-list"><a href="#reminderList" class="pos-relative" data-toggle="collapse">Reminders<span class="tag tag-danger tag-pill">5</span><i class="fa fa-angle-right expand-collapse"></i></a>
							<ol id="reminderList" class="collapse">
								<li>
									<a href="#">Review feedback from David W. <i class="fa fa-exclamation-circle color-danger" data-toggle="popover" data-popover-class="color-danger" data-content="Action required by 8/28/16 at 9:00 pm"></i><br>
									<span class="do-detail">Facebook post 8/29</span>
									<i class="fa fa-angle-right expand-collapse"></i></a>
								</li>
								<li>
									<a href="#">Approve post <i class="fa fa-exclamation-circle color-danger" data-toggle="popover" data-popover-class="color-danger" data-content="Approval required by 8/28/16 at 9:00 pm"></i><br>
									<span class="do-detail">Facebook post 8/31</span>
									<i class="fa fa-angle-right expand-collapse"></i></a>
								</li>
								<li>
									<a href="#">Review feedback from Kristin P. <br>
									<span class="do-detail">Twitter post 9/2</span>
									<i class="fa fa-angle-right expand-collapse"></i></a>
								</li>
								<li>
									<a href="#">Review feedback from Jose A.<br>
									<span class="do-detail">Vine post 9/3</span>
									<i class="fa fa-angle-right expand-collapse"></i></a>
								</li>
								<li>
									<a href="#">Review post<br>
									<span class="do-detail">Twitter post 9/5</span>
									<i class="fa fa-angle-right expand-collapse"></i></a>
								</li>
							</ol>
						</li>
						<li><a href="#summaryList" class="pos-relative" data-toggle="collapse">Summary<i class="fa fa-angle-right expand-collapse"></i></a>
							<ul class="summary-list collapse" id="summaryList">
								<li>
									<i class="tf-icon-schedule tf-icon-circle bg-info pull-xs-left"></i>Scheduled Posts 
									<div class="pull-xs-right tag">13</div>
								</li>
								<li>
									<i class="fa fa-minus-circle color-warning pull-xs-left"></i>Pending Approval 
									<div class="pull-xs-right tag">2</div>
								</li>
								<li>
									<i class="tf-icon-ticktock tf-icon-circle bg-orange pull-xs-left"></i>Awaiting Scheduling 
									<div class="pull-xs-right tag">0</div>
								</li>
								<li>
									<i class="fa fa-pencil fa-custom-circle color-white bg-gray pull-xs-left"></i>Drafts 
									<div class="pull-xs-right tag">5</div>
								</li>
							</ul>
						</li>
						<li><a href="approvals.php" class="pos-relative">Approvals<i class="fa fa-angle-right expand-collapse"></i></a></li>
					</ul>
				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/fullcalendar.min.js?ver=2.6.1'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
</body>
</html>
