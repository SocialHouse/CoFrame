<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>Timeframe | Overview</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.css"/>
<link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all">
<link type="text/css" rel="stylesheet" href="assets/css/intlTelInput.css" media="all">
<script type='text/javascript' src='assets/js/vendor/modernizr.3.3.1.custom.js?ver=3.3.1'></script>
</head>

<body class="page-global">
	<div class="container container-head navbar-fixed-top bg-white">
		<?php include("lib/global-navigation.php"); ?>
	</div>
	<div class="container content-container">
		<div class="content-area row animated fadeIn">
			<section id="user-preferences" class="page-main col-sm-12">
				<header class="page-main-header header-fixed-top bg-white row">
					<h1 class="center-title section-title border-none">Account Settings</h1>
				</header>
				<div class="text-xs-center">
					<div class="btn-group-background center-block">
					<a href="user-preferences.php" class="btn btn-sm active">My Info</a>
					<a href="user-plan.php" class="btn btn-sm ">Plan</a>
					<a href="user-billing.php" class="btn btn-sm ">Billing</a>
					</div>
				</div>
				<div class="bg-white col-sm-12 content-shadow brand-main">
					<form action="https://timeframe-dev.blueshoon.com/user_preferences/save_payment" id="payment-form" method="post">
						<input type="hidden" name="plan" value="CORPORATE">
						<input type="hidden" name="email" value="roy@blueshoon.com" >
						<input type="hidden" name="billing_id" value="">
						
						<div class="field-group">
							<label class="section-label" for="fullName">Full Name</label>
							<fieldset class="form-group">
								<input type="text" class="form-control" id="fullName" placeholder="Full Name" name="name" data-stripe="name" value="">
							</fieldset>
						</div>
						<div class="field-group clearfix">
							<fieldset class="form-group pull-xs-left width-70">
								<label class="section-label" for="ccNumber">Credit Card Number</label>
								<input type="text" class="form-control" data-stripe="number" id="ccNumber" placeholder="**** **** **** 1235" name="cc_number" value="">
							</fieldset>
							<fieldset class="form-group pull-xs-left width-30">
								<label class="section-label" for="cvv">CVV</label>
								<input type="text" id="cvv" class="form-control" placeholder="***" name="cvc" data-stripe="cvc" value="">
							</fieldset>
						</div>
						<div class="field-group clearfix">
							<fieldset class="form-group pull-xs-left width-50">
								<label class="section-label" for="expMonth">Expiration Month</label>
								<select class="form-control" data-stripe="exp-month" name="expiry_month">
									<option value="">Month</option>
									<option  value="01">01</option>
									<option  value="02">02</option>
									<option  value="03">03</option>
									<option  value="04">04</option>
									<option  value="05">05</option>
									<option  value="06">06</option>
									<option  value="07">07</option>
									<option  value="08">08</option>
									<option  value="09">09</option>
									<option  value="10">10</option>
									<option  value="11">11</option>
									<option  value="12">12</option>
								</select>
							</fieldset>
							<fieldset class="form-group pull-xs-left width-50">
								<label class="section-label" for="expYear">Expiration Year</label>
								<select class="form-control" id="expYear" name="expiry_year" data-stripe="exp-year">
									<option value="">Year</option>
									<option  value="2016">2016</option>
									<option  value="2017">2017</option>
									<option  value="2018">2018</option>
									<option  value="2019">2019</option>
									<option  value="2020">2020</option>
									<option  value="2021">2021</option>
									<option  value="2022">2022</option>
									<option  value="2023">2023</option>
									<option  value="2024">2024</option>
									<option  value="2025">2025</option>
									<option  value="2026">2026</option>
									<option  value="2027">2027</option>
								</select>
							</fieldset>
						</div>
						<div class="field-group clearfix">
							<fieldset class="form-group pull-xs-left width-50">
								<label class="section-label" for="zip">Zip/Postal Code</label>
								<input type="text" class="form-control" id="zip" placeholder="11111" name="zip" data-stripe="address-zip" value="">
							</fieldset>
							<fieldset class="form-group pull-xs-left width-50">
								<label class="section-label" for="country">Country</label>
								<select class="form-control" id="country" data-stripe="country" name="country">
									<option value="">-- Select Country --</option>
									<option value="United States" >United States</option>
									<option value="Canada" >Canada</option>
									<option value="Virtual" >Virtual</option>
									<option value="Afghanistan" >Afghanistan</option>
									<option value="Albania" >Albania</option>
									<option value="Algeria" >Algeria</option>
									<option value="American Samoa" >American Samoa</option>
									<option value="Andorra" >Andorra</option>
									<option value="Angola" >Angola</option>
									<option value="Anguilla" >Anguilla</option>
									<option value="Antarctica" >Antarctica</option>
									<option value="Antigua and/or Barbuda" >Antigua and/or Barbuda</option>
									<option value="Argentina" >Argentina</option>
									<option value="Armenia" >Armenia</option>
									<option value="Aruba" >Aruba</option>
									<option value="Australia" >Australia</option>
									<option value="Austria" >Austria</option>
									<option value="Azerbaijan" >Azerbaijan</option>
									<option value="Bahamas" >Bahamas</option>
									<option value="Bahrain" >Bahrain</option>
									<option value="Bangladesh" >Bangladesh</option>
									<option value="Barbados" >Barbados</option>
									<option value="Belarus" >Belarus</option>
									<option value="Belgium" >Belgium</option>
									<option value="Belize" >Belize</option>
									<option value="Benin" >Benin</option>
									<option value="Bermuda" >Bermuda</option>
									<option value="Bhutan" >Bhutan</option>
									<option value="Bolivia" >Bolivia</option>
									<option value="Bosnia and Herzegovina" >Bosnia and Herzegovina</option>
									<option value="Botswana" >Botswana</option>
									<option value="Bouvet Island" >Bouvet Island</option>
									<option value="Brazil" >Brazil</option>
									<option value="British lndian Ocean Territory" >British lndian Ocean Territory</option>
									<option value="Brunei Darussalam" >Brunei Darussalam</option>
									<option value="Bulgaria" >Bulgaria</option>
									<option value="Burkina Faso" >Burkina Faso</option>
									<option value="Burundi" >Burundi</option>
									<option value="Cambodia" >Cambodia</option>
									<option value="Cameroon" >Cameroon</option>
									<option value="Cape Verde" >Cape Verde</option>
									<option value="Cayman Islands" >Cayman Islands</option>
									<option value="Central African Republic" >Central African Republic</option>
									<option value="Chad" >Chad</option>
									<option value="Chile" >Chile</option>
									<option value="China" >China</option>
									<option value="Christmas Island" >Christmas Island</option>
									<option value="Cocos (Keeling) Islands" >Cocos (Keeling) Islands</option>
									<option value="Colombia" >Colombia</option>
									<option value="Comoros" >Comoros</option>
									<option value="Congo" >Congo</option>
									<option value="Cook Islands" >Cook Islands</option>
									<option value="Costa Rica" >Costa Rica</option>
									<option value="Croatia (Hrvatska)" >Croatia (Hrvatska)</option>
									<option value="Cuba" >Cuba</option>
									<option value="Cyprus" >Cyprus</option>
									<option value="Czech Republic" >Czech Republic</option>
									<option value="Denmark" >Denmark</option>
									<option value="Djibouti" >Djibouti</option>
									<option value="Dominica" >Dominica</option>
									<option value="Dominican Republic" >Dominican Republic</option>
									<option value="East Timor" >East Timor</option>
									<option value="Ecuador" >Ecuador</option>
									<option value="Egypt" >Egypt</option>
									<option value="El Salvador" >El Salvador</option>
									<option value="Equatorial Guinea" >Equatorial Guinea</option>
									<option value="Eritrea" >Eritrea</option>
									<option value="Estonia" >Estonia</option>
									<option value="Ethiopia" >Ethiopia</option>
									<option value="Falkland Islands (Malvinas)" >Falkland Islands (Malvinas)</option>
									<option value="Faroe Islands" >Faroe Islands</option>
									<option value="Fiji" >Fiji</option>
									<option value="Finland" >Finland</option>
									<option value="France" >France</option>
									<option value="France, Metropolitan" >France, Metropolitan</option>
									<option value="French Guiana" >French Guiana</option>
									<option value="French Polynesia" >French Polynesia</option>
									<option value="French Southern Territories" >French Southern Territories</option>
									<option value="Gabon" >Gabon</option>
									<option value="Gambia" >Gambia</option>
									<option value="Georgia" >Georgia</option>
									<option value="Germany" >Germany</option>
									<option value="Ghana" >Ghana</option>
									<option value="Gibraltar" >Gibraltar</option>
									<option value="Greece" >Greece</option>
									<option value="Greenland" >Greenland</option>
									<option value="Grenada" >Grenada</option>
									<option value="Guadeloupe" >Guadeloupe</option>
									<option value="Guam" >Guam</option>
									<option value="Guatemala" >Guatemala</option>
									<option value="Guinea" >Guinea</option>
									<option value="Guinea-Bissau" >Guinea-Bissau</option>
									<option value="Guyana" >Guyana</option>
									<option value="Haiti" >Haiti</option>
									<option value="Heard and Mc Donald Islands" >Heard and Mc Donald Islands</option>
									<option value="Honduras" >Honduras</option>
									<option value="Hong Kong" >Hong Kong</option>
									<option value="Hungary" >Hungary</option>
									<option value="Iceland" >Iceland</option>
									<option value="India" >India</option>
									<option value="Indonesia" >Indonesia</option>
									<option value="Iran (Islamic Republic of)" >Iran (Islamic Republic of)</option>
									<option value="Iraq" >Iraq</option>
									<option value="Ireland" >Ireland</option>
									<option value="Israel" >Israel</option>
									<option value="Italy" >Italy</option>
									<option value="Ivory Coast" >Ivory Coast</option>
									<option value="Jamaica" >Jamaica</option>
									<option value="Japan" >Japan</option>
									<option value="Jordan" >Jordan</option>
									<option value="Kazakhstan" >Kazakhstan</option>
									<option value="Kenya" >Kenya</option>
									<option value="Kiribati" >Kiribati</option>
									<option value="Korea, Democratic People's Republic of" >Korea, Democratic People's Republic of</option>
									<option value="Korea, Republic of" >Korea, Republic of</option>
									<option value="Kosovo" >Kosovo</option>
									<option value="Kuwait" >Kuwait</option>
									<option value="Kyrgyzstan" >Kyrgyzstan</option>
									<option value="Lao People's Democratic Republic" >Lao People's Democratic Republic</option>
									<option value="Latvia" >Latvia</option>
									<option value="Lebanon" >Lebanon</option>
									<option value="Lesotho" >Lesotho</option>
									<option value="Liberia" >Liberia</option>
									<option value="Libyan Arab Jamahiriya" >Libyan Arab Jamahiriya</option>
									<option value="Liechtenstein" >Liechtenstein</option>
									<option value="Lithuania" >Lithuania</option>
									<option value="Luxembourg" >Luxembourg</option>
									<option value="Macau" >Macau</option>
									<option value="Macedonia" >Macedonia</option>
									<option value="Madagascar" >Madagascar</option>
									<option value="Malawi" >Malawi</option>
									<option value="Malaysia" >Malaysia</option>
									<option value="Maldives" >Maldives</option>
									<option value="Mali" >Mali</option>
									<option value="Malta" >Malta</option>
									<option value="Marshall Islands" >Marshall Islands</option>
									<option value="Martinique" >Martinique</option>
									<option value="Mauritania" >Mauritania</option>
									<option value="Mauritius" >Mauritius</option>
									<option value="Mayotte" >Mayotte</option>
									<option value="Mexico" >Mexico</option>
									<option value="Micronesia, Federated States of" >Micronesia, Federated States of</option>
									<option value="Moldova, Republic of" >Moldova, Republic of</option>
									<option value="Monaco" >Monaco</option>
									<option value="Mongolia" >Mongolia</option>
									<option value="Montenegro" >Montenegro</option>
									<option value="Montserrat" >Montserrat</option>
									<option value="Morocco" >Morocco</option>
									<option value="Mozambique" >Mozambique</option>
									<option value="Myanmar" >Myanmar</option>
									<option value="Namibia" >Namibia</option>
									<option value="Nauru" >Nauru</option>
									<option value="Nepal" >Nepal</option>
									<option value="Netherlands" >Netherlands</option>
									<option value="Netherlands Antilles" >Netherlands Antilles</option>
									<option value="New Caledonia" >New Caledonia</option>
									<option value="New Zealand" >New Zealand</option>
									<option value="Nicaragua" >Nicaragua</option>
									<option value="Niger" >Niger</option>
									<option value="Nigeria" >Nigeria</option>
									<option value="Niue" >Niue</option>
									<option value="Norfork Island" >Norfork Island</option>
									<option value="Northern Mariana Islands" >Northern Mariana Islands</option>
									<option value="Norway" >Norway</option>
									<option value="Oman" >Oman</option>
									<option value="Pakistan" >Pakistan</option>
									<option value="Palau" >Palau</option>
									<option value="Panama" >Panama</option>
									<option value="Papua New Guinea" >Papua New Guinea</option>
									<option value="Paraguay" >Paraguay</option>
									<option value="Peru" >Peru</option>
									<option value="Philippines" >Philippines</option>
									<option value="Pitcairn" >Pitcairn</option>
									<option value="Poland" >Poland</option>
									<option value="Portugal" >Portugal</option>
									<option value="Puerto Rico" >Puerto Rico</option>
									<option value="Qatar" >Qatar</option>
									<option value="Reunion" >Reunion</option>
									<option value="Romania" >Romania</option>
									<option value="Russian Federation" >Russian Federation</option>
									<option value="Rwanda" >Rwanda</option>
									<option value="Saint Kitts and Nevis" >Saint Kitts and Nevis</option>
									<option value="Saint Lucia" >Saint Lucia</option>
									<option value="Saint Vincent and the Grenadines" >Saint Vincent and the Grenadines</option>
									<option value="Samoa" >Samoa</option>
									<option value="San Marino" >San Marino</option>
									<option value="Sao Tome and Principe" >Sao Tome and Principe</option>
									<option value="Saudi Arabia" >Saudi Arabia</option>
									<option value="Senegal" >Senegal</option>
									<option value="Serbia" >Serbia</option>
									<option value="Seychelles" >Seychelles</option>
									<option value="Sierra Leone" >Sierra Leone</option>
									<option value="Singapore" >Singapore</option>
									<option value="Slovakia" >Slovakia</option>
									<option value="Slovenia" >Slovenia</option>
									<option value="Solomon Islands" >Solomon Islands</option>
									<option value="Somalia" >Somalia</option>
									<option value="South Africa" >South Africa</option>
									<option value="South Georgia South Sandwich Islands" >South Georgia South Sandwich Islands</option>
									<option value="Spain" >Spain</option>
									<option value="Sri Lanka" >Sri Lanka</option>
									<option value="St. Helena" >St. Helena</option>
									<option value="St. Pierre and Miquelon" >St. Pierre and Miquelon</option>
									<option value="Sudan" >Sudan</option>
									<option value="Suriname" >Suriname</option>
									<option value="Svalbarn and Jan Mayen Islands" >Svalbarn and Jan Mayen Islands</option>
									<option value="Swaziland" >Swaziland</option>
									<option value="Sweden" >Sweden</option>
									<option value="Switzerland" >Switzerland</option>
									<option value="Syrian Arab Republic" >Syrian Arab Republic</option>
									<option value="Taiwan" >Taiwan</option>
									<option value="Tajikistan" >Tajikistan</option>
									<option value="Tanzania, United Republic of" >Tanzania, United Republic of</option>
									<option value="Thailand" >Thailand</option>
									<option value="Togo" >Togo</option>
									<option value="Tokelau" >Tokelau</option>
									<option value="Tonga" >Tonga</option>
									<option value="Trinidad and Tobago" >Trinidad and Tobago</option>
									<option value="Tunisia" >Tunisia</option>
									<option value="Turkey" >Turkey</option>
									<option value="Turkmenistan" >Turkmenistan</option>
									<option value="Turks and Caicos Islands" >Turks and Caicos Islands</option>
									<option value="Tuvalu" >Tuvalu</option>
									<option value="Uganda" >Uganda</option>
									<option value="Ukraine" >Ukraine</option>
									<option value="United Arab Emirates" >United Arab Emirates</option>
									<option value="United Kingdom" >United Kingdom</option>
									<option value="United States minor outlying islands" >United States minor outlying islands</option>
									<option value="Uruguay" >Uruguay</option>
									<option value="Uzbekistan" >Uzbekistan</option>
									<option value="Vanuatu" >Vanuatu</option>
									<option value="Vatican City State" >Vatican City State</option>
									<option value="Venezuela" >Venezuela</option>
									<option value="Vietnam" >Vietnam</option>
									<option value="Virigan Islands (British)" >Virigan Islands (British)</option>
									<option value="Virgin Islands (U.S.)" >Virgin Islands (U.S.)</option>
									<option value="Wallis and Futuna Islands" >Wallis and Futuna Islands</option>
									<option value="Western Sahara" >Western Sahara</option>
									<option value="Yemen" >Yemen</option>
									<option value="Yugoslavia" >Yugoslavia</option>
									<option value="Zaire" >Zaire</option>
									<option value="Zambia" >Zambia</option>
									<option value="Zimbabwe" >Zimbabwe</option>
								</select>
							</fieldset>
						</div>
						<button id="make_payment" type="button" class="btn btn-secondary btn-sm btn-block">Save Changes</button>
					</form>

				</div>
			</section>
		</div>
	</div>

	<script type='text/javascript' src='assets/js/vendor/jquery.js?ver=1.11.3'></script>
	<script type='text/javascript' src='assets/js/vendor/jquery.qtip.min.js'></script>
	<script type='text/javascript' src='assets/js/vendor/bootstrap.min.js?ver=4.0.0'></script>
	<script type='text/javascript' src='assets/js/vendor/intlTelInput.min.js?ver=9.0.2'></script>
	<script type='text/javascript' src='assets/js/main.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/tooltip-config.js?ver=1.0.0'></script>
	<script type='text/javascript' src='assets/js/user_preference.js?ver=1.0.0'></script>
</body>
</html>
