<section id="overview" class="page-main overview-main bg-white col-sm-12">
	<div class="relative-wrapper">
		<header class="page-main-header">
			<?php
			if(!empty($brands))
			{
				$show = 0;
				if($this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group']) == "Master Admin")
				{
					$show = 1;
					if(count($brands) < $this->plan_data['brands'] OR $this->plan_data['brands'] == 'unlimited')
					{
						?>
						<a href="<?php echo base_url().'brands/add' ?>" class="btn btn-secondary btn-sm pull-sm-left">Add a Brand</a>
						<?php
					}
				}
				if(count($brands) > 1)
				{
					?>
					<a href="#" class="btn btn-default btn-sm btn-reorder pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="<?php echo base_url().'brands/reorder_brands'; ?>" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
					<?php
				}
				?>
				<h1 class="center-title section-title">Overview</h1>
			</header>
			<div id="brand-sort">
				<?php
				if(!empty($trial_message))
				{
					?>
					<div class="row">
						<div class="col-sm-12 center-title">
							<strong><?php echo $trial_message ?></strong>
						</div>
					</div>
					<?php
				}

				$subscription_error = $this->session->flashdata('subscription_error');
				if($subscription_error)
				{
					?>
					<div class="alert alert-danger center-title">
					  <?php echo $subscription_error; ?>
					</div>
					<?php
				}
				
				foreach($brands as $key=>$brand)
				{
					?>
					<div class="brand-overview" data-list-order="<?php echo $key; ?>" data-brand="<?php echo $brand->order; ?>">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-2">
								<h2><?php echo $brand->name ?></h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<div class="brand-link text-xs-center">
									<?php
									$image_path = img_url().'default_brand.png';
									$image_class = 'img-responsive center-block';
									if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
									{
										$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';
										$image_class = 'img-responsive center-block circle-img';
									}
									?>
									<img src="<?php echo $image_path; ?>?version=<?php echo time(); ?>" width="135" height="135" alt="" class="<?php echo $image_class; ?>"/>
									<a href="<?php echo base_url().'brands/dashboard/'.$brand->slug; ?>" class="btn btn-default btn-xs">View Dashboard</a>
								</div>
							</div>
							<div class="col-sm-6 reminder-list-div<?php echo $brand->id; ?>">								
								<?php
								$this->data['brand'] = $brand;
								$this->load->view('brands/reminder_list_html',$this->data);
								?>
							</div>
							<div class="col-sm-4">
								<div class="container-summary-list border-top bg-gray-lightest padding-2rem">
									<h3>Total Summary <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
									
									<ul class="summary-list timeframe-list">
										<li>
											<i class="tf-icon-schedule tf-icon-circle bg-info"></i>Scheduled Posts 
											<div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'scheduled'); ?></div>
										</li>
										<li>
											<i class="fa fa-minus-circle color-warning"></i>Pending Approval 
											<div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'pending'); ?></div>
										</li>
										<li>
											<i class="tf-icon-ticktock tf-icon-circle bg-orange"></i>Awaiting Scheduling 
											<div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'approved'); ?></div>
										</li>
										<li>
											<i class="fa fa-pencil fa-custom-circle color-white bg-gray"></i>Drafts 
											<div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'draft'); ?></div>
										</li>
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
				<?php
				if($this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND $this->user_data['user_group'] == "Master Admin"))
				{
					?>
					<a href="<?php echo base_url().'brands/add'; ?>" class="btn btn-secondary btn-sm pull-sm-left" data-toggle="popover-onload" data-content="CLICK THIS BUTTON TO ADD YOUR FIRST BRAND<br><br>Your brands will appear on this overview page. You will see all the reminders, notifications and summary for each brand.">Add a Brand</a>
					<?php
				}
				?>
				<a href="#" class="btn btn-default btn-sm btn-reorder btn-disabled disabled pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
				<h1 class="center-title section-title border-none">Overview</h1>
			</header>
			<div id="brand-sort">
				<div class="brand-overview border-gray-lighterer" data-list-order="0" data-brand="Lorac Cosmetics">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-2">
							<h2 class="border-bottom border-gray-lighterer"><img src="<?php echo img_url(); ?>blank-title.png" alt=""/></h2>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<img src="<?php echo img_url(); ?>blank-brand-img.png" class="center-block" alt=""/>
						</div>
						<div class="col-sm-6">
							<img src="<?php echo img_url(); ?>blank-reminders.png" alt=""/>
						</div>
						<div class="col-sm-4">
							<img src="<?php echo img_url(); ?>blank-summary.png" alt=""/>
						</div>
					</div>
				</div>
				<div class="brand-overview border-gray-lighterer" data-list-order="1" data-brand="J Brand">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-2">
							<h2 class="border-bottom border-gray-lighterer"><img src="<?php echo img_url(); ?>blank-title.png" alt=""/></h2>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<img src="<?php echo img_url(); ?>blank-brand-img.png" class="center-block" alt=""/>
						</div>
						<div class="col-sm-6">
							<img src="<?php echo img_url(); ?>blank-reminders.png" alt=""/>
						</div>
						<div class="col-sm-4">
							<img src="<?php echo img_url(); ?>blank-summary.png" alt=""/>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<?php $this->load->view('partials/footer_nav'); ?>
	</div>
</section>
