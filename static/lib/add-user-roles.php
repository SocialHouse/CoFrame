
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
