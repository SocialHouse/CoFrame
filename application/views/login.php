<?php
echo form_open(base_url().'welcome',array('method'=>'post'));
?> 
	<h1>Login here</h1>
    <div class="form-group danger">
		<label for="Username">Username</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username'); ?>" >
		<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="Password">Password</label>
		<input type="password" id="Password" name="password" class="form-control" placeholder="Password">
		<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
    	<div class="image">
    		<?php echo $capcha; ?>
    	</div>    	
    </div>
    <div class="form-group">
		<a href="<?php echo base_url().'welcome/register'; ?>">Register</a> | <a href="<?php echo base_url().'welcome/forgot_password'; ?>">Forgot password</a>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
<?php echo form_close(); ?>