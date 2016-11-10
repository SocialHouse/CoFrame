<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Sub-users
		</h3>
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
							<td><a href="<?php echo base_url().'/account/sub-users/'.$user->aauth_user_id; ?>"></a></td>
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