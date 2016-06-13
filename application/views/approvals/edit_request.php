<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">Post Approval</h1>
	</header>

	<input type="hidden" name="brand_owner" id="brand-owner" value="<?php echo $brand->created_by; ?>" />
	<input type="hidden" name="phase_id" id="phase-id" value="<?php echo $phase['phase_users'][0]->id; ?>" />
	<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
	<input type="hidden" name="post_id" id="post-id" value="<?php echo $post_id; ?>" />
	<input type="hidden" name="brand_id" id="brand-id" value="<?php echo $brand_id; ?>" />

	<div class="row equal-cols">
		<div class="col-md-4">
			<div class="container-post-approval-preview post-content">
				<h4 class="text-xs-center">Post</h4>
				<div id="live-post-preview">
					<img src="assets/images/post-preview.png" width="406" height="506" alt="" class="center-block"/>
					<div class="post-preview-footer">
						<div class="author clearfix">
							<img src="assets/images/fpo/david.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img pull-sm-left">
							<div class="author-meta pull-sm-left">
								<h5>Created By:</h5>
								David W
							</div>
							<div class="pull-sm-right">
								<div class="post-tags" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-postid-1223" data-popover-class="popover-inline popover-sm" data-attachment="bottom center" data-target-attachment="top center" data-popover-arrow="true" data-arrow-corner="bottom center">
									<i class="fa fa-circle tag-green"></i><i class="fa fa-circle tag-orange"></i><i class="fa fa-circle tag-red"></i>
									<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
									<div id="tags-postid-1223" class="hidden">
										<div class="tag-list">
											<ul>
												<li class="tag"><i class="fa fa-circle tag-red"></i>Brand Building / Product Education</li>
												<li class="tag"><i class="fa fa-circle tag-orange"></i>Orange Tag</li>
												<li class="tag"><i class="fa fa-circle tag-green"></i>Marketing</li>
											</ul>
										</div>
									</div>								
								</div>
							</div>
						</div>
					</div>
				</div>
				<footer class="post-approval-btns post-actions clearfix">
					<!-- Approver Buttons-->
					<a href="#" class="btn btn-secondary btn-xs btn-disabled">Approved</a>
					<a href="#undoApproval" data-toggle="modal" data-target="#undoApproval">Undo</a>
					<!-- Creator Buttons-->
					<div class="btn-group btn-thirds" role="group">
					  <button type="button" class="btn btn-xs btn-default">Edit</button>
					  <button type="button" class="btn btn-xs btn-default">Schedule</button>
					  <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#postNow">Post Now</button>
					</div>
					<!-- Master Admin Buttons-->
					<a href="#" class="btn btn-secondary btn-xs pull-sm-left">Approve</a>
					<div class="btn-group pull-sm-right" role="group">
					  <button type="button" class="btn btn-xs btn-default">Edit</button>
					  <button type="button" class="btn btn-xs btn-default">Schedule</button>
					  <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#postNow">Post Now</button>
					</div>
				</footer>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="bg-gray-lightest border-gray-lighter border-all padding-22px container-view-approvals">
				<h4 class="text-xs-center">Approval Info</h4>
				<div class="bg-white approval-phase animated fadeIn active" id="approvalPhase1">
					<h2 class="clearfix">Phase <?php echo $phase['phase_users'][0]->phase; ?> </button>
					</h2>
					<ul class="timeframe-list user-list approval-list border-bottom clearfix">
						<?php
						foreach($phase['phase_users'] as $user)
						{
							$path = img_url()."default_profile.jpg";
						
							if (file_exists(upload_path().$brand->created_by.'/users/'.$user->aauth_user_id.'.png'))
							{
								$path = upload_url().$brand->created_by.'/users/'.$user->aauth_user_id.'.png';
							}
							?>
							<li class="pull-sm-left <?php echo $user->status; ?>"><img src="<?php echo $path; ?>" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></li>
							<?php
						}
						?>							
					</ul>
					<div class="approval-date">
						<span class="uppercase">Must approve by:</span> <?php echo date('m/d/Y' , strtotime($phase['phase_users'][0]->approve_by)); ?> PST
					</div>
					<?php
					if(!empty($phase['phase_users'][0]->note))
					{
						?>
						<div class="approval-note">
							<?php echo !empty($phase['phase_users'][0]->note) ? "NOTE: ".$phase['phase_users'][0]->note : ''; ?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="container-post-discussion post-content">
				<div class="padding-22px">
					<h4 class="text-xs-center">Edit Requests</h4>
					<div class="form-group">
						<label for="postCopy">Suggest an Edit:</label>
						<textarea class="form-control" id="postCopy" rows="2" name="comment" placeholder="Suggest an edit here..."></textarea>
					</div>
					<div class="form-group clearfix">
						<div class="attachment pull-sm-left">
							<input type="file" name="attachment" class="hidden" id="attachment">
							<button title="Add Attachment" class="btn-icon add-attachment"><i class="fa fa-paperclip"></i></button>			
						</div>
						<div class="pull-sm-right">
							<button type="reset" class="btn btn-default btn-sm">Clear</button>
							<button type="button" class="btn btn-default btn-sm save-edit-req">Submit</button>
						</div>
					</div>
					<ul class="timeframe-list comment-list clearfix">
						<?php
						if(!empty($phase['phase_comments']))
						{
							foreach($phase['phase_comments'] as $comment)
							{
								$path = img_url()."default_profile.jpg";
						
								if (file_exists(upload_path().$brand->created_by.'/users/'.$comment->user_id.'.png'))
								{
									$path = upload_url().$brand->created_by.'/users/'.$comment->user_id.'.png';
								}
								?>
								<li>
									<div class="author clearfix">
										<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo ucfirst($comment->first_name).' '.$comment->last_name; ?>" class="circle-img pull-sm-left">
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
										<p><?php echo $comment->status ? 'Staus: '.$comment->status : 'Staus: '.'Pending'; ?></p>

										<?php										
										if(!empty($comment->media))
										{
											?>
											<div class="comment-asset">
												<a target="_blank" href="<?php echo upload_url().$brand->created_by.'/brands/'.$brand->id.'/requests/'.$comment->media ?>" title="Download Asset">
													<i class="tf-icon-download"></i>
													<img src="<?php echo upload_url().$brand->created_by.'/brands/'.$brand->id.'/requests/'.$comment->media ?>" width="60" height="60" alt=""/>
												</a>
											</div>
											<?php
										}

										if($replay)
										{
											?>
											<ul class="commentReply timeframe-list replay">
												<li>
													<div class="author clearfix">
														<?php
														$path = img_url()."default_profile.jpg";						
														if (file_exists(upload_path().$brand->created_by.'/users/'.$replay->user_id.'.png'))
														{
															$path = upload_url().$brand->created_by.'/users/'.$replay->user_id.'.png';
														}
														?>
														<img src="<?php echo $path; ?>" width="36" height="36" alt="Norel Mancuso" class="circle-img pull-sm-left">

														<div class="author-meta pull-sm-left">
															<?php echo ucfirst($replay->first_name).' '.$replay->last_name; ?>	
															<span class="dateline"><?php echo date('m/d/Y' , strtotime($replay->created_at));; ?></span>
														</div>
													</div>	
													<div class="comment">
														<p><?php echo $replay->comment; ?></p>
													</div>
													<?php
													if(!empty($replay->media))
													{
														?>
														<div class="comment-asset">
															<a href="<?php echo upload_url().$brand->created_by.'/'.$brands.'/'.$post_id.'/requests/'.$comment->media ?>" title="Download Asset">
																<i class="tf-icon-download"></i>
																<img src="<?php echo base_url().$brand->created_by.'/'.$brands.'/'.$post_id.'/requests/'.$comment->media ?>" width="60" height="60" alt=""/>
															</a>
														</div>
														<?php
													}
													?>
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
						?>							
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>