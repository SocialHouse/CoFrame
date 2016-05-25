<section class="brand-navigation bg-white opaque-88 col-sm-2">
	<?php $this->load->view('partials/brand_nav'); ?>	
</section>
<input type="hidden" value="<?php echo $brand_id; ?>" id="brand_id">
<input type="hidden" id="outlet_ids">
<input type="hidden" id="statuses">
<input type="hidden" id="calender_type" value="month">

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-month" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
			<h2 class="date-header pull-xs-left">Calendar | <strong id="calendarCurrentMonth"><?php echo date('F'); ?></strong> <span id="calendarCurrentYear"><?php echo date('Y'); ?></span></h2>
			
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
			<div id="calendar-month"></div>
		</div>
	</div>
</section>