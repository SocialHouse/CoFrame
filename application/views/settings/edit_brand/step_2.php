
	<div class="container-brand-step">
	<form id="step_2_edit" method="POST" action="<?php echo base_url()?>brands/save_outlet" enctype="multipart/form-data">
		<h4 class="text-xs-center">Social Outlets</h4>
		<div class="add-brand-details brand-fields border-bottom border-black">
		<input type="hidden" name="brand_id" value="<?php echo $brand->id; ?>">
		<input type="hidden" name="slug" value="<?php echo $brand->slug; ?>">
			<div id="selectedOutlets" class="outlet-list selected-items hidden" style="display: block;">
				<ul>
					<?php 
					if(!empty($selected_outlets )){
						foreach ($selected_outlets as $st_outlet) {
							if($st_outlet->outlet_name == 'youtube'){
								$st_outlet->outlet_name = 'youtube-play';
							}
							$outlet_name =  strtolower($st_outlet->outlet_name);
							$outlet_id =  $st_outlet->id;
							?>
							<li data-outlet="<?php echo $outlet_name; ?>">
								<i class="fa fa-<?php echo $outlet_name; ?>">
									<span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span>
								</i>
								<input type="hidden" value="<?php echo $outlet_id; ?>" name="outlets[]" class="outlets"><?php echo $outlet_name; ?>
								<a data-remove-outlet="<?php echo $outlet_name; ?>" class="pull-sm-right remove-outlet" href="#">
									<i class="tf-icon circle-border">x</i>
								</a>
							</li>
							<?php	
						}
					}
					?>
				</ul>
			</div>
			<a href="#brandOutlets" id="addOutletLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addOutletLink, #outletStep2Btns, #selectedOutlets" data-show="#brandOutlets, #addOutletBtns"><i class="tf-icon circle-border">+</i>Add Outlet</a>
			<div id="brandOutlets" class="outlet-list hidden">
				<h5 class="text-xs-center border-bottom border-black ">Add an Outlet</h5>
				<ul>
					<?php
					$selected_outlet_string='';
					if(!empty($outlets))
					{
						foreach($outlets as $outlet)
						{
							$event = '';
							if($outlet->outlet_constant == 'FACEBOOK')
							{
								$event = 'onclick="login(this)"';
							}
							$cls = 'disabled';
							if(!empty($selected_outlets )){
								foreach ($selected_outlets as $st_outlet) {
									if(strtolower($outlet->outlet_constant) ==  strtolower($st_outlet->outlet_name) ){
										$cls = 'saved';
										if(empty($selected_outlet_string)){
											$selected_outlet_string = strtolower($st_outlet->outlet_name);
										}else{
											$selected_outlet_string .=','.strtolower($st_outlet->outlet_name);
										}
										
										break;
									}else{
										$cls = 'disabled';
									}
								}
							}							
							?>
							<li class="<?php echo $cls ?>" <?php echo $event; ?>  data-outlet-const="<?php echo $outlet->outlet_constant; ?>" data-selected-outlet-id="<?php echo strtolower($outlet->id); ?>" data-selected-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>	
							<input type="hidden" id="<?php echo $outlet->id; ?>" name="<?php echo $outlet->id; ?>">	
							<?php
						}
					}
					?>								
				</ul>
				<input type="hidden" id="brandOutlet" value="<?php echo $selected_outlet_string; ?>">
			</div>
		</div>
		<footer class="post-content-footer">
			<div id="outletStep2Btns">
				<button type="button" class="btn btn-sm btn-default close_brand"  data-step-no="2">Cancel</button>
				<button type="submit" id="save_outlet" class="btn btn-sm btn-secondary pull-sm-right"  data-step-no="2">Save</button>
			</div>
			<div class="hidden" id="addOutletBtns">
				<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Cancel</button>
				<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addOutlet" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Add</button>
			</div>
		</footer>
		</form>
	</div>

<?php       
if(isset($js_files))
{
    foreach ($js_files as $js_src) 
    {
        ?>
        <script src="<?php echo $js_src; ?>"></script>
        <?php
    }
}
?>
