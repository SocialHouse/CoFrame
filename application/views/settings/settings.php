<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<div class="row row-sm-12 equal-cols relative-wrapper">
		<input type="hidden" name="brand_slug" value="<?php echo $brand->slug; ?>" id="brand_slug">
		<div class="brand-steps col-xl-11 center-block">
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep1">
				<?php 
					$this->load->view('settings/step_1');
				?>
			</div>
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep2">
				<?php 
					$this->load->view('settings/step_2');
				?>
			</div>
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep3">
				<?php 
					$this->load->view('settings/step_3');
				?>
			</div>
			<div class="col-md-3 col-sm-6 brand-step" id="brandStep4">
				<?php 
					$this->load->view('settings/step_4');
				?>
			</div>
		</div>
	</div>
</section>