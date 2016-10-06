<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Approvals</h1>
	</header>
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
				<img src="<?php echo $image_path; ?>" class="circle-img pull-xs-left" height="75" width="75"><?php echo $brand->name; ?>
			</div>
		</div>
		<ul class="timeframe-list full-width-list">
			<li><a href="<?php echo base_url().'approvals/approvals-today/'.$brand->slug; ?>" class="pos-relative">Today's Approvals<i class="fa fa-angle-right expand-collapse"></i></a></li>
			<li><a href="<?php echo base_url().'approvals/approvals-week/'.$brand->slug; ?>" class="pos-relative">Approvals by Week<i class="fa fa-angle-right expand-collapse"></i></a></li>
			<li><a href="<?php echo base_url().'approvals/approvals-month/'.$brand->slug; ?>" class="pos-relative">Approvals by Month<i class="fa fa-angle-right expand-collapse"></i></a></li>
			<li><a href="approvals-outlet.php" class="pos-relative">Approvals by Outlet<i class="fa fa-angle-right expand-collapse"></i></a></li>
		</ul>
	</div>
</section>