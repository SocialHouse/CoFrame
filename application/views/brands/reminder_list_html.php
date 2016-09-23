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
					?>
					<a class="reminders" data-brand-id="<?php echo $reminder->brand_id; ?>" data-reminder-id="<?php echo $reminder->id; ?>" data-modal-size="lg" data-modal-id="edit-request-modal" data-toggle="modal-ajax" data-clear="yes" href="#" data-modal-src="<?php echo base_url()."edit-request-modal/".$reminder->post_id ;?>"> <?php echo $reminder->text." ".$symbol ?></a>
					<?php
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
						?>
						<a class="reminders" data-brand-id="<?php echo $reminder->brand_id; ?>" data-reminder-id="<?php echo $reminder->id; ?>" data-modal-size="lg" data-modal-id="edit-request-modal" data-toggle="modal-ajax" data-clear="yes" href="#" data-modal-src="<?php echo base_url()."edit-request-modal/".$reminder->post_id ;?>"> <?php echo $reminder->text." ".$symbol ?></a>
						<?php
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