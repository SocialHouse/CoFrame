<?php
$segment = $this->uri->segment(2);
$week = '';
$month = '';
$day = '';
switch ($segment) {
	case 'week':
		$week = 'active';
		break;
	case 'month':
		$month = 'active';
		break;
	
	default:
		$day = 'active';
		break;
}
?>
<div class="btn-group-calendar pull-sm-left">
	<a href="<?php echo base_url().'calendar/day/'.$brand->slug; ?>" class="btn btn-sm <?php echo $day; ?>">Day</a>
	<a href="<?php echo base_url().'calendar/week/'.$brand->slug; ?>" class="btn btn-sm <?php echo $week; ?>">Week</a>
	<a href="<?php echo base_url().'calendar/month/'.$brand->slug; ?>" class="btn btn-sm <?php echo $month; ?>">Month</a>
</div>

<div class="btn-group-calendar pull-sm-left">
	<a class="btn btn-sm active" href="#" id="calendarBtnToday">Today</a>
</div>

<div class="pull-md-right toolbar">
	<?php $this->load->view('partials/search_form'); ?>
	<a href="#" id="show-filter-overlay" class="tf-icon-circle pull-xs-left  post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/post_filters/'.$brand_id; ?>" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70" data-hide="false"><i class="tf-icon-filter"></i></a>
	<a href="#" class="tf-icon-circle pull-xs-left post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/print_posts/'.$brand_id; ?>" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20" data-hide="false"><i class="tf-icon-print"></i></a>

</div>