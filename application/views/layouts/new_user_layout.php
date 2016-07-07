<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>style.css" media="all">
<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>search.css" media="all">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<?php    
if(isset($css_files))
{
    foreach ($css_files as $css_src) 
    {
        ?>
        <link href="<?php echo $css_src ?>" rel="stylesheet">
        <?php
    }
}
// create json messafe file
if($this->config->item('compile_json_message_js')){
	$msg_file = $this->config->item('json_msg_file');
	$json_message = $this->lang->language;
	$json_str = 'var language_message = '.json_encode($json_message);
	@unlink($msg_file);
	file_put_contents($msg_file, $json_str);
}

?>

<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
	var selected_day = "<?php echo isset($selected_date)?$selected_date : ''; ?>";
</script>
<script type='text/javascript' src='<?php echo js_url(); ?>json_message.json?ver=4.0.0'></script>
<script type='text/javascript' src='http://fast.fonts.net/jsapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.js'></script>
<script type='text/javascript' src='<?php echo js_url(); ?>vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global" style="background-image: url(<?php echo img_url().$background_image; ?>);">
	<div class="container container-head">
		<nav class="navbar navbar-dark navbar-main bg-transparent row">
			<a class="navbar-brand hidden-print" href="/brands/overview"><span class="brand-logo hide-text">Timeframe</span></a>
			<div class="go-to-brands">
				<a href="#" class="hide-text show-brands-toggler animated infinite pulse popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/brand_list/'.$this->user_id; ?>" data-title="Go To" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-brand-list" data-attachment="top left" data-target-attachment="bottom left" data-offset-x="-24" data-offset-y="6" data-popover-arrow="true" data-arrow-corner="top left" data-popover-container="body">Go To Brand</a>
		  	</div>

		  	<ul class="nav navbar-nav pull-sm-right">
		    	<li class="nav-item">
		      		<a class="nav-link" href="<?php echo base_url(); ?>brands/overview">Overview</a>
		    	</li>
		   		<li class="nav-item">
		      		<a class="nav-link" href="<?php echo base_url()?>/user_preferences">User Preferences</a>
		    	</li>
		   		<li class="nav-item dropdown">
		      		<a class="nav-link" href="#">Companies</a>
					<!-- if multiple companies-->
					<ul class="dropdown-menu">
						<li class="nav-item">
							<a class="nav-link" href="/brands/overview">Company Name 1</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/brands/overview">Company Name 2</a>
						</li>
					</ul>
		    	</li>
		    	<li class="nav-item">
		      		<a class="btn btn-default btn-sm" href="<?php echo base_url().'tour/logout' ?>">Log out</a>
		    	</li>
		  	</ul>
		</nav>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<?php echo $yield; ?>
		</div>
	</div>

	<!-- Blank Modal -->
	<div class="modal hide fade" id="emptyModal" data-keyboard="false" role="dialog" aria-hidden="true" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
		  </div>
		</div>
	  </div>
	</div>
	<?php $this->load->view('partials/modals'); ?>
	<button type="button" class="modal-toggler">
		<span class="sr-only">Toggle Modal</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='<?php echo js_url(); ?>vendor/bootstrap.min.js?ver=4.0.0'></script>	
	
	
	<?php       
    if(isset($js_files))
    {
        foreach ($js_files as $js_src) 
        {
            ?>
            <script src="<?php echo $js_src; ?>"></script>
            <?php
        }
    }
    ?>
    <script type='text/javascript' src='<?php echo js_url(); ?>jquery.mask.min.js?ver=1.0.0'></script>
    <script type='text/javascript' src='<?php echo js_url(); ?>main.js?ver=1.0.0'></script>
    <script>
    console.log(language_message);
    	if(typeof(fileDragNDrop) == 'function')
		{
			fileDragNDrop();
		}

		jQuery(function($) {
			if(typeof(successTip) == 'function')
			{
				successTip();
			}
		});
    </script>
</body>
</html>
