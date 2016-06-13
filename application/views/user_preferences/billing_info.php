<div class="col-md-4 col-md-offset-4 text-xs-center">
	<div class="user-info">
		<?php 
			$this->load->view('user_preferences/preference_nav');
		?>
		<form action="" id="billing" novalidate>
			<div class="field-group">
				<label class="section-label" for="fullName">Full Name</label>
				<fieldset class="form-group">
					<input type="text" class="form-control" id="fullName" placeholder="Full Name" name="fullName">
				</fieldset>
			</div>
			<div class="field-group clearfix">
				<fieldset class="form-group float-md">
					<label class="section-label" for="ccNumber">Credit Card Number</label>
					<input type="number" class="form-control" id="ccNumber" placeholder="**** **** **** 1235" name="ccNumber">
				</fieldset>
				<fieldset class="form-group float-md">
					<label class="section-label" for="cvv">CVV</label>
					<input type="number" id="cvv" class="form-control" placeholder="***" name="cvv">
				</fieldset>
			</div>
			<div class="field-group clearfix">
				<fieldset class="form-group float-md">
					<label class="section-label" for="expMonth">Expiration Month</label>
					<select class="form-control" id="expMonth" name="expMonth">
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
					</select>
				</fieldset>
				<fieldset class="form-group float-md">
					<label class="section-label" for="expYear">Expiration Year</label>
					<select class="form-control" id="expYear" name="expYear">
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
					</select>
				</fieldset>
			</div>
			<div class="field-group clearfix">
				<fieldset class="form-group float-md">
					<label class="section-label" for="zip">Zip/Postal Code</label>
					<input type="text" class="form-control" id="zip" placeholder="11111" name="zip">
				</fieldset>
				<fieldset class="form-group float-md">
					<label class="section-label" for="expYear">Country</label>
					<select class="form-control" id="expYear" name="expYear">
						<option value="usa">United States</option>
					</select>
				</fieldset>
			</div>
			<button type="submit" class="btn btn-secondary btn-sm">Save Changes</button>
		</form>
	</div>
</div>
<div class="page-divider"></div>