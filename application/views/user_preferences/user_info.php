

<div class="col-md-4 col-md-offset-4 text-xs-center">
	<div class="user-info">
		<?php 
			$this->load->view('user_preferences/preference_nav');
		?>
		<form action="" id="user_info" novalidate>
			<img src="<?php echo img_url()?>fpo/norel.jpg" alt="Norel Mancuso" class="circle-img user-img">
			<label class="section-label">Personal Info</label>
			<div class="field-group">
				<div class="clearfix">
					<fieldset class="form-group float-md">
						<label class="sr-only" for="firstName">First Name</label>
						<input type="text" class="form-control" id="firstName" placeholder="First Name" name="first_name">
					</fieldset>
					<fieldset class="form-group float-md">
						<label class="sr-only" for="lastName">Last Name</label>
						<input type="text" class="form-control" id="lastName" placeholder="Last Name" name="last_name">
					</fieldset>
				</div>
				<fieldset class="form-group">
					<label class="sr-only" for="emailAddress">Email address</label>
					<input type="email" class="form-control" id="emailAddress" placeholder="Email" name="email">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="phoneNumber">Phone Number</label>
					<input type="tel" id="phone" class="form-control" placeholder="Phone" name="phone">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="timeZone">Time Zone</label>
					<select class="form-control" id="timeZone" name="timezone">
						<option value="">Time Zone</option>
						<option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
						<option value="-11">(GMT -11:00) Midway Island, Samoa</option>
						<option value="-10">(GMT -10:00) Hawaii</option>
						<option value="-9">(GMT -9:00) Alaska</option>
						<option value="-8">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
						<option value="-7">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
						<option value="-6">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
						<option value="-5">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
						<option value="-4">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
						<option value="-3.5">(GMT -3:30) Newfoundland</option>
						<option value="-3">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
						<option value="-2">(GMT -2:00) Mid-Atlantic</option>
						<option value="-1">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
						<option value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
						<option value="1">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
						<option value="2">(GMT +2:00) Kaliningrad, South Africa</option>
						<option value="3">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
						<option value="3.5">(GMT +3:30) Tehran</option>
						<option value="4">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
						<option value="4.5">(GMT +4:30) Kabul</option>
						<option value="5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
						<option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
						<option value="5.75">(GMT +5:45) Kathmandu</option>
						<option value="6">(GMT +6:00) Almaty, Dhaka, Colombo</option>
						<option value="7">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
						<option value="8">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
						<option value="9">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
						<option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
						<option value="10">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
						<option value="11">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
						<option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
					</select>
				</fieldset>
			</div>
			<label class="section-label">Login Info</label>
			<div class="field-group">
				<fieldset class="form-group">
					<label class="sr-only" for="userName">User Name</label>
					<input type="text" class="form-control" id="userName" placeholder="User Name" name="username">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="password">Password</label>
					<input type="password" class="form-control" id="password" placeholder="Password" name="password">
				</fieldset>
			</div>
			<label class="section-label">Master Admin Info</label>
			<div class="field-group">
				<fieldset class="form-group">
					<label class="sr-only" for="companyName">Company Name</label>
					<input type="text" class="form-control" id="companyName" placeholder="Company Name" name="company_name">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="companyEmail">Company Email</label>
					<input type="email" class="form-control" id="companyEmail" placeholder="Company Email" name="company_email">
				</fieldset>
				<fieldset class="form-group">
					<label class="sr-only" for="companyURL">Company URL</label>
					<input type="text" class="form-control" id="companyURL" placeholder="Company URL" name="company_url">
				</fieldset>
			</div>
			<button type="submit" class="btn btn-secondary btn-sm">Save Changes</button>
		</form>
	</div>
</div>
<div class="page-divider"></div>


