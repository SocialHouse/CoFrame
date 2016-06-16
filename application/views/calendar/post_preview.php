<?php 
	if(!empty($post_details))
	{
		$outlet_name = $post_details->outlet_name;

		$all_phases = get_post_approvers($post_details->id);								
		$user_is = '';
		$approver_stats = '';
		$phase_id = '';
		if(isset($all_phases['result']) and !empty($all_phases['result']))
		{
			foreach($all_phases['result'] as $phase)
			{
				if($phase['user_id'] == $this->user_id)
				{
					$user_is = 'approver';
					$approver_status = $phase['status'];
					$phase_id = $phase['id'];
				}
			}
		}


?>	
		<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
		<input type="hidden" name="outlet_id" id="postOutlet" value="<?php echo $post_details->user_id; ?>" />
		
		<div class="row equal-cols">
			<div class="col-md-6 bg-white equal-height">
				<div class="container-post-preview">
					<div id="live-post-preview-approver">
						<?php
						if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($outlet_name).".php")){
						 	$this->load->view('calendar/post_preview/'.strtolower($outlet_name));
						}
						?>
					</div>
					<footer class="post-content-footer">
						<span class="post-actions pull-xs-left">
							<!-- <a href="#" class="btn btn-secondary btn-xs approve_post" data-post-id="<?php echo $post_details->id; ?>"  data-user-id="<?php echo $this->user_id; ?>" >Approve</a> -->
							<?php
							if($user_is == 'approver')
							{
								if($approver_status == 'pending')
								{
									?>
									<div class="before-approve">
										<button class="btn btn-approved btn-sm btn-secondary change-approve-status small_font_size"  data-post-id="<?php echo $post_details->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="approved">Approve</button>
									</div>

									<div class="after-approve hide">
										<button class="btn btn-secondary btn-disabled btn-sm small_font_size" disabled>Approved</button><br>
										<a class="change-approve-status small_font_size"  data-post-id="<?php echo $post_details->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="pending" href="#">Undo</a>
									</div>
									<?php
								}
								elseif($approver_status == 'posted')
								{
									?>
									<button class="btn btn-approved btn-sm btn-default small_font_size">View Live</button>
									<?php 
								}
								elseif($approver_status == 'approved')
								{
									?>
									<div class="before-approve">	
										<button class="btn btn-secondary btn-disabled btn-sm small_font_size" disabled>Approved</button><br>
										<a  class="change-approve-status small_font_size"  data-post-id="<?php echo $post_details->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="pending" href="#">Undo</a>
									</div>

									<div class="after-approve hide">
										<button class="btn btn-approved btn-sm btn-secondary change-approve-status small_font_size" data-post-id="<?php echo $post_details->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="approved">Approve</button>
									</div>
									<?php
								}
							}
							else
							{

								if($post_details->user_id == $this->user_id)
								{
									?>
									<div class="btn-group pull-md-right" role="group">
										<a href="#" data-clear="yes" class="btn btn-xs btn-default" data-modal-src="<?php echo base_url()?>calendar/edit_post_calendar/<?php echo $post_details->slug.'/'.$post_details->id; ?>" data-toggle="modal-ajax" data-modal-id="edit-post-id<?php echo $post_details->id; ?>" data-modal-size="lg">Edit</a>
										<?php
										if($post_details->status == 'scheduled')
										{
											?>
											<button type="button" class="btn btn-xs btn-default" disabled>Scheduled</button>	
											<button type="button" class="btn btn-xs btn-default">Post Now</button>
											<?php
										}
										elseif($post_details->status == 'pending')
										{
											?>
											<button class="btn btn-xs btn-default schedule-post" id="<?php echo $post_details->id; ?>">Schedule</button>
											<button type="button" class="btn btn-xs btn-default">Post Now</button>
											<?php
										}
										elseif($post_details->status == 'posted')
										{
											?>
											<button type="button" class="btn btn-xs btn-default">Posted</button>
											<?php
										}
										?>								  		
								  	</div>
									<?php
								}
							}
							?>
						</span>						
					</footer>
				</div>
			</div>
			
				<?php 
					if(!empty($phases)){ 
					?> 
					<div class="col-md-6 bg-gray-lightest equal-height">
						<div class="container-phases">							
							<?php
								foreach ($phases as $phase_no => $obj) {
									?>
									<div class="bg-white approval-phase animated fadeIn" id="approvalPhase<?php echo $phase_no ?>">
										<h2 class="clearfix">Phase <?php echo $phase_no ?>
											<?php
											if($obj[0]->phase_status != 'pending' AND $post_details->user_id == $this->user_id)
											{
												?>
												<button id="<?php echo $obj[0]->phase_id; ?>" class="btn btn-xs btn-secondary color-success pull-sm-right resubmit-approval">Resubmit for Approval</button>
												<?php
											}
											?>
										</h2>
										<ul class="timeframe-list user-list approval-list border-bottom clearfix">
											<?php
											foreach ($obj as $key => $details) 
											{
												if (!file_exists(upload_path().$all_phases['owner_id'].'/users/'.$details->user_id.'.png')) 
												{
													$user_img = '../../assets/images/default_profile.jpg';
												}
												else
												{
													$user_img = upload_url().$all_phases['owner_id'].'/users/'.$details->user_id.'.png';
												}
											?>
												<li class="pull-sm-left <?php echo $details->status; ?>">
													<img  width="36" height="36" alt="<?php echo ucfirst($details->first_name).' '.ucfirst($details->last_name) ?>" class="circle-img" src='<?php echo $user_img?>'/>
												</li>
											<?php 
											}
											?>
										</ul>
										<div class="approval-date">
											<span class="uppercase">Must approve by:</span> <?php echo date('m/d/Y', strtotime($obj[0]->approve_by)). ' at ' .date('h:i A', strtotime($obj[0]->approve_by));?> PST
										</div>
										<?php
										if(!empty($obj[0]->note))
										{
											?>
											<div class="approval-note">
												NOTE: <?php echo $obj[0]->note ?>
											</div>
											<?php
										}
										?>
									</div>
								<?php
								}
							?>
							<footer class="post-content-footer">
								<div class="btn-group pull-md-right" role="group">
									<?php
									if($post_details->user_id == $this->user_id)
									{
										?>
										<a type="button" class="btn btn-xs btn-default" href="<?php echo base_url().'view-request/'.$post_details->id; ?>">View Edit Requests</a>
										<?php
									}
								  	if($user_is == 'approver')
								  	{
									  	?>
									  	<a type="button" class="btn btn-xs btn-default" href="<?php echo base_url().'edit-request/'.$post_details->id; ?>">Suggest an Edit</a>
									  	<?php
									}
									?>
								</div>
							</footer>							
						</div>
					</div>
					<?php
					}
				?>
		</div>
		<?php
			}
		?>
