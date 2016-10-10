<form action="<?php echo base_url().'approvals/save_post_outlet'; ?>" method="post">
	<div class="timeframe-list outlet-list list-block clearfix">
		<ul>
			<?php
			if(!empty($outlets))
			{
				foreach($outlets as $outlet)
				{
					$class = 'disabled';
					if($outlet->id == $post[0]->outlet_id)
					{
						$class = '';
					}
					?>
					<li data-outlet-id="<?php echo $outlet->id; ?>" class="<?php echo $class; ?>" data-selected-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i><?php echo $outlet->outlet_name; ?></li>
					<?php
				}
			}
			?>
		</ul>
		<input type="hidden" id="postOutlet" name="post_outlet" value="<?php echo $post[0]->outlet_id; ?>">
		<input type="hidden" name="post_id" value="<?php echo $post[0]->id; ?>">
		<div class="overlay-footer border-gray-lighter">
		<button class="btn btn-secondary btn-sm btn-block">Save Outlet</button>
		</div>
	</div>
</form>