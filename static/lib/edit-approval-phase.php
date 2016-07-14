	<form name="edit-date">
		<h5>Approvers</h5>
		<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax" data-content-src="lib/user-list.php" data-title="Add to Phase 2" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-container="body" >
			<li class="pull-sm-left"><img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></li>
			<li class="pull-sm-left"><img src="assets/images/fpo/kristin.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></li>
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div></li>
		</ul>
		<h5>Must Approve By:</h5>
		<div class="clearfix">
			<div class="form-inline pull-sm-left">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-edit-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-popover-container="body" data-target-attachment="top left" data-popover-width="300">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control">
						<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH">
						<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM">
						<input type="text" class="time-input amselect" name="post-ampm" value="am">
					</div>
				</div>
				<span class="timezone pull-xs-right">PST</span>
			</div>
		</div>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
		</div>		
		<footer class="overlay-footer">
			<button title="Delete Phase" class="pull-sm-left btn-icon btn-icon-xl delete-phase"><i class="fa fa-trash-o"></i></button>
			<span class="sep pull-sm-left"></span>
			<button type="reset" class="btn btn-sm btn-default modal-hide">Cancel</button>
			<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Save</button>
		</footer>

		<!-- Select Date Calendar -->
		<div id="calendar-edit-date" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
		</div>
	</form>