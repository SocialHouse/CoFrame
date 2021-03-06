<?php 
$this->load->view('partials/brand_nav');
?>
<input type="hidden" value="co_create" id="page">
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
	<?php //echo base_url()."co_create/save_post"; actio for this for is removed because it triggers save when click on mute button ?>
	<form method="POST" id="<?php echo (isset($post_details) AND !empty($post_details)) ? 'edit-post-details' : 'post-details'; ?>" upload="<?php echo base_url()."posts/upload_co_create"; ?>" class="file-upload clearfix co-create-form">	
		<input type="hidden" id="post_type" name="post_type" value="cocreate">
		<input type="hidden" name="cocreate_info_id" value="<?php echo (isset($post_details) AND !empty($post_details)) ? $post_details->id : '';?>" id="cocreate_info_id">
		<input type="hidden" name="co_create_req_id" id="co_create_req_id" value="<?php echo $req_id; ?>">
		<input type="hidden" name="post_id" id="post_id" value="<?php echo (isset($draft) AND !empty($draft)) ? $draft[0]->id : ''; ?>">

		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $this->user_data['account_id']; ?>">
		<input type="hidden" name="save_as" id="save_as" value="">
		<input type="hidden" name="slug" id="slug" value="<?php echo $brand->slug; ?>">

		<input type="hidden" name="uploaded_files[]" id="uploaded_files">
		<input type="hidden" id="all_files">
		<div class="row equal-columns">

			<div class="col-sm-4 equal-height">
				<div class="container-post-preview post-content">
					<h4 class="text-xs-center">Live Preview</h4>
					<?php
					if(isset($is_sender))
					{
						if(!empty($post_details))
						{
							if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($post_details->outlet_name).".php")){
								?>
								<div id="live-post-preview">
									<?php
								 	$this->load->view('calendar/post_preview/'.strtolower($post_details->outlet_name));							 	
								 	?>
							 	</div>
							 	<?php
							}
						}
						else
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
					}
					else
					{
						// $this->data['cocreate'] = $cocreate;
						?>
						<div id="live-cocreate-preview">
							<?php
							if(!empty($post_details))
							{
								if (file_exists(APPPATH."views/calendar/post_preview/".strtolower($post_details->outlet_name).".php")){
								 	$this->load->view('calendar/post_preview/'.strtolower($post_details->outlet_name));
								}
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

			<?php 
			if(isset($is_sender))
			{
				$this->data['is_cocreate'] = 1;
				if(isset($post_details) AND !empty($post_details))
				{
					$this->load->view('co_create/edit_post_details',$this->data);
				}
				else
				{
					$this->load->view('partials/post_details',$this->data); 
				}
			}
			else
			{
				?>
				<div class="col-sm-4 equal-height"></div>
				<?php
			}
			?>

			<div class="col-sm-4 equal-height">
				<label class="switch">
				  <input type="checkbox" id="toogle-vide-aud" checked>
				  <div class="slider round"></div>
				</label>
				<div class="container-cocreate-discussion">
					<div id="videos">
				        <div id="subscriber" class="hidden"></div>
				        <div id="publisher" class="hidden"></div>
					</div>
					<div class="cocreate-participants"><strong>Participants:</strong>
						<span class="participant-list"></span>
						<a class="co-create-approver timeframe-list user-list border-bottom popover-toggle approver-selected" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'co_create/get_brand_users/'.$brand_id.'/'.$req_id; ?>" data-title="Add participants" data-popover-class="popover-users popover-clickable" data-popover-id="popover-user-list" data-attachment="top right" data-target-attachment="top left" data-offset-x="-4" data-offset-y="-15" data-popover-arrow="true" data-arrow-corner="right top" data-popover-container="body"><i class="tf-icon circle-border pull-sm-right">+</i></a>
					</div>
					<div class="discussion-list">
						<div class="chat-panel">
						</div>
						<input type="text" class="form-control" id="cocreate-comment" placeholder="Type a message ...">
					</div>
					<div class="cocreate-approve bg-gray-lightest">
						<?php
						if(!isset($is_sender) OR empty($is_sender))
						{
							?>
							<button data-req-id="<?php echo $req_id; ?>" type="button" class="btn btn-sm btn-secondary color-success pull-sm-left approve-cocreate">Approve Post</button>
							<span class="sep pull-sm-left"></span>
							<?php
						}
						?>
						<div class="pull-sm-right">
							<ul class="timeframe-list user-list approval-list  clearfix">		
							</ul>
						</div>
					</div>
					<footer class="post-content-footer">
						<button type="button" class="btn btn-sm btn-default schedule-cocreate">Schedule</button>
						<button type="button" class="btn btn-sm btn-secondary pull-sm-right submit-btn">Post Now</button>
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