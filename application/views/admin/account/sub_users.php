<div class="panel panel-default">
	<div class="panel-heading">		
		<div class="row">
			<div class="col-sm-10">
				<h3 class="panel-title">
					Sub users					
				</h3>
			</div>
			<div class="col-sm-2">
				<a href="<?php echo base_url('admin/accounts'); ?>" class="btn btn-primary pull-right">Back</a>
			</div>
		</div>
	</div>

	<div class="panel-body">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Title</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Verification status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($sub_users))
				{
					foreach ($sub_users as $user) 
					{
						?>
						<tr>
							<td><?php echo ucfirst($user->first_name); ?></td>
							<td><?php echo ucfirst($user->last_name); ?></td>
							<td><?php echo ucfirst($user->title); ?></td>
							<td><?php echo $user->email; ?></td>
							<td><?php echo $user->phone; ?></td>
							<td>
								<?php 
								if(!empty($user->verification_code))
								{
									echo "Not verified";
								}
								else
								{
									echo "Verified";	
								}
								?>
							</td>
							<td>
								<a href="<?php echo base_url().'users/edit-account/'.$user->aauth_user_id.'/'.$account_id; ?>">Edit</a>
								<?php
								$text = 'Unban';
								if($user->banned == 0)
								{
									$text = 'Ban';
								}

								if(empty($user->verification_code))
								{
									?>
									|
									<a href="<?php echo base_url().'admin/accounts/change_status/'.$user->aauth_user_id.'/'.$user->banned.'/'.$account_id; ?>"><?php echo $text; ?></a>
									<?php
								}
								?>
							</td>
						</tr>
						<?php
					}
				}
				else
				{
					?>
					<tr>
						<td colspan="6">No data available</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>