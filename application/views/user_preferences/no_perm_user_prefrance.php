<section id="user-preferences" class="page-main bg-white col-sm-12">
	<div class="relative-wrapper">
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
			<div class="col-sm-4 col-sm-offset-4 text-xs-center">
				<div class="user-info">
					<div class="btn-group-background">
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
					<div>
						You dont have access to this page
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('partials/footer_nav'); ?>
	</div>
</section>
	