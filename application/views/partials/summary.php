<?php 
$summary_posts = get_summary($brand_id,'scheduled'); 

?>
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
					<li class="post-summary"><a href="<?php echo base_url().'calendar/day/'.$brand->slug; ?>"><i class="fa fa-<?php echo $post->outlet_name; ?>"><span class="bg-outlet bg-<?php echo $post->outlet_name; ?>"></span></i><?php echo date('H:i A',strtotime($post->slate_date_time)); ?><span class="excerpt-summary"><?php echo $post->content; ?></span></a></li>
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