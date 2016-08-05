<?php 
if(!empty($post_details->brand_id)){
	$brand_id = $post_details->brand_id;
}
?>
	<div class="bg-white approval-phase active animated fadeIn" id="approvalPhase1" data-id="0">
		<h2 class="clearfix">Phase 1 </h2>
		<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/get_brand_users/'.$brand_id; ?>" data-title="Add to Phase 1" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black" title="Add Approvers">+</i></div><div class="add-approver">Add <br>Approvers</div></li>
		</ul>

		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left phase-date-time-div">
				<div class="hide-top-bx-shadow">
					<input type="text" id="ph_one_date" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[0][approve_date]">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm phase-time-input 1-phase-time-input">
						<input type="text" id="ph_one_hour" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[0][approve_hour]">
						<input type="text" id="ph_one_minute" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[0][approve_minute]">
						<input type="text" id="ph_one_ampm" class="time-input amselect" value="am" name="phase[0][approve_ampm]">
					</div>
				</div>
			</div>
		</div>
		<label class="phase-one-error-all error hide clearfix"></label>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[0][note]"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-default cancel-phase">Cancel</button>
			<button type="button" class="btn btn-xs btn-secondary pull-sm-right btn-change-phase btn-disabled" data-new-phase="2" >Next Phase</button>
		</div>
	</div>
	<div class="bg-white approval-phase saved-phase animated fadeIn hide" id="preview_approvalPhase1" data-id="0">
		<h2 class="clearfix">Phase 1 <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
		<ul class="timeframe-list user-list approval-list border-bottom clearfix">						
			
		</ul>
		<div class="approval-date">
			<span class="uppercase">Must approve by:</span> <span class="date-preview1"></span> <span class="time-preview">at <span class="hour-preview"></span>:<span class="minute-preview"></span> <span class="ampm-preview"></span></span>
		</div>
		<div class="approval-note">
			
		</div>
	</div>
	
	<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase2" data-id="1">
		<h2 class="clearfix">Phase 2 
		<button type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
		<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax-inline" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-title="Add to Phase 2" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black" title="Add Approvers">+</i></div><div class="add-approver">Add <br>Approvers</div></li>
		</ul>

		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left phase-date-time-div">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[1][approve_date]">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm 2-phase-time-input">
						<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[1][approve_hour]">
						<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[1][approve_minute]">
						<input type="text" class="time-input amselect" value="am" name="phase[1][approve_ampm]">
					</div>
				</div>
			</div>
		</div>
		<label class="phase-two-error error hide clearfix"></label>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[1][note]"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="1">Previous</button>
			<button type="button" class="btn btn-xs btn-secondary pull-sm-right btn-change-phase btn-disabled" data-new-phase="3" >Next Phase</button>
		</div>
	</div>
	<div class="bg-white approval-phase saved-phase animated fadeIn hide" id="preview_approvalPhase2" data-id="1">
		<h2 class="clearfix">Phase 2 <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
		<ul class="timeframe-list user-list approval-list border-bottom clearfix">						
			
		</ul>
		<div class="approval-date">
			<span class="uppercase">Must approve by:</span> <span class="date-preview2"></span> <span class="time-preview">at <span class="hour-preview"></span>:<span class="minute-preview"></span> <span class="ampm-preview"></span></span>
		</div>
		<div class="approval-note">
			
		</div>
	</div>

	<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase3" data-id="2">
		<h2 class="clearfix">Phase 3 
		<button type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
		<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax-inline" data-title="Add to Phase 3" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
			<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black" title="Add Approvers">+</i></div><div class="add-approver">Add <br>Approvers</div></li>
		</ul>
		
		<div class="clearfix">
			<div class="form-group form-inline pull-sm-left phase-date-time-div">
				<div class="hide-top-bx-shadow">
					<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[2][approve_date]">
				</div>
			</div>
			<div class="form-group pull-sm-left">
				<div class="pull-xs-left">
					<div class="time-select form-control form-control-sm 3-phase-time-input">
						<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[2][approve_hour]">
						<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[2][approve_minute]">
						<input type="text" class="time-input amselect" value="am" name="phase[2][approve_ampm]">
					</div>
				</div>
			</div>
		</div>
		<label class="phase-three-error error hide clearfix"></label>
		<div class="form-group">
			<label for="approvalNotes">Note to Approvers (optional):</label>
			<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[2][note]"></textarea>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="2">Previous</button>
		</div>
	</div>
	<div class="bg-white approval-phase saved-phase animated fadeIn hide" id="preview_approvalPhase" data-id="2">
		<h2 class="clearfix">Phase 3 <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
		<ul class="timeframe-list user-list approval-list border-bottom clearfix">					
			
		</ul>
		<div class="approval-date">
			<span class="uppercase">Must approve by:</span> <span class="date-preview3"></span> <span class="time-preview">at <span class="hour-preview"></span>:<span class="minute-preview"></span> <span class="ampm-preview"></span></span>
		</div>
		<div class="approval-note">
			
		</div>
	</div>

	<footer class="post-content-footer" id="save-phase-btns">
		<button type="button" class="btn btn-sm btn-default cancel-phase">Cancel</button>
		<button type="button" class="btn btn-sm btn-secondary pull-sm-right save-phases btn-disabled" disabled="disabled">Save Phases</button>
	</footer>
	<footer class="post-content-footer hide" id="submit-approval-btns">
		<button class="btn btn-sm btn-default save-draft-btn submit-btn clear-phase" id="draft">Save Draft</button>
		<button type="button" class="btn btn-sm btn-secondary submit-approval submit-btn clear-phase pull-sm-right" id="submit-approval">Submit for Approval</button>
	</footer>
