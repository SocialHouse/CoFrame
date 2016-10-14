<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile_assets/css/style.css" media="all">
<link href="<?php echo base_url(); ?>assets/mobile_assets/css/fullcalendar.css" rel="stylesheet">
<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
</script>

<style type="text/css">
	.hide{
		display: none !important;
	}
</style>
<?php
// create json message file
if($this->config->item('compile_json_message_js')){
	$msg_file = $this->config->item('json_msg_file');
	$json_message = $this->lang->language;
	$json_str = 'var language_message = '.json_encode($json_message);
	@unlink($msg_file);
	file_put_contents($msg_file, $json_str);
}
?>
</head>
<body class="page-global">
	<div class="container container-head navbar-fixed-top bg-white">
		<?php 
		if(isset($show_filter))
		{
			$this->load->view('mobile/partials/approval_nav'); 
		}
		else
			$this->load->view('mobile/partials/global_nav'); 
		?>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<?php echo $yield; ?>
		</div>
	</div>

	<script type='text/javascript' src='<?php echo js_url(); ?>json_message.json'></script>

	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/jquery.js?ver=1.11.3'></script>

	<script type="text/javascript">
		var plan_data = '<?php echo json_encode($this->plan_data); ?>';	
		plan_data = jQuery.parseJSON(plan_data);

		var user_data = '<?php echo json_encode($this->user_data); ?>';	
		user_data = jQuery.parseJSON(user_data);

		var upload_limit = '<?php echo json_encode($this->config->item('upload_limit')) ?>';
		upload_limit = jQuery.parseJSON(upload_limit);	
	</script>

	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/jquery-ui-sortable.min.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/isotope.pkgd.min.js?ver=3.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/vendor/jquery.bxslider.min.js?ver=1.0.0'></script>

	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/main.js?ver=1.0.0'></script>

	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/reorder-brands.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/tooltip-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/bxslider-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/modal-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/approvals.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/post-filters.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/view-n-edit-request.js?ver=1.0.0'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/mobile_assets/js/user_preference.js?ver=1.0.0'></script>
</body>
</html>
