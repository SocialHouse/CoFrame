<div class="container-approvals">
	<div class="bg-gray-lightest border-gray-lighter padding-22px">
		<h4 class="text-xs-center">Mandatory Approvals</h4>
		<label>Check all that apply:</label>
		<ul class="timeframe-list user-list">
			<li>
				<div class="pull-sm-left"><input type="checkbox" class="hidden-xs-up" name="post-approver" value="Norel Mancuso"><i class="tf-icon radio-button circle-border" data-value="Norel Mancuso" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Norel Mancuso</strong>Master Admin</div>
			</li>
			<li>
				<div class="pull-sm-left"><input type="checkbox" class="hidden-xs-up" name="post-approver" value="David Weinberg"><i class="tf-icon radio-button circle-border" data-value="David Weinberg" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>David Weinberg</strong>Manager</div>
				</li>
			<li>
				<div class="pull-sm-left"><input type="checkbox" class="hidden-xs-up" name="post-approver" value="Kristin Patrick"><i class="tf-icon radio-button circle-border" data-value="Kristin Patrick" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><img src="assets/images/fpo/kristin.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Kristin Patrick</strong>Approver</div>
			</li>
			<li>
				<div class="pull-sm-left"><input type="checkbox" class="hidden-xs-up" name="post-approver" value="Johan Loekito"><i class="tf-icon radio-button circle-border" data-value="Johan Loekito" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><img src="assets/images/fpo/jose.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Johan Loekito</strong>Approver</div>
			</li>
			<li>
				<div class="pull-sm-left"><input type="checkbox" class="hidden-xs-up" name="post-approver" value="Jose Andrade"><i class="tf-icon radio-button circle-border" data-value="Jose Andrade" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><img src="assets/images/fpo/johan.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Jose Andrade</strong>Approver</div>
			</li>
			<li>
				<div class="pull-sm-left"><input type="checkbox" class="hidden-xs-up" name="post-approver" value="Sophie Hawkins"><i class="tf-icon radio-button circle-border" data-value="Sophie Hawkins" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><img src="assets/images/fpo/sophie.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Sophie Hawkins</strong>Approver</div>
			</li>
			<li>
				<div class="pull-sm-left"><i class="tf-icon radio-button circle-border" data-value="check-all" data-group="post-approver"></i></div>
				<div class="pull-sm-left"><div class="check-all circle-border bg-black">All</div></div>
				<div class="pull-sm-left post-approver-name">Check<br>All</div>
			</li>
		</ul>
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
	<div class="bg-gray-lightest border-gray-lighter padding-22px text-xs-center add-approval-phases">
		<label>Approval Phases (Optional):</label>
		<a href="#" class="btn btn-sm btn-default">Add Approval Phase(s)</a>
	</div>
	<footer class="post-content-footer">
	<button href="#" class="btn btn-sm btn-disabled" disabled data-active-class="btn-default">Save Draft</button>
	<button href="#" class="btn btn-sm btn-disabled" disabled data-active-class="btn-secondary">Submit for Approval</button>
	</footer>
</div>