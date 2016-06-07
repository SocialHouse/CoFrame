
	
<!-- $outlet_name = $post_details->outlet_name; -->

<!-- action="<?php echo base_url() ?>posts/edit/<?php echo $slug ?>" -->
	<form  id="day-edit-post-details" class="file-upload clearfix">	
		<div class="row equal-cols">
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
						<div class="outlet-list clearfix">
							<label for="postOutlet" class="pull-sm-left">Outlet: </label>
							<?php 
								if(!empty($outlets)){
									echo '<ul class="pull-sm-left">';

									foreach($outlets as $outlet)
									{
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
										<li <?php echo $selected; ?> data-selected-outlet="<?php echo $outlet->id; ?>" data-outlet-const="<?php echo strtolower($outlet->outlet_name); ?>">
											<i class="fa fa-<?php echo $class; ?>">
												<span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span>
											</i>
										</li>
										<?php
									}
									echo '</ul>';
								}
							?>
							<input type="hidden" id="postOutlet">
						</div>
					</div>
					<div class="form-group">
						<label for="postCopy">Post Copy</label>
						<textarea class="form-control" id="postCopy" rows="5" placeholder="Type your copy here..."></textarea>
					</div>
					<div class="form-group">
						<label>Upload Photo(s) Or Video: <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></label>
						<div class="form__input has-files">
							<?php 
								if(!empty($post_images)){								
									foreach ($post_images as $key) {
										if (file_exists('uploads/'.$post_details->created_by.'/brands/'.$post_details->brand_id.'/posts/'.$key->name)) {
											echo '<img src="'.base_url().'uploads/'.$post_details->created_by.'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'" class="form__file-preview" />';
										}
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
					

					<div class="form-group pull-xl-right">
						<label>Tags:</label><br>
						<div class="hide-top-bx-shadow">
							<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'posts/tag_list/'.$post_details->brand_id; ?>" data-title="Select all that apply:" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-offset-x="0" data-offset-y="-2">
								<i class="fa fa-circle color-gray-lighter"></i> | <i class="fa fa-caret-down color-black"></i>
							</div>
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<label>Slate Post:</label><br>
						<div class="hide-top-bx-shadow">
							<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0">
						</div>
					</div>
					<div class="form-group pull-sm-left">
						<div class="pull-xs-left">
							<label class="invisible">Post Time</label>
							<div class="time-select form-control">
								<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH">
								<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM">
								<input type="text" class="time-input amselect" name="post-ampm" value="am">
							</div>
						</div>
						<span class="timezone pull-xs-right">
							<label class="invisible">Post Timezone</label>
							PST
						</span>
					</div>

					<div class="clearfix"></div>
					<footer class="post-content-footer">
						<div class="auto-save text-xs-center hidden">Auto Saving ...</div>
					</footer>
				</div>

				<?php //include("lib/add-post-details.php"); ?> 
			</div>
			
			<div class="col-md-4">
				<div class="container-phases">
				<h4 class="text-xs-center">Post Details</h4>
					<?php 
					//include("lib/view-approval-phases.php");
							if(!empty($phases)){ 
							?> 
								<div class="bg-gray-lightest border-gray-lighter border-all padding-22px">
									<div class="container-phases">
										<div class="">
											<?php
												foreach ($phases as $phase_no => $obj) {
													?>
													<div>
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
																<span class="uppercase">Must approve by:</span> <?php echo date('m/d/Y \a\t h:i A', strtotime($obj[0]->approve_by))?> PST
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
														<div class="bg-white approval-phase active animated fadeIn hide" id="edit_approvalPhase<?php echo $phase_no ?>" data-id="0">
															<h2 class="clearfix">Phase <?php echo $phase_no ?> </h2>
															<ul class="timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/get_brand_users/'.$post_details->brand_id; ?>" data-title="Add to Phase <?php echo $phase_no ?>" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top">
																<li><div class="pull-sm-left"><i class="tf-icon tf-icon-plus circle-border bg-black">+</i></div><div class="pull-sm-left post-approver-name">Add <br>Approvers</div></li>
															</ul>

															<div class="clearfix">
																<div class="form-group form-inline pull-sm-left phase-date-time-div">
																	<div class="hide-top-bx-shadow">
																		<input type="text" class="form-control form-control-sm popover-toggle single-date-select phase-date-time-input"  placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-hasqtip="0" name="phase[<?php echo $phase_no ?>][approve_date]">
																	</div>
																</div>
																<div class="form-group pull-sm-left">
																	<div class="pull-xs-left">
																		<div class="time-select form-control form-control-sm phase-time-input">
																			<input type="text" class="time-input hour-select" data-min="1" data-max="12" placeholder="HH" name="phase[<?php echo $phase_no ?>][approve_hour]">
																			<input type="text" class="time-input minute-select" data-min="0" data-max="59" placeholder="MM" name="phase[<?php echo $phase_no ?>][approve_minute]">
																			<input type="text" class="time-input amselect" value="am" name="phase[<?php echo $phase_no ?>][approve_ampm]">
																		</div>
																	</div>
																	<span class="timezone pull-xs-right form-control-sm phase-timezone">PST</span>
																</div>
															</div>
															<div class="form-group">
																<label for="approvalNotes">Note to Approvers (optional):</label>
																<textarea class="form-control approvalNotes" id="approvalNotes" rows="2" placeholder="Type your note here..." name="phase[<?php echo $phase_no ?>][note]"></textarea>
															</div>
															<div class="form-group">
																<button type="button" class="btn btn-sm btn-default cancel-phase">Cancel</button>
																<button type="button" class="btn btn-xs pull-sm-right btn-change-phase btn-disabled" data-new-phase="2" data-active-class="btn-default" disabled="disabled">Next Phase</button>
															</div>
														</div>
													</div>

												<?php
												}
											?>
										</div>
									</div>
								</div>
								<?php
								}
							?>
						<?php //include("lib/view-approval-phases.php"); ?>
					
					<footer class="post-content-footer day-edit-post">
						<button type="button" class="btn btn-sm btn-default">Save Changes</button>
						<button class="btn btn-sm btn-default pull-sm-right">Resubmit to Phases</button>
					</footer>

				</div>
			</div>
		</div>
	</form>


