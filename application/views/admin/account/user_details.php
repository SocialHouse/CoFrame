<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Edit user
		</h3>
	</div>

	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo base_url('') ?>"  method="post" accept-charset="utf-8">
			<div class="form-group">
				<label class="control-label col-sm-2" >First name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo $user_details->first_name; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" >Last name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo $user_details->last_name; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" >Company</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="company" name="company" placeholder="Enter company name"  value="<?php echo $user_details->company_name; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2" >Title</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?php echo $user_details->title; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2" >Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $user_details->email; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2" >Phone</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="<?php echo $user_details->phone; ?>">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2" >Plan</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="plan" name="plan" value="<?php echo $user_details->plan; ?>" disabled="disabled">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2" >Status</label>

				<div class="col-sm-10">
					<label class="radio-inline">
						<input type="radio" name="status" value="1" <?php if($user_details->banned == 1) { echo 'checked="checked"'; } ?> >Ban
					</label>
					<label class="radio-inline">
						<input type="radio" name="status" value="0" <?php if($user_details->banned == 0) { echo 'checked="checked"'; } ?>>Unban
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>