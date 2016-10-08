<input type="hidden" id="type" value="today">
<input type="hidden" id="brand-id" value="<?php echo $brand_id; ?>">
<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Today's Approvals</h1>
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
					<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '-1 days' ) ); ?>" class="next-date previous"><i class="fa fa-angle-left fa-custom-circle bg-black"></i></a>
				</div>
				<div class="pull-xs-right">
					<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '+1 days' ) ); ?>" class="next-date next"><i class="fa fa-angle-right fa-custom-circle bg-black"></i></a>
				</div>
				<div class="center-title"><a href="#calendarSelectModal" data-toggle="modal"><?php echo date('F d, Y'); ?></a></div>
			</div>
		</div>
		<ul class="my-approvals">
			<?php
			$this->load->view('mobile/approvals/approval_post');
			?>
		</ul>
	</div>
</section>

<div class="modal hide fade" id="calendarSelectModal" data-keyboard="false" role="dialog" aria-hidden="true" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content bg-white">
		  <div class="modal-body">
			<div id="calendar-change-day" class="calendar-select-date">
				<div class="date-select-calendar"></div>
			</div>
			<div class="text-xs-center overlay-footer border-gray-lighter">
				<button type="button" class="btn btn-sm btn-default modal-hide">Cancel</button>
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-secondary btn-disabled modal-hide" disabled="">Apply</button>
			</div>			
		  </div>
		</div>
	</div>
</div>	

<!-- Blank Modal -->
<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  </div>
	</div>
  </div>
</div>