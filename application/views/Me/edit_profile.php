<?php echo form_open(base_url().'me/update_user',array('method'=>'post','novalidate'=>"novalidate")); ?>
    <div class="form-group">
		<label for="firstName">First name</label>
		<input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" value="<?php echo set_value('first_name') ? set_value('first_name') : $user->first_name; ?>" >
		<?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="lastName">Last name</label>
		<input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name" value="<?php echo set_value('last_name') ? set_value('last_name') : $user->last_name; ?>" >
		<?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email') ? set_value('email') : $user->email; ?>" readonly>
	    <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" value="<?php echo set_value('phone') ? set_value('phone') : $user->phone; ?>" >
         <?php echo form_error('phone', '<div class="text-danger">', '</div>'); ?>
    </div>  
    <div class="form-group">
      	<label for="timezone">Timezone</label>
		<select name="timezone" id="timezone" class="form-control" >
      		<option value="">Select timezone</option>
		    <?php
		    foreach($timezones as $timezone)
		    {
		    	$selected = '';
		    	if($timezone->value == $user->timezone)
		    	{
		    		$selected = 'selected="selected"';
		    	}
		    	?>
		    	<option value="<?php echo $timezone->value ?>" <?php echo set_select('timezone', $timezone->value) ? set_select('timezone', $timezone->value) : $selected ; ?>><?php echo $timezone->timezone; ?></option>
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('timezone', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group danger">
		<label for="Username">Username</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username') ? set_value('username'): $user->name; ?>" readonly>
		<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="Password">Password</label>
		<input type="password" id="Password" name="password" class="form-control" placeholder="Password">
		<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>
   
    <div class="form-group">
		<label for="companyName">Company name</label>
		<input type="text" id="company_name" name="company_name" class="form-control" placeholder="Company name" value="<?php echo set_value('company_name') ? set_value('company_name') : $user->company_name; ?>" >		
    </div>

    <div class="form-group">
		<label for="companyEmail">Comapny email</label>
		<input type="email" id="company_email" name="company_email" class="form-control" placeholder="Company email" value="<?php echo set_value('company_email') ? set_value('company_email') : $user->company_email; ?>">		
		<?php echo form_error('company_email', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
		<label for="companyUrl">Comapny url</label>
		<input type="url" id="company_url" name="company_url" class="form-control" placeholder="Company url" value="<?php echo set_value('company_url') ? set_value('company_url') : $user->company_url; ?>" >
    </div>

    <button type="submit" class="btn btn-primary">Update</button>    
<?php echo form_close(); ?>