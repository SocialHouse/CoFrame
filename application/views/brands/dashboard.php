<?php $this->load->view('partials/brand_nav'); ?>

<input type="hidden" id="brand_id" value="<?php echo $brand_id; ?>">
<input type="hidden" id="brand_slug" value="<?php echo $brand->slug; ?>">
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header">
		<h1 class="center-title section-title">Brand Dashboard</h1>
		<div class="date-header header-w-search clearfix">
			<h2 class="pull-md-left"><strong><?php echo date('F'); ?></strong> <?php echo date('d') . ", " . date('Y'); ?></h2>
			<div class="pull-md-right toolbar hidden-print">
				<?php $this->load->view('partials/search_form'); ?>
			</div>
		</div>
	</header>
	<div class="row equal-columns">
		<div class="col-sm-6 equal-height">
			<div class="container-reminder-list">
				<h3>Reminders <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>

				<ul class="reminder-list timeframe-list">
					<?php
					if(!empty($reminders))
					{
						foreach($reminders as $reminder)
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
								<a data-modal-size="lg" data-modal-id="edit-request-modal" data-toggle="modal-ajax" data-clear="yes" href="#" data-modal-src="<?php echo base_url()."edit-request-modal/".$reminder->post_id ;?>"> <?php echo $reminder->text." ".$symbol ?></a>
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
		<div class="col-sm-3 equal-height">
			<div class="container-summary-list border-top border-gray-lighter bg-gray-lightest padding-2rem">
				<h3>Total Summary <i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard."></i></h3>

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
		<div class="col-sm-3 equal-height">
			<?php
			$this->load->view('partials/summary');
			?>
			</div>
	</div>
</section>