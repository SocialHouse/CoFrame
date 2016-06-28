<div class="container-archive">
	<h2 class="text-xs-center">Outlets</h2>
	<div class="outlet-list timeframe-list">
		<ul>
			<?php 
			if(!empty($selected_outlets))
			{
				foreach ($selected_outlets as $obj => $outlet) 
				{
					$outlet_name = strtolower($outlet->outlet_name);
					?>
					<li data-value="<?php echo $outlet_name; ?>" data-group="post-outlet">
						<div class="pull-sm-left">
							<input type="checkbox" class="hidden-xs-up" name="post-outlet[]" value="<?php echo $outlet_name; ?>">
							<i class="tf-icon check-box circle-border has-archive" data-value="<?php echo $outlet_name; ?>" data-group="post-outlet"><i class="fa fa-check"></i></i>
						</div>
						<div class="pull-sm-left">
							<i class="fa fa-<?php echo $outlet_name; ?>">
								<span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span>
							</i> <?php echo ucfirst($outlet_name); ?>
						</div>
					</li>
					<?php

				}
			}
			?>
			<li data-value="check-all" data-group="post-outlet">
				<div class="pull-sm-left">
					<i class="tf-icon check-box circle-border has-archive" data-value="check-all" data-group="post-outlet"><i class="fa fa-check"></i></i>
				</div>
				<i class="fa">
					<span class="bg-outlet bg-all"></span>
					<span class="outlet-text">All</span>
				</i>
			</li>
			
		</ul>
	</div>
</div>
