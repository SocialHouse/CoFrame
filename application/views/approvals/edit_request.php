	<?php $this->load->view('partials/brand_nav'); ?>
	<section id="brand-manage" class="page-main bg-white col-sm-10">
		<header class="page-main-header">
			<a href="<?php echo base_url().'approvals/'.$brand->slug; ?>" class="btn btn-default btn-sm btn-arrow-left pull-left"><i class="fa fa-angle-left"></i>Back</a>
			<!-- invisible button hack to maintain centering of title-->
			<a href="<?php echo base_url().'approvals/'.$brand->slug; ?>" class="btn btn-default btn-sm btn-arrow pull-right invisible"><i class="fa fa-angle-left"></i>Back</a>
			<h1 class="center-title section-title">Edit Requests</h1>
		</header>

		<input type="hidden" name="brand_owner" id="brand-owner" value="<?php echo $this->user_data['account_id']; ?>" />
		
		<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
		<input type="hidden" name="post_id" id="post-id" value="<?php echo $post_id; ?>" />
		<input type="hidden" name="brand_id" id="brand-id" value="<?php echo $brand_id; ?>" />

			<div class="row equal-columns">
				<div class="col-md-4 equal-height">
					<div class="container-post-approval-preview post-content">
					<h4 class="text-xs-center">Post</h4>
					<div id="live-post-preview-approver">
						<?php
							if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($post_details->outlet_name).".php")){
							 	$this->load->view('calendar/post_preview/'.strtolower($post_details->outlet_name));
							}
						?>
						<div class="clearfix"></div>
						<div class="post-preview-footer">
							<div class="author clearfix">
								<?php
								if (file_exists(upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png')) {
				                	echo '<img src="'.upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png" class="circle-img pull-sm-left" width="36" height="36" />';
				                }else{
				                	echo '<img class="circle-img pull-sm-left" width="36" height="36" src="'.img_url().'default_profile_twitter.png">';	
				                }
								?>
								
								<div class="author-meta pull-sm-left">
									<h5>Created By:</h5>
									<?php echo $post_details->user; ?>
								</div>
								<div class="pull-sm-right">
									<div class="post-tags" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-postid-<?php echo $post_details->id; ?>" data-popover-class="popover-inline popover-sm" data-attachment="bottom center" data-target-attachment="top center" data-popover-arrow="true" data-arrow-corner="bottom center">
										<?php
										if(!empty($selected_tags))
										{
											foreach($selected_tags as $tag)
											{
												?>
												<i class="fa fa-circle" style="color:<?php echo $tag['tag_color']; ?>" ></i>
												<?php
											}
										}
										?>
										<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
										<div id="tags-postid-<?php echo $post_details->id; ?>" class="hidden">
											<div class="tag-list">
												<ul>
													<?php
													if(!empty($selected_tags))
													{
														foreach($selected_tags as $tag)
														{
															?>
															<li class="tag"><i class="fa fa-circle" style="color:<?php echo $tag['tag_color']; ?>"></i><?php echo $tag['tag_name']; ?></li>
															<?php
														}
													}
													?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					if($post_details->outlet_name == $this->user_id)
					{
						?>
						<footer class="post-content-footer post-actions text-xs-center">
							<a href="#" class="btn btn-default btn-sm" data-clear="yes" data-modal-src="<?php echo base_url()?>calendar/edit_post_calendar/edit-request/<?php echo $post_details->slug.'/'.$post_details->id; ?>" data-toggle="modal-ajax" data-modal-id="edit-post-id<?php echo $post_details->id; ?>" data-modal-size="lg">Edit</a>
							
						</footer>
						<?php
					}
					?>
				</div>
			</div>
				<div class="col-md-8 equal-height">
					<div class="container-post-discussion post-content">
						<h4 class="text-xs-center">Edit Requests</h4>
						<div class="bg-gray-lightest border-top padding-22px">
						<?php 
	                    	$i = 0;
	                    	$len = count($phase);
	                    	$ph_one_status ='';
	                    	$ph_two_status ='';
	                    	$ph_three_status ='';
	                    	$cls = 'inactive';
	                    	$is_shown = 'false';
	                    	$shown_anch = 'false';
							foreach ($phase as $ph_number => $phs) 
							{

								if($phs['phase_users'][0]->status == 'finished'){

								}else{
									if($is_shown !='true'){
										$cls = 'active';
										$is_shown = 'true';
									}else{
										$cls = 'inactive';
										$shown_anch = 'true';
									}
								}
							
							?>
									<div id="approvalPhase<?php echo $ph_number ; ?>" class="bg-white approval-phase animated fadeIn <?php echo $cls ?>">
										<h2 class="clearfix">
										<?php 
											if($cls =='active')
											{
												?>
													Phase <?php echo $ph_number ; ?>
													<i class="fa fa-angle-down"></i> 
													<button class="btn btn-xs btn-default color-success pull-sm-right">Current</button>
												<?php
											}
											else
											{
												if($shown_anch =='false')
												{
													?>
														Phase <?php echo $ph_number ; ?>
														<i class="fa fa-angle-right"></i>
														<button class="btn btn-xs btn-default btn-disabled pull-sm-right ">Finished</button>
													<?php
												}
												else
												{

													?>
														<a title="Edit Phase" class="toggleActive" href="#approvalPhase<?php echo $ph_number ; ?>">
														Phase <?php echo $ph_number ; ?>
															<i class="fa fa-angle-right"></i>
														</a>
													<?php

												}
											}
										?>
										</h2>

										<div class="row equal-columns">

										<!-- Comments Start-->
											<div class="col-md-8 equal-section">
												<?php
													$path = img_url()."default_profile.jpg";

													if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png'))
													{
														$path = upload_url().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png';
													}
									            ?>
									            <img class="circle-img pull-sm-left current-user" width="36" height="36" src="<?php echo $path; ?>">
									            <!-- Suggest an Edit Start-->
												<div class="suggest-edit">
													<div class="form-group">
														<label for="postCopy">Suggest an Edit:</label>
														<textarea class="form-control" id="comment_copy" rows="2" name="comment" placeholder="Suggest an edit here..."></textarea>
													</div>
													<div class="form-group clearfix">
														<div class="attachment pull-sm-left">
															<input type="file" name="attachment" class="hidden attachment_image">
															<button title="Add Attachment" class="btn-icon add-attachment">
															<i class="fa fa-paperclip"></i></button>
															<img id="attached_img" accept="images/*" class="hide" height="25" width="25" src="<?php echo img_url().'default_profile.jpg'; ?>">
														</div>
														<div class="pull-sm-right">
															<button type="button" class="btn btn-default btn-sm reset-edit-request">Clear</button>
														<?php 
														if(!empty($phs['phase_users'][0]->id)){
															$ph_id = $phs['phase_users'][0]->id;
														}else{
															$ph_id = 1;
														}
														?>
															<button type="button" class="btn btn-secondary btn-sm btn-disabled save-edit-req" data-phase-id="<?php echo $ph_id ;?>" disabled="disabled">Submit</button>
														</div>
													</div>
												</div>
												<!-- Suggest an Edit Start -->

												<!-- Display Comments End -->
												<ul class="timeframe-list comment-list clearfix">
													<?php
													if(!empty($phs['phase_comments']))
													{
														foreach($phs['phase_comments'] as $key => $comment)
														{
															$path = img_url()."default_profile.jpg";
													
															if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$comment->user_id.'.png'))
															{
																$path = upload_url().$this->user_data['img_folder'].'/users/'.$comment->user_id.'.png';
															}
															?>
															<li>
																<div class="author clearfix">
																	<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>" class="circle-img pull-sm-left">
																	<div class="author-meta pull-sm-left">
																		<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>
																		<span class="dateline">
																			<?php echo relative_date(strtotime($comment->created_at)); ?>
																		</span>
																	</div>
																</div>
																<?php
																$class = "";
																$replies = get_comment_reply($comment->id);
																if($replies)
																{
																	$class = " has-reply";
																}
																?>

																<div class="comment<?php echo $class; ?>">
																	<p><?php echo $comment->comment; ?></p>
																	<?php
																	if(!empty($comment->media))
																	{
																		?>
																		<div class="comment-asset">
																			<a target="_blank" href="<?php echo upload_url().$this->user_data['img_folder'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>" title="Download Asset">
																				<i class="tf-icon-download"></i>
																				<img src="<?php echo upload_url().$this->user_data['img_folder'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>" width="60" height="60" alt=""/>
																			</a>
																		</div>
																		<?php
																	}
																	?>
																	<?php 

																	if($comment->user_id != $this->user_id)
																	{
																		?>
																		<div class="comment-btns">
																			<a href="#" class="reply-link show-hide-replay" data-show="#commentReply_<?php echo $comment->id; ?>">Reply</a>
																		</div>
																		<?php 
																	}
																	?>

																	<?php
																	//echo '<pre>'; print_r($replays);echo '</pre>'; 
																	if($replies)
																	{
																		$data['replies'] = $replies;
																		$this->load->view('approvals/comment_edit_request' , $data);
																	}
																	?>
																</div>
															</li>
															<?php
														}
													}
													?>
												</ul>
												<!-- Display Comments End -->
											</div>
										<!-- Comments End-->

											<!-- Pending Approvals Start-->
											<div class="col-md-4 bg-gray-lightest equal-section container-view-approvals">
												<h5>Pending Approvals:</h5>
												<ul class="timeframe-list user-list approval-list  clearfix">
													<?php
														foreach ($phs['phase_users']as $key => $user) {				
															?>
															<li class="pull-sm-left <?php echo $user->status ?>">
																<?php
																	if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png')) {
													                	echo '<img src="'.upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png" class="circle-img pull-sm-left" width="36" height="36" />';
													                }else{
													                	echo '<img class="circle-img pull-sm-left" width="36" height="36" src="'.img_url().'default_profile.jpg">';	
													                }
																?>
															</li>
															<?php
														}
													?>
												</ul>
												<div class="approval-date">
													<h5>Must approve by:</h5>
													<?php echo date('m/d/Y \a\t h:i A' , strtotime($phs['phase_users'][0]->approve_by)); ?>
												</div>
												<div class="approval-note">
													<h5>Notes:</h5>
													<?php echo $phs['phase_users'][0]->note; ?>
												</div>
												<?php
												if($this->user_id == $this->user_data['account_id'] OR check_user_perm($this->user_id,'create',$brand_id))
												{
													?>
													<footer class="post-content-footer text-xs-center">
														<a href="#" class="btn btn-default btn-sm" data-modal-id="phase2-postid-1223" data-class="alert-modal edit-approvals-modal"  data-toggle="modal-ajax" data-modal-src="<?php echo base_url('approvals/edit-approval-phase').'/'.$phs['phase_users'][0]->id.'/'.$post_id ;?>" data-title="Edit Approvals - Phase <?php echo $ph_number; ?>">Edit Approvers</a>
													</footer>
													<?php
												}
												?>
											</div>
											<!-- Pending Approvals End -->

										</div>
										<footer class="post-content-footer text-xs-center">
												<?php
												$approver_status = '';
												$phase_status = '';
												foreach($phs['phase_users'] as $phase_data)
												{
													if($phase_data->aauth_user_id == $this->user_id)
													{
														$approver_status = $phase_data->status;
														$phase_status = $phase_data->phase_status;
													}
												}
												
												if(!empty($approver_status)){
													if($approver_status == 'approved')
													{
														?>
														<div class="before-approve">
															<span class="post-actions pull-sm-left">
																<a href="#" class="btn btn-secondary btn-md btn-disabled">Approved</a>
																<?php
																if($phase_status == 'pending' && $post_details->status == 'pending')
																{
																	?>
																	<br/>
																	<a href="#" class="change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" data-phase-status="pending">Undo</a>
																	<?php
																}
																?>
															</span>
														</div>
														
														<div class="after-approve hide">
															<a href="#" class="btn btn-default color-success btn-md change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" data-phase-status="approved">Approve</a>
														</div>

														<?php
													}
													elseif($approver_status == 'pending')
													{
														?>
														<div class="before-approve">
															<a href="#" class="btn btn-default color-success btn-md change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" data-phase-status="approved">Approve</a>
														</div>
														<div class="after-approve hide">
															<a href="#" class="btn btn-secondary btn-md btn-disabled">Approved</a>
															<br/>
															<a href="#" class="change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" data-phase-status="pending" >Undo</a>
														</div>
														<?php
													}
												}

												if($this->user_id == $this->user_data['account_id'] OR check_user_perm($this->user_id,'create',$brand_id))
												{	
													?>
													<a href="#" class="btn btn-secondary btn-md finish_phase" data-target="#finishPhase" data-toggle="modal" data-phase-number="<?php echo $ph_number ?>" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" >Finish Phase <?php echo $ph_number ?></a>
													<?php
												}
												?>
										</footer>
									</div>
									<?php
								// }
									$i++;
						}
						?>
						</div>
						<footer class="post-content-footer post-actions text-xs-right">
							<?php 
							if($this->user_id == $this->user_data['account_id'] OR check_user_perm($this->user_id,'create',$brand_id))
							{
								if($post_details->status != 'posted')
								{
									?>
									<a href="#"  data-target="#postNow" data-toggle="modal" data-post-id="<?php echo $post_id; ?>" class="btn btn-secondary btn-sm">Post Now</a>
									<?php
								}
								if($post_details->status == 'scheduled' )
								{
									?>
									<div class="before-approve">
					               		<button class="btn btn-default color-success btn-disabled btn-sm" disabled>Scheduled</button><br>
					                    <a class="change-approve-status"  data-post-id="<?php echo $post_id; ?>"  data-phase-status="unschedule" href="#">Undo</a>
					                </div>
					                <div class="after-approve hide">
					                    <a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-status="scheduled">Schedule</a>
					                </div>
									<?php
								}
								else
								{
									?>
									<div class="before-approve hide">
					               		<button class="btn btn-default color-success btn-disabled btn-sm" disabled>Scheduled</button><br>
					                    <a class="change-approve-status"  data-post-id="<?php echo $post_id; ?>" data-phase-status="unschedule" href="#">Undo</a>
					                </div>
					                <div class="after-approve">
					                    <a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-status="scheduled">Schedule</a>
					                </div>
									<?php
								}
							}
							?>
						</footer>
					</div>
				</div>
			</div>
	</section>

<div id="commentReplyStatic">
	<ul class="commentReply emptyCommentReply timeframe-list hide">
		<li>
			<div class="author clearfix">
				<?php
					$path = img_url()."default_profile.jpg";

					if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png'))
					{
						$path = upload_url().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png';
					}
	            ?>
	            <img class="circle-img pull-sm-left current-user" width="36" height="36" src="<?php echo $path; ?>">
				
				<div class="author-meta pull-sm-left">
					<?php echo $this->user_data["first_name"] .' '.$this->user_data["last_name"]; ?>
					<span class="dateline">Reply to request</span>
				</div>
			</div>
			<div class="suggest-edit">
				<div class="form-group">
					<textarea class="form-control" rows="2" name="comment" id="replay_comment_copy" placeholder="Suggest an edit here..."></textarea>
				</div>
				<div class="form-group clearfix">
					<div class="attachment pull-sm-left">
						<input type="file" name="replay-attachment" class="hidden attachment_image">
						<button title="Add Attachment" class="btn-icon add-attachment">
						<i class="fa fa-paperclip"></i></button>
						<img  accept="images/*" class="hide" height="25" width="25" src="<?php echo img_url().'default_profile.jpg'; ?>">
					</div>
					<div class="pull-sm-right">
						<button type="button" class="btn btn-default btn-sm reset-edit-request">Clear</button>
						<button type="button" class="btn btn-secondary btn-sm btn-disabled reply-comment-submit" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" disabled="disabled">Submit</button>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>
	