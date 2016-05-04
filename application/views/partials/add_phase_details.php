<div class="bg-gray-lightest border-gray-lighter border-all padding-22px add-phases">
	<div class="container-phases">
		<h4 class="text-xs-center">Mandatory Approvals</h4>
		<div class="overlay-box bg-white animated fadeIn">
			<div class="text-xs-center form-inline">
				<label for="approvalPhases">How many approval phases would you like to add? (1-3)</label>
				<select class="form-control" id="approvalPhases">
					<option value="">1</option>
					<option value="">2</option>
					<option value="">3</option>
				</select>
			</div>
			<footer class="form-footer">
				<button class="btn btn-xs btn-default">Cancel</button>
				<button type="button" class="btn btn-xs btn-secondary pull-sm-right" onClick="showContent(jQuery('#phaseDetails')); hideContent(jQuery(this).closest('.overlay-box'));">Next</button>
			</footer>
		</div>
		<div id="phaseDetails" style="display: none;">
			<div class="bg-white approval-phase active animated fadeIn" id="approvalPhase1" data-id="0">
				<h2 class="clearfix">Phase 1 <button title="Edit Phase" disabled class="btn-icon btn-disabled" data-active-class="btn-gray"><i class="fa fa-pencil"></i></button>
				<button title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
				<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/get_brand_users/'.$brand_id; ?>" data-title="Add to Phase 1" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
					<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
				</ul>
				<div class="form-group form-inline">
					<label>Must approve by:</label><br>
					<select class="form-control form-control-sm" name="phase[0][approve_month]">
						<option value="">Month</option>
						<?php
						for($i = 1;$i<=12;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo date("M", mktime(null, null, null, $i, 1)); ?></option>
		    				<?php
		    			}
						?>
					</select>
					<select class="form-control form-control-sm" name="phase[0][approve_day]">
						<option value="">DD</option>
						<?php
		    			for($i = 1;$i<=31;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		    				<?php
		    			}
		    			?>
					</select>
					<select class="form-control form-control-sm" name="phase[0][approve_year]">
						<option value="">YYYY</option>
						<?php
		    			for($i = date('Y');$i<=date('Y') +10;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		    				<?php
		    			}
		    			?>
					</select>
					<input type="text" class="form-control form-control-sm form-control-time" placeholder="HH:MM" name="phase[0][approve_time]">
					<select class="form-control form-control-sm" name="phase[0][time_type]">
						<option value="am">AM</option>
						<option value="pm">PM</option>
					</select>
				</div>
				<div class="form-group">
					<label for="approvalNotes">Note to Approvers (optional):</label>
					<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[0][note]"></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-sm btn-default">Cancel</button>
					<button type="button" class="btn btn-xs pull-sm-right btn-change-phase" data-new-phase="2" data-active-class="btn-default">Next Phase</button>
				</div>
			</div>

			<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase2" data-id="1">
				<h2 class="clearfix">Phase 2 <button title="Edit Phase" disabled class="btn-icon btn-disabled" data-active-class="btn-gray"><i class="fa fa-pencil"></i></button>
				<button title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
				<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax-inline" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-title="Add to Phase 2" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
					<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
				</ul>
				<div class="form-group form-inline">
					<label>Must approve by:</label><br>
					<select class="form-control form-control-sm" name="phase[1][approve_month]">
						<option value="">Month</option>
						<?php
						for($i = 1;$i<=12;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo date("M", mktime(null, null, null, $i, 1)); ?></option>
		    				<?php
		    			}
						?>
					</select>
					<select class="form-control form-control-sm" name="phase[1][approve_day]">
						<option value="">DD</option>
						<?php
		    			for($i = 1;$i<=31;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		    				<?php
		    			}
		    			?>
					</select>
					<select class="form-control form-control-sm" name="phase[1][approve_year]">
						<option value="">YYYY</option>
						<?php
		    			for($i = date('Y');$i<=date('Y') +10;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		    				<?php
		    			}
		    			?>
					</select>
					<input type="text" class="form-control form-control-sm form-control-time" placeholder="HH:MM" name="phase[1][approve_time]">
					<select class="form-control form-control-sm" name="phase[1][time_type]">
						<option value="am">AM</option>
						<option value="pm">PM</option>
					</select>
				</div>
				<div class="form-group">
					<label for="approvalNotes">Note to Approvers (optional):</label>
					<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[1][note]"></textarea>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="1">Previous</button>
					<button type="button" class="btn btn-xs pull-sm-right btn-change-phase" data-new-phase="3" data-active-class="btn-default">Next Phase</button>
				</div>
			</div>

			<div class="bg-white approval-phase animated fadeIn inactive" id="approvalPhase3" data-id="2">
				<h2 class="clearfix">Phase 3 <button title="Edit Phase" disabled class="btn-icon btn-disabled" data-active-class="btn-gray"><i class="fa fa-pencil"></i></button>
				<button title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
				<ul class="timeframe-list user-list border-bottom popover-toggle" data-toggle="popover-ajax-inline" data-title="Add to Phase 3" data-popover-id="popover-user-list" data-popover-class="popover-users popover-clickable" data-attachment="center right" data-target-attachment="center left" data-offset-x="-14" data-offset-y="0" data-popover-arrow="true" data-arrow-corner="right center">
					<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
				</ul>
				<div class="form-group form-inline">
					<label>Must approve by:</label><br>
					<select class="form-control form-control-sm" name="phase[2][approve_month]">
						<option value="">Month</option>
						<?php
						for($i = 1;$i<=12;$i++)
		    			{
		    				?>
		    				<option value="<?php echo $i; ?>"><?php echo date("M", mktime(null, null, null, $i, 1)); ?></option>
		    				<?php
		    			}
						?>
					</select>
					<select class="form-control form-control-sm" name="phase[2][approve_day]">
						<option value="">DD</option>
					</select>
					<select class="form-control form-control-sm" name="phase[2][approve_year]">
						<option value="">YYYY</option>
					</select>
					<input type="text" class="form-control form-control-sm form-control-time" placeholder="HH:MM" name="phase[2][approve_time]">
					<select class="form-control form-control-sm" name="phase[2][time_type]">
						<option value="am">AM</option>
						<option value="pm">PM</option>
					</select>
				</div>
				<div class="form-group">
					<label for="approvalNotes">Note to Approvers (optional):</label>
					<textarea class="form-control" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[2][note]"></textarea>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="2">Previous</button>
				</div>
			</div>
		</div>
		<footer class="post-content-footer">
			<button class="btn btn-sm btn-disabled" disabled data-active-class="btn-default">Cancel</button>
			<button class="btn btn-sm pull-sm-right" data-active-class="btn-secondary">Save Phases</button>
		</footer>
	</div>
</div>