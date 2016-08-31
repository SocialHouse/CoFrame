<?php $this->load->view('partials/brand_nav'); ?>

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
			<div class="cocreate-opts text-xs-center">
				<i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-tele"></i></i>
				<i class="tf-icon circle-border" data-value="Facebook" data-group="post-outlet"><i class="tf-icon-video"></i></i>
			</div>
		</div>
	</div>
	<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="post-details" class="file-upload clearfix">	
		<div class="row equal-columns">

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
				<div class="container-cocreate-discussion">
					<div class="cocreate-participants"><strong>Participants:</strong> <span id="participants"><span></div>
					<div class="discussion-list">
							<ul>
							</ul>
							<input type="text" class="form-control" id="cocreate-comment" placeholder="Type a message ...">
					</div>
					<footer class="post-content-footer">
						<div class="pull-sm-right">
						<button type="button" class="btn btn-sm btn-default btn-disabled" disabled>Schedule</button>
						<button type="submit" class="btn btn-sm btn-disabled btn-secondary" disabled>Post Now</button>
						</div>
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
</script>