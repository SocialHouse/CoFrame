	<?php $this->load->view('partials/brand_nav'); ?>
	<section id="brand-manage" class="page-main bg-white col-sm-10">
		<header class="page-main-header">
			<a href="<?php echo base_url().'approvals/'.$brand->slug; ?>" class="btn btn-default btn-sm btn-arrow-left pull-left"><i class="fa fa-angle-left"></i>Back</a>
			<!-- invisible button hack to maintain centering of title-->
			<a href="<?php echo base_url().'approvals/'.$brand->slug; ?>" class="btn btn-default btn-sm btn-arrow pull-right invisible"><i class="fa fa-angle-left"></i>Back</a>
			<h1 class="center-title section-title">Edit Requests</h1>
		</header>

		<?php
		$this->data['show_model'] = 1;
		$this->load->view('approvals/edit-request-modal',$this->data);
		?>
	</section>


	