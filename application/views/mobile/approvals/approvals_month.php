<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Approvals by Month</h1>
	</header>
	<div id="selectedFilters" class="hidden" style="">
		<ul class="filter-list tag-list clearfix"></ul>
	</div>
	<div class="bg-white col-sm-12 content-shadow brand-main">
		<div class="content-shadow brand-header row">
			<div class="col-sm-12">
				<?php
				$image_path = img_url().'default_brand.png';				
				if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';					
				}									
				?>
				<img src="<?php echo $image_path; ?>" class="circle-img pull-xs-left" height="75" width="75"> <?php echo $brand->name; ?>
			</div>
		</div>
		<div class="date-header row">
			<div class="col-sm-12">
				<div class="pull-xs-left">
					<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '-1 month' ) ); ?>" class="next-date"><i class="fa fa-angle-left fa-custom-circle bg-black"></i></a>
				</div>
				<div class="pull-xs-right">
					<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '+1 month' ) ); ?>" class="next-date"><i class="fa fa-angle-right fa-custom-circle bg-black"></i></a>
				</div>
				<div class="center-title"><a href="#approvalMonth" class="target-hidden"><?php echo date('F, Y'); ?></a></div>
				<input type="month" id="approvalMonth" class="invisible pos-absolute" name="approvalMonth">
			</div>
		</div>
		<ul class="my-approvals">
			<?php
			$this->load->view('mobile/approvals/approval_post');
			?>
		</ul>
	</div>
</section>