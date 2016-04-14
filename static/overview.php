<!doctype html>
<html>
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
		<div class="content-area row">
			<section id="overview" class="page-main bg-white col-sm-12">
				<header class="page-main-header">
					<a href="add-a-brand.php" class="btn btn-secondary btn-sm pull-sm-left">Add a Brand</a>
					<a href="#" class="btn btn-default btn-sm pull-sm-right">Reorder <i class="fa fa-bars"></i></a>
					<h1 class="center-title section-title">Overview</h1>
				</header>
				<div class="row">
					<div class="col-md-2">
						<?php include("lib/brand-link.php"); ?>
					</div>
					<div class="col-md-6">
						<?php include("lib/reminder-list.php"); ?>
					</div>
					<div class="col-md-4">
						<?php include("lib/summary-list.php"); ?>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
</body>
</html>
