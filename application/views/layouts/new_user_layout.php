<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>CoFrame | Create, Manage &amp; Approve Your Social Media Calendars, All On One Easy-To-Use Platform.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>style.css" media="all">
<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>search.css" media="all">
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
	// create json message file
	if($this->config->item('compile_json_message_js')){
		$msg_file = $this->config->item('json_msg_file');
		$json_message = $this->lang->language;
		$json_str = 'var language_message = '.json_encode($json_message);
		@unlink($msg_file);
		file_put_contents($msg_file, $json_str);
	}

	$brand_id = get_my_brand($this->user_id);
?>

<script type="text/javascript">
	var base_url = "<?php echo base_url(); ?>";
	var selected_day = "<?php echo isset($selected_date)?$selected_date : ''; ?>";
	var desktop_notify_status = "<?php echo isset($this->user_data['desktop_notification']) ? $this->user_data['desktop_notification'] : ''; ?>";		
</script>
<script type='text/javascript' src='<?php echo js_url(); ?>json_message.json'></script>
<script type='text/javascript' src='<?php echo js_url(); ?>vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global" style="background-image: url(<?php echo img_url().$background_image; ?>);">
	<div class="container container-head">
		<nav class="navbar navbar-dark navbar-main bg-transparent row">
			<a class="navbar-brand hidden-print" href="<?php echo base_url();?>brands/overview"><span class="brand-logo hide-text">CoFrame</span></a>
			<div class="visible-print-block logo-print">
				<img src="/assets/images/logo-black.png" height="67" width="250" alt="">
			</div>
			<div class="go-to-brands hidden-print">
				<a href="#" class="hide-text show-brands-toggler animated infinite pulse popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/brand_list/'.$this->user_id; ?>" data-title="Go To" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-brand-list" data-attachment="top left" data-target-attachment="bottom left" data-offset-x="-24" data-offset-y="6" data-popover-arrow="true" data-arrow-corner="top left" data-popover-container="body">Go To Brand</a>
		  	</div>

		  	<ul class="nav navbar-nav pull-sm-right hidden-print">
		    	<li class="nav-item">
		      		<a class="nav-link" href="<?php echo base_url(); ?>brands/overview">Overview</a>
		    	</li>
		   		<li class="nav-item">
		      		<a class="nav-link" href="<?php echo base_url()?>user_preferences">User Preferences</a>
		    	</li>

		   		<li class="nav-item dropdown">
					<span class="company-name" href="#"><?php echo get_company_name($this->user_data['account_id']); ?></span>
					<!-- if multiple companies-->
					<?php
					if(count($this->user_data['accounts']) > 1)
					{
						?>
						<ul class="dropdown-menu">
							<?php
							foreach($this->user_data['accounts'] as $id)
							{
								if($this->user_data['account_id'] != $id)
								{
									?>
									<li class="nav-item">
										<a class="nav-link" href="<?php echo base_url().'brands/change_account/'.$id; ?>"><?php echo get_company_name($id); ?></a>
									</li>
									<?php
								}
							}
							?>
						</ul>
						<?php
					}
					?>
		    	</li>
				<li class="nav-item dropdown dropdown-user">
					<a class="nav-link" href="#"><?php echo print_user_image($this->user_data['img_folder'],$this->user_id); ?></a>
					<ul class="dropdown-menu">
						<li class="user-info"><?php echo $this->user_data['first_name'] . " " . $this->user_data['last_name']; ?><br>
						<?php
						$parent_id = NULL;
						if(empty($current_brand) AND isset($this->user_data['user_group']))
						{
							$parent_id = $this->user_data['account_id'];
						}
						?>
						<span class="user-role"><?php echo get_user_groups($this->user_id,$current_brand,$parent_id); ?></span></li>
						<li><a class="nav-link" href="<?php echo base_url().'tour/logout' ?>">Log out</a></li>
					</ul>
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
	<script type="text/javascript">
		var plan_data = '<?php echo json_encode($this->plan_data); ?>';	
		plan_data = jQuery.parseJSON(plan_data);
		var user_data = '<?php echo json_encode($this->user_data); ?>';	
		user_data = jQuery.parseJSON(user_data);
	</script>
	
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
    <script type='text/javascript' src='<?php echo js_url(); ?>notification.js?ver=1.0.0'></script>
    <script type='text/javascript' src='<?php echo js_url(); ?>main.js?ver=1.0.0'></script>
    <script>
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
