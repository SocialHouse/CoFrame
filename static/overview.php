<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all">
<script type='text/javascript' src='http://fast.fonts.net/jsapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.js'></script>
<script type='text/javascript' src='assets/js/vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global" style="background-image: url(assets/images/bg-admin-overview.jpg);">
	<div class="container container-head">
		<?php include("lib/global-navigation.php"); ?>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<section id="overview" class="page-main bg-white col-sm-12">
				<header class="page-main-header">
					<a href="add-a-brand.php" class="btn btn-secondary btn-sm pull-sm-left">Add a Brand</a>
					<a href="#" class="btn btn-default btn-sm btn-reorder pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="lib/reorder-brands.php" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
					<h1 class="center-title section-title">Overview</h1>
				</header>
				<div id="brand-sort">
					<div class="brand-overview" data-list-order="0" data-brand="Lorac Cosmetics">
						<div class="row">
							<div class="col-md-10 col-md-offset-2">
								<h2>Lorac</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<?php include("lib/brand-link.php"); ?>
							</div>
							<div class="col-md-6">
								<?php include("lib/reminder-list-sm.php"); ?>
							</div>
							<div class="col-md-4">
								<?php include("lib/summary-list.php"); ?>
							</div>
						</div>
					</div>
					<div class="brand-overview" data-list-order="1" data-brand="J Brand">
						<div class="row">
							<div class="col-md-10 col-md-offset-2">
								<h2>J Brand</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<?php include("lib/brand-link.php"); ?>
							</div>
							<div class="col-md-6">
								<?php include("lib/reminder-list-sm.php"); ?>
							</div>
							<div class="col-md-4">
								<?php include("lib/summary-list.php"); ?>
							</div>
						</div>
					</div>
					<div class="brand-overview" data-list-order="2" data-brand="Pepsi">
						<div class="row">
							<div class="col-md-10 col-md-offset-2">
								<h2>Pepsi</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<?php include("lib/brand-link.php"); ?>
							</div>
							<div class="col-md-6">
								<?php include("lib/reminder-list-sm.php"); ?>
							</div>
							<div class="col-md-4">
								<?php include("lib/summary-list.php"); ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery-ui-sortable.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/reorder-brands.js?ver=1.0.0'></script>
</body>
</html>
