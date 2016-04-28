<div class="container-brand-step">
	<h3 class="text-xs-center">Step 3</h3>
	<h4 class="text-xs-center">Users &amp; Permissions</h4>
	<?php include("user-permission-list.php"); ?>
	<a href="#addUser" id="addUserLink" class="border-top border-bottom border-black add-link show-hide" data-hide="#addUserLink, #outletStepBtns, #userPermissionsList" data-show="#addNewUser, #addUserBtns"><i class="tf-icon circle-border">+</i>Add User</a>
	<?php include("add-new-user.php"); ?>
	<?php include("add-user-roles.php"); ?>
	<footer class="post-content-footer">
		<div id="outletStepBtns">
			<button type="button" class="btn btn-sm btn-default btn-next-step" data-next-step="2">Back</button>
			<button type="button" class="btn btn-sm pull-sm-right btn-next-step btn-secondary"  data-next-step="4">Next</button>
		</div>
		<div class="hidden" id="addUserBtns">
			<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addNewUser, #addUserBtns" data-show="#addUserLink, #outletStepBtns, #userPermissionsList">Cancel</button>
			<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole">Role</button>
		</div>
		<div class="hidden" id="userRoleBtns">
			<p class="disclaimer">Upon clicking ‘Add,’ a registration link
will be sent to this user.</p>
			<button type="button" class="btn btn-sm btn-default btn-cancel show-hide" data-hide="#addNewUser, #addUserBtns" data-show="#addUserLink, #outletStepBtns, #userPermissionsList">Cancel</button>
			<button type="button" class="btn btn-sm btn-disabled btn-secondary pull-sm-right show-hide" disabled id="addRole" data-hide="#addNewUser, #addUserBtns" data-show="#userRoleBtns, #addUserRole">Add</button>
		</div>
	</footer>
</div>