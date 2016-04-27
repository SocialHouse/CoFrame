<div class="container-approvals">
	<div class="bg-gray-lightest border-gray-lighter border-all padding-22px">
		<h4 class="text-xs-center">Mandatory Approvals</h4>
		<label>Check all that apply:</label>
		<?php include("user-list.php"); ?>
		<label>Must approve by:</label>
		<div class="form-group form-inline">
			<select class="form-control form-control-sm">
				<option value="">Month</option>
			</select>
			<select class="form-control form-control-sm">
				<option value="">DD</option>
			</select>
			<select class="form-control form-control-sm">
				<option value="">YYYY</option>
			</select>
			<input type="text" class="form-control form-control-sm form-control-time" placeholder="HH:MM">
			<select class="form-control form-control-sm">
				<option value="am">AM</option>
				<option value="pm">PM</option>
			</select>
		</div>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..."></textarea>
		</div>
	</div>
	<div class="bg-gray-lightest border-gray-lighter border-all padding-22px text-xs-center add-phases-footer">
		<label>Approval Phases (Optional):</label>
		<a href="#" class="btn btn-sm btn-default" data-toggle="addPhases" data-div-src="lib/add-approval-phases.php">Add Approval Phase(s)</a>
	</div>
	<footer class="post-content-footer">
	<button class="btn btn-sm btn-disabled" disabled data-active-class="btn-default">Save Draft</button>
	<button class="btn btn-sm btn-disabled" disabled data-active-class="btn-secondary">Submit for Approval</button>
	</footer>
</div>