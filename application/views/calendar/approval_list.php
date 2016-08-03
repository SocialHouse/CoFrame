
<?php 
if(!empty($approved)){
	?>
	<h5>Approved By:</h5>
	<ul class="timeframe-list approval-list">
	<?php 
		foreach ($approved as $phase) {
			$name = '';
			if(!empty($current_phase->first_name)){
				$name = ucfirst($current_phase->first_name);
				if(!empty($current_phase->last_name)){
					$name = $name.' '.ucfirst(substr($current_phase->last_name, 0, 1));
				}
			}
			?>
			<li class="approved">
				<div class="pull-sm-left"><img width="36" height="36" class="circle-img" alt="<?php echo $name; ?>" src="http://localhost/timeframe_server/assets/images/default_profile.jpg" /></div>
				<div class="pull-sm-left">Norel M</div>
			</li>			
			<?php
		}
	?>
	</ul>
	<?php
	}
?>
<?php 
if(!empty($pending)){
	?>
	<h5>Pending:</h5>
	<ul class="timeframe-list approval-list">
	<?php 
		foreach ($pending as $current_phase) {
			$name = '';
			if(!empty($current_phase->first_name)){
				$name = ucfirst($current_phase->first_name);
				if(!empty($current_phase->last_name)){
					$name = $name.' '.ucfirst(substr($current_phase->last_name, 0, 1));
				}
			}
			?>
			<li class="pending">
				<div class="pull-sm-left">
				<?php
					$image_path = img_url().'default_profile.jpg';
					if(file_exists(upload_path().$this->user_data['img_folder'].'/users/'.$current_phase->user_id.'.png'))
					{
						$image_path = upload_url().$this->user_data['img_folder'].'/users/'.$current_phase->user_id.'.png';
					}
				?>
				<img width="36" height="36" class="circle-img" alt="<?php echo $name; ?>" src="<?php echo $image_path; ?>" />
				</div>
				<div class="pull-sm-left"><?php echo $name; ?></div>
			</li>		
			<?php
		}
	?>
	</ul>	
	<?php
	}
?>