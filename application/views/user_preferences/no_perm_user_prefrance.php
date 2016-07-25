<section id="user-preferences" class="page-main bg-white col-sm-12">
	<header class="page-main-header">
		<?php
		if(!empty($access_denied_msg))
		{
			?>
			<h1 class="center-title section-title"><?php echo $access_denied_msg; ?></h1>	
			<?php
		}
		else
		{
			?>
			<h1 class="center-title section-title">You don't have access to this page</h1>
			<?php
		}
		?>
	</header>
	
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-xs-center">
			<div class="user-info">
				<div class="btn-group">
					<?php
					$segment = $this->uri->segment(2);
					$my_info = '';
					$plan = '';
					$billing = '';
					switch ($segment) {
						case 'billing_info':
							$billing = 'active';
							break;
						case 'save_payment':
							$billing = 'active';
							break;
						case 'user_plan':
							$plan = 'active';
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
						<?php
					// }
					?>
				</div>
				<div>
					You dont have access to this page
				</div>
			</div>
		</div>
	</div>
</section>
	