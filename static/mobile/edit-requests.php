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
					<h1 class="center-title section-title border-none">Post Preview / Edit Requests</h1>
				</header>
				<div class="bg-white col-sm-12 content-shadow brand-main">
					<div class="content-shadow brand-header row">
						<div class="col-sm-12">
							<img src="assets/images/fpo/jbrand-brand-logo.png" class="circle-img pull-xs-left" height="75" width="75"> J Brand
						</div>
					</div>
					<div class="post-meta pos-relative border-bottom border-black row">
						<div class="col-sm-12">
							<div class="outlet-list pull-xs-left">
								<i class="fa fa-twitter" title="twitter"><span class="bg-outlet bg-twitter"></span></i>
							</div>
							<div class="post-meta-content">
								<span class="post-author">twitter Post By John Honkala:</span>
								<span class="post-date">Thursday, 09/22/16 at 09:00 AM PST</span>
							</div>
						</div>
					</div>
					<div id="live-post-preview-approver">
						<div id="outlet_3" class="ig_post">
							<div class="post-container clearfix">
								<div class="clearfix post-header">
									<div class="pull-left">
										<img class="img-circle user-profile-img" src="assets/images/default_profile.jpg">
									</div>
									<span class="post-user-name pull-left">C. Denim</span>
									<div class="pull-right time-color">0m</div>
								</div>
							
								<div class="insta-img-div img-div">
									<img src="assets/images/fpo/57b61ee96cb99.jpg">	
								</div>	
									
								<div class="insta-post-copy">
									<span class="post-user-name">C. Denim</span>
									<span class="post_copy_text">
									Take your denim for a ride. <a href="#">#CDenim</a> <a href="#">#denim</a> <a href="#">#OOTD</a>			</span>
								</div>
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
							<button class="btn-icon btn-icon-lg btn-menu pull-xs-right" data-toggle="modal-ajax" data-hide="false" data-modal-src="lib/calendar-edit-menu.php" data-modal-id="modal-post-menu">
								<i class="fa fa-circle-o"></i> 
								<i class="fa fa-circle-o"></i> 
								<i class="fa fa-circle-o"></i>
							</button>
						</div>
					</div>
					<div class="container-post-discussion">
						<img class="circle-img pull-xs-left current-user" width="36" height="36" src="assets/images/default_profile.jpg">
						<div class="suggest-edit">
							<!-- Suggest an Edit Start-->
							<div class="comment-section">
								<div class="form-group">
									<label for="postCopy">Suggest an Edit:</label>
									<textarea class="form-control" id="comment_copy" rows="2" name="comment" placeholder="Suggest an edit here..."></textarea>
								</div>
								<div class="form-group clearfix">
									<div class="attachment pull-xs-left">
										<input type="file" name="attachment" class="hidden attachment_image">
										<button title="Add Attachment" class="btn-icon add-attachment pull-xs-left">
										<i class="fa fa-paperclip"></i></button>
										<img id="attached_img" class="base-64-img" height="30" width="30">
										<a href="#" class="remove-attached-img hidden">
											<i class="tf-icon-circle remove-upload">x</i>
										</a>
									</div>
									<div class="pull-xs-right">
										<button type="button" class="btn btn-default btn-sm reset-edit-request">Clear</button>
										<button type="button" class="btn btn-secondary btn-sm btn-disabled save-edit-req" data-phase-id="4" disabled="disabled">Submit</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Suggest an Edit End -->

						<!-- Display Comments Start -->
						<ul class="timeframe-list comment-list clearfix">
							<li class="comment-section">
								<div class="author clearfix">
									<img class="circle-img pull-xs-left" src="assets/images/default_profile.jpg" width="36" height="36" alt="Elizabeth Eun">
									<div class="author-meta pull-xs-left">
										Elizabeth Eun	
										<span class="dateline">September 13 at 7:43 pm</span>
									</div>															
								</div>
					
								<div class="comment">
									<div class="comment_view2">
										<p class="text">i hate this what about this </p>
										<div class="comment-asset">
											<a target="_blank" download="assets/images/fpo/57d856d8651ca.jpg" href="https://timeframe-dev.blueshoon.com/uploads/6/brands/4/requests/57d856d8651ca.jpg" title="Download Asset">
												<i class="tf-icon-download"></i>
												<img width="60" height="60" alt="" src="assets/images/fpo/57d856d8651ca.jpg">
											</a>
										</div>
									</div>
									<div class="hidden edit_suggest_form2 suggest-edit" data-state="hide">
										<div class="form-group">
											<input type="hidden" id="suggestId2">
											<textarea id="comment_copy" class="form-control suggestTect2">i hate this what about this </textarea>
										</div>
										<div class="form-group clearfix">
											<div class="attachment pull-xs-left">
												<input type="file" class="hidden attachment_image" name="replay-attachment">
												<button class="btn-icon add-attachment" title="Add Attachment">
													<i class="fa fa-paperclip"></i>
												</button>

												<a class="remove-attached-img " href="#">
													<i class="tf-icon-circle remove-upload">x</i>
												</a>
											</div>
											<div class="pull-xs-right">			
												<button data-id="2" data-phase-id="64" class="btn btn-secondary btn-sm save-edit-req" type="button" data-parent-id="43">Submit</button>
											</div>
										</div>
									</div>															
									<div class="comment-btns">
										<a href="#" class="reply-link show-hide-reply" data-show="#commentReply_2">Reply</a>
									</div>
								</div>
							</li>
						</ul>
						<!-- Display Comments End -->
					</div>
				</div>
			</section>
		</div>
	</div>
	
	<!--Static Comment for Replication-->
	<div id="commentReplyStatic">
		<ul class="commentReply emptyCommentReply hidden">
			<li class="comment-section">
				<div class="author clearfix">
					<img class="circle-img pull-xs-left" width="36" height="36" src="https://timeframe-dev.blueshoon.com/uploads/3/users/3.png">

					<div class="author-meta pull-xs-left">
						Jamie Doherty						
						<span class="dateline">Reply to request</span>
					</div>
				</div>
				<div class="form-group">
					<textarea class="form-control" rows="2" name="comment" id="reply_comment_copy" placeholder="Suggest an edit here..."></textarea>
				</div>
				<div class="form-group clearfix">
					<div class="attachment pull-xs-left">
						<input type="file" name="replay-attachment" class="hidden attachment_image">
						<button title="Add Attachment" class="btn-icon add-attachment">
							<i class="fa fa-paperclip"></i></button>
							<img class="base-64-img hidden" height="30" width="30">
							<a href="#" class="remove-attached-img hidden">
								<i class="tf-icon-circle remove-upload">x</i>
							</a>
					</div>
					<div class="pull-xs-right">
						<button type="button" class="btn btn-default btn-sm reset-edit-request">Clear</button>
						<button type="button" class="btn btn-secondary btn-sm btn-disabled reply-comment-submit" data-phase-id="4" disabled="disabled">Submit</button>
					</div>
				</div>
			</li>
		</ul>
	</div>

	<!-- Calender -->
	<div class="modal hide fade" id="calendarSelectModal" data-keyboard="false" role="dialog" aria-hidden="true" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content bg-white">
			<button type="button" class="modal-toggler">
				<span class="sr-only">Toggle Modal</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		  <div class="modal-body">
			<div id="calendar-change-day" class="calendar-select-date">
				<div class="date-select-calendar"></div>
			</div>
			<div class="text-xs-center">
				<hr>
				<button type="button" class="btn btn-sm btn-default modal-hide">Cancel</button>
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-secondary btn-disabled modal-hide" disabled="">Apply</button>
			</div>			
		  </div>
		</div>
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
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/modal-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/view-n-edit-request.js?ver=1.0.0'></script>

</body>
</html>
