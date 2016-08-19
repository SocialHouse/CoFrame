<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<a href="<?php echo base_url().'approvals/'.$brand->slug; ?>" class="btn btn-default btn-sm btn-arrow-left pull-left"><i class="fa fa-angle-left"></i>Back</a>
		<!-- invisible button hack to maintain centering of title-->
		<a href="<?php echo base_url().'approvals/'.$brand->slug; ?>" class="btn btn-default btn-sm btn-arrow pull-right invisible"><i class="fa fa-angle-left"></i>Back</a>
		<h1 class="center-title section-title">Post Approval</h1>
	</header>

	<input type="hidden" name="brand_owner" id="brand-owner" value="<?php echo $this->user_data['account_id']; ?>" />	
	<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
	<input type="hidden" name="post_id" id="post-id" value="<?php echo $post_id; ?>" />
	<input type="hidden" name="brand_id" id="brand-id" value="<?php echo $brand_id; ?>" />
	<input type="hidden" name="post_outlet" id="postOutlet" value="<?php echo $post_details->outlet_id; ?>" />
	

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
			                	echo '<img src="'.upload_url().$this->user_data['img_folder'].'/users/'.$post_details->user_id.'.png" class="ccircle-img pull-sm-left" width="36" height="36" />';
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
				<footer class="post-approval-btns post-actions clearfix">
					<?php
					if($post_details->user_id == $this->user_id)
					{
						?>
						<div class="btn-group pull-md-right" role="group">
							<a href="#" class="btn btn-xs btn-default" data-clear="yes" data-toggle="modal-ajax" data-modal-id="edit-post-modal" data-modal-size="lg" data-modal-src="<?php echo base_url()?>calendar/edit_post_calendar/view_request/<?php echo $post_details->slug.'/'.$post_details->id.''; ?>" >Edit</a>
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
								<button class="btn btn-xs btn-default color-success schedule-post" id="<?php echo $post_details->id; ?>">Schedule</button>
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
					?>
				</footer>
			</div>
		</div>
		
		<div class="col-md-4 equal-height">
			<div class="bg-gray-lightest border-gray-lighter border-all padding-22px container-view-approvals">
				<h4 class="text-xs-center">Approval Info</h4>
				<?php
				$i = 1;
				foreach($phases as $phase)
				{
					$active_class = '';
					if($i == 1)
					{
						$active_class = 'active';
					}
					?>			
					<div class="bg-white approval-phase animated fadeIn <?php echo $active_class; ?>" id="approvalPhase<?php echo $i; ?>">
						<h2 class="clearfix">Phase <?php echo $phase->phase; ?>
							<?php
							if($phase->phase_status != 'pending')
							{
								?>							
								<button id="<?php echo $phase->id; ?>" class="btn btn-xs btn-secondary color-success pull-sm-right resubmit-approval">Resubmit for Approval</button>
								<?php
							}
							?>
						</h2>
						<ul class="timeframe-list user-list approval-list border-bottom clearfix">
							<?php
							$phase_users = get_phase_users($phase->id);
							if(!empty($phase_users))
							{
								foreach($phase_users as $user)
								{
									$path = img_url()."default_profile.jpg";
								
									if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png'))
									{
										$path = upload_url().$this->user_data['img_folder'].'/users/'.$user->aauth_user_id.'.png';
									}
									?>
									<li class="pull-sm-left <?php echo $user->status; ?>"><img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?>" class="circle-img"/></li>
									<?php
								}
							}
							?>
						</ul>
						<div class="approval-date">
							<span class="uppercase">Must approve by:</span> <?php echo date('m/d/Y' , strtotime($phase->approve_by)); ?> PST
						</div>
						<?php
						if(!empty($phase->note))
						{
							?>
							<div class="approval-note">
								<?php echo !empty($phase->note) ? "NOTE: ".$phase->note : ''; ?>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					$i++;
					}
				?>
			</div>
		</div>

		<div class="col-md-4 equal-height">
			<div class="container-post-discussion post-content">
				<div class="padding-22px">
					<h4 class="text-xs-center">Edit Requests</h4>					
					<?php
					$i = 1;
					foreach($phases as $phase)
					{
						$hide_class = 'hide';
						if($i == 1)
						{
							$hide_class = '';
						}
						?>
						<ul class="timeframe-list comment-list clearfix <?php echo $hide_class; ?> approvalPhase<?php echo $i; ?>">
							<?php
							$comments = get_phase_comments($phase->id);
							if(!empty($comments))
							{
								foreach($comments as $comment)
								{
									$path = img_url()."default_profile.jpg";
							
									if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$comment->user_id.'.png'))
									{
										$path = upload_url().$this->user_data['img_folder'].'/users/'.$comment->user_id.'.png';
									}
									?>
									<li>
										<div class="author clearfix">
											<img class="circle-img pull-sm-left" width="36" height="36" src="<?php echo $path; ?>"  alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>" >
											<div class="author-meta pull-sm-left">
												<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>
												<span class="dateline"><?php echo date('m/d/Y' , strtotime($comment->created_at));; ?></span>
											</div>
										</div>

										<?php
										$class = "";
										$replay = get_comment_reply($comment->id);
										if($replay)
										{
											$class = "has-reply";
										}
										?>

										<div class="comment <?php echo $class; ?>">
											<p><?php echo $comment->comment; ?></p>
											<p class="comment-status"><?php echo $comment->status ? 'Staus: '.$comment->status : 'Staus: '.'Pending'; ?></p>

											<?php										
											if(!empty($comment->media))
											{
												?>
												<div class="comment-asset">
													<a target="_blank" href="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>" title="Download Asset">
														<i class="tf-icon-download"></i>
														<img  width="60" height="60" alt="" class="base-64-img hide"src="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>"/>
													</a>
												</div>												
												<?php
											}


											$disabled = '';
											if($comment->status == 'accepted' or $comment->status == 'rejected')
											{
												$disabled = 'disabled="disabled"';
											}
											if($replay)
											{
												$data['replies'] = $replay;
												$data['phase_id'] = $phase->id;
												$this->load->view('approvals/comment_view_request' , $data);
											}
											else
											{
												?>
												<div class="comment-btns">
													<button <?php echo $disabled; ?> class="btn btn-default btn-xs change-status" type="button" data-status="accepted" data-id="<?php echo $comment->id; ?>">Accept</button>
													<button <?php echo $disabled; ?> class="btn btn-default btn-xs change-status" type="button" data-status="rejected" data-id="<?php echo $comment->id; ?>">Reject</button>
													<a data-show="#commentReply<?php echo $comment->id; ?>" class="reply-link show-hide" href="#">Reply</a>
												</div>
												<ul id="commentReply<?php echo $comment->id; ?>" class="commentReply timeframe-list hidden replay">
													<li class="comment-section">
														<?php
														$path = img_url()."default_profile.jpg";						
														if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png'))
														{
															$path = upload_url().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png';
														}
														?>
														<div class="author clearfix">
															<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']); ?>" class="circle-img pull-sm-left">
															<div class="author-meta pull-sm-left">
																<?php
																echo ucfirst($this->user_data['first_name']).' '.ucfirst($this->user_data['last_name']);
																?>
																<span class="dateline">Reply to request</span>
															</div>
														</div>
														<div class="form-group">
															<input type="hidden" name="phase_id<?php echo $comment->id; ?>" value="<?php echo $phase->id; ?>" />
															<textarea class="form-control reply-comment" name="comment<?php echo $comment->id; ?>" rows="2" placeholder="Suggest an edit here..."></textarea>
														</div>
														<div class="form-group clearfix">
															<div class="attachment pull-sm-left">
																<input type="file" name="attachment<?php echo $comment->id; ?>" class="hidden reply-attach">
																<button title="Add Attachment" class="btn-icon add-attachment"><i class="fa fa-paperclip"></i></button>

																<img src="" class="base-64-img hide" height="25" width="25">
															</div>
															<div class="pull-sm-right">
																<button type="button" data-comment-id="<?php echo $comment->id; ?>" class="btn btn-default btn-sm reset-comment">Clear</button>
																<button type="button" data-comment-id="<?php echo $comment->id; ?>" class="btn btn-disabled btn-sm save-reply" disabled="disabled">Submit</button>
															</div>
														</div>
													</li>
												</ul>
											<?php
											}
											?>
										</div>
									</li>
									<?php
								}

							}
							else
							{
								?>
								<li>
								Currently there are no edit request
								</li>
								<?php
							}
							?>							
						</ul>
						<?php
						$i++;
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>