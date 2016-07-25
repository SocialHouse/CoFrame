<?php
if(check_user_perm($this->user_id,'master') OR check_user_perm($this->user_id,'billing') OR $this->user_id == $this->user_data['account_id'])
{
	?>
	<section id="user-preferences" class="page-main bg-white col-sm-12">
		<header class="page-main-header">
			<h1 class="center-title section-title">User Preferences</h1>
		</header>
		<div class="row">
			<form id="payment_form" method="post" action="<?php echo base_url();?>user_preferences/change-plan">
				<input type="hidden" name="plan" id="selected_plan">
				<input type="hidden" id="billing_id" name="billing_id" value="<?php echo set_value('billing_id') ? set_value('billing_id') : (isset($billing_details->id) ? $billing_details->id : '' ); ?>">
				<div class="col-lg-8 col-sm-10 center-block text-xs-center">
					<?php 
						$this->load->view('user_preferences/preference_nav');
					?>
					<?php 
					$start_up = '';
					$business = '';
					$corporate = '';
					$premiere = '';
					if(!empty($user_details)){
						$selected_plan = strtolower(get_plan($this->user_data['account_id']));
					}
					switch ($selected_plan) {
					case 'business':
						$business = 'active-plan';
						break;
					case 'start-up':
						$start_up = 'active-plan';
						break;
					case 'corporate':
						$corporate = 'active-plan';
						break;
					default:
						$premiere = 'active-plan';
						break;
				}
				//echo '<pre>'; print_r($user_details);echo '</pre>';
				?>

					<div class="row table">
						<div class="col-md-3 text-center col-sm-6 table-cell pricing-details <?php echo $start_up; ?>">
							<header class="price-title">
								<h2>Start-Up</h2>
								<h3>$99 <small>per month</small></h3>
							</header>
							<ul>
								<li>Lorem ipsum dolor sit</li>
								<li>Amet consectetur</li>
								<li>Adipiscing elit sed do euis</li>
								<li>Mod tempor incididunt</li>
							</ul>
							<?php 
								if(!empty($start_up))
								{
									?>
									<a class="btn btn-secondary btn-sm btn-choose-plan btn-disabled" data-plan="START-UP" data-price="$99.00">Active</a>
									<?php
								}
								else
								{
									?>
									<a class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="START-UP" data-price="$99.00">Select</a>
									<?php
								}
							?>
						</div>
						<div class="col-md-3 text-center col-sm-6 table-cell pricing-details <?php echo $business; ?>">	

							<header class="price-title">
								<h2>Business</h2>
								<h3>$199 <small>per month</small></h3>
							</header>
							<ul>
								<li>Lorem ipsum dolor sit</li>
								<li>Amet consectetur</li>
								<li>Adipiscing elit sed do euis</li>
								<li>Mod tempor incididunt</li>
								<li>Ut labore et dolore magn</li>
							</ul>

							<?php 
								if(!empty($business))
								{
									?>
									<a class="btn btn-secondary btn-sm btn-choose-plan btn-disabled" data-plan="BUSINESS" data-price="$199.00">Active</a>
									<?php
								}
								else
								{
									?>
										<a class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="BUSINESS" data-price="$199.00">Select</a>
									<?php
								}
							?>	
						</div>
						<div class="col-md-3 text-center col-sm-6 table-cell pricing-details <?php echo $corporate; ?>">
							<header class="price-title">
								<h2>Corporate</h2>
								<h3>$299 <small>per month</small></h3>
							</header>
							<ul>
								<li>Lorem ipsum dolor sit</li>
								<li>Amet consectetur</li>
								<li>Adipiscing elit sed do euis</li>
								<li>Mod tempor incididunt</li>
								<li>ut labore et dolore magn</li>
								<li>aliqua ut enim ad minim</li>
							</ul>
							<?php 
								if(!empty($corporate))
								{
									?>
									<a class="btn btn-secondary btn-sm btn-choose-plan btn-disabled" data-plan="CORPORATE" data-price="$299.00">Active</a>
									<?php
								}
								else
								{
									?>
										<a class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="CORPORATE" data-price="$299.00">Select</a>
									<?php
								}
							?>
						</div>
						<div class="col-md-3 text-center col-sm-6 table-cell pricing-details <?php echo $premiere; ?>">
							<header class="price-title">
								<h2>Premiere</h2>
								<h3>$499 <small>per month</small></h3>
							</header>
							<ul>
								<li>Lorem ipsum dolor sit</li>
								<li>Amet consectetur</li>
								<li>Adipiscing elit sed do euis</li>
								<li>Mod tempor incididunt</li>
								<li>ut labore et dolore magn</li>
								<li>aliqua ut enim ad minim</li>
								<li>veniam quis nostrud</li>
							</ul>

							<?php 
								if(!empty($premiere))
								{
									?>
									<a class="btn btn-secondary btn-sm btn-choose-plan btn-disabled" data-plan="PREMIERE" data-price="$499.00">Active</a>
									<?php
								}
								else
								{
									?>
										<a class="btn btn-secondary btn-sm btn-choose-plan change_plan" data-plan="PREMIERE" data-price="$499.00">Select</a>
									<?php
								}
							?>
						</div>
					</div>

				</div>
			</form>
		</div>
	</section>
<?php
}
else
{	
	$this->load->view('user_preferences/no_perm_user_prefrance');
}
?>

