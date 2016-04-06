<div class="alert alert-danger payment-errors">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>    
</div>
<form action="<?php echo base_url().'payment/save_payment' ?>" method="POST" id="payment-form">
  	<div class="row">  		
		<div class="form-group col-md-12">
			<input type="hidden" name="billing_id" value="<?php echo set_value('billing_id') ? set_value('billing_id') : (isset($billing_details->id) ? $billing_details->id : '' ); ?>">
		    <label for="cc_number">CC number:</label>	    
		    <input type="text" placeholder="cc number" data-stripe="number" class="form-control" name="cc_number" id="cc_number" value="<?php echo set_value('cc_number') ? set_value('cc_number') : (isset($billing_details->cc_number) ? "************".$billing_details->cc_number : '' ); ?>" required>
	  	</div>
	  	<div class="form-group col-md-12">
	   		<label for="name_on_card">Name on card:</label>
	        <input type="text" placeholder="Name on card" class="form-control" name="name" id="name" data-stripe="name" value="<?php echo set_value('name') ? set_value('name') : (isset($billing_details->name) ? $billing_details->name : '' ); ?>">
	  	</div>	  
	  	<label for="expiry_month" class="col-md-12">Card expiry date:</label>
	  	<div class="form-group">	  		
	        <div class="col-md-6">
	        	<div class="form-group">
		            <select class="form-control" name="expiry_month" data-stripe="exp-month" id="expiry_month" required>
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
		        </div>
	        </div>
	        <div class="col-md-6">
	        	<div class="form-group">
		            <select class="form-control" name="expiry_year" data-stripe="exp-year" id="expiry_year" required>
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
		        </div>
	        </div>
	    </div>
	    <div class="form-group col-md-12">
	   		<label for="cvv">CVC:</label>
	        <input type="text" placeholder="cvc" class="form-control" name="cvc" id="cvc" data-stripe="cvc"  value="<?php echo set_value('cvc') ? set_value('cvc') : (isset($billing_details->cvc) ? $billing_details->cvc : '' ); ?>" required>
	  	</div>
	    <div class="form-group col-md-12">
	        <label for="billing_address">Billing address:</label>            
	        <!-- <textarea type="text" rows="4" placeholder="billing address" class="form-control" data-stripe="address-line1" name="billing_address" id="billing_address"></textarea> -->
	        <input type="text" placeholder="Billing address" name="address" id="address" data-stripe="address-line1" class="form-control" value="<?php echo set_value('address') ? set_value('address') : (isset($billing_details->address) ? $billing_details->address : '' ); ?>" >
	    </div>
	    <div class="form-group col-md-12">
	        <label for="city">City:</label>            
			<input type="text" placeholder="City" name="city" id="city" data-stripe="address-city" class="form-control" value="<?php echo set_value('city') ? set_value('city') : (isset($billing_details->city) ? $billing_details->city : '' ); ?>" >
	    </div>

	    <div class="form-group col-md-12">
			<label for="state">State:</label>
			<input type="text" placeholder="State" name="state" id="state" class="form-control" data-stripe="address-state" value="<?php echo set_value('state') ? set_value('state') : (isset($billing_details->state) ? $billing_details->state : '' ); ?>" >
		</div>

		<div class="form-group col-md-12">
	        <label for="zip">Zip:</label>
	        <input type="text" placeholder="Zip" name="zip" id="zip" class="form-control" data-stripe="address-zip" value="<?php echo set_value('zip') ? set_value('zip') : (isset($billing_details->zip) ? $billing_details->zip : '' ); ?>" >
	    </div>

	    <div class="form-group col-md-12">
	        <label for="country">Country:</label>
	        <input type="hidden" placeholder="Country" id="country" data-stripe="country" class="form-control" >
	        <select name="country" class="form-control" data-stripe="country" id="country_select">
	        	<option>Select country</option>
	        	<?php
	        	foreach($countries as $country)
	        	{
	        		$selected = '';
	        		if(isset($billing_details->country) AND ($country->name == $billing_details->country))
	        		{
	        			$selected = 'selected="selected"';
	        		}
	        		?>
	        		<option value="<?php echo $country->name; ?>" <?php echo set_select('country',$country->name)? set_select('country',$country->id) : $selected; ?>><?php echo $country->name; ?></option>
	        		<?php
	        	}
	        	?>
	        </select>
	    </div>
	    <div class="form-group col-md-12">
	        <label for="email">Email:</label>
	        <input type="email" placeholder="Email" name="email" id="email" class="form-control" value="<?php echo set_value('email') ? set_value('email') : (isset($billing_details->email) ? $billing_details->email : '' ); ?>" >
	    </div>
	    <div class="form-group col-md-12">
	        <label for="email">Plan:</label>	        
	        <div class="radio">
  				<label><input type="radio" name="plan" value="START-UP" <?php echo set_radio("plan","START-UP") ? set_radio("plan","START-UP") : ( (isset($plan) AND $plan === 'START-UP') ? 'checked="checked"'  : ''); ?> >START-UP</label>
			</div>
			<div class="radio">
  				<label><input type="radio" name="plan" value="BUSINESS" <?php echo set_radio("plan","BUSINESS") ? set_radio("plan","BUSINESS") : ( (isset($plan) AND $plan === 'BUSINESS') ? 'checked="checked"'  : ''); ?> >BUSINESS</label>
			</div>
			<div class="radio">
  				<label><input type="radio" name="plan" value="CORPORATE" <?php echo set_radio("plan","CORPORATE") ? set_radio("plan","CORPORATE") : ( (isset($plan) AND $plan === 'CORPORATE') ? 'checked="checked"'  : ''); ?> >CORPORATE</label>
			</div>
			<div class="radio">
  				<label><input type="radio" name="plan" value="PREMIERE" <?php echo set_radio("plan","PREMIERE") ? set_radio("plan","PREMIERE") : ( (isset($plan) AND $plan == 'PREMIERE') ? 'checked="checked"' : '' ); ?> >PREMIERE</label>
			</div>
	    </div>
	    <div class="form-group col-md-12">
	  		<button id="make_payment" class="btn btn-primary" type="button">Make Payment</button>
	  	</div>
	</div>
</form>