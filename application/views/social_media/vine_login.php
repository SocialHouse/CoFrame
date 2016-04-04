<?php
echo form_open(base_url().'social_media/vine',array('method'=>'post'));
?> 
	<h1>Login to Vine</h1>
    <div class="form-group danger">
		<label for="email">Email</label>
		<input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email'); ?>" >
		<?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="Password">Password</label>
		<input type="password" id="Password" name="password" class="form-control" placeholder="Password">
		<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>    
    <button type="submit" class="btn btn-primary">Login</button>
<?php echo form_close(); ?>