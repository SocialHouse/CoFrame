<div class="container-brand-step">
	<h3 class="text-xs-center">Step 2</h3>
	<h4 class="text-xs-center">Brand Outlets</h4>
	<div class="add-brand-details border-bottom border-black">
		<div id="selectedOutlets" class="outlet-list hidden">
			<ul>
			</ul>
		</div>
		<a href="#brandOutlets" id="addOutletLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addOutletLink, #outletStepBtns, #selectedOutlets" data-show="#brandOutlets, #addOutletBtns"><i class="tf-icon circle-border">+</i>Add Outlet</a>
		<div id="brandOutlets" class="outlet-list hidden">
			<h5 class="text-xs-center border-bottom border-black ">Add an Outlet</h5>
			<ul>
				<li class="disabled" data-selected-outlet="facebook"><i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i></li>
				<li class="disabled" data-selected-outlet="twitter"><i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i></li>
				<li class="disabled" data-selected-outlet="instagram"><i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i></li>
				<li class="disabled" data-selected-outlet="linkedin"><i class="fa fa-linkedin"><span class="bg-outlet bg-linkedin"></span></i></li>
				<li class="disabled" data-selected-outlet="vine"><i class="fa fa-vine"><span class="bg-outlet bg-vine"></span></i></li>
				<li class="disabled" data-selected-outlet="pinterest"><i class="fa fa-pinterest"><span class="bg-outlet bg-pinterest"></span></i></li>
				<li class="disabled" data-selected-outlet="tumblr"><i class="fa fa-tumblr"><span class="bg-outlet bg-tumblr"></span></i></li>
				<li class="disabled" data-selected-outlet="youtube"><i class="fa fa-youtube-play"><span class="bg-outlet bg-youtube"></span></i></li>
				<li class="disabled" data-selected-outlet="google"><i class="fa fa-google-plus"><span class="bg-outlet bg-google-plus"></span></i></li>
				<li class="disabled" data-selected-outlet="vimeo"><i class="fa fa-vimeo"><span class="bg-outlet bg-vimeo"></span></i></li>
				<li class="disabled" data-selected-outlet="wordpress"><i class="fa fa-wordpress"><span class="bg-outlet bg-wordpress"></span></i></li>
				<li class="disabled" data-selected-outlet="blogger"><i class="icon-blogger"><span class="bg-outlet bg-blogger"></span></i></li>
			</ul>
			<input type="hidden" id="brandOutlet">
		</div>
	</div>
	<footer class="post-content-footer">
		<div id="outletStepBtns">
			<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="1">Back</button>
			<button type="button" class="btn btn-sm btn-disabled pull-sm-right btn-next-step" disabled data-active-class="btn-secondary">Next</button>
		</div>
		<div class="hidden" id="addOutletBtns">
			<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStepBtns, #addOutletLink, #selectedOutlets">Cancel</button>
			<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addOutlet" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStepBtns, #addOutletLink, #selectedOutlets">Add</button>
		</div>
	</footer>
</div>