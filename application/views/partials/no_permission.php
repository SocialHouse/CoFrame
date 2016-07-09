<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">

	<header class="page-main-header">
		<?php
		if(!empty($access_denied_msg))
		{
			?>
			<h1 class="center-title section-title"><?php echo $access_denied_msg; ?></h1>	
			<?php
		}
		else
		{
			?>
			<h1 class="center-title section-title">You don't have access to this page</h1>
			<?php
		}
		?>
	</header>
</section>
	