<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Dashboard</h1>
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
				<img src="<?php echo $image_path; ?>" class="circle-img pull-xs-left" height="75" width="75"> <?php echo $brand->name; ?>
			</div>
		</div>
		<ul class="timeframe-list to-do-list">
			<?php
			if(!empty($reminders))
			{
				?>
				<li class="reminder-list"><a href="#reminderList" class="pos-relative" data-toggle="collapse">Reminders<span class="tag tag-danger tag-pill"><?php echo count_reminders($this->user_id,$brand->id); ?></span><i class="fa fa-angle-right expand-collapse"></i></a>
					<ol id="reminderList" class="collapse">
						<?php
						foreach($reminders as $reminder)
						{
							$symbol = '';						
							if(!empty($reminder->due_date))
							{
								if(date('Y-m-d H:i') <= date('Y-m-d H:i',strtotime($reminder->due_date)) AND date('Y-m-d H:i',strtotime('12 hours')) >= date('Y-m-d H:i',strtotime($reminder->due_date)))
								{
									$symbol = '<i class="fa fa-exclamation-circle color-danger" data-toggle="popover" data-popover-class="color-danger" data-content="Action required by 8/28/16 at 9:00 pm"></i>';
								}
							}
							?>
							<li>
								<a href="#"><?php echo $reminder->text." ".$symbol ?><br>
								<span class="do-detail">
									<?php 
										if(!empty($reminder->brand_id))
										{
											echo get_brand_outlet_name($reminder->brand_id).' post '.date('m/d',strtotime($reminder->due_date));
										}
									?> 
									</span>
								<i class="fa fa-angle-right expand-collapse"></i></a>
							</li>
							
							<?php
						}
						?>					
					</ol>
				</li>
				<?php
			}
			?>
			<li><a href="#summaryList" class="pos-relative" data-toggle="collapse">Summary<i class="fa fa-angle-right expand-collapse"></i></a>
				<ul class="summary-list collapse" id="summaryList">
					<li>
						<i class="tf-icon-schedule tf-icon-circle bg-info pull-xs-left"></i>Scheduled Posts 
						<div class="pull-xs-right tag"><?php echo get_post_count_status($brand->id,'scheduled'); ?></div>
					</li>
					<li>
						<i class="fa fa-minus-circle color-warning pull-xs-left"></i>Pending Approval 
						<div class="pull-xs-right tag"><?php echo get_post_count_status($brand->id,'pending'); ?></div>
					</li>
					<li>
						<i class="tf-icon-ticktock tf-icon-circle bg-orange pull-xs-left"></i>Awaiting Scheduling 
						<div class="pull-xs-right tag"><?php echo get_post_count_status($brand->id,'approved'); ?></div>
					</li>
					<li>
						<i class="fa fa-pencil fa-custom-circle color-white bg-gray pull-xs-left"></i>Drafts 
						<div class="pull-xs-right tag"><?php echo get_post_count_status($brand->id,'draft'); ?></div>
					</li>
				</ul>
			</li>
			<li><a href="<?php echo base_url(); ?>approvals/approvals-menu/<?php echo $brand->slug; ?>" class="pos-relative">Approvals<i class="fa fa-angle-right expand-collapse"></i></a></li>
		</ul>
	</div>
</section>