<section id="overview" class="page-main col-sm-12">
	<input type="hidden" id="brand_id" value="<?php echo $brand_id; ?>">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Approvals by Month</h1>
	</header>
	<?php
	$this->data['post_data'] = $post_data;
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
		<div class="date-header row">
			<div class="col-sm-12">
				<div class="pull-xs-left">
					<div id="outlet-prev" class="next-outlet"></div>
				</div>
				<div class="pull-xs-right">
					<div id="outlet-next" class="next-outlet"></div>
				</div>
				<ul class="outlet-list bxslider">
					<li class="" data-value="check-all"><i class="fa"><span class="bg-outlet bg-all"></span><span class="outlet-text">All</span></i></li>

					<?php
					if(!empty($outlets))
					{
						foreach($outlets as $outlet)
						{
							?>
							<li class="disabled" data-selected-outlet-id="<?php echo $outlet->id; ?>" data-selected-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>
							<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
		<ul class="my-approvals">
			<?php
			$this->load->view('mobile/approvals/approval_post');
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