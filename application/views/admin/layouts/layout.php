<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>CoFrame</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="<?php echo css_url(); ?>admin/others.min.css">
    <link rel="stylesheet" href="<?php echo css_url(); ?>admin/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo css_url(); ?>admin/datatables.min.css">
    <!-- <link rel="stylesheet" href="<?php echo css_url(); ?>admin/datatables-net.min.css"> -->
    
    <link rel="stylesheet" href="<?php echo css_url(); ?>admin/main.css">
    <script type="text/javascript">
    	var base_url = "<?php echo base_url(); ?>";
    </script>
</head>
<body class="with-side-menu">
	<?php
	$this->load->view('admin/partials/header-nav');
	$this->load->view('admin/partials/sidebar');
	?>

	<div class="page-content">
		<div class="container-fluid">
			<?php
			$message = $this->session->flashdata('message');
			if(!empty($message))
			{
				?>
				<div class="alert alert-<?php echo $message['class']; ?> alert-fill alert-close alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<?php echo $message['message']; ?>
				</div>
				<?php
			}
			echo $yield; 
			?>
		</div>
	</div>

	<script src="<?php echo js_url(); ?>admin/jquery.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/tether.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/bootstrap.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/plugins.js"></script>
	<script src="<?php echo js_url(); ?>admin/jquery.peity.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/jquery.tabledit.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/app.js"></script>
	<script src="<?php echo js_url(); ?>jquery.validate.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/datatables.min.js"></script>
	<script src="<?php echo js_url(); ?>admin/datatable-bootstrap.js"></script>
	<script src="<?php echo js_url(); ?>admin/admin.js"></script>

	
</body>
</html>