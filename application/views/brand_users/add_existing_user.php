<?php echo form_open(base_url().'brands/save-existing-user',array('method'=>'post','enctype' => 'multipart/form-data')); ?>
	<h2>Add user for: <?php echo $brand_name; ?></h2>	

	<input type="hidden" name="brand_id" value="<?php echo set_value('brand_id') ? set_value('brand_id') : $brand_id; ?>">

    <div class="form-group">
      	<label for="permission">Users</label>
		<select name="user" id="user" class="form-control" >
      		<option value="">Select user</option>
		    <?php
		    foreach($existing_users as $user)
		    {
		    	?>
		    	<option value="<?php echo $user->access_user_id ?>" <?php echo set_select('permission', $user->access_user_id); ?>><?php echo ucfirst($user->first_name).' '.ucfirst($user->last_name); ?></option>
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('permission', '<div class="text-danger">', '</div>'); ?>
    </div>   

    <button type="submit" class="btn btn-primary">Add</button>    

<?php echo form_close(); ?>