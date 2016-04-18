<?php echo form_open(base_url().'phases/save',array('method'=>'post')); ?>

	<h2>Add phase: <?php echo $next_phase; ?></h2>
	<div class="form-group">
		<input type="hidden" name="phase" value="<?php echo $next_phase; ?>">
		<input type="hidden" name="brand_id" value="<?php echo $brand_id; ?>">
    	<?php
    	if(!empty($users))
    	{
	    	foreach($users as $user)
	    	{
	    		?>
		    	<label class="checkbox-inline">
		      		<input type="checkbox" name="users[]" value="<?php echo $user->aauth_user_id; ?>" <?php echo set_checkbox('users',$user->aauth_user_id); ?>><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?>
				</label>					
		    	<?php

		    }
		}
	    echo form_error('users[]', '<div class="text-danger">', '</div>'); 
	    ?>
   		
	</div>
    <button type="submit" class="btn btn-primary">Add</button>    

<?php echo form_close(); ?>