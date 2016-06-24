<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">Brand Settings</h1>
	</header>
	<div class="row equal-columns relative-wrapper ">
		<input type="hidden" name="brand_slug" value="<?php echo $brand->slug; ?>" id="brand_slug">
		<div class="brand-steps brand-settings col-sm-12 create">
			<div class="row">
				<div class="col-md-3 col-sm-6 brand-step  equal-height" id="brandStep1">
					<?php 
						$this->load->view('settings/step_1');
					?>
				</div>
				<div class="col-md-3 col-sm-6 brand-step  equal-height" id="brandStep2">
					<?php 
						$this->load->view('settings/step_2');
					?>
				</div>
				<div class="col-md-3 col-sm-6 brand-step  equal-height" id="brandStep3">
					<?php 
						$this->load->view('settings/step_3');
					?>
				</div>
				<div class="col-md-3 col-sm-6 brand-step  equal-height" id="brandStep4">
					<?php 
						$this->load->view('settings/step_4');
					?>
				</div>
			</div>
		</div>
	</div>
</section>