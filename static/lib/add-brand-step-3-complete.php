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
		<div class="table">
			<div class="table-cell">
				<div class="pull-sm-left"><img src="assets/images/fpo/david.jpg" width="36" height="36" alt="David Weinberg" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>David Weinberg</strong>Manager</div>
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
			</div>
		</div>
		<div class="table">
			<div class="table-cell">
				<div class="pull-sm-left"><img src="assets/images/fpo/kristin.jpg" width="36" height="36" alt="David Weinberg" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Kristin Patrick</strong>Approver</div>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
		</div>
		<div class="table border-bottom border-black">
			<div class="table-cell">
				<div class="pull-sm-left"><img src="assets/images/fpo/johan.jpg" width="36" height="36" alt="David Weinberg" class="circle-img"/></div>
				<div class="pull-sm-left post-approver-name"><strong>Johan Loekito</strong>Creator</div>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
				<i class="fa fa-check"></i>
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
			<div class="table-cell text-xs-center vertical-middle has-permission">
			</div>
		</div>
	</div>
	<div class="hidden brand-fields">
		<?php include("user-permission-list.php"); ?>
		<a href="#addUser" id="addUserLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addUserLink, #outletStep3Btns, #userPermissionsList" data-show="#addNewUser, #addUserBtns"><i class="tf-icon circle-border">+</i>Add User</a>
		<?php include("add-new-user.php"); ?>
		<?php include("add-user-roles.php"); ?>
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
		<div class="text-xs-center">
		<button type="button" class="btn btn-sm btn-default">Manage Users</button>
		</div>
	</footer>
</div>