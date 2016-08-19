<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">

	<header class="page-main-header">
		<h1 class="center-title section-title">Archive</h1>
	</header>

	<form id="archive-export" method="POST" action="<?php echo base_url();?>archives/export_post/<?php echo $brand->slug?>" >

		<input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>">
		<div class="row equal-columns relative-wrapper archives">
			<!-- archive-date-select -->
			<div class="col-md-3 col-sm-6">
				<?php $this->load->view('archives/date_select'); ?>
			</div>
			<!-- archive-outlet-select -->
			<div class="col-md-3 col-sm-6">
				<?php $this->load->view('archives/outlet_select'); ?>
			</div>
			<!-- archive-tag-select -->
			<div class="col-md-3 col-sm-6">
				<?php $this->load->view('archives/tag_select'); ?>
			</div>
			<!-- archive-export -->
			<div class="col-md-3 col-sm-6">
				<div class="container-archive">
					<h2 class="text-xs-center">Export Format</h2>
					<ul class="timeframe-list">
						<li class="radio">
							<label>
							<input type="radio" name="exportType" value="CSV" checked>
							.CSV
							</label>
						</li>
						<li class="radio">
							<label>
							<input type="radio" name="exportType" value="PDF">
							.PDF
							</label>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<?php
	        $message = $this->session->flashdata('message');
	        if(!empty($message)){
	           echo ' <div class="alert alert-success col-md-12 center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$message.'</strong></div>';
	        }
	    ?>
		<div class="row archives">
			<div class="col-sm-12">
				<footer class="post-content-footer">
				<button type="reset" class="btn btn-sm btn-default">Reset</button>
				<button type="submit" class="btn btn-sm btn-disabled btn-secondary pull-sm-right" disabled="disabled" >Export</button>
				</footer>
			</div>
		</div>
	</form>

</section>