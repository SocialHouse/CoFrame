<?php 
	if(!empty($post_details)){
		$outlet_name = $post_details->outlet_name;
?>	
		<div class="row equal-cols">
			<div class="col-md-6 bg-white equal-height">
				<div class="container-post-preview">
					<div id="live-post-preview">
						<?php
						if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($outlet_name).".php")){
						 	$this->load->view('calendar/post_preview/'.strtolower($outlet_name));
						}
						?>
					</div>
					<footer class="post-content-footer">
						<a href="#" class="btn btn-secondary btn-xs">Approve</a>
						<div class="btn-group pull-md-right" role="group">
						  <button type="button" class="btn btn-xs btn-default">Edit</button>
						  <button type="button" class="btn btn-xs btn-default">Schedule</button>
						  <button type="button" class="btn btn-xs btn-default">Post Now</button>
						</div>
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
										<h2 class="clearfix">Phase <?php echo $phase_no ?> <button title="Edit Phase" class="btn-icon">
											<i class="fa fa-pencil"></i></button>
											<button class="btn btn-xs btn-secondary color-success pull-sm-right">Resubmit for Approval</button>
										</h2>
										<ul class="timeframe-list user-list approval-list border-bottom clearfix">
											<?php
											foreach ($obj as $key => $details) {
												if (!file_exists('uploads/users/'.$details->user_id.'.png')) {
													$user_img = '../../assets/images/default_profile.jpg';
												}else{
													$user_img = '../../uploads/users/'.$details->user_id.'.png';
												}
											?>
												<li class="pull-sm-left approved">
													<img  width="36" height="36" alt="Norel Mancuso" class="circle-img" src='<?php echo $user_img?>'/>
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
								  <button type="button" class="btn btn-xs btn-default">View Edit Requests</button>
								  <button type="button" class="btn btn-xs btn-default">Suggest an Edit</button>
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
