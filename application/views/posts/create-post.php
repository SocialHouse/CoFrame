<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">New Post</h1>
	</header>
	<form action="<?php echo base_url().'posts/save_post' ?>" method="POST" id="post-details" class="file-upload clearfix" upload="<?php echo base_url()."posts/upload"; ?>" autocomplete="off">
		<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id; ?>">
		<input type="hidden" name="user_id" id="post_user_id" value="<?php echo $this->user_data['account_id']; ?>">
		<input type="hidden" name="save_as" id="save_as" value="">
		<input type="hidden" name="slug" id="slug" value="<?php echo $brand->slug; ?>">

		<input type="hidden" name="uploaded_files[]" id="uploaded_files">
		<input type="hidden" id="all_files">
		<div class="row equal-columns create">
			<div class="col-md-4 equal-height">
				<div class="container-post-preview post-content">
					<h4 class="text-xs-center">Live Preview</h4>
					<div id="live-post-preview">
						<img src="<?php echo img_url(); ?>post-preview.png" width="406" height="506" alt="" class="center-block"/>
						
					</div>
					<footer class="post-content-footer">
					<!-- 	<a href="#" class="btn btn-default btn-xs">Delete</a> -->
					</footer>
				</div>
			</div>

			<?php $this->load->view('partials/post_details'); ?>

			<div class="col-md-4 equal-height">
				<div class="container-approvals">
					<div id="phaseDetails">
						<?php
						if($this->plan_data['phase_approvals'] == 1)
						{
							$this->data['timezone_list'] = $timezones;							
							$this->load->view('partials/all_phases',$this->data);
							?>
						<?php
						}
						?>						
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<!-- Select Date Calendar -->
<?php
$this->load->view('partials/previews');
?>