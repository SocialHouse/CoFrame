<form  id="edit-post-details" class="file-upload clearfix" action="<?php echo base_url() ?>calendar/edit_post " method="post" upload="<?php echo base_url()."posts/upload"; ?>" autocomplete="off">

	<input type="hidden" name="is_new_approver" value="no" id="is-new-approver">
	<input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>" id="redirect_url">
	<input type="hidden" name="resubmit" id="resubmit" value="">
	<div  id="edit-post-manage" class="row equal-columns create">
		<div class="col-md-4 equal-height">
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
		
		<div class="col-md-4 equal-height">
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
					<input type="hidden" name="delete_img" id="delete_img" />
					<div class="form__input has-files">
						<?php 
							if(!empty($post_images)){
								$class = 1;
								foreach ($post_images as $key) {
									if($key->type =='images'){
										echo '<div class="form__preview-wrapper"><i data-delete-id="'.$key->id.'" class="tf-icon-circle remove-upload">x</i><img src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'" class="form__file-preview delete-img" data-delete="'.$class.'" /></div>';
										$class++;
									}else if($key->type =='video'){
										echo '<video class="form__file-preview"src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$post_details->brand_id.'/posts/'. $key->name.'"></video>';
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
				<div class="clearfix">
					<div class="pull-sm-left">
						<label>Slate Post:</label>
						<div class="slate-post clearfix">
							<div class="form-group form-inline pull-sm-left">
								<div class="hide-top-bx-shadow">
									<input type="text" class="form-control popover-toggle single-date-select" name="post-date" placeholder="DD/MM/YYYY" data-toggle="popover-calendar" data-popover-id="calendar-select-date" data-popover-class="popover-clickable popover-sm future-dates-only" data-attachment="bottom left" data-target-attachment="top left" data-popover-width="300" data-popover-container="#edit-post-details" value="<?php echo !empty($post_details->slate_date_time) ? date('m/d/Y' , strtotime($post_details->slate_date_time)) : ''; ?>" >
								</div>
							</div>
							<div class="form-group pull-sm-left">
								<div class="pull-xs-left">
									<label class="hidden">Post Time</label>
									<div class="time-select form-control">
										<input type="text" class="time-input hour-select" name="post-hour" data-min="1" data-max="12" placeholder="HH" value="<?php echo date('h' , strtotime($post_details->slate_date_time)); ?>">
										<input type="text" class="time-input minute-select" name="post-minute" data-min="0" data-max="59" placeholder="MM" value="<?php echo date('i' , strtotime($post_details->slate_date_time)); ?>">
										<input type="text" class="time-input amselect" name="post-ampm"  value="<?php echo date('A' , strtotime($post_details->slate_date_time)); ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="slate-post-errors">
							<div id="date_error" class="error"></div>
							<div id="hm_error" class="error"></div>
						</div>
						<div class="form-group slate-post-tz">
							<select class="form-control" name="time_zone">
								<?php 
									foreach ($timezones as $key => $obj) {
										$selected_tz = '';
										if(!empty($post_details->time_zone))
										{
											if( $obj->value == $post_details->time_zone ){
												$selected_tz = 'selected="selected"';
											}
										}
										else
										{
											if( $obj->value == $brand->timezone)
											{
												$selected_tz = 'selected = "selected"';
											}
										}
										?>
										<option <?php echo $selected_tz ;?> data-abbreviation="<?php echo $obj->abbreviation; ?>" value="<?php echo $obj->value; ?>"><?php echo $obj->timezone; ?></option>
										<?php
									}
								?>
							</select>
						</div>
					</div>
					<?php
					if(!empty($tags))
					{
					?>
						<div class="form-group form-inline pull-xl-right">
							<label>Tags:</label><br>
							<div class="hide-top-bx-shadow">
								<div class="form-control tag-select popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/selected_tag_list/'.$post_details->brand_id.'/'.$post_details->id; ?>" data-title="Select all that apply:" data-popover-class="popover-tags popover-clickable" data-popover-id="popover-tag-list" data-attachment="bottom right" data-target-attachment="top right" data-popover-container="#edit-post-details">
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
					<?php
					}
					?>
				</div>
				<footer class="post-content-footer">
					<div class="auto-save text-xs-center hidden">Auto Saving ...</div>
				</footer>
			</div>			
		</div>
		
		<?php 
		if($this->plan_data['phase_approvals'] == 1)
		{
			if(empty($phases))
			{
				$data['is_edit'] = 'true';
				$data['brand'] = $brand;
				$this->load->view('partials/default_phase' ,$data);
			} 
			else
			{ 
				?>
				<div class="col-md-4 equal-height">
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
													<button type="button" title="Delete Phase" class="pull-sm-right btn-icon btn-icon-lg delete-phase"><i class="fa fa-trash-o"></i></button></h2>
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
													<span class="uppercase">Must approve by:</span> <span class="date-preview<?php echo $phase_no + 1 ; ?>"><?php echo date('m/d/y',strtotime($obj[0]->approve_by)); ?></span> <span class="time-preview"><?php  echo ' '.date('\a\t h:i A',strtotime($obj[0]->approve_by)); ?></span>
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
		}
		else
		{
			?>
			<div class="col-md-4 equal-height">
				<div class="container-phases">
					<footer class="post-content-footer day-edit-post">
						<button type="submit" class="btn btn-sm submit-btn btn-default">Save Changes</button>
					</footer>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</form>
<?php
$this->load->view('partials/previews');
?>
