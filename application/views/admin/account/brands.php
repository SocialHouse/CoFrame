<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Brands
		</h3>
	</div>

	<div class="panel-body">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created By</th>
					<th>Timezone</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($brands))
				{
					foreach ($brands as $brand) 
					{
						?>
						<tr>
							<td><?php echo ucfirst($brand->name); ?></td>
							<td><?php echo get_users_full_name($brand->created_by); ?></td>
							<td><?php echo get_time_zone($brand->timezone); ?></td>
							<td><a href="<?php echo base_url().'/account/sub-users/'; ?>"></a></td>
						</tr>
						<?php
					}
				}
				else
				{
					?>
					<tr>
						<td colspan="4">No data available</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>