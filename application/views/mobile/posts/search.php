<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title border-none"><?php echo count($approval_list); ?> search results for <strong><?php echo $search; ?></strong></h1>
	</header>	
	<?php
	$this->data['filters'] = $filters;
	$this->load->view('mobile/partials/selected_filters',$this->data);
	?>
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
		<ul class="my-approvals">
			<?php
			$this->load->view('mobile/approvals/approval_post',$this->data);
			?>
		</ul>
	</div>
</section>

<!-- Blank Modal -->
<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  </div>
	</div>
  </div>
</div>