<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h2>Change password</h2>				
			</div>
		</div>
	</div>
</header>
<section class="card">
	<div class="card-block">
		<form action="<?php echo base_url().'admin/update-password'; ?>" method="POST" id="change_password_form">
			<div class="form-group row">
				<label class="col-sm-2 form-control-label">Current password</label>
				<div class="col-sm-10">
					<p class="form-control-static"><input class="form-control" id="inputPassword" placeholder="Enter current password" type="password" name="old_password"></p>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label">New password</label>
				<div class="col-sm-10">
					<p class="form-control-static"><input class="form-control" id="newPass" placeholder="Enter new password" type="password" name="password"></p>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label">Confirm password</label>
				<div class="col-sm-10">
					<p class="form-control-static"><input class="form-control" id="confirmPassword" placeholder="Confirm new password" type="password" name="confirm_password"></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 form-control-label">&nbsp;</label>
				<button type="submit" class="btn btn-inline">Save</button>
				
			</div>
		</form>
	</div>
</section>