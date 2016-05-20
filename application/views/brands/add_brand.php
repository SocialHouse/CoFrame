<section id="overview" class="page-main bg-white col-sm-12">
	<form action="<?php echo base_url().'brands/save_brand'; ?>" method="post" id="add-brand-details" class="file-upload clearfix row-sm-12">	

	<input type="hidden" name="all_selected_outlets" id="all_selected_outlets" />
	<input type="hidden" name="brand_id" id="brand_id" />

	<div class="row row-sm-12 equal-cols relative-wrapper">
		<div class="brand-steps col-xl-11 center-block">
			<div class="col-md-3 col-sm-6 brand-step active" id="brandStep1">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 1</h3>
					<h4 class="text-xs-center">Add Brand</h4>
					<div class="brand-fields">
						<div class="form-group">
							<div class="form__input center-block brand-logo">
								<input type="file" name="files[]" id="brandFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
								<label for="brandFile" id="brandFileLabel" class="file-upload-label">Click to upload <span class="form__dragndrop">or drag &amp drop here</span></span></label>
								<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
							</div>
							<div class="form__uploading">Uploading ...</div>
							<div class="form__success">Done!</div>
							<div class="form__error">Error! <span></span></div>
						</div>
						<div class="form-group">
							<label for="brandName">Brand Name:</label>
							<input type="text" class="form-control" id="brandName" placeholder="INSERT BRAND NAME" name="name">
						</div>
						<div class="form-group">
							<label>Brand Time Zone:</label>
							<select class="form-control" name="timezone">
								<option value="">Select Brand Time Zone</option>
								<?php
							    foreach($timezones as $timezone)
							    {
							    	$selected = "";
							    	if($brand->timezone == $timezone->value)
							    	{
							    		$selected = 'selected="selected"';
							    	}
							    	?>
							    	<option value="<?php echo $timezone->value ?>" <?php echo set_select('timezone', $timezone->value)?set_select('timezone', $timezone->value):(!empty($selected)?$selected:''); ?>><?php echo $timezone->timezone; ?></option>
							    	<?php
							    }
							    ?>
							</select>
						</div>
					</div>
					<footer class="post-content-footer">
						<button type="reset" class="btn btn-sm btn-default">Cancel</button>
						<button type="button" class="btn btn-sm btn-disabled pull-sm-right save_brand">Next</button>

						<button type="button" id="btn-next-step" class="btn btn-sm btn-disabled pull-sm-right btn-next-step hide" data-active-class="btn-secondary" data-next-step="2"></button>
					</footer>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep2">
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
										?>
										<li class="disabled" data-selected-outlet-id="<?php echo strtolower($outlet->id); ?>" data-selected-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i></li>		
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
							<button type="button" id="save_outlet" class="btn btn-sm btn-disabled pull-sm-right">Next</button>

							<button type="button" id="btn-next-step" class="btn btn-sm btn-disabled pull-sm-right btn-next-step hide" data-active-class="btn-secondary" data-next-step="3"></button>
						</div>
						<div class="hidden" id="addOutletBtns">
							<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Cancel</button>
							<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addOutlet" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Add</button>
						</div>
					</footer>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep3">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 3</h3>
					<h4 class="text-xs-center">Users &amp; Permissions</h4>
					<div class="brand-fields">
						<?php $this->load->view('partials/user_permission_list'); ?>
						<a href="#addUser" id="addUserLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addUserLink, #outletStep3Btns, #userPermissionsList" data-show="#addNewUser, #addUserBtns"><i class="tf-icon circle-border">+</i>Add User</a>
						<?php $this->load->view('partials/add_new_user'); ?>
						<?php $this->load->view('partials/add_user_roles'); ?>
					</div>
					<footer class="post-content-footer">
						<div id="outletStep3Btns">
							<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="2">Back</button>
							<button type="button" class="btn btn-sm pull-sm-right btn-next-step btn-secondary"  data-next-step="4">Next</button>
						</div>
						<div class="hidden" id="addUserBtns">
							<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addNewUser, #addUserBtns" data-show="#addUserLink, #outletStep3Btns, #userPermissionsList">Cancel</button>
							<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole">Role</button>
						</div>
						<div class="hidden" id="userRoleBtns">
							<p class="disclaimer">Upon clicking ‘Add,’ a registration link will be sent to this user.</p>
							<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addUserRole, #userRoleBtns" data-show="#addUserLink, #outletStep3Btns, #userPermissionsList">Cancel</button>
							<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole">Add</button>
						</div>
					</footer>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep4">
				<?php  ?>
			</div>
		</div>
		<div class="modal-backdrop fade in modal-contain"></div>
		<div class="hidden" id="addBrandSuccess"><a href="dashboard.php" class="btn btn-secondary btn-sm" tabindex="0" data-content="CONGRATULATIONS!<br><br>You’ve just added your first brand. Go to the brand dashboard to create your first post, view calendar, and more.">Go to Brand Dashboard</a></div>
	</div>
	</form>
</section>