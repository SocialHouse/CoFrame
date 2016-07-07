<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">Co-Create</h1>
	</header>
	<form action="<?php echo base_url().'posts/save_post' ?>" method="POST" id="post-details" class="file-upload clearfix" upload="<?php echo base_url()."posts/upload"; ?>">
		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $brand->created_by; ?>">
		<input type="hidden" name="save_as" id="save_as" value="">
		<input type="hidden" name="slug" id="slug" value="<?php echo $brand->slug; ?>">
		<input type="hidden" name="request_string" id="request-string" value="<?php echo !empty($request_string) ? $request_string : ''; ?>">

		<input type="hidden" name="uploaded_files[]" id="uploaded_files">
		<input type="hidden" id="all_files">
		<div class="row equal-columns create">
		<?php
		if(empty($request))
		{
			?>
			<div class="col-md-6 " style="height:900px;">
				<div class="container-approvals">
					<div class="dafault-phase">
						<div>
							<h4 class="text-xs-center">Collaborate</h4>
							<?php 
							if(!empty($users))
							{
								?>
								<ul class="timeframe-list user-list first-phase">
									<?php
									foreach ($users as $user)
									{
										?>
										<li>
											<div class="pull-sm-left">
												<input type="checkbox" data-clear-phase="first" class="hidden-xs-up" name="join_req[]" value="<?php echo $user->email; ?>"><i class="tf-icon check-box circle-border" data-value="<?php echo $user->email; ?>" data-group="join_req[]"><i class="fa fa-check"></i></i>
											</div>
											<div class="pull-sm-left">
												<?php
												$path = img_url()."default_profile.jpg";
												if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png'))
												{
													$path = upload_url().$brand->created_by.'/brands/'.$brand_id.'/posts'.$user->aauth_user_id.'.png';
												}
												?>
												<img src="<?php echo $path; ?>" width="36" height="36" alt="<?php echo $user->first_name; ?>" class="circle-img"/>
											</div>
											<div class="pull-sm-left post-approver-name">
												<strong>
												<?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
												</strong>
												<?php echo get_user_groups($user->aauth_user_id,$brand_id); ?>
											</div>
										</li>										
										<?php									
									}
									?>

									<li class="option-all-users">
										<div class="pull-sm-left"><i class="tf-icon check-box circle-border" data-value="check-all" data-group="join_req[]"><i class="fa fa-check"></i></i></div>
										<div class="pull-sm-left"><div class="circle-border bg-black tf-icon">All</div></div>
										<div class="pull-sm-left post-approver-name">Check<br>All</div>
									</li>
								</ul>
								<?php
							}
							?>
							<button type="button" id="send-join" class="btn btn-sm btn-secondary">Send join request</button>							
						</div>						
					</div>
				</div>
			</div>
			<?php
			}
			?>
			<div class="col-md-6" style="height:900px;">
				<div class="container-approvals">
					<div class="dafault-phase">
						<div>
							<h4 class="text-xs-center">Collaborate</h4>								
							<div id="videos">
						        <div id="subscriber"></div>
						        <div id="publisher"></div>
							</div>

							<br/>

							<div class="container">
							    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
							        <div class="col-xs-12 col-md-12">
							        	<div class="panel panel-default">
							                <div class="panel-heading top-bar">
							                    <div class="col-md-8 col-xs-8">
							                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat here</h3>
							                    </div>
							                    <div class="col-md-4 col-xs-4" style="text-align: right;">
							                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
							                        <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
							                    </div>
							                </div>
							                <div class="panel-body msg_container_base">
							                </div>
							                <div class="panel-footer msg_container_footer">
							                    <div class="input-group">
							                        <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
							                        <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
							                    </div>
							                </div>
							    		</div>
							        </div>
							    </div>
							</div>

						</div>
						<footer class="post-content-footer">
						<button class="btn btn-sm save-draft-btn submit-btn btn-default"  id="draft">Save Draft</button>
						<button type="submit" class="btn btn-sm btn-secondary submit-approval submit-btn "  id="submit-approval">Submit for Approval</button>
						</footer>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<script type="text/javascript">
	var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
	var sessionId = '<?php echo $sessionId; ?>';
	var token = '<?php echo $token; ?>';
</script>
<!-- Select Date Calendar -->
<?php
$this->load->view('partials/previews');
?>