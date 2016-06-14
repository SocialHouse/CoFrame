<div class="container-brand-step">
	<h3 class="text-xs-center">Step 2</h3>
	<h4 class="text-xs-center">Brand Outlets</h4>
	<div class="outlet-list saved-items">
		<ul>
		<?php			
			if(!empty($selected_outlets )){
				foreach ($selected_outlets as $st_outlet) {
					
					if($st_outlet->outlet_name == 'youtube'){
						$st_outlet->outlet_name= 'youtube';
					}
					$outlet_name =  strtolower($st_outlet->outlet_name);			
					$outlet_id =  $st_outlet->id;
					?>
					<li data-outlet="<?php echo $outlet_name; ?>">
						<i class="fa fa-<?php echo $outlet_name; ?>">
							<span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span>
						</i>
						<?php echo strtoupper($outlet_name); ?>
					</li>
					<?php	
				}
			}
		?>
		</ul>
	</div>
	<footer class="post-content-footer">
		<div class="text-xs-center">
		<button type="button" class="btn btn-sm btn-default edit-brands-info" data-step-no="2">Manage Outlets</button>
		</div>
	</footer>
</div>