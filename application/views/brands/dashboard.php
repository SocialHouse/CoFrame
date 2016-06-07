<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">Brand Dashboard</h1>
		<h2 class="date-header"><strong><?php echo date('F'); ?></strong> <?php echo date('d') . ", " . date('Y'); ?></h2>
	</header>
	<div class="row equal-cols">
		<div class="col-md-6">
			<div class="container-reminder-list">
				<h3>Reminders <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
				
				<ul class="reminder-list timeframe-list">
					<?php
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
		</div>
		<div class="col-md-3">
			<div class="container-summary-list border-top border-gray-lighter bg-gray-lightest padding-2rem">
				<h3>Total Summary <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>
				
				<ul class="summary-list timeframe-list">
					<li><i class="fa fa-check-circle color-info"></i>Scheduled Posts <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'schecduled'); ?></div></li>
					<li><i class="fa fa-check-circle color-success"></i>Posted <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'posted'); ?></div></li>
					<li><i class="fa fa-minus-circle color-warning"></i>Pending Approval <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'pending'); ?></div></li>
					<li><i class="fa fa-pencil fa-custom-circle color-white bg-gray"></i>Drafts <div class="pull-sm-right"><?php echo get_post_count_status($brand->id,'draft'); ?></div></li>
				</ul>
			</div>
		</div>
		<div class="col-md-3">
			<div class="calendar-summary bg-gray-dark">
				<div id="calendar"></div>
				<div class="today-summary">
					<?php
					if(!empty($summary_posts))
					{
						?>
						<h5 class="border-title"><span>Summary</span></h5>
						<ul class="timeframe-list calendar-list outlet-list">
							<?php
							foreach($summary_posts as $post)
							{
								?>
								<li class="post-summary"><i class="fa fa-<?php echo $post->outlet_name; ?>"><span class="bg-outlet bg-<?php echo $post->outlet_name; ?>"></span></i><?php echo date('H:i A',strtotime($post->slate_date_time)); ?><span class="excerpt-summary"><?php echo $post->content; ?></span></li>
								<?php
							}
							?>
						</ul>
						<?php
					}
					?>	
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>