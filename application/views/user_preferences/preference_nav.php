<div class="btn-group">
	<?php
	$segment = $this->uri->segment(2);
	$my_info = '';
	$plan = '';
	$billing = '';
	$role = '';
	$payment = '';
	switch ($segment) {
		case 'billing_info':
			$billing = 'active';
			break;
		case 'save_payment':
			$payment = 'active';
			break;
		case 'user_plan':
			$plan = 'active';
			break;
		case 'users':
			$role = 'active';
			break;
		default:
			$my_info = 'active';
			break;
	}
	?>
	<a href="<?php echo base_url()?>user_preferences/user_info" class="btn btn-sm <?php echo $my_info; ?>">My Info</a>
	<?php	
	// if($this->user_id == $this->user_data['account_id'])
	// {
		?>
		<a href="<?php echo base_url()?>user_preferences/user_plan" class="btn btn-sm <?php echo $plan; ?>">Plan</a>
		<a href="<?php echo base_url()?>user_preferences/billing_info" class="btn btn-sm <?php echo $billing; ?>">Billing</a>
		<a href="<?php echo base_url()?>user_preferences/users" class="btn btn-sm <?php echo $role; ?>">Account Users</a>
		<?php
	// }
	?>
</div>