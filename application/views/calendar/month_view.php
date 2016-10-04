<?php 
	$this->load->view('partials/brand_nav'); 
	if(!empty($filters))
	{
		?>
		<input type="hidden" name="filter_id" id="filter-id" value="<?php echo $filters[0]->id; ?>">
		<?php
	}
?>

<input type="hidden" value="<?php echo $brand_id; ?>" id="brand_id">
<input type="hidden" id="outlet_ids" value="<?php echo !empty($filters) ? $filters[0]->outlets : ''; ?>">
<input type="hidden" id="statuses" value="<?php echo !empty($filters) ? $filters[0]->statuses : ''; ?>">
<input type="hidden" id="tags" value="<?php echo !empty($filters) ? $filters[0]->tags : ''; ?>">
<input type="hidden" id="calendar_type" value="month">

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a href="#" class="tf-icon-circle pull-xs-left hidden-print" data-toggle="popover-calendar" data-popover-id="calendar-change-month" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
			<h2 class="date-header pull-xs-left">Calendar | <strong id="calendarCurrentMonth"><?php echo date('F'); ?></strong> <span id="calendarCurrentYear"><?php echo date('Y'); ?></span></h2>
			
			<?php $this->load->view('partials/calendar_nav'); ?>		
			
		</div>
		<div id="selectedFilters" class="clearfix border-top border-black hidden">
			<strong class="uppercase">Filters: </strong>
			<ul class="filter-list tag-list">
				<?php
				if(!empty($filters))
				{
					if(!empty($filters[0]->outlets))
					{
						$outlet_ids = explode(',',$filters[0]->outlets);
						foreach($outlet_ids as $id)
						{
							$outlet_name = strtolower(get_outlet_by_id($id));
							?>
							<li data-id="<?php echo $id; ?>" data-value="f-<?php echo $outlet_name; ?>" class="filter-remove-list outlet-list">
								<i class="fa fa-<?php echo $outlet_name; ?>">
									<span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span>
								</i>
							<i class="tf-icon-close"></i></li>
							<?php
						}
					}
					if(!empty($filters[0]->statuses))
					{
						$statuses = explode(',',$filters[0]->statuses);
						foreach($statuses as $status)
						{							
							?>
							<li data-status="<?php echo $status ?>" data-value="f-<?php echo $status; ?>" class="filter-remove-list outlet-list">
								<?php echo $status; ?>
								<i class="tf-icon-close"></i>
							</li>
							<?php
						}
					}

					if(!empty($filters[0]->tags))
					{
						$tags = explode(',',$filters[0]->tags);						
						foreach($tags as $tag)
						{
							$tag_data = get_tag_data($tag);

							if(!empty($tag_data))
							{
								?>
								<li data-value="<?php echo $tag_data[0]->name; ?>" class="filter-remove-list outlet-list">
									<i style="color:<?php echo $tag_data[0]->color; ?>" class="fa fa-circle tag-test"></i>
									<span class="tag-title"><?php echo $tag_data[0]->name; ?></span>
									<i class="tf-icon-close"></i>
								</li>
								<?php
							}
						}
					}
				}
				?>
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
		<div class="col-sm-12">
			<div id="calendar-month"></div>
		</div>
	</div>
</section>