<section id="overview" class="page-main bg-white col-sm-12">
	<header class="page-main-header">
		<?php
		if(!empty($brands))
		{
			$show = 0;
			if($this->user_id == $this->user_data['account_id'])
			{
				$show = 1;
				if(count($brands) < $this->plan_data['brands'] OR $this->plan_data['brands'] == 'unlimited')
				{
					?>
					<a href="<?php echo base_url().'brands/add' ?>" class="btn btn-secondary btn-sm pull-sm-left">Add a Brand</a>
					<?php
				}
			}
			?>
			<a href="#" class="btn btn-default btn-sm btn-reorder pull-sm-right popover-toggle" data-toggle="popover-reorder-brands" data-content-src="<?php echo base_url().'brands/reorder_brands'; ?>" data-popover-class="popover-brand-list popover-clickable" data-popover-id="popover-reorder-brands" data-attachment="top right" data-target-attachment="bottom right" data-offset-x="20" data-offset-y="-6" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container="body">Reorder <i class="fa fa-bars"></i></a>
			<h1 class="center-title section-title">Overview</h1>
		</header>
		<div id="brand-sort">
			<?php
        	if(!empty($trial_message))
        	{
        		?>
       			<div class="col-md-12 center-title">
       				<strong><?php echo $trial_message ?></strong>
       			</div>
           		<?php
           	}
           	
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
								$image_class = 'img-responsive center-block';
								if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
								{
									$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';
									$image_class = 'img-responsive center-block circle-img';
								}
								?>
								<img src="<?php echo $image_path; ?>" width="135" height="135" alt="" class="<?php echo $image_class; ?>"/>
								<a href="<?php echo base_url().'brands/dashboard/'.$brand->slug; ?>" class="btn btn-default btn-xs">View Dashboard</a>
							</div>
						</div>
						<div class="col-md-6">
							<h3>Reminders <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
							<ul class="reminder-list timeframe-list">
								<?php 
									$reminders = get_brand_reminders($this->user_id, $brand->id, '', 'reminder');
									$i=1;
									$rms = array();
									if(!empty($reminders)){
										foreach ($reminders as $key) {
											if($i > 6){
												$rms['see_more'][] = $key;
											}else{
												$rms['displayed'][] = $key;
											}
											$i++;
										}
									}

									if(!empty($rms['displayed'])){
										foreach($rms['displayed'] as $reminder)
										{
											$symbol = '';
											if(!empty($reminder->due_date))
											{
												if(date('Y-m-d H:i') <= date('Y-m-d H:i',strtotime($reminder->due_date)) AND date('Y-m-d H:i',strtotime('12 hours')) >= date('Y-m-d H:i',strtotime($reminder->due_date)))
												{
													$symbol = '<div class="pull-sm-right"><i class="fa fa-exclamation-circle color-danger"></i></div>';
												}
											}
											?>
											<li>
												<?php
													$date = !empty($reminder->due_date) ? date('m/d',strtotime($reminder->due_date)): date('m/d',strtotime($reminder->created_at));
													echo '<a href="'.base_url().'edit-request/'.$reminder->post_id.'">'.$reminder->text." ".$symbol.'</a>';
												?>
											</li>
											<?php
										}
									}
									else
									{
										?>
										<li>Currently no reminders</li>
										<?php
									}
									?>
							</ul>
							<?php
								if(!empty($rms['see_more']))
								{
									?>
									
									<div  class="panel-collapse collapse" id="collapse<?php echo $brand->id ;?>">
										<ul class="reminder-list timeframe-list">
											<?php
											foreach($rms['see_more'] as $reminder)
												{
													$symbol = '';
													if(!empty($reminder->due_date))
													{
														if(date('Y-m-d H:i') <= date('Y-m-d H:i',strtotime($reminder->due_date)) AND date('Y-m-d H:i',strtotime('12 hours')) >= date('Y-m-d H:i',strtotime($reminder->due_date)))
														{
															$symbol = '<div class="pull-sm-right"><i class="fa fa-exclamation-circle color-danger"></i></div>';
														}
													}
													?>
													<li>
														<?php
															$date = !empty($reminder->due_date) ? date('m/d',strtotime($reminder->due_date)): date('m/d',strtotime($reminder->created_at));
															echo '<a href="'.base_url().'edit-request/'.$reminder->post_id.'">'.$reminder->text." ".$symbol.'</a>';
														?>
													</li>
													<?php
												}
											?>
										</ul>
									</div>
									<a class="accordion-toggle" data-toggle="collapse" href="#collapse<?php echo $brand->id ;?>">See more</a>
									<?php
								}
							?>
						</div>
						<div class="col-md-4">
							<div class="container-summary-list border-top bg-gray-lightest padding-2rem">
								<h3>Total Summary <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
								
								<ul class="summary-list timeframe-list">
									<li><i class="tf-icon-schedule tf-icon-circle bg-info"></i>Scheduled Posts <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'scheduled'); ?></div></li>
									<li><i class="fa fa-check-circle color-success"></i>Posted <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'posted'); ?></div></li>
									<li><i class="fa fa-minus-circle color-warning"></i>Pending Approval <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'pending'); ?></div></li>
									<li><i class="fa fa-pencil fa-custom-circle color-white bg-gray"></i>Drafts <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'draft'); ?></div></li>
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
			if($this->user_id == $this->user_data['account_id'])
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