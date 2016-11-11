<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-10">
				<h3 class="panel-title">
					Brands					
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
							<td><a href="<?php echo base_url().'brand/brand-details/'.$brand->account_id.'/'.$brand->id; ?>">Details</a> |
							<?php
							$text = 'Unhide';
							if($brand->is_hidden == 0)
							{
								$text = 'Hide';
							}
							?>
							<a href="<?php echo base_url().'admin/brands/chane_brand_status/'.$brand->account_id.'/'.$brand->id.'/'.$brand->is_hidden; ?>"><?php echo $text; ?></a></td>
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