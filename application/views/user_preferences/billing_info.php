<?php
if(check_user_perm($this->user_id,'master') OR check_user_perm($this->user_id,'billing') OR $this->user_id == $this->user_data['account_id'] OR (isset($this->user_data['user_group']) AND ($this->user_data['user_group'] == 'Master Admin' OR $this->user_data['user_group'] == 'Billing')))
{
	?>
	<section id="user-preferences" class="page-main bg-white col-sm-12">
		<header class="page-main-header">
			<h1 class="center-title section-title">User Preferences</h1>
		</header>
		<div class="row">
			<div class="col-md-4 col-md-offset-4 text-xs-center">
				<div class="user-info">
					<?php 
						$this->load->view('user_preferences/preference_nav');
					?>
					<div class="alert alert-danger payment-errors">
					    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>    
					</div>
					<form action="<?php echo base_url().'user_preferences/save_payment'; ?>" id="payment-form" method="post">
						<input type="hidden" name="plan" value="<?php echo get_plan($this->user_data['account_id']); ?>">
						<input type="hidden" name="email" value="<?php echo $this->email; ?>" >
						<input type="hidden" name="billing_id" value="<?php echo set_value('billing_id') ? set_value('billing_id') : (isset($billing_details->id) ? $billing_details->id : '' ); ?>">
						
						<div class="field-group">
							<label class="section-label" for="fullName">Full Name</label>
							<fieldset class="form-group">
								<input type="text" class="form-control" id="fullName" placeholder="Full Name" name="name" data-stripe="name" value="<?php echo set_value('name') ? set_value('name') : (isset($billing_details->name) ? $billing_details->name : '' ); ?>">
							</fieldset>
						</div>
						<div class="field-group clearfix">
							<fieldset class="form-group float-md">
								<label class="section-label" for="ccNumber">Credit Card Number</label>
								<input type="text" class="form-control" data-stripe="number" id="ccNumber" placeholder="**** **** **** 1235" name="cc_number" value="<?php echo set_value('cc_number') ? set_value('cc_number') : (isset($billing_details->cc_number) ? "************".$billing_details->cc_number : '' ); ?>">
							</fieldset>
							<fieldset class="form-group float-md">
								<label class="section-label" for="cvv">CVV</label>
								<input type="text" id="cvv" class="form-control" placeholder="***" name="cvc" data-stripe="cvc" value="<?php echo set_value('cvc') ? set_value('cvc') : (isset($billing_details->cvc) ? $billing_details->cvc : '' ); ?>">
							</fieldset>
						</div>
						<div class="field-group clearfix">
							<fieldset class="form-group float-md">
								<label class="section-label" for="expMonth">Expiration Month</label>
								<select class="form-control" data-stripe="exp-month" name="expiry_month">
									<option value="">Month</option>
					                <?php
					                for($i=1; $i<=12; $i++)
					                {	                	

					                	$month = $i;                	

					                	$selected = '';
					                	if(isset($billing_details->exp_month) AND $billing_details->exp_month == $i)
					                	{
					                		$selected = 'selected="selected"';
					                	}
					                  	if($month < 10)
					                  	{
					                    	$month = "0".$month;
					                  	}
					                  	?>
					                  	<option <?php echo set_select("expiry_month", $month) ? set_select("expiry_month", $month): $selected; ?> value="<?php echo $month ?>"><?php echo $month ?></option>
					                  	<?php
					                }
					                ?>
								</select>
							</fieldset>
							<fieldset class="form-group float-md">
								<label class="section-label" for="expYear">Expiration Year</label>
								<select class="form-control" id="expYear" name="expiry_year" data-stripe="exp-year">
									<option value="">Year</option>
									<?php
					                for($i=0; $i<12; $i++)
					                {
						                $year = date('Y', strtotime('+'.$i.' years'));
						                
						                $selected = '';
					                	if(isset($billing_details->exp_year) AND $billing_details->exp_year == $year)
					                	{
					                		$selected = 'selected="selected"';
					                	}
						               	?>		               	
						               	<option <?php echo set_select("expiry_year", $year) ? set_select("expiry_year", $year) : $selected; ?> value="<?php echo $year ?>"><?php echo $year ?></option>
						                <?php
					                }
					                ?>
								</select>
							</fieldset>
						</div>
						<div class="field-group clearfix">
							<fieldset class="form-group float-md">
								<label class="section-label" for="zip">Zip/Postal Code</label>
								<input type="text" class="form-control" id="zip" placeholder="11111" name="zip" data-stripe="address-zip" value="<?php echo set_value('zip') ? set_value('zip') : (isset($billing_details->zip) ? $billing_details->zip : '' ); ?>">
							</fieldset>
							<fieldset class="form-group float-md">
								<label class="section-label" for="country">Country</label>
								<select class="form-control" id="country" data-stripe="country" name="country">
									<option value="">-- Select Country --</option>
									<?php 
									if(!empty($countries))
									{
										foreach ($countries as $country) 
										{
											$selected = '';
							        		if(isset($billing_details->country) AND ($country->name == $billing_details->country))
							        		{
							        			$selected = 'selected="selected"';
							        		}
							        		?>
											<option value="<?php echo $country->name; ?>"><?php echo $country->name; ?></option>;
											<?php
										}
									}
									?>
								</select>
							</fieldset>
						</div>
						<button id="make_payment" type="button" class="btn btn-secondary btn-sm">Save Changes</button>
					</form>
				</div>
			</div>
			<div class="page-divider"></div>
		</div>
	</section>
	<?php
}
else
{	
	$this->load->view('user_preferences/no_perm_user_prefrance');
}
?>
