<div class="bg-white approval-phase active animated fadeIn" id="approvalPhase1">
	<h2 class="clearfix">Phase 1 <button title="Edit Phase" disabled class="btn-icon btn-disabled" data-active-class="btn-gray"><i class="fa fa-pencil"></i></button>
	<button title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
	<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax" data-content-src="lib/user-list.php" data-title="Add to Phase 1" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
		<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
	</ul>
	<div class="clearfix">
		<div class="form-group form-inline pull-sm-left">
			<div class="hide-top-bx-shadow">
				<input type="text" class="form-control form-control-sm popover-toggle single-date-select" name="approval-date-1" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
			</div>
		</div>
		<div class="form-group pull-sm-left">
			<div class="pull-xs-left">
				<div class="time-select form-control form-control-sm">
					<input type="text" class="time-input hour-select" name="approval-hour-1" data-min="1" data-max="12" placeholder="HH">
					<input type="text" class="time-input minute-select" name="approval-minute-1" data-min="0" data-max="59" placeholder="MM">
					<input type="text" class="time-input amselect" name="approval-ampm-1" value="am">
				</div>
			</div>
			<span class="timezone pull-xs-right form-control-sm">PST</span>
		</div>
	</div>
	<div class="form-group">
		<label for="approvalNotes">Note to Approvers (optional):</label>
		<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
	</div>
	<div class="form-group">
		<button class="btn btn-sm btn-default">Cancel</button>
		<button type="button" class="btn btn-xs btn-disabled pull-sm-right btn-change-phase" data-new-phase="2" data-active-class="btn-default">Next Phase</button>
	</div>
</div>

<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase2">
	<h2 class="clearfix">Phase 2 <button title="Edit Phase" disabled class="btn-icon btn-disabled" data-active-class="btn-gray"><i class="fa fa-pencil"></i></button>
	<button title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
	<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax-inline" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-title="Add to Phase 2" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
		<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
	</ul>
	<div class="clearfix">
		<div class="form-group form-inline pull-sm-left">
			<div class="hide-top-bx-shadow">
				<input type="text" class="form-control form-control-sm popover-toggle single-date-select" name="approval-date-2" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
			</div>
		</div>
		<div class="form-group pull-sm-left">
			<div class="pull-xs-left">
				<div class="time-select form-control form-control-sm">
					<input type="text" class="time-input hour-select" name="approval-hour-2" data-min="1" data-max="12" placeholder="HH">
					<input type="text" class="time-input minute-select" name="approval-minute-2" data-min="0" data-max="59" placeholder="MM">
					<input type="text" class="time-input amselect" name="approval-ampm-2" value="am">
				</div>
			</div>
			<span class="timezone pull-xs-right form-control-sm">PST</span>
		</div>
	</div>
	<div class="form-group">
		<label for="approvalNotes">Note to Approvers (optional):</label>
		<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="1">Previous</button>
		<button type="button" class="btn btn-xs btn-disabled pull-sm-right btn-change-phase" disabled data-new-phase="3" data-active-class="btn-default">Next Phase</button>
	</div>
</div>

<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase3">
	<h2 class="clearfix">Phase 3 <button title="Edit Phase" disabled class="btn-icon btn-disabled" data-active-class="btn-gray"><i class="fa fa-pencil"></i></button>
	<button title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
	<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax-inline" data-title="Add to Phase 3" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
		<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
	</ul>
	<div class="clearfix">
		<div class="form-group form-inline pull-sm-left">
			<div class="hide-top-bx-shadow">
				<input type="text" class="form-control form-control-sm popover-toggle single-date-select" name="approval-date-3" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
			</div>
		</div>
		<div class="form-group pull-sm-left">
			<div class="pull-xs-left">
				<div class="time-select form-control form-control-sm">
					<input type="text" class="time-input hour-select" name="approval-hour-3" data-min="1" data-max="12" placeholder="HH">
					<input type="text" class="time-input minute-select" name="approval-minute-3" data-min="0" data-max="59" placeholder="MM">
					<input type="text" class="time-input amselect" name="approval-ampm-3" value="am">
				</div>
			</div>
			<span class="timezone pull-xs-right form-control-sm">PST</span>
		</div>
	</div>
	<div class="form-group">
		<label for="approvalNotes">Note to Approvers (optional):</label>
		<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
	</div>
	<div class="form-group">
		<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="2">Previous</button>
	</div>
</div>