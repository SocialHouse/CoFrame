<?php 
$this->load->view('partials/brand_nav');
?>
<section id="brand-manage" class="page-main bg-white col-sm-10 cocreate-post">
	<div class="row">
		<div class="col-sm-8">
			<header class="page-main-header">
				<h1 class="center-title section-title">Co-Create</h1>
			</header>
		</div>
		<div class="col-sm-4">
			<header class="page-main-header">
				<h1 class="center-title section-title">Discussion</h1>
			</header>
		</div>
	</div>
	<form action="" method="POST" upload="<?php echo base_url()."posts/upload_co_create"; ?>" id="post-details" class="file-upload clearfix">	
		<input type="hidden" id="post_type" name="post_type" value="cocreate">
		<input type="hidden" name="cocreate_info_id" value="" id="cocreate_info_id">
		<input type="hidden" name="co_create_req_id" id="co_create_req_id" value="<?php echo $req_id; ?>">

		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $this->user_data['account_id']; ?>">
		<input type="hidden" name="save_as" id="save_as" value="">
		<input type="hidden" name="slug" id="slug" value="<?php echo $brand->slug; ?>">

		<input type="hidden" name="uploaded_files[]" id="uploaded_files">
		<input type="hidden" id="all_files">
		<div class="row equal-columns">

			<div class="col-md-4 equal-height">
				<div class="container-post-preview post-content">
					<h4 class="text-xs-center">Live Preview</h4>
					<?php
					if(isset($is_sender))
					{
						?>
						<div id="live-post-preview">
							<img src="<?php echo img_url(); ?>post-preview.png" width="406" height="506" alt="" class="center-block"/>
							
						</div>
						<footer class="post-content-footer">
						<!-- 	<a href="#" class="btn btn-default btn-xs">Delete</a> -->
						</footer>
						<?php
					}
					else
					{
						// $this->data['cocreate'] = $cocreate;
						?>
						<div id="live-cocreate-preview">
							<?php							
							if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($post_details->outlet_name).".php")){
							 	$this->load->view('calendar/post_preview/'.strtolower($post_details->outlet_name));
							}
							?>							
						</div>
						<footer class="post-content-footer">
						<!-- 	<a href="#" class="btn btn-default btn-xs">Delete</a> -->
						</footer>
						<?php
					}
					?>
				</div>
			</div>			

			<?php $this->load->view('partials/post_details'); ?>

			<div class="col-md-4 equal-height">
				<div class="container-cocreate-discussion">
					<div id="videos">
				        <div id="subscriber" class="hidden"></div>
				        <div id="publisher" class="hidden"></div>
					</div>
					<div class="cocreate-participants"><strong>Participants:</strong> <span id="participants"></span><i class="tf-icon circle-border pull-sm-right">+</i></div>
					<div class="discussion-list">
						<div class="chat-panel">
						</div>
						<input type="text" class="form-control" id="cocreate-comment" placeholder="Type a message ...">
					</div>
					<div class="cocreate-approve bg-gray-lightest">
						<button type="button" class="btn btn-sm btn-secondary color-success pull-sm-left">Approve Post</button>
						<span class="sep pull-sm-left"></span>
						<div class="pull-sm-right">
							<ul class="timeframe-list user-list approval-list  clearfix">
								<li class="pull-sm-left approved"><img src="/uploads/3/users/3.png" width="36" height="36" alt="Jamie Doherty" class="circle-img" data-toggle="popover-hover" data-content="Jamie Doherty"></li>
								<li class="pull-sm-left pending"><img src="/uploads/6/users/11.png" width="36" height="36" alt="Norel Mancuso" class="circle-img" data-toggle="popover-hover" data-content="Norel Mancuso"></li>
								<li class="pull-sm-left pending"><img src="/uploads/6/users/10.png" width="36" height="36" alt="Bree Hardaway" class="circle-img" data-toggle="popover-hover" data-content="Bree Hardaway"></li>
							</ul>
						</div>
					</div>
					<footer class="post-content-footer">
						<button type="button" class="btn btn-sm btn-default btn-disabled" disabled>Schedule</button>
						<button type="submit" class="btn btn-sm btn-disabled btn-secondary pull-sm-right" disabled>Post Now</button>
					</footer>
				</div>
			</div>
		</div>
	</form>
</section>

<?php
$this->load->view('partials/previews');
?>

<script type="text/javascript">
	var apiKey = '<?php echo $this->config->item('opentok_key'); ?>';
	var sessionId = '<?php echo $sessionId; ?>';
	var token = '<?php echo $token; ?>';
	var is_sender = '<?php echo isset($is_sender) ? $is_sender : ''; ?>';
</script>