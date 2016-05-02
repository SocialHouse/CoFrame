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
				<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="add-brand-details" class="file-upload clearfix row-sm-12">	
				<div class="row row-sm-12 equal-cols">
					<div class="brand-steps col-xl-11 center-block">
						<div class="col-md-3 col-sm-6 brand-step active" id="brandStep1">
							<?php include("lib/add-brand-step-1.php"); ?>
						</div>
						<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep2">
							<?php include("lib/add-brand-step-2.php"); ?>
						</div>
						<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep3">
							<?php include("lib/add-brand-step-3.php"); ?>
						</div>
						<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep4">
							<?php include("lib/add-brand-step-4.php"); ?>
						</div>
					</div>
					<div class="modal-backdrop fade in modal-contain"></div>
				</div>
				</form>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/drag-drop-file-upload.js?ver=1.0.0'></script>
</body>
</html>
