<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-day" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
			<h2 class="date-header pull-xs-left">Calendar | <strong><?php echo date('F'); ?></strong> <?php echo date('d') . ", " . date('Y'); ?></h2>

			<?php $this->load->view('partials/calender_nav'); ?>

			<div class="btn-group-calendar pull-sm-left">
				<a href="#" class="btn btn-sm active" id="calendarBtnToday">Today</a>
			</div>
			<div class="pull-md-right toolbar">
				<a href="#" class="tf-icon-circle pull-xs-left"><i class="tf-icon-search"></i></a>
				<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calender/post_filters/'.$brand_id; ?>" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70"><i class="tf-icon-filter"></i></a>
				<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="lib/print-posts.php" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20"><i class="tf-icon-print"></i></a>
			</div>
		</div>
		<div id="selectedFilters" class="clearfix border-top border-black hidden">
			<strong class="uppercase">Filters: </strong>
			<ul class="filter-list tag-list">
			</ul>
			<button type="button" class="btn btn-sm btn-secondary reset-filter pull-sm-right" data-filter="*">Reset Filters</button>
		</div>
		<div id="calendar-change-day" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
			<div class="text-xs-center">
				<hr>
				<button type="button" class="btn btn-sm btn-default qtip-hide">Cancel</button>
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-default btn-disabled qtip-hide" disabled>Apply</button>
			</div>
		</div>
	</header>
	<div class="row equal-cols-cal">
		<div class="col-md-9 equal-height">
			<div class="calendar-day">
				<div class="row bg-white clearfix post-day f-approved f-facebook f-brandbuilding f-orange f-retail">
					<div class="col-md-5 post-img">
						<img src="assets/images/fpo/post-img-1.jpg" width="420" height="420" alt="" class="img-responsive"/> 
					</div>
					<div class="col-md-7 post-content">
						<div class="row">
							<div class="col-md-2 outlet-list text-xs-center outlet-list">
								<i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>
							</div>
							<div class="col-md-10 post-meta">
								<span class="post-author">Facebook Post By Johan L:</span>
								<span class="post-date">Wednesday, 5/13/16 at 5:05 PM PST <a href="#" class="btn-icon btn-gray" data-toggle="popover-ajax" data-content-src="lib/calendar-edit-date.php" data-title="Reschedule Post" data-popover-width="415" data-popover-class="popover-post-date popover-clickable form-inline popover-lg" data-popover-id="date-postid-1223" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"><i class="fa fa-pencil"></i></a></span>
								<span class="post-approval"><strong>All Approvals Received <i class="fa fa-check-circle color-success"></i></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-postid-1223" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
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
							<div class="col-md-10">
								<h6>POST COPY</h6>
								<div class="post-body">
									<p>Let whites influence your fresh new spring silhouette.</p>
									<p>Meet the inspiration behind J BRAND Spring on Tumblr: http://jbrn.dj/Tumblr</p>
								</div>
								<span class="post-actions pull-xs-left">
								<button class="btn btn-approved btn-sm" disabled>Approved</button><br>
								<a href="#">Undo</a>
								</span>
								<div class="hide-top-bx-shadow">
									<button class="btn-icon btn-icon-lg btn-menu popover-toggle" data-toggle="popover-ajax" data-content-src="lib/calendar-edit-menu.php" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day"><i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row bg-white clearfix post-day f-pending f-instagram f-blue">
					<div class="col-md-5 post-img">
						<img src="assets/images/fpo/post-img-2.jpg" width="420" height="420" alt="" class="img-responsive"/>
					</div>
					<div class="col-md-7 post-content">
						<div class="row">
							<div class="col-md-2 outlet-list text-xs-center outlet-list">
								<i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i>
							</div>
							<div class="col-md-10 post-meta">
								<span class="post-author">INSTAGRAM POST BY SOPHIE H:</span>
								<span class="post-date">Wednesday, 5/13/16 at 6:21 PM PST <a href="#" class="btn-icon btn-gray" data-toggle="popover-ajax" data-content-src="lib/calendar-edit-date.php" data-title="Reschedule Post" data-popover-width="415" data-popover-class="popover-post-date popover-clickable form-inline popover-lg" data-popover-id="date-postid-1224" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"><i class="fa fa-pencil"></i></a></span>
								<span class="post-approval"><strong>Pending Approvals <i class="icon-clock2 color-danger" data-popover-id="approvals-postid-1224" data-toggle="popover-ajax" data-content-src="lib/approval-list.php" data-popover-class="popover-sm popover-post-approvals" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"></i></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-postid-1224" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
								<i class="fa fa-circle tag-blue"></i>
								<div id="tags-postid-1224" class="hidden">
									<div class="tag-list">
										<ul>
											<li class="tag"><i class="fa fa-circle tag-blue"></i>Blue Tag</li>
										</ul>
									</div>
								</div>								
							</div>
							<div class="col-md-10">
								<h6>POST COPY</h6>
								<div class="post-body">
									<p>Live on the edge like @michelletakeaim. Follow the link in our profile to find your favorite destructed #denim fit. #JBRAND</p>
								</div>
								<span class="post-actions pull-xs-left">
								<button class="btn btn-approved btn-sm btn-secondary">Approve</button>
								</span>
								<div class="hide-top-bx-shadow">
									<button class="btn-icon btn-icon-lg btn-menu popover-toggle" data-toggle="popover-ajax" data-content-src="lib/calendar-edit-menu.php" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day"><i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row bg-white clearfix post-day f-scheduled f-youtube f-brandbuilding">
					<div class="col-md-5 post-img">
						<img src="assets/images/fpo/post-img-4.jpg" width="420" height="420" alt="" class="img-responsive"/>
					</div>
					<div class="col-md-7 post-content">
						<div class="row">
							<div class="col-md-2 outlet-list text-xs-center outlet-list">
								<i class="fa fa-youtube-play"><span class="bg-outlet bg-youtube"></span></i>
							</div>
							<div class="col-md-10 post-meta">
								<span class="post-author">Youtube POST BY SOPHIE H:</span>
								<span class="post-date">Wednesday, 5/13/16 at 6:21 PM PST <a href="#" class="btn-icon btn-gray" data-toggle="popover-ajax" data-content-src="lib/calendar-edit-date.php" data-title="Reschedule Post" data-popover-width="415" data-popover-class="popover-post-date popover-clickable form-inline popover-lg" data-popover-id="date-postid-1225" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"><i class="fa fa-pencil"></i></a></span>
								<span class="post-approval"><strong>Pending Approvals <i class="icon-clock2 color-danger" data-popover-id="approvals-postid-1225" data-toggle="popover-ajax" data-content-src="lib/approval-list.php" data-popover-class="popover-sm popover-post-approvals" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"></i></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-postid-1225" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
								<i class="fa fa-circle tag-red"></i>
								<div id="tags-postid-1225" class="hidden">
									<div class="tag-list">
										<ul>
											<li class="tag"><i class="fa fa-circle tag-red"></i>Brand Building / Product Education</li>
										</ul>
									</div>
								</div>								
							</div>
							<div class="col-md-10">
								<h6>POST COPY</h6>
								<div class="post-body">
									<p>The Lucy Cami: Perfect under everything. Styled by Kaity Modern: http://jbrn.dj/LUCYBLK</p>
								</div>
								<span class="post-actions pull-xs-left">
								<button class="btn btn-approved btn-sm btn-secondary">Schedule</button>
								</span>
								<div class="hide-top-bx-shadow">
									<button class="btn-icon btn-icon-lg btn-menu popover-toggle" data-toggle="popover-ajax" data-content-src="lib/calendar-edit-menu.php"data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day"><i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row bg-white clearfix post-day f-published f-twitter f-retail f-blue">
					<div class="col-md-5 post-img">
						<img src="assets/images/fpo/post-img-3.jpg" width="420" height="420" alt="" class="img-responsive"/>
					</div>
					<div class="col-md-7 post-content">
						<div class="row">
							<div class="col-md-2 outlet-list text-xs-center outlet-list">
								<i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i>
								<div id="tags-postid-1226" class="hidden">
									<div class="tag-list">
										<ul>
											<li class="tag"><i class="fa fa-circle tag-blue"></i>Blue Tag</li>
											<li class="tag"><i class="fa fa-circle tag-green"></i>Marketing</li>
										</ul>
									</div>
								</div>								
							</div>
							<div class="col-md-10 post-meta">
								<span class="post-author">TWITTER POST BY JOSE A:</span>
								<span class="post-date">Monday, 5/11/16 at 9:45 AM PST</span>
								<span class="post-approval"><strong>Published <i class="fa fa-globe color-gray-lighter"></i></strong></span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-postid-1226" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
								<i class="fa fa-circle tag-blue"></i><i class="fa fa-circle tag-green"></i>
							</div>
							<div class="col-md-10">
								<h6>POST COPY</h6>
								<div class="post-body">
									<p>The Atelier by Patricia Manfield & Giotto Calendoli takes Milano in our Amely Leather Trench: http://jbrn.dj/AMELY</p>
								</div>
								<span class="post-actions pull-xs-left">
								<button class="btn btn-approved btn-sm btn-default">View Live</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 equal-height">
			<div class="calendar-summary bg-gray-dark">
				<div id="calendar"></div>
				<div class="today-summary">
					<h5 class="border-title"><span>Summary</span></h5>
					<ul class="timeframe-list calendar-list outlet-list">
						<li><i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>5:05 PM <span class="excerpt-summary">Let whites influence your fre...</span></li>
						<li><i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i>5:05 PM <span class="excerpt-summary">Let whites influence your fre...</span></li>
						<li><i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i>5:05 PM <span class="excerpt-summary">Let whites influence your fre...</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>