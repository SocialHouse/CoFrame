	<hr>
	<form name="edit-date" id="reshedule-date" method="post">
		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control popover-toggle single-date-select" name="post_date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-edit-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-popover-container="body" data-target-attachment="top left" data-popover-width="300">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control">
						<input name="post_id" type="hidden">
						<input type="text" class="time-input hour-select" name="post_hour" data-min="1" data-max="12" placeholder="HH">
						<input type="text" class="time-input minute-select" name="post_minute" data-min="0" data-max="59" placeholder="MM">
						<input type="text" class="time-input amselect" name="post_ampm" value="am">
					</div>
				</div>
				<span class="timezone pull-xs-right">PST</span>
			</div>
		</div>
		<footer class="overlay-footer">
			<button type="reset" class="btn btn-sm btn-default qtip-hide">Cancel</button>
			<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Save</button>
		</footer>

		<!-- Select Date Calendar -->
		<div id="calendar-edit-date" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
		</div>		
	</form>