<p>To edit Approvers, please login to your account on a desktop computer.</p>
<?php
if(!empty($phases))
{ 
	$phase_num_array = array('0' => 'one','1'=>'two','2'=>'three');
	$phase_count = count($phases);
	foreach ($phases as $phase_no => $obj) 
	{
		$class = 'inactive';
		$user_list = 'data-toggle="popover-ajax" data-content-src="'.base_url().'brands/get_brand_users/'.$post_details->brand_id.'"';
		$phase_no -- ;
		?>
		<div class="bg-white approval-phase saved-phase animated fadeIn" id="preview_edit_approvalPhase<?php echo $phase_no + 1;?>" data-id="<?php  echo $phase_no;?>">
			<h2 class="clearfix">Phase <?php echo $phase_no + 1;?>
			</h2>
			<ul class="timeframe-list user-list approval-list border-bottom clearfix">
				<?php
				foreach($obj as $user)
				{
					$image_path = img_url().'default_profile.jpg';
					if(file_exists(upload_path().$user->img_folder.'/users/'.$user->user_id.'.png'))
					{
						$image_path = upload_url().$user->img_folder.'/users/'.$user->user_id.'.png';
					}
					?>
					<li class="pull-xs-left <?php echo $user->status; ?>">
						<input type="checkbox" name="phase[<?php echo $phase_no;?>][approver][]" value="<?php echo $user->user_id; ?>" checked="checked" class="hidden-xs-up approvers">

						<img width="36" height="36" class="circle-img" src="<?php echo $image_path; ?>" data-id="<?php echo $user->user_id; ?>"  alt="<?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?>" data-toggle="popover-hover" data-content="<?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?>">
					</li>
					<?php
				}
				?>
			</ul>

			<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_date]" class="phase-date-time-input" value="<?php echo date('m/d/Y' , strtotime($obj[0]->approve_by))?>" />
			<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_hour]" class="hour-select" value="<?php echo date('h' , strtotime($obj[0]->approve_by))?>" />
			<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_minute]" class="minute-select" value="<?php echo date('i' , strtotime($obj[0]->approve_by))?>" />
			<input type="hidden" name="phase[<?php echo $phase_no;?>][approve_ampm]" class="amselect" value="<?php echo date('A' , strtotime($obj[0]->approve_by))?>" />
			<input type="hidden" name="phase[<?php echo $phase_no;?>][time_zone]" class="zone" value="<?php echo $obj[0]->time_zone; ?>" />		
			<textarea name="phase[<?php echo $phase_no;?>][note]" class="note hide"><?php echo nl2br($obj[0]->note); ?></textarea>

			<div class="approval-date">
				<span class="uppercase">Must approve by:</span> 
				<span class="date-preview"> <?php echo date('m/d/y',strtotime($obj[0]->approve_by)); ?> 
				</span> 
				<span class="time-preview">at 
					<span class="hour-preview">
						<?php  echo ' '.date('h',strtotime($obj[0]->approve_by)); ?>
					</span>:
					<span class="minute-preview">
						<?php  echo date('i',strtotime($obj[0]->approve_by)); ?>
					</span> 
					<span class="ampm-preview">
						<?php  echo ' '.date('A',strtotime($obj[0]->approve_by)); ?>
					</span>
				</span>

				<!-- <span class="uppercase">Must approve by:</span> <span class="date-preview"><?php echo date('m/d/y',strtotime($obj[0]->approve_by)); ?></span> <span class="time-preview"><?php  echo ' '.date('\a\t h:i A',strtotime($obj[0]->approve_by)); ?></span> -->
			</div>
			<?php
			if(!empty($obj[0]->note))
			{
			?>
				<div class="approval-note">
					NOTE: <?php echo nl2br($obj[0]->note); ?>
				</div>
			<?php
			}
			else
			{
			?>
				<div class="approval-note">		
				</div>
			<?php
			}
			?>	
		</div>
		<?php
	}
}
?>