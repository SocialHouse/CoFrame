<div class="container-brand-step">
	<h3 class="text-xs-center">Step 2</h3>
	<h4 class="text-xs-center">Brand Outlets</h4>
	<div class="add-brand-details brand-fields border-bottom border-black">
		<div id="selectedOutlets" class="outlet-list selected-items hidden">
			<ul>
			</ul>
		</div>
		<a href="#brandOutlets" id="addOutletLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addOutletLink, #outletStep2Btns, #selectedOutlets" data-show="#brandOutlets, #addOutletBtns"><i class="tf-icon circle-border">+</i>Add Outlet</a>
		<div id="brandOutlets" class="outlet-list hidden">
			<h5 class="text-xs-center border-bottom border-black ">Add an Outlet</h5>
			<ul>
				<?php
				if(!empty($outlets))
				{
					foreach($outlets as $outlet)
					{
						$event = '';
						if($outlet->outlet_constant == 'FACEBOOK')
						{
							$event = 'onclick="login(this)"';
						}
						?>

						<li class="disabled" <?php echo $event; ?>  data-outlet-const="<?php echo $outlet->outlet_constant; ?>" data-selected-outlet-id="<?php echo strtolower($outlet->id); ?>" data-selected-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>	
						<input type="hidden" id="<?php echo $outlet->id; ?>" name="<?php echo $outlet->id; ?>">	
						<?php
					}
				}
				?>								
			</ul>
			<input type="hidden" id="brandOutlet">
			
		</div>
	</div>
	<footer class="post-content-footer">
		<div id="outletStep2Btns">
			<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="1">Back</button>
			<button type="button" id="save_outlet" class="btn btn-sm btn-disabled pull-sm-right" disabled="disabled">Next</button>

			<button type="button" id="btn-next-step" class="btn btn-sm btn-disabled pull-sm-right btn-next-step hide" data-active-class="btn-secondary" data-next-step="3"></button>
		</div>
		<div class="hidden" id="addOutletBtns">
			<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Cancel</button>
			<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addOutlet" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Add</button>
		</div>
	</footer>
</div>