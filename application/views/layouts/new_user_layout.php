<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="<?php echo css_url(); ?>style.css" media="all">
<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"> -->
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
?>

<script type='text/javascript' src='http://fast.fonts.net/jsapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.js'></script>
<script type='text/javascript' src='<?php echo js_url(); ?>vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global" style="background-image: url(<?php echo img_url(); ?>bg-admin-overview.jpg);">
	<div class="container container-head">
		<nav class="navbar navbar-dark navbar-main bg-transparent row">
			<a class="navbar-brand hidden-print" href=""><span class="brand-logo hide-text">Timeframe</span></a>
			<div class="go-to-brands">
				<a href="#" class="hide-text show-brands-toggler animated infinite pulse popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'brands/brand_list/'.$this->user_id; ?>" data-title="Go To" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-brand-list" data-attachment="top left" data-target-attachment="bottom left" data-offset-x="-24" data-offset-y="6" data-popover-arrow="true" data-arrow-corner="top left" data-popover-container="body">Go To Brand</a>
		  	</div>

		  	<ul class="nav navbar-nav pull-sm-right">
		    	<li class="nav-item">
		      		<a class="nav-link" href="<?php echo base_url(); ?>brands/overview">Overview</a>
		    	</li>
		   		<li class="nav-item">
		      		<a class="nav-link" href="user-preferences.php">User Preferences</a>
		    	</li>
		    	<li class="nav-item">
		      		<a class="btn btn-default btn-sm" href="<?php echo base_url().'welcome/logout' ?>">Log out</a>
		    	</li>
		  	</ul>
		</nav>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<?php echo $yield; ?>
		</div>
	</div>

	<script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='<?php echo js_url(); ?>vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='<?php echo js_url(); ?>vendor/tether.min.js'></script>
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
    <script type='text/javascript' src='<?php echo js_url(); ?>main.js?ver=1.0.0'></script>
</body>
</html>
