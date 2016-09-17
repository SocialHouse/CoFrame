<?php
if(empty($phases))
{
	$data['is_edit'] = 'true';
	$data['brand'] = $brand;
	$this->load->view('partials/all_phases' ,$data);
} 
else
{ 
	?>
	<div class="col-md-4 equal-height phases-div">
		<div class="container-approvals">
			<div class="add-phases">
				<div class="container-phases">
					<h4 class="text-xs-center">Mandatory Approvals</h4>
					<?php 
					$phase_count = 0;
					?> 
					<div id="phaseDetails" >
						<?php
						if(!empty($phases)){ 
							$phase_num_array = array('0' => 'one','1'=>'two','2'=>'three');
							$phase_count = count($phases);
							foreach ($phases as $phase_no => $obj) {
								$class = 'inactive';
								$user_list = 'data-toggle="popover-ajax" data-content-src="'.base_url().'brands/get_brand_users/'.$post_details->brand_id.'"';
								$phase_no -- ;
						?>
								<div class="bg-white approval-phase animated fadeIn hide edit-phase-div <?php echo $class; ?>" id="approvalPhase<?php echo $phase_no + 1 ; ?>" data-id="<?php  echo $phase_no ;?>">
									<h2 class="clearfix">Phase <?php echo $phase_no + 1;?>
										<button data-phase-id="<?php echo $obj[0]->phase_id; ?>" data-post-id="<?php echo $obj[0]->post_id; ?>" type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
									</h2>
									<ul <?php echo $user_list; ?> class="first-new-phase timeframe-list user-list border-bottom popover-toggle approver-selected" data-title="Add to Phase <?php echo $phase_no; ?>" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top" data-popover-container="#edit-post-details">
										<li>
											<?php
											foreach($obj as $user)
											{
												$image_path = img_url().'default_profile.jpg';
												if(file_exists(upload_path().$user->img_folder.'/users/'.$user->user_id.'.png'))
												{
													$image_path = upload_url().$user->img_folder.'/users/'.$user->user_id.'.png';
												}
											?>
												<div class="pull-sm-left user-img">
													<img width="36" height="36" class="circle-img" alt="Sampat" src="<?php echo $image_path; ?>" data-id="<?php echo $user->user_id; ?>">
												</div>
											<?php
											}
											?>																		
											<div class="pull-sm-left">
												<i class="tf-icon tf-icon-plus circle-border bg-black autoUserList">+</i>
											</div>
											<div class="add-approver">Add <br>Approvers</div>
										</li>
									</ul>
									<input type="hidden"  value="<?php echo $obj[0]->phase_id; ?>" name="phase[<?php echo $phase_no;?>][phase_id]" >
									<label>Must approve by:</label>
									<div class="clearfix">
										<div class="form-group form-inline pull-sm-left date-time-div">
											<div class="hide-top-bx-shadow">
												<input id="ph_<?php echo $phase_num_array[$phase_no]; ?>_date" type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="#edit-post-details" name="date<?php echo $phase_no; ?>" value="<?php echo date('m/d/Y' , strtotime($obj[0]->approve_by))?>">
											</div>
										</div>
										<div class="form-group pull-sm-left">
											<div class="pull-xs-left">
												<div class="time-select form-control form-control-sm phase-time-input <?php echo $phase_no + 1;?>-phase-time-input">
													<input id="ph_<?php echo $phase_num_array[$phase_no]; ?>_hour" type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase_approve_hour<?php echo $phase_no;?>" value="<?php echo date('h' , strtotime($obj[0]->approve_by))?>">
													<input id="ph_<?php echo $phase_num_array[$phase_no]; ?>_minute" type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase_approve_minute<?php echo $phase_no;?>"  value="<?php echo date('i' , strtotime($obj[0]->approve_by))?>">
													<input id="ph_<?php echo $phase_num_array[$phase_no]; ?>_ampm" type="text" class="time-input amselect" value="am" name="phase_approve_ampm<?php echo $phase_no;?>"  value="<?php echo date('A' , strtotime($obj[0]->approve_by))?>">
												</div>
											</div>
										</div>
										<div class="form-group slate-post-tz">
											<select class="form-control form-control-sm approval_timezone" name="phase[<?php echo $phase_no ;?>][time_zone]">
												<?php 
													// Display remaining timezones

													foreach ($timezones as $ti_key => $time) 
													{
														$selected = '';
														if(!empty($obj[0]->time_zone))
														{
															if($time->value == $obj[0]->time_zone){
																$selected = 'selected = "selected"';	
															}
														}
														else
														{
															if( $time->value == $brand->timezone)
															{
																$selected = 'selected = "selected"';
															}
														}

														?>
														<option value="<?php echo $time->value; ?>" <?php echo $selected;?>><?php echo $time->timezone; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="approvalNotes">Note to Approvers (optional):</label>
										<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." ><?php echo nl2br($obj[0]->note); ?></textarea>
									</div>
									<div class="form-group">
										<?php 
										if($phase_no != 0){
										?>
											<button type="button" class="btn btn-sm btn-default btn-change-phase" data-new-phase="<?php echo $phase_no ?>">Previous</button>
										<?php
										}else{
											$class = 'cancel-edit-phase';
											if($phase_no == 2)
											{
												$class = 'last_previous_btn';
											}
										?>
											<button type="button" class="btn btn-sm btn-default <?php echo $class; ?>">Cancel</button>
										<?php																			
										}
										$btn_text = 'Next Phase';		
										if($phase_count == ($phase_no + 1))
										{
											$btn_text = 'Add Phase';
										}
										?>
										<button type="button" class="btn btn-xs pull-sm-right btn-secondary btn-change-phase btn-disabled" data-new-phase="<?php echo $phase_no + 2;?>" disabled="disabled"><?php echo $btn_text; ?></button>
									</div>
								</div>
								<div class="bg-white approval-phase saved-phase animated fadeIn" id="preview_edit_approvalPhase<?php echo $phase_no + 1;?>" data-id="<?php  echo $phase_no;?>">
									<h2 class="clearfix">Phase <?php echo $phase_no + 1;?> 
										<button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button>
										<?php
										if($obj[0]->phase_status != 'pending')
										{
										?>
											<button type="button" id="<?php echo $obj[0]->phase_id; ?>" class="btn btn-xs btn-default pull-sm-right resubmit-approval color-success">Resubmit for Approval</button>
										<?php
										}
										?>													
									</h2>
									<ul class="timeframe-list user-list approval-list border-bottom clearfix">
										<?php
										foreach($obj as $user)
										{
											$image_path = img_url().'default_profile.jpg';
											if(file_exists(upload_path().$user->img_folder.'/users/'.$user->user_id.'.png'))
											{
												$image_path = upload_url().$user->img_folder.'/users/'.$user->user_id.'.png';
											}
										?>
											<li class="pull-sm-left <?php echo $user->status; ?>">
												<input type="checkbox" name="phase[<?php echo $phase_no;?>][approver][]" value="<?php echo $user->user_id; ?>" checked="checked" class="hidden-xs-up approvers">

												<img width="36" height="36" class="circle-img" src="<?php echo $image_path; ?>" data-id="<?php echo $user->user_id; ?>"  alt="<?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?>" data-toggle="popover-hover" data-content="<?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?>">
											</li>
										<?php
										}
										?>
									</ul>

									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_date]" class="phase-date-time-input" value="<?php echo date('m/d/Y' , strtotime($obj[0]->approve_by))?>" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_hour]" class="hour-select" value="<?php echo date('h' , strtotime($obj[0]->approve_by))?>" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_minute]" class="minute-select" value="<?php echo date('i' , strtotime($obj[0]->approve_by))?>" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_ampm]" class="amselect" value="<?php echo date('A' , strtotime($obj[0]->approve_by))?>" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][time_zone]" class="zone" value="<?php echo $obj[0]->time_zone; ?>" />		
									<textarea name="phase[<?php echo $phase_no;?>][note]" class="note hide"><?php echo nl2br($obj[0]->note); ?></textarea>

									<div class="approval-date">
										<span class="uppercase">Must approve by:</span> 
										<span class="date-preview"> <?php echo date('m/d/y',strtotime($obj[0]->approve_by)); ?> 
										</span> 
										<span class="time-preview">at 
											<span class="hour-preview">
												<?php  echo ' '.date('h',strtotime($obj[0]->approve_by)); ?>
											</span>:
											<span class="minute-preview">
												<?php  echo date('i',strtotime($obj[0]->approve_by)); ?>
											</span> 
											<span class="ampm-preview">
												<?php  echo ' '.date('A',strtotime($obj[0]->approve_by)); ?>
											</span>
										</span>

										<!-- <span class="uppercase">Must approve by:</span> <span class="date-preview"><?php echo date('m/d/y',strtotime($obj[0]->approve_by)); ?></span> <span class="time-preview"><?php  echo ' '.date('\a\t h:i A',strtotime($obj[0]->approve_by)); ?></span> -->
									</div>
									<?php
									if(!empty($obj[0]->note))
									{
									?>
										<div class="approval-note">
											NOTE: <?php echo nl2br($obj[0]->note); ?>
										</div>
									<?php
									}
									else
									{
									?>
										<div class="approval-note">		
										</div>
									<?php
									}
									?>	
								</div>
							<?php
							}
						}
						$phase_count = $phase_count+1;
						for($i = $phase_count; $i <= 3 ;$i++ ){
							$inactive =  'inactive hide hidden-phase';
							if( $phase_count == 1 && $i == 1 ){
								$inactive = '';
							}
							if($phase_count != 1){
							?>
								<div class="bg-white approval-phase animated fadeIn edit-phase-div <?php echo $inactive ;?>" id="approvalPhase<?php echo $i; ?>" data-id="<?php echo $i -1; ?>">
									<h2 class="clearfix">Phase <?php echo $i?>
									<button type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>

									<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/get_brand_users/'.$post_details->brand_id; ?>" data-title="Add to Phase <?php echo $i; ?>" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list-<?php echo $i?>" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top" data-popover-container="#edit-post-details">
										<li>
											<div class="pull-sm-left">
												<i class="tf-icon tf-icon-plus circle-border bg-black">+</i>
											</div>
											<div class="add-approver">Add <br>Approvers</div>
										</li>
									</ul>
									<div class="clearfix">
										<div class="form-group form-inline pull-sm-left date-time-div">
											<div class="hide-top-bx-shadow">
												<input id="ph_<?php echo $phase_num_array[$i -1] ; ?>_date" type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="#edit-post-details" name="date<?php echo $i- 1;?>">
											</div>
										</div>
										<div class="form-group pull-sm-left">
											<div class="pull-xs-left">
												<div class="time-select form-control form-control-sm phase-time-input <?php echo $i;?>phase-time-input">
													<input id="ph_<?php echo $phase_num_array[$i - 1]; ?>_hour" type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase_approve_hour<?php echo $i- 1;?>">
													<input id="ph_<?php echo $phase_num_array[$i -1]; ?>_minute" type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase_approve_minute<?php echo $i- 1;?>">
													<input id="ph_<?php echo $phase_num_array[$i - 1]; ?>_ampm" type="text" class="time-input amselect" value="am" name="phase_approve_ampm<?php echo $i- 1;?>">
												</div>
											</div>
										</div>
										<div class="form-group slate-post-tz">
											<select class="form-control form-control-sm approval_timezone" name="phase[<?php echo $i- 1;?>][time_zone]">			
												<?php 
													// Display remaining timezones
													foreach ($timezones as $ti_key => $time) 
													{
														$selected = '';
														if( $time->value == $brand->timezone)
														{
															$selected = 'selected = "selected"';
														}
														?>
														<option value="<?php echo $time->value; ?>" <?php echo $selected;?>><?php echo $time->timezone; ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="approvalNotes">Note to Approvers (optional):</label>
										<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[<?php echo $i- 1;?>][note]"></textarea>
									</div>
									<div class="form-group">
										<?php 
										if($i != 1)
										{
											$class = '';
											if($phase_no == 2)
											{
												$class = 'last_previous_btn';
											}
											?>
											<button type="button" class="btn btn-sm btn-default btn-change-phase <?php echo $class; ?>" data-new-phase="<?php echo $i - 1; ?>">Previous</button>
											<?php
										}
										else
										{
											if($i != 3)
											{
												?>
												<button type="button" class="btn btn-sm btn-default cancel-edit-phase">Cancel</button>
												<?php
											}
										}
										if($i != 3)
										{
										?>
											<button type="button" class="btn btn-xs pull-sm-right btn-secondary btn-change-phase btn-disabled" data-new-phase="<?php echo $i + 1;?>" disabled="disabled">Next Phase</button>
										<?php
										}
										?>
									</div>													
								</div>
								<div class="bg-white approval-phase saved-phase animated fadeIn hide" id="preview_edit_approvalPhase<?php echo $i; ?>" data-id="<?php echo $i - 1; ?>">
									<h2 class="clearfix">Phase <?php echo $i?> <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
									<ul class="timeframe-list user-list approval-list border-bottom clearfix">
									</ul>

									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_date]" class="phase-date-time-input" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_hour]" class="hour-select" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_minute]" class="minute-select" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_ampm]" class="amselect" />
									<input type="hidden" name="phase[<?php echo $phase_no;?>][time_zone]" class="zone" />		
									<textarea name="phase[<?php echo $phase_no;?>][note]" class="note hide"></textarea>													
									<div class="approval-date">
										<span class="uppercase">Must approve by:</span> <span class="date-preview<?php echo $i ?>"></span> <span class="time-preview">at <span class="hour-preview"></span>:<span class="minute-preview"></span> <span class="ampm-preview"></span></span>
									</div>
									<div class="approval-note">
										NOTE: <?php echo nl2br($obj[0]->note); ?>
									</div>
								</div>
						<?php
							}
						}
						?>
						<footer class="post-content-footer hide phase-footer" id="save-phase-btns">
							<button type="button" class="btn btn-sm btn-default cancel-edit-phase">Cancel</button>
							<button type="button" class="btn btn-sm pull-sm-right save-phases btn-disabled btn-secondary" disabled="disabled">Save Phases</button>
						</footer>
						<footer id="submit-approval-btns" class="post-content-footer day-edit-post">
							<button type="submit" class="btn btn-sm submit-btn btn-default">Save Changes</button>
							<?php 
								if($phase_count > 0){
									echo '<button type="submit" class="btn btn-sm btn-default pull-sm-right submit-btn" name="resubmit" value="resubmit" >Resubmit to Phases</button>';
								}
							?>
						</footer>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
}