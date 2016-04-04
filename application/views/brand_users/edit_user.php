<?php echo form_open(base_url().'brand_users/update_user',array('method'=>'post')); ?>

	<input type="hidden" name="brand_map_id" value="<?php echo set_value('brand_map_id') ? set_value('brand_map_id') : (isset($brand_map_id) ? $brand_map_id : '' ); ?>">
	<input type="hidden" name="user_id" value="<?php echo set_value('user_id') ? set_value('user_id') : (isset($user->id) ? $user->id : '' ); ?>">

    <div class="form-group">
		<label for="firstName">First name</label>		
		<input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" value="<?php echo set_value('first_name') ? set_value('first_name') : (isset($user->first_name) ? $user->first_name : '' ); ?>" >
		<?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="lastName">Last name</label>
		<input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name" value="<?php echo set_value('last_name') ? set_value('last_name') : (isset($user->last_name) ? $user->last_name : '' ); ?>" >
		<?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="title">Title(optional)</label>
		<input type="text" id="title" name="title" class="form-control" placeholder="Title(optional)" value="<?php echo set_value('title') ? set_value('title') : (isset($user->title) ? $user->title : '' ); ?>" >		
    </div>

    <div class="form-group">
    	<label for="email">Email</label>
	    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email') ? set_value('email') : (isset($user->email) ? $user->email : '' ); ?>" readonly>
	    <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
    </div>
   
    <div class="form-group">
      	<label for="permission">Permission</label>
		<select name="permission" id="permission" class="form-control" >
      		<option value="">Select permission</option>
		    <?php
		    foreach($permissions as $permission)
		    {
		    	$selected = '';
		    	if($permission->id == $current_perm[0]->group_id)
		    	{
		    		$selected = 'selected="selected"';
		    	}
		    	?>
		    	<option value="<?php echo $permission->id ?>" <?php echo set_select('permission', $permission->id) ? set_select('permission', $permission->id) : $selected; ?> ><?php echo $permission->name; ?></option>m
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('permission', '<div class="text-danger">', '</div>'); ?>
    </div>

	<div class="form-group">
		<label for="Username">Username</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username') ? set_value('username') : (isset($user->name) ? $user->name : '' ); ?>" readonly>
		<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
	</div>  
    
    <button type="submit" class="btn btn-primary">Update</button>    
<?php echo form_close(); ?>