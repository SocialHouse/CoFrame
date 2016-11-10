<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Accounts
		</h3>
	</div>

	<div class="panel-body">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Company</th>
					<th>Plan</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($accounts))
				{
					foreach ($accounts as $account) 
					{
						?>
						<tr>
							<td><?php echo ucfirst($account->first_name); ?></td>
							<td><?php echo ucfirst($account->last_name); ?></td>
							<td><?php echo $account->email; ?></td>
							<td><?php echo $account->phone; ?></td>
							<td><?php echo ucfirst($account->company_name); ?></td>
							<td><?php echo ucfirst($account->plan); ?></td>
							<td>
								<a href="<?php echo base_url().'accounts/edit-account/'.$account->id; ?>">Edit</a> |
								<a href="<?php echo base_url().'accounts/sub-users/'.$account->id; ?>">Users</a> |
								<a href="<?php echo base_url().'accounts/brands/'.$account->id; ?>">Brands</a> |
								<?php
								$text = 'Unban';
								if($account->banned == 0)
								{
									$text = 'Ban';
								}
								?>
								<a href="<?php echo base_url().'admin/accounts/change_status/'.$account->id.'/'.$account->banned; ?>"><?php echo $text; ?></a>
							</td>
						</tr>
						<?php
					}
				}
				else
				{
					?>
					<tr>
						<td colspan="5">No data available</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>