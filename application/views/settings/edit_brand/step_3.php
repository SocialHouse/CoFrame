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
							<button type="button" class="btn btn-sm btn-default close_brand"  data-step-no="3">Cancel</button>
							<button type="button" id="add_user_next" class="btn btn-sm pull-sm-right btn-secondary"  data-step-no="3" >Save</button>
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