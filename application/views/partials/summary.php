<?php 
$summary_posts = get_summary($brand_id);

?>
	<div class="calendar-summary bg-gray-dark">
	<form action="<?php echo base_url().'calendar/day/'.$brand->slug; ?>" id="summary-form" method="post">
		<input type="hidden" name="selected_date" id="selected_date" value="">
		<div id="calendar"></div>
		<div class="today-summary">
			<h5 class="border-title"><span>Summary</span></h5>
			<ul class="timeframe-list calendar-list outlet-list summary-posts">			
				<?php
				if(!empty($summary_posts))
				{
					foreach($summary_posts as $post)
					{
						?>
						<li class="post-summary"><a class="got-to-calender" data-post-date="<?php echo date('Y-m-d',strtotime($post->slate_date_time)); ?>" data-post_id="<?php echo $post->id; ?>" href="<?php echo base_url().'calendar/day/'.$brand->slug; ?>"><i class="fa fa-<?php echo strtolower($post->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($post->outlet_name); ?>"></span></i><?php echo date('g:i A',strtotime($post->slate_date_time)); ?><span class="excerpt-summary"><?php echo $post->content; ?></span></a></li>
						<?php
					}
				}
				else
				{
					?>
					<li class="post-summary">No summary on this date</li>
					<?php
				}
				?>
			</ul>
		</div>
	</form>
	</div>