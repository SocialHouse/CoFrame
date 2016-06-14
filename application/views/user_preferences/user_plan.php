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
		$selected_plan = $user_details->plan;
	}
	switch (strtolower($selected_plan)) {
	case 'business':
		$business = 'active-plan';
		break;
	case 'corporate':
		$start_up = 'active-plan';
		break;
	case 'start-up':
		$corporate = 'active-plan';
		break;
	default:
		$premiere = 'active-plan';
		break;
}
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
			<a class="btn btn-secondary btn-sm btn-choose-plan" data-plan="Start-Up" data-price="$99.00">Select</a>
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
			<a class="btn btn-secondary btn-sm btn-choose-plan btn-disabled" data-plan="Business" data-price="$199.00">Active</a>
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
			<a class="btn btn-secondary btn-sm btn-choose-plan" data-plan="Corporate" data-price="$299.00">Select</a>
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
			<a class="btn btn-secondary btn-sm btn-choose-plan" data-plan="Premiere" data-price="$499.00">Select</a>
		</div>
	</div>

</div>
