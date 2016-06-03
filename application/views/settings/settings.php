<?php $this->load->view('partials/brand_nav'); ?>
 
			<section id="brand-manage" class="page-main bg-white col-sm-10">
				<form action="http://timeframe.localhost:8080/static/create-post.php//?" id="add-brand-details" class="file-upload clearfix row-sm-12">	
				<div class="row row-sm-12 equal-cols relative-wrapper">
					<div class="brand-steps col-xl-11 center-block">
						<div class="col-md-3 col-sm-6 brand-step" id="brandStep1">
							<div class="container-brand-step">
	<h3 class="text-xs-center">Step 1</h3>
	<h4 class="text-xs-center">Add Brand</h4>
	<div class="brand-logo">
		<img src="<?php echo img_url(); ?>fpo/jbrand-brand-logo.png" alt="J Brand" class="circle-img center-block">
	</div>
	<div class="saved-items">
		<ul class="text-xs-center">
			<li class="brand-title"><?=$brand->name?></li>
			<li><span class="brand-time"><?php echo $timezone; ?></span></li>
		</ul>
	</div>
	<div class="hidden brand-fields">
		<div class="form-group">
			<div class="form__input center-block brand-logo">
				<input type="file" name="files[]" id="brandFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
				<label for="brandFile" id="brandFileLabel" class="file-upload-label">Click to upload <span class="form__dragndrop">or drag &amp; drop here</span></span></label>
				<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
			</div>
			<div class="form__uploading">Uploading ...</div>
			<div class="form__success">Done!</div>
			<div class="form__error">Error! <span></span></div>
		</div>
		<div class="form-group">
			<label for="brandName">Brand Name:</label>
			<input type="text" class="form-control" id="brandName" placeholder="INSERT BRAND NAME">
		</div>
		<div class="form-group">
			<label>Brand Time Zone:</label>
			<select class="form-control">
				<option value="">Select Brand Time Zone</option>
			</select>
		</div>
	</div>
	<footer class="post-content-footer">
		<button type="reset" class="btn btn-sm btn-default hidden">Cancel</button>
		<button type="button" class="btn btn-sm btn-disabled pull-sm-right btn-next-step hidden" data-active-class="btn-secondary" data-next-step="2">Next</button>
	</footer>
</div>						</div>
						<div class="col-md-3 col-sm-6 brand-step" id="brandStep2">
							<div class="container-brand-step">
	<h3 class="text-xs-center">Step 2</h3>
	<h4 class="text-xs-center">Brand Outlets</h4>
	<div class="outlet-list saved-items"> 
		<?php 
			if(!empty($outlets))
			{
				?>
				<ul>
				<?php
				foreach($outlets as $outlet)
				{
					$class = strtolower($outlet->outlet_name);
					if(strtolower($outlet->outlet_name) == 'youtube')
					{
						$class = 'youtube-play';
					}
					?> 
					<li data-outlet="<?php echo strtolower($outlet->outlet_name); ?>"><i class="fa fa-<?php echo $class; ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span></i><?php echo strtolower($outlet->outlet_name); ?></li>
					<?php
				}
				?>
				</ul>
				<?php
			}
		?>	  
	</div>
	<div class="add-brand-details brand-fields border-bottom border-black hidden">
		<div id="selectedOutlets" class="outlet-list selected-items">
			<ul>
			</ul>
		</div>		
		<a href="#brandOutlets" id="addOutletLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addOutletLink, #outletStep2Btns, #selectedOutlets" data-show="#brandOutlets, #addOutletBtns"><i class="tf-icon circle-border">+</i>Add Outlet</a>
		<div id="brandOutlets" class="outlet-list">
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
		<div id="outletStep2Btns" class="hidden">
			<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="1">Back</button>
			<button type="button" class="btn btn-sm btn-disabled pull-sm-right btn-next-step" data-next-step="3" data-active-class="btn-secondary">Next</button>
		</div>
		<div class="hidden" id="addOutletBtns">
			<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Cancel</button>
			<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addOutlet" data-hide="#addOutletBtns, #brandOutlets" data-show="#outletStep2Btns, #addOutletLink, #selectedOutlets">Add</button>
		</div>
	</footer>
</div>						</div>
						<div class="col-md-3 col-sm-6 brand-step" id="brandStep3">
							<div class="container-brand-step">
	<h3 class="text-xs-center">Step 3</h3>
	<h4 class="text-xs-center">Users &amp; Permissions</h4>
	<div class="user-permissions-list">
		<div class="clearfix">
			<div class="pull-sm-right">
				<div class="table-header">
					<div class="permission">Create</div>
				</div>
				<div class="table-header">
					<div class="permission">Edit</div>
				</div>
				<div class="table-header">
					<div class="permission">Approve</div>
				</div>
				<div class="table-header">
					<div class="permission">View Content</div>
				</div>
				<div class="table-header">
					<div class="permission">Brand Settings</div>
				</div>
				<div class="table-header">
					<div class="permission">Billing</div>
				</div>
			</div>
		</div>
		<?php 
			if(!empty($users))
			{ 
				foreach($users as $user)
				{ 
					?> 
					<div class="table">
						<div class="table-cell">
							<div class="pull-sm-left"><img src="<?php echo img_url(); ?>fpo/norel.jpg" width="36" height="36" alt="" class="circle-img"/></div>
							<div class="pull-sm-left post-approver-name"><strong><?php echo $user->first_name . " " . $user->last_name; ?></strong><?php echo get_user_groups($user->aauth_user_id); ?></div>
						</div> 

						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"create")) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"edit")) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"approve")) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"view")) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"settings")) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div>
						<div class="table-cell text-xs-center vertical-middle has-permission">
							<?php 
								if (check_user_perm($user->aauth_user_id,"billing")) {
									?> 
									<i class="fa fa-check"></i>
									<?php
								}
							?> 
						</div> 
					</div> 
					<?php
				} 
			}
		?>	   
	</div>
	<div class="hidden brand-fields">
			<div id="userPermissionsList" class="user-permissions-list">
		<div class="clearfix">
			<div class="pull-sm-right">
				<div class="table-header">
					<div class="permission">Create</div>
				</div>
				<div class="table-header">
					<div class="permission">Edit</div>
				</div>
				<div class="table-header">
					<div class="permission">Approve</div>
				</div>
				<div class="table-header">
					<div class="permission">View Content</div>
				</div>
				<div class="table-header">
					<div class="permission">Brand Settings</div>
				</div>
				<div class="table-header">
					<div class="permission">Billing</div>
				</div>
			</div>
		</div>
		<div class="table">
			<div class="table-cell">
				<div class="pull-sm-left"><img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Norel Mancuso</strong>Master Admin</div>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
		</div>
	</div>
		<a href="#addUser" id="addUserLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addUserLink, #outletStep3Btns, #userPermissionsList" data-show="#addNewUser, #addUserBtns"><i class="tf-icon circle-border">+</i>Add User</a>
		
<div id="addNewUser" class="outlet-list hidden">
	<h5 class="text-xs-center border-bottom border-black ">Add a User</h5>
	<div class="form-group">
		<div class="form__input center-block">
			<input type="file" name="files[]" id="userFile" class="form__file" data-multiple-caption="{count} files selected" multiple>
			<label for="userFile" id="userFileLabel" class="file-upload-label">Upload photo</label>
			<button type="submit" class="form__button btn btn-sm btn-default">Upload</button>
		</div>
		<div class="form__uploading">Uploading ...</div>
		<div class="form__success">Done!</div>
		<div class="form__error">Error! <span></span></div>
	</div>
	<div class="form-group input-margin">
		<label for="firstName">User Info:</label>
		<input type="text" class="form-control" id="firstName" placeholder="First Name">
		<input type="text" class="form-control" id="lastName" placeholder="Last Name">
		<input type="text" class="form-control" id="userTitle" placeholder="Title (Optional)">
		<input type="email" class="form-control" id="userEmail" placeholder="Email">
	</div>
	
	<h5 class="border-title"><span>Permitted Outlets</span></h5>
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
	<input type="hidden" id="userOutlet">
</div>
		
<div id="addUserRole" class="hidden">
	<h5 class="text-xs-center border-bottom border-black ">Set Role<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover-inline" data-placement="bottom" data-popover-id="set-role"data-popover-class="popover-inline" data-attachment="top left" data-target-attachment="bottom center" data-offset-x="-22" data-popover-width="400" data-popover-arrow="true" data-arrow-corner="top left"></i></h5>
	<div class="permissions-current-user text-xs-center">
		<img src="assets/images/fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img"/>
		Norel Mancuso
	</div>
	<div class="form-group">
		<label>Role:</label>
		<select class="form-control" id="userRoleSelect">
			<option value="">Select Role</option>
			<option value="master">Master Admin</option>
			<option value="manager">Manager</option>
			<option value="creator">Creator</option>
			<option value="approver">Approver</option>
			<option value="billing">Billing</option>
		</select>
	</div>
	<div id="masterPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="masterPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="master-permissions" value="Create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Create" data-group="master-permissions"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="master-permissions" value="Edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Edit" data-group="master-permissions"><i class="fa fa-check"></i></i></li>
			<li>Approve <input type="checkbox" class="hidden-xs-up" name="master-permissions" value="Approve" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Approve" data-group="master-permissions"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="master-permissions" value="View Content" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="View Content" data-group="master-permissions"><i class="fa fa-check"></i></i></li>
			<li>Brand Settings <input type="checkbox" class="hidden-xs-up" name="master-permissions" value="Brand Settings" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Brand Settings" data-group="master-permissions"><i class="fa fa-check"></i></i></li>
			<li>Billing <input type="checkbox" class="hidden-xs-up" name="master-permissions" value="Billing" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Billing" data-group="master-permissions"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="managerPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="managerPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="manager-permissions" value="Create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Create" data-group="manager-permissions"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="manager-permissions" value="Edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Edit" data-group="manager-permissions"><i class="fa fa-check"></i></i></li>
			<li>Approve <input type="checkbox" class="hidden-xs-up" name="manager-permissions" value="Approve" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Approve" data-group="manager-permissions"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="manager-permissions" value="View Content" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="View Content" data-group="manager-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="manager-permissions" value="Brand Settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Brand Settings" data-group="manager-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Billing <input type="checkbox" class="hidden-xs-up" name="manager-permissions" value="Billing"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Billing" data-group="manager-permissions"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="creatorPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="creatorPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="creator-permissions" value="Create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Create" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="creator-permissions" value="Edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Edit" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Approve <input type="checkbox" class="hidden-xs-up" name="creator-permissions" value="Approve"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Approve" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="creator-permissions" value="View Content" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="View Content" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="creator-permissions" value="Brand Settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Brand Settings" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Billing <input type="checkbox" class="hidden-xs-up" name="creator-permissions" value="Billing"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Billing" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="approverPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="approverPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="approver-permissions" value="Create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Create" data-group="approver-permissions"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="approver-permissions" value="Edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Edit" data-group="approver-permissions"><i class="fa fa-check"></i></i></li>
			<li>Approve <input type="checkbox" class="hidden-xs-up" name="approver-permissions" value="Approve" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Approve" data-group="approver-permissions"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="approver-permissions" value="View Content" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="View Content" data-group="creator-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="approver-permissions" value="Brand Settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Brand Settings" data-group="approver-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Billing <input type="checkbox" class="hidden-xs-up" name="approver-permissions" value="Billing"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Billing" data-group="approver-permissions"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="billingPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="billingPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li class="hidden">Create <input type="checkbox" class="hidden-xs-up" name="billing-permissions" value="Create"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Create" data-group="billing-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Edit <input type="checkbox" class="hidden-xs-up" name="billing-permissions" value="Edit"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Edit" data-group="billing-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Approve <input type="checkbox" class="hidden-xs-up" name="billing-permissions" value="Approve"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Approve" data-group="billing-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">View Content <input type="checkbox" class="hidden-xs-up" name="billing-permissions" value="View Content"><i class="tf-icon check-box circle-border pull-sm-right" data-value="View Content" data-group="billing-permissions"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="billing-permissions" value="Brand Settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Brand Settings" data-group="billing-permissions"><i class="fa fa-check"></i></i></li>
			<li>Billing <input type="checkbox" class="hidden-xs-up" name="billing-permissions" value="Billing" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="Billing" data-group="billing-permissions"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
</div>

<div id="set-role" class="hidden">
	<p><strong>Master Admin</strong><br>
	The Master Admin is the master of the account with the ability to control all brand and user settings and can: Create, Edit, Approve, View Content, User Settings, Brand Settings, Billing. </p>
		
	<p><strong>Manager</strong><br>
	The Manager is the manager of this brand, with the ability to control most of the brand settings and can: Create, Edit, Approve, View Content, Brand Settings.</p>
		
	<p><strong>Creator</strong><br>
	The Creator is creating posts and calendars, and can: Create, Edit, View Content.</p>
		
	<p><strong>Approver</strong><br>
	The Approver is approving posts/calendars and can: Approve, View Content.</p>
		
	<p><strong>Billing</strong><br>
	Billing can view: Billing.</p>
</div>
	</div>
	<footer class="post-content-footer">
		<div class="hidden" id="outletStep3Btns">
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
</div>						</div>
						<div class="col-md-3 col-sm-6 brand-step" id="brandStep4">
							<div class="container-brand-step">
	<h3 class="text-xs-center">Step 4</h3>
	<h4 class="text-xs-center">Post Tags<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover" data-placement="bottom" data-content="Whatever cray disrupt ethical. Williamsburg wolf pabst meh blue bottle next level. Blue bottle flannel locavore pour-over, letterpress gluten-free fap ethical polaroid wayfarers trust fund man braid skateboard." data-popover-arrow="true"></i></h4>
	<div class="tag-list saved-items">
		<?php
		if (!empty($tags)) {
			?>
			<ul>
				<?php
				foreach($tags as $key => $tag) {
					?>
					<li class="tag" data-value="<?php echo $tag->name; ?>" data-group="brand-tag" data-tag="<?php echo $tag->name; ?>"><i class="fa fa-circle tag-red" style="background-color:<?php echo $tag->name;?>"></i><?php echo $tag->name; ?></li> 
					<?php
				}
			?>
			</ul>
			<?php
		}
		?> 
	</div>
	<div class="add-brand-details brand-fields border-bottom border-black hidden">
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
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="red"><i class="fa fa-circle tag-red"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="pink"><i class="fa fa-circle tag-pink"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="orange"><i class="fa fa-circle tag-orange"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="yellow"><i class="fa fa-circle tag-yellow"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="green"><i class="fa fa-circle tag-green"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="green-dark"><i class="fa fa-circle tag-green-dark"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="blue"><i class="fa fa-circle tag-blue"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="blue-dark"><i class="fa fa-circle tag-blue-dark"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="purple-dark"><i class="fa fa-circle tag-purple-dark"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="purple"><i class="fa fa-circle tag-purple"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="brown"><i class="fa fa-circle tag-brown"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="tan"><i class="fa fa-circle tag-tan"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="gray"><i class="fa fa-circle tag-gray"></i></li>
					<li class="tag hidden custom-tag" data-value="" data-group="brand-tag"><input type="checkbox" class="hidden-xs-up" name="brand-tag" value="custom"><i class="fa fa-circle tag-custom"></i></li>
					<li class="tag" data-value="" data-group="brand-tag"><a href="#" id="chooseTagColor"><i class="tf-icon circle-border">+</i></a></li>
				</ul>
			</div>
			<div class="form-group">
				<select class="form-control" name="tagLabel" id="tagLabel">
					<option value="">Select Label</option>
					<option value="Marketing">Marketing</option>
					<option value="E-Commerce">E-Commerce</option>
					<option value="Sales">Sales</option>
					<option value="Promotion">Promotion</option>
					<option value="other">+ Add Label</option>
				</select>
			</div>
			<div class="form-group hidden" id="otherTagLabel">
				<input type="text" class="form-control" name="otherTagLabel">
			</div>
		</div>
	</div>
	<footer class="post-content-footer">
		<div class="hidden" id="outletStep4Btns">
			<div class="disclaimer"><button class="btn btn-sm btn-default" type="submit">Skip this Step</button></div>
			<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="3">Back</button>
			<button type="submit" class="btn btn-sm btn-disabled pull-sm-right btn-next-step btn-secondary" disabled>Done</button>
		</div>
		<div id="addTagBtns" class="hidden">
			<button type="button" class="btn btn-sm btn-default show-hide" data-show="#addTagLink, #outletStep4Btns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns">Cancel</button>
			<button class="btn btn-sm btn-disabled pull-sm-right btn-secondary show-hide" data-show="#addTagLink, #outletStep4Btns, #selectedTags" data-hide="#selectBrandTags, #addTagBtns" id="addTag">Add</button>
		</div>
	</footer>
</div>						</div>
					</div>
				</div>
				</form>
			</section>
		</div>
	</div>

	 