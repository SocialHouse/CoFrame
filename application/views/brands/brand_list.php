<div class="row">
	<div class="form-group col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created at</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($brands))
				{
					foreach($brands as $brand)
					{
						?>
						<tr>
							<td><?php echo $brand->name; ?></td>
							<td><?php echo date('d M,Y',strtotime($brand->created_at)); ?></td>							
							<td>
								<a href="<?php echo base_url().'brands/edit/'.$brand->id; ?>">Edit</a> | 
								<a href="<?php echo base_url().'brand_users/add_user/'.$brand->id; ?>">Add user</a> | 
								<a href="<?php echo base_url().'brand_users/index/'.$brand->id; ?>">Show users</a> | 
								<a href="<?php echo base_url().'outlets/add_outlet/'.$brand->id; ?>">Outlets</a> | 
								<a href="<?php echo base_url().'tags/index/'.$brand->id; ?>">Tags</a> | 
								<a href="<?php echo base_url().'tags/add_tags/'.$brand->id; ?>">Add tags</a> | 
								<a href="<?php echo base_url().'posts/index/'.$brand->id; ?>">Posts</a> | 
								<a href="<?php echo base_url().'posts/create/'.$brand->id; ?>">Add Post</a> | 
								<a href="<?php echo base_url().'posts/drafts/'.$brand->id; ?>">Drafts</a> | 
								<?php
								if($brand->is_hidden == 0)
								{
									?>
									<a href="<?php echo base_url().'brands/hide_brand/'.$brand->id; ?>">Hide</a>
									<?php
								}
								else
								{
									?>
									<a href="<?php echo base_url().'brands/un_hide_brand/'.$brand->id; ?>">Unhide</a> 
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
					echo "<tr><td colspan='3'>No data available</td></tr>";
				}
				?>
			</tbody>
		</table>
		<?php

		?>
	</div>
</div>