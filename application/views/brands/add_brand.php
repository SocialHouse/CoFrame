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
							<select class="form-control" name="timezone" id="timezone">
								<option value="">Select Brand Time Zone</option>
								<?php
							    foreach($timezones as $timezone)
							    {
							    	?>
							    	<option value="<?php echo $timezone->value ?>" ><?php echo $timezone->timezone; ?></option>
							    	<?php
							    }
							    ?>
							</select>
						</div>
					</div>
					<footer class="post-content-footer">
						<button type="reset" class="btn btn-sm btn-default">Cancel</button>
						<button type="button" class="btn btn-sm btn-disabled pull-sm-right save_brand" disabled="disabled">Next</button>

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
							<button type="button" id="save_outlet" class="btn btn-sm btn-disabled pull-sm-right" disabled="disabled">Next</button>

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
							<button type="button" id="add_user_next" class="btn btn-sm pull-sm-right btn-next-step btn-secondary"  data-next-step="4">Next</button>
						</div>
						<div class="hidden" id="addUserBtns">
							<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addNewUser, #addUserBtns" data-show="#addUserLink, #outletStep3Btns, #userPermissionsList">Cancel</button>
							<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole" disabled="disabled">Role</button>
						</div>
						<div class="hidden" id="userRoleBtns">
							<p class="disclaimer">Upon clicking ‘Add,’ a registration link will be sent to this user.</p>
							<button type="button" class="btn btn-sm btn-default btn-cancel show-hide go-to-userlist" data-hide="#addUserRole, #userRoleBtns" data-show="#addUserLink, #outletStep3Btns, #userPermissionsList">Cancel</button>
							<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide addUserToBrand" disabled id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole">Add</button>
						</div>
					</footer>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 brand-step inactive" id="brandStep4">
				<div class="container-brand-step">
					<h3 class="text-xs-center">Step 4</h3>
					<h4 class="text-xs-center">Post Tags<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h4>
					<div class="add-brand-details brand-fields border-bottom border-black">
						<div id="selectedTags" class="tag-list selected-items hidden">
							<ul>
							</ul>
						</div>
						<a href="#brandOutlets" id="addTagLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addTagLink, #outletStep4Btns, #selectedTags" data-show="#selectBrandTags, #addTagBtns"><i class="tf-icon circle-border">+</i>Add Tag</a>
						<div id="selectBrandTags" class="hidden">
							<h5 class="text-xs-center border-bottom border-black ">Add a Tag</h5>
							<h5 class="border-title"><span>Select Tag Color</span></h5>
							<div class="tag-list">
								<ul>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ef3c39"><i class="fa fa-circle" style="color:#ef3c39;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ff7bac"><i class="fa fa-circle" style="color:#ff7bac;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#f7931e"><i class="fa fa-circle" style="color:#f7931e;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#ffdf7f"><i class="fa fa-circle" style="color:#ffdf7f;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#8cc63f"><i class="fa fa-circle" style="color:#8cc63f;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#009245"><i class="fa fa-circle" style="color:#009245;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#58b0e3"><i class="fa fa-circle" style="color:#58b0e3;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#0071bc"><i class="fa fa-circle" style="color:#0071bc;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#662d91"><i class="fa fa-circle" style="color:#662d91;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag[]" checked="checked" value="#a75574"><i class="fa fa-circle" style="color:#a75574;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#a67c52"><i class="fa fa-circle" style="color:#a67c52;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#c7b299"><i class="fa fa-circle" style="color:#c7b299;"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" name="brand-tag[]" checked="checked" value="#bfbfbf"><i class="fa fa-circle" style="color:#bfbfbf;"></i></li>
									<li class="tag hidden custom-tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up color" checked="checked" name="brand-tag[]" value=""><i class="fa fa-circle tag-custom"></i></li>
									<li class="tag" data-value="" data-group="brand-tag"><a href="#" id="chooseTagColor"><i class="tf-icon circle-border">+</i></a></li>
								</ul>
							</div>
							<div class="form-group">
								<select class="form-control" name="tagLabel" id="tagLabel">								
									<option value="">Select Label</option>
									<option value="other">+ Add Label</option>
								</select>
							</div>
							<div class="form-group hidden" id="otherTagLabel">
								<input type="text" class="form-control" name="otherTagLabel" id="newLabel">
							</div>
						</div>
					</div>
					<footer class="post-content-footer">
						<div id="outletStep4Btns">
							<div class="disclaimer"><button class="btn btn-sm btn-default skip_step" type="button">Skip this Step</button></div>
							<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="3">Back</button>
							<button type="button" class="btn btn-sm btn-disabled pull-sm-right submit_tag" disabled="disabled">Done</button>
						</div>
						<div id="addTagBtns" class="hidden">
							<button type="button" class="btn btn-sm btn-default show-hide" data-show="#addTagLink, #outletStep4Btns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns">Cancel</button>
							<button class="btn btn-sm btn-disabled pull-sm-right btn-secondary show-hide" data-show="#addTagLink, #outletStep4Btns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns" id="addTag" disabled="disabled">Add</button>
						</div>
					</footer>
				</div>
			</div>
		</div>
		<div class="modal-backdrop fade in modal-contain backdrop-height"></div>
		<div class="hidden" id="addBrandSuccess"><a href="dashboard.php" class="btn btn-secondary btn-sm" tabindex="0" data-content="CONGRATULATIONS!<br><br>You’ve just added your first brand. Go to the brand dashboard to create your first post, view calendar, and more.">Go to Brand Dashboard</a></div>
	</div>
	</form>
</section>