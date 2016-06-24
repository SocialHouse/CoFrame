<?php
$checked = '';
$password = '';
$username = '';
$user_pass=$this->input->cookie('user_pass', TRUE);
$user_name=$this->input->cookie('user_name', TRUE);
if((isset($user_pass) && !empty($user_pass)) && (isset($user_name) && !empty($user_name))){
    $checked='checked="checked"';
    $username = $user_name;
    $password = $user_pass;
}

echo form_open(base_url().'welcome',array('method'=>'post'));
?> 
	<h1>Login here</h1>
    <div class="form-group danger">
		<label for="Username">Username</label>
		<input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo set_value('username')? set_value('username') : $username; ?>" >
		<?php echo form_error('username', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
		<label for="Password">Password</label>
		<input type="password" id="Password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('user_pass',$user_pass); ?>" >
		<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>
    <div class="form-group">
    	<div class="image">
    		<?php echo $capcha; ?>
    	</div>    	
    </div>

    <div class="form-group">
        <label class="checkbox-inline">
            <input type="checkbox" <?php echo $checked; ?> name="remember_me" value="remember_me" >Remember me
        </label>
    </div>

    <div class="form-group">
		<a href="<?php echo base_url().'welcome/register'; ?>">Register</a> | <a href="<?php echo base_url().'welcome/forgot_password'; ?>">Forgot password</a>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
<?php echo form_close(); ?>