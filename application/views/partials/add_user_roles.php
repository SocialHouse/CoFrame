
<div id="addUserRole" class="hidden">
	<h5 class="text-xs-center border-bottom border-black ">Set Role<i class="fa fa-question-circle-o" tabindex="0" data-toggle="popover-inline" data-placement="bottom" data-popover-id="set-role"data-popover-class="popover-inline" data-attachment="top left" data-target-attachment="bottom center" data-offset-x="-22" data-popover-width="400" data-popover-arrow="true" data-arrow-corner="top left"></i></h5>
	<div class="permissions-current-user text-xs-center">
		<img src="<?php echo img_url(); ?>fpo/norel.jpg" width="36" height="36" alt="Norel Mancuso" class="circle-img user-img-preview"/>
		<span class="user-name-role"></span>
	</div>
	<div class="form-group">
		<label>Role:</label>
		<select class="form-control" id="userRoleSelect">
			<option value="">Select Role</option>
			<?php
			if(!empty($groups))
			{
				foreach($groups as $group)
				{
					?>
					<option value="<?php echo strtolower($group->name); ?>"><?php echo $group->name; ?></option>
					<?php
				}
			}
			?>			
		</select>
	</div>
	<div id="adminPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="adminPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">

			<li>Create <input type="checkbox" class="hidden-xs-up" name="admin-permissions[]" value="create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="create" data-group="admin-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="admin-permissions[]" value="edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="edit" data-group="admin-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Approve <input type="checkbox" class="hidden-xs-up" name="admin-permissions[]" value="approve" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="approve" data-group="admin-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="admin-permissions[]" value="view" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="view" data-group="admin-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Brand Settings <input type="checkbox" class="hidden-xs-up" name="admin-permissions[]" value="settings" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="settings" data-group="admin-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Billing <input type="checkbox" class="hidden-xs-up" name="admin-permissions[]" value="billing" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="billing" data-group="admin-permissions[]"><i class="fa fa-check"></i></i></li>
			
		</ul>
	</div>
	<div id="managerPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="managerPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="manager-permissions[]" value="create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="create" data-group="manager-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="manager-permissions[]" value="edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="edit" data-group="manager-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Approve <input type="checkbox" class="hidden-xs-up" name="manager-permissions[]" value="approve" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="approve" data-group="manager-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="manager-permissions[]" value="view" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="view" data-group="manager-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="manager-permissions[]" value="settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="settings" data-group="manager-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Billing <input type="checkbox" class="hidden-xs-up" name="manager-permissions[]" value="billing"><i class="tf-icon check-box circle-border pull-sm-right" data-value="billing" data-group="manager-permissions[]"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="creatorPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="creatorPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="creator-permissions[]" value="create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="create" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="creator-permissions[]" value="edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="edit" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Approve <input type="checkbox" class="hidden-xs-up" name="creator-permissions[]" value="approve"><i class="tf-icon check-box circle-border pull-sm-right" data-value="approve" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="creator-permissions[]" value="view" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="view" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="creator-permissions[]" value="settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="settings" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Billing <input type="checkbox" class="hidden-xs-up" name="creator-permissions[]" value="billing"><i class="tf-icon check-box circle-border pull-sm-right" data-value="Billing" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="approverPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="approverPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li>Create <input type="checkbox" class="hidden-xs-up" name="approver-permissions[]" value="create" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="create" data-group="approver-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Edit <input type="checkbox" class="hidden-xs-up" name="approver-permissions[]" value="edit" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="edit" data-group="approver-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Approve <input type="checkbox" class="hidden-xs-up" name="approver-permissions[]" value="approve" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="approve" data-group="approver-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>View Content <input type="checkbox" class="hidden-xs-up" name="approver-permissions[]" value="view" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="view" data-group="creator-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="approver-permissions[]" value="sttings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="sttings" data-group="approver-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Billing <input type="checkbox" class="hidden-xs-up" name="approver-permissions[]" value="billing"><i class="tf-icon check-box circle-border pull-sm-right" data-value="billing" data-group="approver-permissions[]"><i class="fa fa-check"></i></i></li>
		</ul>
	</div>
	<div id="billingPermissions" class="permission-details hidden">
		<p class="clearfix">Permissions: <button type="button" title="Edit Phase" class="btn-icon btn-gray pull-sm-right edit-permissions" data-section="billingPermissions"><i class="fa fa-pencil"></i></button></p>
		<ul class="timeframe-list permissions-list view">
			<li class="hidden">Create <input type="checkbox" class="hidden-xs-up" name="billing-permissions[]" value="create"><i class="tf-icon check-box circle-border pull-sm-right" data-value="create" data-group="billing-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Edit <input type="checkbox" class="hidden-xs-up" name="billing-permissions[]" value="edit"><i class="tf-icon check-box circle-border pull-sm-right" data-value="edit" data-group="billing-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Approve <input type="checkbox" class="hidden-xs-up" name="billing-permissions[]" value="approve"><i class="tf-icon check-box circle-border pull-sm-right" data-value="approve" data-group="billing-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">View Content <input type="checkbox" class="hidden-xs-up" name="billing-permissions[]" value="view"><i class="tf-icon check-box circle-border pull-sm-right" data-value="view" data-group="billing-permissions[]"><i class="fa fa-check"></i></i></li>
			<li class="hidden">Brand Settings <input type="checkbox" class="hidden-xs-up" name="billing-permissions[]" value="settings"><i class="tf-icon check-box circle-border pull-sm-right" data-value="settings" data-group="billing-permissions[]"><i class="fa fa-check"></i></i></li>
			<li>Billing <input type="checkbox" class="hidden-xs-up" name="billing-permissions[]" value="billing" checked><i class="tf-icon check-box circle-border pull-sm-right selected" data-value="billing" data-group="billing-permissions[]"><i class="fa fa-check"></i></i></li>
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
