<?php $this->load->view('partials/brand_nav'); ?>	
<input type="hidden" value="<?php echo $brand_id; ?>" id="brand_id">
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-day" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
			<h2 class="date-header pull-xs-left">Calendar | <strong id="calendarCurrentMonth"><?php echo date('F'); ?></strong > <span id="calendarCurrentdate"><?php echo date('d') . ", " . date('Y'); ?></span></h2>

			<?php $this->load->view('partials/calendar_nav'); ?>
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
	<div class="row equal-columns">
		<div class="col-md-9 equal-height">
			<div class="calendar-day">
				<?php $this->load->view('calendar/post_preview/day_post'); ?>
			</div>
		</div>
		<div class="col-md-3 equal-height">
			<?php
			$this->load->view('partials/summary');
			?>			
		</div>
	</div>
</section>