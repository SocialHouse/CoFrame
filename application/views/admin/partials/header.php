<!DOCTYPE html>
<html>
	<head>
		<title>CoFrame</title>
		<link rel="stylesheet" href="<?php echo css_url()."bootstrap.min.css"; ?>">
		<link rel="stylesheet" href="<?php echo css_url()."admin/font-awesome.min.css"; ?>">
		<style type="text/css">
			.starter-template{
				padding: 70px 15px;
			}
			label.error {
				font-size: 12px !important;
				font-weight:normal;
				color: #ff0000 !important;
			}
		</style>
	</head>
	<script>
		var base_url = "<?php echo base_url(); ?>";
	</script>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">CoFrame</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li data-url="category" ><a href="<?php echo base_url()."admin/accounts"; ?>">Accounts</a></li>
					</ul>

					<!-- <ul class="nav navbar-nav">
						<li data-url="category" ><a href="<?php echo base_url()."admin/category"; ?>">Users</a></li>
					</ul> -->

					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" role="button" 
							aria-haspopup="true" aria-expanded="false" >
								<i class="fa fa-user" aria-hidden="true"></i> Admin
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo base_url()."change-password"; ?>">
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change Password
									</a>
								</li>
								<li>
									<a href="<?php echo base_url()."logout"; ?>">
										<i class="fa fa-sign-out" aria-hidden="true"></i> Log out
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<?php 
				if(!isset($message))
					$message = $this->session->flashdata('message');

				if (isset($message) AND !empty($message))
				{ 
					?>
					<div class="alert alert-<?php echo $message['class']; ?> alert-dismissible" role="alert">
						<a href="#" class="close" data-hidden ="true" data-dismiss="alert" aria-label="close">&times;</a>
						<?php
							echo $message['message'];
						?>
					</div>
					<?php
				}
				?>