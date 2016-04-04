<h2>Users for: <?php echo $brand_name; ?></h2>
<div class="row">
	<div class="form-group col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Email</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($brands_user))
				{
					foreach($brands_user as $brand)
					{
						?>
						<tr>
							<td><?php echo $brand->first_name; ?></td>
							<td><?php echo $brand->last_name; ?></td>
							<td><?php echo $brand->email; ?></td>
							<td>
								<a href="<?php echo base_url().'brand_users/edit_user/'.$brand->id; ?>">Edit</a> | 
								<a onclick="return confirm('Are you sure, you want to delete this user?');" href="<?php echo base_url().'brand_users/delete_user/'.$brand->id; ?>">Delete</a>								
							</td>
						</tr>
						<?php
					}
				}
				else
				{
					echo "<tr><td colspan='4'>No data available</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div>