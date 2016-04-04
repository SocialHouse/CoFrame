<?php
echo form_open(base_url().'welcome/reset_password',array('method'=>'post'));
?> 
	<h1>Reset password</h1>
    <div class="form-group danger">
		<label for="Username">Email</label>
		<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>" >
		<?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
    </div>   
    <div class="form-group">
		<a href="<?php echo base_url().'welcome'; ?>">Login</a>
    </div>
    <button type="submit" class="btn btn-primary">Reset</button>
<?php echo form_close(); ?>