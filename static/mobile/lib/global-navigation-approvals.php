<nav class="navbar navbar-light row">
<div class="col-sm-12">
	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#globalNav">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand hidden-print" href="overview.php"><span class="brand-logo hide-text">CoFrame</span></a>
	<div class="go-to-brands pull-xs-right toolbar">
		<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="modal-ajax" data-modal-src="lib/post-filters.php" data-hide="false" data-clear="no" data-modal-id="modal-post-filters"><i class="tf-icon-filter"></i></a>
		<a href="#" class="hide-text show-brands-toggler pull-xs-left animated infinite pulse popover-toggle" data-toggle="popover-ajax" data-content-src="lib/go-to-brand.php" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-brand-list" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="-3" data-offset-y="6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body" data-popover-width="90%">Go To Brand</a>
	</div>
	
		<ul class="nav navbar-nav navbar-main bg-white collapse" id="globalNav">
			<li class="nav-item brand-title text-xs-center">J Brand</li>
			<li class="nav-item search-item border-gray-lighter border-top border-bottom">
				<form method="get" action="https://timeframe-dev.blueshoon.com/posts/search" class="form-inline form-search">
					<input type="text" name="search" class="form-control input-search" value="" placeholder="Search">
					<button type="submit" class="btn btn-search"><i class="tf-icon-search"></i></button>
				</form>		
			</li>
			<li class="nav-item"> <a class="nav-link" href="overview.php">Overview</a> </li>
			<li class="nav-item"> <a class="nav-link" href="approvals.php">Approvals</a> </li>
			<li class="nav-item"> <a class="nav-link" href="user-preferences.php">User Preferences</a> </li>
			<li class="nav-item"> <a class="nav-link border-gray-lighter border-top border-bottom" href="#">Log out</a> </li>
			<li>
				<div class="current-user-details">
					<div class="user-time">
						<div class="btn btn-secondary btn-xs no-hover">Master</div>
						<div class="clearfix current-time">
							<div class="pull-xs-left time-label border-gray-lighter border-right">Current<br>Brand<br>Time </div>
							<div class="pull-xs-left">
							<strong id="userTime">1:18</strong><br>
							<span id="userTimeZone">pm CDT</span>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</nav>
