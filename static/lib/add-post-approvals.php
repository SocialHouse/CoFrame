<div class="container-approvals">
	<div>
		<h4 class="text-xs-center">Mandatory Approvals</h4>
		<label>Check all that apply:</label>
		<?php include("user-list.php"); ?>
		<label>Must approve by:</label>
		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control form-control-sm popover-toggle single-date-select" name="approval-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm">
						<input type="text" class="time-input hour-select" name="approval-hour" data-min="1" data-max="12" placeholder="HH">
						<input type="text" class="time-input minute-select" name="approval-minute" data-min="0" data-max="59" placeholder="MM">
						<input type="text" class="time-input amselect" name="approval-ampm" value="am">
					</div>
				</div>
				<span class="timezone pull-xs-right form-control-sm">PST</span>
			</div>
		</div>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
		</div>
	</div>
	<div class="border-gray-lighter border-all padding-22px text-xs-center add-phases-footer">
		<label>Approval Phases (Optional):</label>
		<a href="#" class="btn btn-sm btn-default" data-toggle="addPhases" data-div-src="lib/add-approval-phases.php">Add Approval Phase(s)</a>
	</div>
	<footer class="post-content-footer">
	<button class="btn btn-sm btn-disabled" disabled data-active-class="btn-default">Save Draft</button>
	<button class="btn btn-sm btn-disabled" disabled data-active-class="btn-secondary">Submit for Approval</button>
	</footer>
</div>