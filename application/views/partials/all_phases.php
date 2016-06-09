<?php 
if(!empty($post_details->brand_id)){
	$brand_id = $post_details->brand_id;
}
?>
<div>
	<div class="bg-white approval-phase active animated fadeIn" id="approvalPhase1" data-id="0">
		<h2 class="clearfix">Phase 1 </h2>
		<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/get_brand_users/'.$brand_id; ?>" data-title="Add to Phase 1" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
		</ul>

		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left phase-date-time-div">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[0][approve_date]">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm phase-time-input">
						<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[0][approve_hour]">
						<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[0][approve_minute]">
						<input type="text" class="time-input amselect" value="am" name="phase[0][approve_ampm]">
					</div>
				</div>
				<span class="timezone pull-xs-right form-control-sm phase-timezone">PST</span>
			</div>
		</div>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[0][note]"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-default cancel-phase">Cancel</button>
			<button type="button" class="btn btn-xs pull-sm-right btn-change-phase btn-disabled" data-new-phase="2" data-active-class="btn-default" disabled="disabled">Next Phase</button>
		</div>
	</div>

	<div class="bg-white approval-phase animated fadeIn hide" id="preview_approvalPhase1">
		<h2 class="clearfix">Phase 1 <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
		<ul class="timeframe-list user-list approval-list border-bottom clearfix">						
			
		</ul>
		<div class="approval-date">
			<span class="uppercase">Must approve by:</span> <span class="date-preview1"></span><span class="time-preview1"></span>PST
		</div>
		<div class="approval-note">
			
		</div>
	</div>
</div>
<div>
	<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase2" data-id="1">
		<h2 class="clearfix">Phase 2 
		<button type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
		<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax-inline" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-title="Add to Phase 2" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
		</ul>

		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left phase-date-time-div">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[1][approve_date]">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm phase-time-input">
						<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[1][approve_hour]">
						<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[1][approve_minute]">
						<input type="text" class="time-input amselect" value="am" name="phase[1][approve_ampm]">
					</div>
				</div>
				<span class="timezone pull-xs-right form-control-sm phase-timezone">PST</span>
			</div>
		</div>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[1][note]"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="1">Previous</button>
			<button type="button" class="btn btn-xs pull-sm-right btn-change-phase btn-disabled" data-new-phase="3" data-active-class="btn-default" disabled="disabled">Next Phase</button>
		</div>
	</div>

	<div class="bg-white approval-phase animated fadeIn hide" id="preview_approvalPhase2">
		<h2 class="clearfix">Phase 2 <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
		<ul class="timeframe-list user-list approval-list border-bottom clearfix">						
			
		</ul>
		<div class="approval-date">
			<span class="uppercase">Must approve by:</span> <span class="date-preview2"></span><span class="time-preview2"></span>PST
		</div>
		<div class="approval-note">
			
		</div>
	</div>
</div>
<div>
	<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase3" data-id="2">
		<h2 class="clearfix">Phase 3 
		<button type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
		<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax-inline" data-title="Add to Phase 3" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
		</ul>
		
		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left phase-date-time-div">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[2][approve_date]">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm phase-time-input">
						<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[2][approve_hour]">
						<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[2][approve_minute]">
						<input type="text" class="time-input amselect" value="am" name="phase[2][approve_ampm]">
					</div>
				</div>
				<span class="timezone pull-xs-right form-control-sm phase-timezone">PST</span>
			</div>
		</div>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[2][note]"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="2">Previous</button>
		</div>
	</div>
	<div class="bg-white approval-phase animated fadeIn hide" id="preview_approvalPhase">
		<h2 class="clearfix">Phase 3 <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
		<ul class="timeframe-list user-list approval-list border-bottom clearfix">					
			
		</ul>
		<div class="approval-date">
			<span class="uppercase">Must approve by:</span> <span class="date-preview3"></span><span class="time-preview3"></span>PST
		</div>
		<div class="approval-note">
			
		</div>
	</div>
</div>

<div>
	<div>
		<footer class="post-content-footer">
			<button type="button" class="btn btn-sm btn-default cancel-phase" data-active-class="btn-default">Cancel</button>
			<button type="button" class="btn btn-sm pull-sm-right save-phases btn-disabled" data-active-class="btn-secondary" disabled="disabled">Save Phases</button>
		</footer>
	</div>
	<div class="hide">
		<footer class="post-content-footer">
			<button class="btn btn-sm save-draft-btn" data-active-class="btn-default submit-btn" id="draft">Save Draft</button>
			<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn" data-active-class="btn-secondary" id="submit-approval">Submit for Approval</button>
		</footer>
	</div>
</div>