<form name="edit-date" id="edit-phase-modal-form" method="post" action="<?php echo base_url();?>approvals/edit-approval-phase/<?php echo $phase_id.'/'.$post_id .'/edit'; ?>" autocomplete="off">
		<h5>Approvers</h5>
		<?php 
		$user_list = 'data-toggle="popover-ajax" data-content-src="'.base_url().'approvals/phase_user_list/'.$phase_id.'"';			
		?>
		<div id="phaseDetails" >
			<div class="active" id="<?php echo $phase_details->phase; ?>" data-id="<?php echo $phase_details->phase; ?>">
				<ul <?php echo $user_list; ?> class="first-new-phase timeframe-list user-list border-bottom popover-toggle approver-selected edit-request-approver" data-title="Add to Phase <?php echo $phase_details->phase; ?>" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top" data-popover-container="body">
					<li>
					<?php
						foreach ($phase_users as $key => $user)
						{
							$image_path = img_url().'default_profile.jpg';
							if(file_exists(upload_path().$user->img_folder.'/users/'.$user->aauth_user_id.'.png'))
							{
								$image_path = upload_url().$user->img_folder.'/users/'.$user->aauth_user_id.'.png';
							}
							?>
							<div class="pull-sm-left">
								<input type="checkbox" checked="checked" class="hidden-xs-up approvers" name="phase[<?php echo $phase_details->phase;?>][approver][]" value="<?php echo $user->aauth_user_id; ?>" >
								<img width="36" height="36" class="circle-img" alt="Sampat" src="<?php echo $image_path; ?>" data-id="<?php echo $user->aauth_user_id; ?>">
							</div>
							<?php
							}
						?>
						<div class="pull-sm-left">
							<i class="tf-icon tf-icon-plus circle-border bg-black autoUserList">+</i>
						</div>
						<div class="pull-sm-left add-approver">Add <br>Approvers</div>
					</li>
				</ul>
				<input type="hidden"  value="<?php echo $phase_id; ?>" name="phase[<?php echo $phase_details->phase;?>][phase_id]" >
				<h5>Must Approve By:</h5>
				<div class="clearfix">
					<div class="form-inline pull-sm-left">
						<div class="hide-top-bx-shadow">
							<input type="text" value="<?php echo date('m/d/Y', strtotime($phase_details->approve_by)); ?>" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-edit-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-popover-container="body" data-target-attachment="top left" data-popover-width="300">
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<div class="pull-xs-left">
							<div class="time-select form-control">
								<input type="text" class="time-input hour-select" name="post-hour" data-min="01" data-max="12" placeholder="HH" value="<?php echo date('h', strtotime($phase_details->approve_by));?>">
								<input type="text" class="time-input minute-select" name="post-minute" data-min="00" data-max="59" placeholder="MM" value="<?php echo date('i', strtotime($phase_details->approve_by)); ?>">
								<input type="text" class="time-input amselect" name="post-ampm" value="<?php echo date('A', strtotime($phase_details->approve_by)); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="approvalNotes">Note to Approvers (optional):</label>
					<textarea class="form-control" id="approvalNotes" rows="2" name="note" placeholder="Type your note here..."><?php echo (!empty($phase_details->note))?$phase_details->note :''; ?></textarea>
				</div>
			</div>
		</div>
		<footer class="overlay-footer">
			<button type="button" title="Delete Phase" class="pull-sm-left btn-icon btn-icon-xl delete-phase" data-phase-id="<?php echo $phase_id; ?>" data-post-id="<?php echo $post_id; ?>" >
				<i class="fa fa-trash-o"></i>
			</button>
			<span class="sep pull-sm-left"></span>
			<button type="reset" class="btn btn-sm btn-default close-phase-modal">Cancel</button>
			<button type="submit" class="btn btn-sm pull-sm-right btn-secondary">Save</button>
		</footer>

		<!-- Select Date Calendar -->
		<div id="calendar-edit-date" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
		</div>
	</form>
<?php

// echo '<pre>'; print_r($phase_users);echo '</pre>';
// echo '<pre>'; print_r($phase_details);echo '</pre>';
?>

