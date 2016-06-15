
<form  id="edit-post-details" class="file-upload clearfix" action="<?php echo base_url() ?>calendar/edit_post "  method="post" upload="<?php echo base_url()."posts/upload"; ?>">

		<input type="hidden" name="is_new_approver" value="no" id="is-new-approver">

		<div class="row equal-cols create">
			<div class="col-md-4">
				<div class="container-post-preview post-content">
					<h4 class="text-xs-center">Live Preview</h4>
					<div id="live-post-preview">
						<?php
						if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($post_details->outlet_name).".php")){
						 	$this->load->view('calendar/post_preview/'.strtolower($post_details->outlet_name));
						}
						?>
					</div>
					<footer class="post-content-footer day-edit-post">
						<a href="#" data-post-id="<?php echo $post_details->id; ?>" class="btn btn-default btn-xs delete_post">Delete</a>
					</footer>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="container-post-details post-content">
					<h4 class="text-xs-center">Post Details</h4>
					<div class="form-group">
					<input type="hidden" name="post_id" value="<?php echo $post_details->id; ?>">
					<input type="hidden" name=" brand_id" value="<?php echo $post_details->brand_id ; ?>">
					<input type="hidden" name=" brand_slug" value="<?php echo $slug ; ?>">
					<input type="hidden" name="uploaded_files[]" id="uploaded_files">
					<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $this->user_id; ?>">
					
					<input type="hidden" id="all_files">
						<div class="outlet-list clearfix">
							<label for="postOutlet" class="pull-sm-left">Outlet: </label>
							<?php 
								if(!empty($outlets)){
									echo '<ul class="pull-sm-left outlet_ul">';

									foreach($outlets as $outlet)
									{
										//echo '<pre>'; print_r($outlet);echo '</pre>';
										$class = strtolower($outlet->outlet_name);
										if(strtolower($outlet->outlet_name) == 'youtube')
										{
											$class = 'youtube-play';
										}
										$selected ='class= "disabled" ';
										if( $post_details->outlet_id == $outlet->id  ){
											$selected = '';
										}
										?>
											<li <?php echo $selected; ?>   data-selected-outlet="<?php echo $outlet->id; ?>" data-outlet-const="<?php echo strtolower($outlet->outlet_name); ?>">
												<i class="fa fa-<?php echo $class; ?>">
													<span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span>
												</i>
											</li>
										<?php
									}
									echo '</ul>';
								}
							?>
							<input type="hidden" name="post_outlet" id="postOutlet" value="<?php echo $post_details->outlet_id; ?>" data-outlet-const="<?php echo strtolower($post_details->outlet_name); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="postCopy">Post Copy</label>
						<textarea class="form-control" id="postCopy" name ="post_copy" rows="5" placeholder="Type your copy here..."><?php echo (!empty($post_details->content)) ? $post_details->content : '';?></textarea>
					</div>
					<div class="form-group">
						<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></label>
						<div class="form__input has-files">
							<?php 
								if(!empty($post_images)){
									$class = 1;
									foreach ($post_images as $key) {
										echo '<img src="'.base_url().'uploads/'.$post_details->created_by.'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'" class="form__file-preview delete-img " data-delete="'.$class.'" />';
										$class++;									
		                            }
		                            echo '<label class="file-upload-label" id="postFileLabel" for="postFile"><i class="tf-icon circle-border">+</i><span class="form__label-text">Click to upload<span class="form__dragndrop"> or drag &amp; drop here ...</span></span></label>';
								}else{?>
									<label for="postFile" id="postFileLabel" class="file-upload-label">
										<i class="tf-icon circle-border">+</i>
										<span class="form__label-text">Click to upload
											<span class="form__dragndrop"> or drag &amp; drop here ...</span>
										</span>
									</label>
									<?php
								}
							?>
							<input type="file" name="files[]" id="postFile" class="form__file" data-multiple-caption="{count} files selected" multiple />
							<button type="button" class="form__button btn btn-sm btn-default">Upload</button>
						</div>
						<div class="form__uploading">Uploading ...</div>
						<div class="form__success">Done!</div>
						<div class="form__error">Error! <span></span>.</div>
					</div>

					<div class="form-group pull-sm-left">
						<label>Slate Post:</label><br>
						<div class="hide-top-bx-shadow">
							<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0"  value="<?php echo date('m/d/Y' , strtotime($post_details->slate_date_time))?>" >
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<div class="pull-xs-left">
							<label class="invisible">Post Time</label>
							<div class="time-select form-control">
								<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH" value="<?php echo date('h' , strtotime($post_details->slate_date_time))?>">
								<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM" value="<?php echo date('i' , strtotime($post_details->slate_date_time))?>">
								<input type="text" class="time-input amselect" name="post-ampm"  value="<?php echo date('A' , strtotime($post_details->slate_date_time))?>">
							</div>
						</div>
						<span class="timezone pull-xs-right">
							<label class="invisible">Post Timezone</label>
							PST
						</span>
					</div>

					<div class="form-group pull-xl-right">
						<label>Tags:</label><br>
						<div class="hide-top-bx-shadow">
							<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/selected_tag_list/'.$post_details->brand_id.'/'.$post_details->id; ?>" data-title="Select all that apply:" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-offset-x="0" data-offset-y="-2">
								<?php
								$style = ''; 
								if(!empty($selected_tags)){
									$style = ' style="display: none;" ';
									foreach ($selected_tags as $stag) {
										?>
										<i style="color:<?php echo $stag['tag_color']; ?>" data-tag="<?php echo $stag['id']; ?>" class="fa fa-circle"><input type="checkbox" value="<?php echo $stag['id']; ?>" name="post_tag[]" class="hidden-xs-up" checked="checked"></i>
										<?php
										}
								}
								?>
								<i class="fa fa-circle color-gray-lighter"  <?php echo $style; ?>></i> | <i class="fa fa-caret-down color-black"></i>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
					<footer class="post-content-footer">
						<div class="auto-save text-xs-center hidden">Auto Saving ...</div>
					</footer>
				</div>			
			</div>
			
			<div class="col-md-4">
				<div class="container-phases">
				<h4 class="text-xs-center">Post Details</h4>
					<?php 
					$phase_count = 0;
					//echo '<pre>'; print_r($phases);echo '</pre>';
					?> 
						<div class="bg-gray-lightest border-gray-lighter border-all padding-22px">
							<div class="container-phases">
								<div id="phaseDetails" >
									<?php
										if(!empty($phases)){ 
											$phase_count = count($phases);
											foreach ($phases as $phase_no => $obj) {
												$user_list = 'data-toggle="popover-ajax-inline"';
												$class = 'inactive';
												if($phase_no == 1)
												{
													$class = 'active';
													$user_list = 'data-toggle="popover-ajax" data-content-src="'.base_url().'brands/get_brand_users/'.$post_details->brand_id.'"';
												}
												$phase_no -- ;
												?>
													<div>
														<div class="bg-white approval-phase animated fadeIn hide edit-phase-div <?php echo $class; ?>" id="approvalPhase<?php echo $phase_no + 1 ; ?>" data-id="<?php  echo $phase_no ;?>">
															<h2 class="clearfix">Phase <?php echo $phase_no + 1;?> </h2>
															<ul <?php echo $user_list; ?> class="first-new-phase timeframe-list user-list border-bottom popover-toggle approver-selected" data-title="Add to Phase <?php echo $phase_no; ?>" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
																<li>
																<?php
																	foreach($obj as $user)
																	{
																		$image_path = img_url().'default_profile.jpg';
																		if(file_exists(upload_path().$brand->created_by.'/users/'.$user->user_id.'.png'))
																		{
																			$image_path = upload_url().$brand->created_by.'/users/'.$user->user_id.'.png';
																		}
																		?>
																		<div class="pull-sm-left">
																			<input type="checkbox" name="phase[<?php echo $phase_no;?>][approver][]" value="<?php echo $user->user_id; ?>" checked="checked" class="hidden-xs-up approvers">
																			<img width="36" height="36" class="circle-img" alt="Sampat" src="<?php echo $image_path; ?>" data-id="<?php echo $user->user_id; ?>">
																		</div>
																		<?php
																	}
																	?>																		
																	<div class="pull-sm-left">
																		<i class="tf-icon tf-icon-plus circle-border bg-black autoUserList">+</i>
																	</div>
																	<div class="pull-sm-left post-approver-name">Add <br>Approvers</div>
																</li>
															</ul>
															<input type="hidden"  value="<?php echo $obj[0]->phase_id; ?>" name="phase[<?php echo $phase_no;?>][phase_id]" >
															<div class="clearfix">
																<div class="form-group form-inline pull-sm-left phase-date-time-div">
																	<div class="hide-top-bx-shadow">
																		<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[<?php echo $phase_no;?>][approve_date]" value="<?php echo date('m/d/Y' , strtotime($obj[0]->approve_by))?>" >
																	</div>
																</div>
																<div class="form-group pull-sm-left">
																	<div class="pull-xs-left">
																		<div class="time-select form-control form-control-sm phase-time-input">
																			<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[<?php echo $phase_no;?>][approve_hour]"  value="<?php echo date('h' , strtotime($obj[0]->approve_by))?>">
																			<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[<?php echo $phase_no;?>][approve_minute]"  value="<?php echo date('i' , strtotime($obj[0]->approve_by))?>">
																			<input type="text" class="time-input amselect" value="am" name="phase[<?php echo $phase_no;?>][approve_ampm]"  value="<?php echo date('A' , strtotime($obj[0]->approve_by))?>">
																		</div>
																	</div>
																	<span class="timezone pull-xs-right form-control-sm phase-timezone">PST</span>
																</div>
															</div>
															<div class="form-group">
																<label for="approvalNotes">Note to Approvers (optional):</label>
																<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[<?php echo $phase_no;?>][note]"><?php echo $obj[0]->note; ?></textarea>
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
																?>
																
																
																<button type="button" class="btn btn-xs pull-sm-right btn-change-phase btn-disabled" data-new-phase="<?php echo $phase_no + 2;?>" data-active-class="btn-default" disabled="disabled">Next Phase</button>
															</div>
														</div>

														<div class="bg-white approval-phase animated fadeIn" id="preview_approvalPhase<?php echo $phase_no + 1;?>">
															<h2 class="clearfix">Phase <?php echo $phase_no + 1;?> 
																<button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button>

																<?php
																if($obj[0]->phase_status != 'pending')
																{
																	?>
																	<button type="button" id="<?php echo $obj[0]->phase_id; ?>" class="btn btn-xs btn-default pull-sm-right resubmit-approval">Resubmit for Approval</button>
																	<?php
																}
																?>													
															</h2>
															<ul class="timeframe-list user-list approval-list border-bottom clearfix">
																<?php
																foreach($obj as $user)
																{
																	$image_path = img_url().'default_profile.jpg';
																	if(file_exists(upload_path().$brand->created_by.'/users/'.$user->user_id.'.png'))
																	{
																		$image_path = upload_url().$brand->created_by.'/users/'.$user->user_id.'.png';
																	}
																	?>
																	<li class="pull-sm-left <?php echo $user->status; ?>">
																		<img width="36" height="36" class="circle-img" alt="Sampat" src="<?php echo $image_path; ?>" data-id="<?php echo $user->user_id; ?>">
																	</li>
																	<?php
																}
																?>
															</ul>
															<div class="approval-date">
																<span class="uppercase">Must approve by:</span> <span class="date-preview<?php echo $phase_no + 1 ; ?>"><?php echo date('m/d/y',strtotime($obj[0]->approve_by)); ?></span><span class="time-preview<?php echo $phase_no + 1 ; ?>"><?php  echo ' '.date('\a\t h:i A',strtotime($obj[0]->approve_by)); ?></span> PST
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
															else
															{
																?>
																<div class="approval-note">		
																</div>
																<?php
															}
															?>	
														</div>
													</div>

											<?php
											}
										}

										$phase_count = $phase_count+1;
										for($i = $phase_count; $i <= 3 ;$i++ ){
											$inactive =  'inactive';
											//echo $phase_count;
											//echo $i;
											if( $phase_count == 1 && $i == 1 ){
												$inactive = '';
											}
											if($phase_count == 1){
												$this->load->view('partials/all_phases');
												break;
											}else{
												?>
												<div>
													<div class="bg-white approval-phase animated fadeIn edit-phase-div  <?php echo $inactive ;?>" id="approvalPhase<?php echo $i?>" data-id="<?php echo $i -1 ?>">
														<h2 class="clearfix">Phase <?php echo $i?></h2>
														<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax-inline" data-content-src="<?php echo base_url().'calendar/get_brand_users_by_post/'.$post_details->brand_id.'/'.$post_details->id.'/'.$i; ?>" data-title="Add to Phase <?php echo $i; ?>" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
															<li>
																<div class="pull-sm-left">
																	<i class="tf-icon tf-icon-plus circle-border bg-black">+</i>
																</div>
																<div class="pull-sm-left post-approver-name">Add <br>Approvers</div>
															</li>
														</ul>
														<div class="clearfix">
															<div class="form-group form-inline pull-sm-left phase-date-time-div">
																<div class="hide-top-bx-shadow">
																	<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[<?php echo $i- 1;?>][approve_date]">
																</div>
															</div>
															<div class="form-group pull-sm-left">
																<div class="pull-xs-left">
																	<div class="time-select form-control form-control-sm phase-time-input">
																		<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[<?php echo $i- 1;?>][approve_hour]">
																		<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[<?php echo $i- 1;?>][approve_minute]">
																		<input type="text" class="time-input amselect" value="am" name="phase[<?php echo $i- 1;?>][approve_ampm]">
																	</div>
																</div>
																<span class="timezone pull-xs-right form-control-sm phase-timezone">PST</span>
															</div>
														</div>
														<div class="form-group">
															<label for="approvalNotes">Note to Approvers (optional):</label>
															<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[<?php echo $i- 1;?>][note]"></textarea>
														</div>

														<div class="form-group">
															<?php 
																if($i != 1){
																	$class = '';
																	if($phase_no == 2)
																	{
																		$class = 'last_previous_btn';
																	}
																	?>
																	<button type="button" class="btn btn-sm btn-default btn-change-phase <?php echo $class; ?>" data-new-phase="<?php echo $i - 1 ?>">Previous</button>
																	<?php
																}else{
																	if($i != 3){
																		?>
																			<button type="button" class="btn btn-sm btn-default cancel-edit-phase">Cancel</button>
																		<?php
																	}
																}
																if($i != 3){
																	?>
																	<button type="button" class="btn btn-xs pull-sm-right btn-change-phase btn-disabled" data-new-phase="<?php echo $i + 1;?>" data-active-class="btn-default" disabled="disabled">Next Phase</button>
																	<?php
																}else{
																	?>
																	
																	<?php
																}
															?>
														</div>													
													</div>
														<div class="bg-white approval-phase animated fadeIn hide" id="preview_approvalPhase<?php echo $i; ?> ">
															<h2 class="clearfix">Phase <?php echo $i?> <button type="button" title="Edit Phase" class="btn-icon edit-phase"><i class="fa fa-pencil"></i></button></h2>
															<ul class="timeframe-list user-list approval-list border-bottom clearfix">
																
															</ul>													

															<div class="approval-date">
																<span class="uppercase">Must approve by:</span> <span class="date-preview<?php echo $i ?>"></span><span class="time-preview3"></span>PST
															</div>
															<div class="approval-note">
																NOTE: <?php echo $obj[0]->note; ?>
															</div>
														</div>
												</div>
												<?php
											}
										}

									?>
									<div>
										<div>
											<footer class="post-content-footer">
												<button type="button" class="btn btn-sm btn-default cancel-edit-phase" data-active-class="btn-default">Cancel</button>
												<button type="button" class="btn btn-sm pull-sm-right save-phases btn-disabled" data-active-class="btn-secondary" disabled="disabled">Save Phases</button>
											</footer>
										</div>
										<!-- <div class="hide">
											<footer class="post-content-footer">
												<button class="btn btn-sm save-draft-btn" data-active-class="btn-default submit-btn" id="draft">Save Draft</button>
												<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn" data-active-class="btn-secondary" id="submit-approval">Submit for Approval</button>
											</footer>
										</div> -->
									</div>
								</div>
							</div>
						</div>								
					<?php //include("lib/view-approval-phases.php"); ?>
					
					<footer class="post-content-footer day-edit-post">
						<button type="submit" class="btn btn-sm submit-btn btn-default">Save Changes</button>
						<?php 
							if($phase_count > 0){
								echo '<button type="button" class="btn btn-sm btn-default pull-sm-right">Resubmit to Phases</button>';
							}
						?>
					</footer>

				</div>
			</div>
		</div>
	</form>
<?php 
$this->load->view('partials/modals');
?>