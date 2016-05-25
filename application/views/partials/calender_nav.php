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
	<a href="<?php echo base_url().'calender/'.$brand_id; ?>" class="btn btn-sm <?php echo $day; ?>">Day</a>
	<a href="<?php echo base_url().'calender/week/'.$brand_id; ?>" class="btn btn-sm <?php echo $week; ?>">Week</a>
	<a href="<?php echo base_url().'calender/month/'.$brand_id; ?>" class="btn btn-sm <?php echo $month; ?>">Month</a>
</div>

<div class="btn-group-calendar pull-sm-left">
	<a href="#" class="btn btn-sm active" id="calendarBtnToday">Today</a>
</div>

<div class="pull-md-right toolbar">
	<a href="#" class="tf-icon-circle pull-xs-left"><i class="tf-icon-search"></i></a>
	<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calender/post_filters/'.$brand_id; ?>" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70"><i class="tf-icon-filter"></i></a>
	<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calender/print_posts/'.$brand_id; ?>" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20"><i class="tf-icon-print"></i></a>
</div>