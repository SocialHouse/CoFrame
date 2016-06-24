<?php echo form_open(base_url().'brand_users/save_user',array('method'=>'post','enctype' => 'multipart/form-data')); ?>
	<h2>Add user for: <?php echo $brand_name; ?></h2>

	<div class="form-group">
	    <label for="profile_pic">Upload photo</label>	   
	    <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
	</div>	

    <div class="form-group">
		<label for="first_name">First name</label>
		<input type="hidden" name="brand_id" value="<?php echo set_value('brand_id') ? set_value('brand_id') : $brand_id; ?>">
		<input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" value="<?php echo set_value('first_name') ? set_value('first_name') : (isset($user->first_name) ? $user->first_name : '' ); ?>" >
		<?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="last_name">Last name</label>
		<input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name" value="<?php echo set_value('last_name') ? set_value('last_name') : (isset($user->last_name) ? $user->last_name : '' ); ?>" >
		<?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="title">Title(optional)</label>
		<input type="text" id="title" name="title" class="form-control" placeholder="Title(optional)" value="<?php echo set_value('title') ? set_value('title') : (isset($user->title) ? $user->title : '' ); ?>" >		
    </div>

    <div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email') ? set_value('email') : (isset($user->email) ? $user->email : '' ); ?>" >
	    <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
      	<label for="permission">Permission</label>
		<select name="permission" id="permission" class="form-control" >
      		<option value="">Select permission</option>
		    <?php
		    foreach($permissions as $permission)
		    {
		    	?>
		    	<option value="<?php echo $permission->id ?>" <?php echo set_select('permission', $permission->id); ?>><?php echo $permission->name; ?></option>
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('permission', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group danger">
		<label for="Username">Username</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username') ? set_value('username') : (isset($user->username) ? $user->username : '' ); ?>" >
		<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
    </div>

    <?php
    if(!empty($brand_outlets))
    {
	    ?>
	    <div class="form-group danger">
			<label for="Username">Outlets</label><br/>
			<?php
	    	foreach($brand_outlets as $outlet)
	    	{
	    		?>
	    		<label class="checkbox-inline">
	      			<input type="checkbox" name="outlets[]" value="<?php echo $outlet->outlet_id; ?>"><?php echo $outlet->outlet_name; ?>
			    </label>
	    		<?php
	    	}
	    	?>
		    	<?php echo form_error('outlets[]', '<div class="text-danger">', '</div>'); ?>
	    </div>
	<?php
	}
	?>

    <button type="submit" class="btn btn-primary">Add</button>    

<?php echo form_close(); ?>