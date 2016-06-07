<section id="overview" class="page-main bg-white col-sm-12">	
	<?php
	if(!empty($brands))
	{
		?>
		<header class="page-main-header">
			<a href="<?php echo base_url().'brands/add' ?>" class="btn btn-secondary btn-sm pull-sm-left">Add a Brand</a>
			<a href="#" class="btn btn-default btn-sm btn-reorder pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="<?php echo base_url().'brands/reorder_brands'; ?>" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
			<h1 class="center-title section-title">Overview</h1>
		</header>
		<div id="brand-sort">
			<?php
			foreach($brands as $key=>$brand)
			{
				?>
				<div class="brand-overview" data-list-order="<?php echo $key; ?>" data-brand="<?php echo $brand->id; ?>">
					<div class="row">
						<div class="col-md-10 col-md-offset-2">
							<h2><?php echo $brand->name ?></h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<div class="brand-link text-xs-center">
								<?php
								$image_path = img_url().'default_brand.png';
								if(file_exists(upload_path().$brand->created_by.'/brands/'.$brand->id.'/'.$brand->id.'.png'))
								{
									$image_path = upload_url().$brand->created_by.'/brands/'.$brand->id.'/'.$brand->id.'.png';
								}
								?>
								<img src="<?php echo $image_path; ?>" width="135" height="135" alt="" class="img-responsive center-block circle-img"/>								
								<a href="<?php echo base_url().'brands/dashboard/'.$brand->slug; ?>" class="btn btn-default btn-xs">View Dashboard</a>
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
			?>
		</div>	
		<?php
	}
	else
	{
		?>
		<header class="page-main-header">
			<a href="<?php echo base_url().'brands/add'; ?>" class="btn btn-secondary btn-sm pull-sm-left" data-toggle="popover-onload" data-content="CLICK THIS BUTTON TO ADD YOUR FIRST BRAND<br><br>Your brands will appear on this overview page. You will see all the reminders, notifications and summary for each brand.">Add a Brand</a>
			<a href="#" class="btn btn-default btn-sm btn-reorder btn-disabled disabled pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
			<h1 class="center-title section-title border-none">Overview</h1>
		</header>
		<div id="brand-sort">
			<div class="brand-overview border-gray-lighterer" data-list-order="0" data-brand="Lorac Cosmetics">
				<div class="row">
					<div class="col-md-10 col-md-offset-2">
						<h2 class="border-bottom border-gray-lighterer"><img src="<?php echo img_url(); ?>blank-title.png" alt=""/></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<img src="<?php echo img_url(); ?>blank-brand-img.png" class="center-block" alt=""/>
					</div>
					<div class="col-md-6">
						<img src="<?php echo img_url(); ?>blank-reminders.png" alt=""/>
					</div>
					<div class="col-md-4">
						<img src="<?php echo img_url(); ?>blank-summary.png" alt=""/>
					</div>
				</div>
			</div>
			<div class="brand-overview border-gray-lighterer" data-list-order="1" data-brand="J Brand">
				<div class="row">
					<div class="col-md-10 col-md-offset-2">
						<h2 class="border-bottom border-gray-lighterer"><img src="<?php echo img_url(); ?>blank-title.png" alt=""/></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<img src="<?php echo img_url(); ?>blank-brand-img.png" class="center-block" alt=""/>
					</div>
					<div class="col-md-6">
						<img src="<?php echo img_url(); ?>blank-reminders.png" alt=""/>
					</div>
					<div class="col-md-4">
						<img src="<?php echo img_url(); ?>blank-summary.png" alt=""/>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	?>
		
</section>