<?php
echo form_open(base_url().'welcome/save_password',array('method'=>'post'));
?> 
	<h1>Change password</h1>
	<input type="hidden" name="token" value="<?php echo !empty(set_value('token')) ? set_value('token') : $token; ?>" >
    <div class="form-group">
		<label for="Password">Password</label>
		<input type="password" id="Password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>" >
		<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="confirmPassword">Confirm Password</label>
		<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php echo set_value('confirm_password') ?>" >		
		<?php echo form_error('confirm_password', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<a href="<?php echo base_url().'welcome/register'; ?>">Login</a>
    </div>
    <button type="submit" class="btn btn-primary">Reset</button>
<?php echo form_close(); ?>