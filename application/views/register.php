<?php echo form_open(base_url().'welcome/save',array('method'=>'post','novalidate'=>"novalidate")); ?>
    <div class="form-group">
		<label for="firstName">First name</label>
		<input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" value="<?php echo set_value('first_name'); ?>" >
		<?php echo form_error('first_name', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="lastName">Last name</label>
		<input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name" value="<?php echo set_value('last_name'); ?>" >
		<?php echo form_error('last_name', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
	    <label for="email">Email</label>
	    <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>" >
	    <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" value="<?php echo set_value('phone'); ?>" >        
         <?php echo form_error('phone', '<div class="text-danger">', '</div>'); ?>
    </div>  
    <div class="form-group">
      	<label for="timezone">Timezone</label>
		<select name="timezone" id="timezone" class="form-control" >
      		<option value="">Select timezone</option>
		    <?php
		    foreach($timezones as $timezone)
		    {
		    	?>
		    	<option value="<?php echo $timezone->value ?>" <?php echo set_select('timezone', $timezone->value); ?>><?php echo $timezone->timezone; ?></option>
		    	<?php
		    }
		    ?>
		</select>
		<?php echo form_error('timezone', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group danger">
		<label for="Username">Username</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Email Address" value="<?php echo set_value('username'); ?>" >
		<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="Password">Password</label>
		<input type="password" id="Password" name="password" class="form-control" placeholder="Password">
		<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="confirm_password">Confirm password</label>
		<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm password" >		
		<?php echo form_error('confirm_password', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="companyName">Company name</label>
		<input type="text" id="company_name" name="company_name" class="form-control" placeholder="Company name" value="<?php echo set_value('company_name'); ?>" >		
    </div>
    <input type="hidden" name="dialcode" value="" id="dialcode"> 
    <div class="form-group">
		<label for="companyUrl">Comapny url</label>
		<input type="url" id="company_url" name="company_url" class="form-control" placeholder="Company url" value="<?php echo set_value('company_url'); ?>" >		
    </div>
     <div class="form-group">
		<a href="<?php echo base_url().'welcome'; ?>">Already have account</a>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>    
<?php echo form_close(); ?>