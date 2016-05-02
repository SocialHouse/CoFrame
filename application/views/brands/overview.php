<section id="overview" class="page-main bg-white col-sm-12">
	<header class="page-main-header">
		<a href="add-a-brand.php" class="btn btn-secondary btn-sm pull-sm-left">Add a Brand</a>
		<a href="#" class="btn btn-default btn-sm btn-reorder pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="lib/reorder-brands.php" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
		<h1 class="center-title section-title">Overview</h1>
	</header>
	<div id="brand-sort">
		<?php
		if(!empty($brands))
		{
			foreach($brands as $brand)
			{
				?>
				<div class="brand-overview" data-list-order="0" data-brand="Lorac Cosmetics">
					<div class="row">
						<div class="col-md-10 col-md-offset-2">
							<h2><?php echo $brand->name ?></h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<div class="brand-link text-xs-center">
								<?php
								$image_path = img_url().'blank-brand-img.png';
								if(file_exists(upload_path().'brands/'.$brand->id.'.png'))
								{
									$image_path = upload_path().'brands/'.$brand->id.'.png';
								}
								?>
								<img src="<?php echo $image_path; ?>" width="135" height="135" alt="" class="img-responsive center-block circle-img"/>								
								<a href="<?php echo base_url().'brands/dashboard/'.$brand->id; ?>" class="btn btn-default btn-xs">View Dashboard</a>
							</div>
						</div>
						<div class="col-md-6">
							<h3>Reminders <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
							<ul class="reminder-list timeframe-list">
								<?php 
									$reminders = get_brand_reminders($this->user_id,$brand->id,4);
									if(!empty($reminders))
									{
										foreach($reminders as $reminder)
										{
											$symbol = '';
											if(!empty($reminder->approve_by))
											{
												if(date('Y-m-d',strtotime('-12 hours')) <= date('Y-m-d',strtotime($reminder->approve_by)) AND date('Y-m-d') >= date('Y-m-d',strtotime($reminder->approve_by)))
												{
													$symbol = '<div class="pull-sm-right"><i class="fa fa-exclamation-circle color-danger"></i></div>';
												}
											}
											?>
											<li>
												<?php 
													$date = !empty($reminder->approve_by) ? date('m/d',strtotime($reminder->approve_by)): date('m/d',strtotime($reminder->created_at));
													echo $reminder->text." ".$date.$symbol;
											 	?>
											</li>											
											<?php
										}
										?>
										<a href="#">See more</a>
										<?php
									}
									else
									{
										?>
										<li>Currently no reminders</li>
										<?php
									}
								?>
							</ul>
							
						</div>
						<div class="col-md-4">
							<div class="container-summary-list border-top bg-gray-lightest padding-2rem">
								<h3>Total Summary <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
								
								<ul class="summary-list timeframe-list">
									<li><i class="fa fa-check-circle color-info"></i>Scheduled Posts <div class="pull-sm-right">13</div></li>
									<li><i class="fa fa-check-circle color-success"></i>Approved Posts <div class="pull-sm-right">6</div></li>
									<li><i class="fa fa-minus-circle color-warning"></i>Pending Approval <div class="pull-sm-right">4</div></li>
									<li><i class="icon-clock2 color-orange"></i>Awaiting Scheduling <div class="pull-sm-right">5</div></li>
									<li><i class="fa fa-pencil fa-custom-circle color-white bg-gray"></i>Drafts <div class="pull-sm-right">0</div></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</section>