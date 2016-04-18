<?php echo form_open(base_url().'phases/update',array('method'=>'post')); ?>	
	<h2>Edit phase: <?php echo isset($phase_data->phase) ? $phase_data->phase: $phase_number; ?></h2>
	<div class="form-group">
		<input type="hidden" name="phase_number" value="<?php echo set_value('phase_number') ? set_value('phase_number') : (isset($phase_data->phase) ? $phase_data->phase : ''); ?>">
		<input type="hidden" name="phase" value="<?php echo set_value('phase') ? set_value('phase') : (isset($phase_data->id) ? $phase_data->id : ''); ?>">
		<input type="hidden" name="brand_id" value="<?php echo set_value('brand_id') ? set_value('brand_id') : (isset($phase_data->brand_id) ? $phase_data->brand_id : ''); ?>">
    	<?php
    	if(!empty($users))
    	{
	    	foreach($users as $user)
	    	{
	    		$checked = '';
	    		if(in_array($user->aauth_user_id,$selected_users))
	    		{
	    			$checked = 'checked="checked"';
	    		}
	    		?>
		    	<label class="checkbox-inline">
		      		<input type="checkbox" <?php echo set_select('users', $user->aauth_user_id) ? set_select('users', $tag->id) : $checked; ?> name="users[]" value="<?php echo $user->aauth_user_id; ?>" <?php echo set_checkbox('users',$user->aauth_user_id); ?>><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
				</label>					
		    	<?php

		    }
		}
	    echo form_error('users[]', '<div class="text-danger">', '</div>'); 
	    ?>
   		
	</div>
    <button type="submit" class="btn btn-primary">Update</button>    

<?php echo form_close(); ?>