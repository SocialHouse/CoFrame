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
					<h1 class="center-title section-title border-none">Edit Post</h1>
				</header>
				<div class="bg-white col-sm-12 content-shadow brand-main">
					<div class="content-shadow brand-header row">
						<div class="col-sm-12">
							<img src="assets/images/fpo/jbrand-brand-logo.png" class="circle-img pull-xs-left" height="75" width="75"> J Brand
						</div>
					</div>
					<form>
						<ul class="timeframe-list full-width-list edit-post">
							<li data-toggle="modal" data-target="#changeOutletModal">
								<div class="outlet-list pull-xs-left">
									<i class="fa fa-twitter" title="twitter"><span class="bg-outlet bg-twitter"></span></i>Twitter
								</div>
								<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
							</li>
							<li>
								<a href="#postDateField" class="target-hidden">Thursday, 9/22/16 at 9:00 AM PST</a>
								<input type="datetime-local" id="postDateField" class="invisible pos-absolute" name="postDate">
							</li>
							<li>
							<span contenteditable="true" id="postContentEditable" class="content-editable" data-input="#postContent">Let whites influence your fresh new spring silhouette.
							<br><br>
							Meet the inspiration behind J BRAND Spring on Tumblr: http://jbrn.dj/Tumblr</span>
							<textarea id="postContent" class="hidden">Let whites influence your fresh new spring silhouette.
							<br><br>
							Meet the inspiration behind J BRAND Spring on Tumblr: http://jbrn.dj/Tumblr</textarea>
							</li>
							<li>
							<div class="form-group" id="mediaUpload">
								<div class="form__input has-files clearfix">
									<div class="form__preview-wrapper"><i class="tf-icon-circle remove-upload">x</i><img src="assets/images/fpo/post-img-2.jpg" alt="" class="form__file-preview"/></div>
									<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
									<label for="postFile" id="postFileLabel" class="file-upload-label"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>
								</div>
							</div>
							</li>
							<li data-toggle="modal-ajax" data-modal-src="lib/select-tags.php" data-class="full-page-modal" data-title="Edit Tags" data-clear="no" data-modal-id="modal-post-tags">
								<div class="post-tags pull-xs-left">
									<i class="fa fa-circle" style="color:#ff7bac"></i>
									<i class="fa fa-circle" style="color:#662d91"></i>
								</div>
								Tags						
								<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
							</li>
							<li data-toggle="modal-ajax" data-modal-src="lib/approvals.php" data-class="full-page-modal" data-title="Mandatory Approvals" data-clear="no" data-modal-id="modal-approvals">
								View Mandatory Approvals
								<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
							</li>
						</ul>
					</form>
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
	
	<!-- Change Outlet Modal -->
	<div class="modal alert-modal fade" id="changeOutletModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content bg-white">
				<div class="modal-header">
					<h1 class="text-xs-center">Change Outlet</h2>
				</div>
				<div class="modal-body">
					<p class="text-xs-center">Some of the post details such as multiple photos may not be compatible with certain outlets.</p>
				</div>
				<div class="modal-footer">
					<div class="btn-group" role="group">
					  <button type="button" class="btn btn-sm btn-default modal-hide col-xs-6">Cancel</button>
					  <button type="button" class="btn btn-sm btn-default col-xs-6" data-toggle="modal-ajax" data-modal-src="lib/select-outlet.php" data-class="full-page-modal" data-title="Change Outlet" data-clear="no" data-modal-id="modal-post-outlet">Continue</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/modal-config.js?ver=1.0.0'></script>

</body>
</html>
