<input type="hidden" name="brand_owner" id="brand-owner" value="<?php echo $this->user_data['account_id']; ?>" />
<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
<input type="hidden" name="post_id" id="post-id" value="<?php echo $post_id; ?>" />
<input type="hidden" name="brand_id" id="brand-id" value="<?php echo $brand_id; ?>" />

<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Post Preview / Edit Requests</h1>
	</header>
	<div class="bg-white col-sm-12 content-shadow brand-main">
		<div class="content-shadow brand-header row">
			<div class="col-sm-12">
				<?php
				$image_path = img_url().'default_brand.png';				
				if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';					
				}									
				?>
				<img src="<?php echo $image_path; ?>" class="circle-img pull-xs-left" height="75" width="75"> <?php echo $brand->name; ?>
			</div>
		</div>
		<div class="post-meta pos-relative border-bottom border-black row">
			<div class="col-sm-12">
				<div class="outlet-list pull-xs-left">
					<i class="fa fa-twitter" title="twitter"><span class="bg-outlet bg-twitter"></span></i>
				</div>
				<div class="post-meta-content">
					<span class="post-author"><?php echo $post_details->outlet_name; ?> Post By <?php echo get_users_full_name($post_details->user_id); ?>:</span>
					<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A',strtotime($post_details->slate_date_time)); ?> PST</span>
				</div>
			</div>
		</div>
	
		<div id="live-post-preview-approver">
			<?php
			if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($post_details->outlet_name).".php")){
				$this->load->view('calendar/post_preview/'.strtolower($post_details->outlet_name));
			}
			?>
			<div class="post-footer clearfix">
				<span class="pull-xs-left post-actions">					
					<?php 
					if($this->user_id == $this->user_data['account_id'] OR check_user_perm($this->user_id,'create',$brand_id) OR (isset($this->user_data['user_group']) && ($this->user_data['user_group'] == "Master Admin" OR $this->user_data['user_group'] == "Manager")))
					{
						if($post_details->status == 'scheduled' )
						{
							?>
							<div class="before-approve post-actions">
								<button class="btn btn-default color-success btn-disabled btn-sm" disabled>Scheduled</button><br>
								<a class="change-approve-status"  data-post-id="<?php echo $post_id; ?>"  data-phase-status="unschedule" href="#">Undo</a>
							</div>
							<div class="after-approve hidden">
								<a class="btn btn-sm btn-default color-success change-approve-status" data-post-id="<?php echo $post_id ?>" data-phase-status="scheduled">Schedule</a>
							</div>
							<?php
						}
						else
						{
							?>
							<div class="before-approve hidden post-actions">
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
				</span>
				<button class="btn-icon btn-icon-lg btn-menu pull-xs-right" data-toggle="modal-ajax" data-hide="false" data-modal-src="<?php echo base_url().'calendar/get_view/edit_menu/'.get_brand_slug($post_details->brand_id).'/'.$post_details->id; ?>" data-modal-id="modal-post-menu">
					<i class="fa fa-circle-o"></i> 
					<i class="fa fa-circle-o"></i> 
					<i class="fa fa-circle-o"></i>
				</button>
			</div>
		</div>
		<div class="container-post-discussion">
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
					<div class="comment-section">
						<div class="form-group">
							<label for="postCopy">Suggest an Edit:</label>
							<textarea class="form-control" id="comment_copy" rows="2" name="comment" placeholder="Suggest an edit here..."></textarea>
						</div>
						<div class="form-group clearfix">
							<div class="attachment pull-sm-left">
								<input type="file" name="attachment" class="hidden attachment_image">
								<button title="Add Attachment" class="btn-icon add-attachment pull-sm-left">
									<i class="fa fa-paperclip"></i></button>
									<img id="attached_img"  class="base-64-img" class="hide" height="30" width="30">
									<a href="#" class="remove-attached-img hide">
										<i class="tf-icon-circle remove-upload">x</i>
									</a>
							</div>
							<div class="pull-sm-right">
								<button type="button" class="btn btn-default btn-sm reset-edit-request">Clear</button>
								<?php 
								if(!empty($phase[1]['phase_users'][0]->id)){
									$ph_id = $phase[1]['phase_users'][0]->id;
								}else{
									$ph_id = 1;
								}
								?>
								<button type="button" class="btn btn-secondary btn-sm btn-disabled save-edit-req" data-phase-id="<?php echo $ph_id ;?>" disabled="disabled">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Suggest an Edit Start -->

				<!-- Display Comments End -->
				<ul class="timeframe-list comment-list clearfix">
					<?php
					if(!empty($phase))
					{
						foreach ($phase as $key => $phs)
						{
							if(!empty($phs['phase_comments']))
							{
								// echo "<pre>";
								// print_r($phs);
								// echo "</pre>";
								foreach($phs['phase_comments'] as $key => $comment)
								{
									$path = img_url()."default_profile.jpg";

									if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$comment->user_id.'.png'))
									{
										$path = upload_url().$this->user_data['img_folder'].'/users/'.$comment->user_id.'.png';
									}
									?>
									<li class="comment-section">
										<div class="author clearfix">
											<img class="circle-img pull-sm-left" src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>" >
											<div class="author-meta pull-sm-left">
												<?php 
												echo ucfirst($comment->first_name).' '.$comment->last_name;
												?>
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
											<div class="comment_view<?php echo $comment->id; ?>">
												<p class="text"><?php echo $comment->comment; ?></p>
												<?php
												$media = 0;
												if(!empty($comment->media))
												{
													$media = 1;
													?>
													<div class="comment-asset">
														<a target="_blank" download="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>" href="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>" title="Download Asset">
															<i class="tf-icon-download"></i>
															<img width="60" height="60" alt="" src="<?php echo upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/requests/'.$comment->media ?>" />
														</a>
													</div>
													<?php
												}
												?>
											</div>
											<div class="hide edit_suggest_form<?php echo $comment->id; ?> suggest-edit" data-state="hide">
												<div class="form-group">
													<input type="hidden" id="suggestId<?php echo $comment->id; ?>">
													<textarea id="comment_copy" class="form-control suggestTect<?php echo $comment->id; ?>"><?php echo $comment->comment; ?></textarea>
												</div>
												<div class="form-group clearfix">
													<div class="attachment pull-sm-left">
														<input type="file" class="hidden attachment_image" name="replay-attachment">
														<button class="btn-icon add-attachment" title="Add Attachment">
															<i class="fa fa-paperclip"></i>
														</button>
														<?php
														$media_class = 'hide';
														if($media == 1)
														{
															$media_class = '';
														}
														?>
														<img width="30" height="30" class="base-64-img <?php echo $media_class; ?>">
														<a class="remove-attached-img <?php echo $media_class; ?>" href="#">
															<i class="tf-icon-circle remove-upload">x</i>
														</a>
													</div>
													<div class="pull-sm-right">			
														<button data-id="<?php echo $comment->id; ?>" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" class="btn btn-secondary btn-sm save-edit-req" type="button" data-parent-id="43">Submit</button>
													</div>
												</div>
											</div>															
											<div class="comment-btns">
												<a href="#" class="reply-link show-hide-reply" data-show="#commentReply_<?php echo $comment->id; ?>">Reply</a>
											</div>
											<?php
											if($replies)
											{
												$data['replies'] = $replies;
												$data['is_mobile'] = 1;
												$this->load->view('approvals/comment_edit_request' , $data);
											}
											?>
										</div>
									</li>
									<?php
								}
							}
						}
					}
					?>
				</ul>
			<!-- Display Comments End -->
		</div>
	</div>
</section>


<div id="commentReplyStatic">
	<ul class="commentReply emptyCommentReply hidden">
		<li class="comment-section">
			<div class="author clearfix">
				<?php
				$path = img_url()."default_profile.jpg";

				if (file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png'))
				{
					$path = upload_url().$this->user_data['img_folder'].'/users/'.$this->user_id.'.png';
				}
				?>
				<img class="circle-img pull-xs-left" width="36" height="36" src="<?php echo $path; ?>">

				<div class="author-meta pull-xs-left">
					<?php echo $this->user_data["first_name"] .' '.$this->user_data["last_name"]; ?>
					<span class="dateline">Reply to request</span>
				</div>
			</div>
			<div class="form-group">
				<textarea class="form-control" rows="2" name="comment" id="reply_comment_copy" placeholder="Suggest an edit here..."></textarea>
			</div>
			<div class="form-group clearfix">
				<div class="attachment pull-xs-left">
					<input type="file" name="replay-attachment" class="hidden attachment_image">
					<button title="Add Attachment" class="btn-icon add-attachment">
						<i class="fa fa-paperclip"></i></button>
						<img class="base-64-img hide" height="30" width="30" >
						<a href="#" class="remove-attached-img hide">
							<i class="tf-icon-circle remove-upload">x</i>
						</a>
				</div>
				<div class="pull-sm-right">
					<button type="button" class="btn btn-default btn-sm reset-edit-request">Clear</button>
					<button type="button" class="btn btn-secondary btn-sm btn-disabled reply-comment-submit" data-phase-id="<?php echo $phs['phase_users'][0]->id; ?>" disabled="disabled">Submit</button>
				</div>
			</div>
		</li>
	</ul>
</div>

<!-- Blank Modal -->
<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  </div>
	</div>
  </div>
</div>