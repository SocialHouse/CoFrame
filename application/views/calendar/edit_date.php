	<div class="clearfix"></div>
	<hr>
	<form id="reschedule_post" name="edit-date" method="post" action="<?php echo base_url(); ?>calendar/reschedule_post" >
		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left">
				<div class="hide-top-bx-shadow">
					<input type="text" id="reschedule_day" class="form-control popover-toggle single-date-select" name="post_date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-edit-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-popover-container="body" data-target-attachment="top left" data-popover-width="300" value="<?php echo date('m-d-Y',strtotime($post_details->slate_date_time)); ?>">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control">
						<input type="text" class="time-input hour-select" name="post_hour" id="edit_hour" data-min="1" data-max="12" placeholder="HH" value="<?php echo date('h',strtotime($post_details->slate_date_time)); ?>">
						<input type="text" class="time-input minute-select" name="post_minute" id="edit_minute" data-min="0" data-max="59" placeholder="MM" value="<?php echo date('m',strtotime($post_details->slate_date_time)); ?>">
						<input type="text" class="time-input amselect" name="post_ampm" id="edit_ampm" value="<?php echo date('a',strtotime($post_details->slate_date_time)); ?>">
					</div>
					
				</div>
				<span class="timezone pull-xs-right">PST</span>

			</div>

			<input type="hidden" name="post_id" value="<?php echo $post_id ; ?>">
		</div>
		<div id='reschedule_error' class=" error hide clearfix"></div>
		<footer class="overlay-footer">
			<button type="reset" class="btn btn-sm btn-default qtip-hide">Cancel</button>
			<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Save</button>
		</footer>

		<!-- Select Date Calendar -->
		<div id="calendar-edit-date" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
		</div>
	</form>