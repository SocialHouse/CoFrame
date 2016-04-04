<div class="row">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Color</th>
					<th>Created at</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($brand_tags))
				{
					foreach($brand_tags as $tag)
					{
						?>
						<tr>
							<td><?php echo $tag->name; ?></td>
							<td style="background-color:<?php echo $tag->color; ?>"></td>
							<td><?php echo date('d M,Y',strtotime($tag->created_at)); ?></td>							
							<td>
								<a href="<?php echo base_url().'tags/edit_tags/'.$tag->id; ?>">Edit</a> | 
								<?php
								if($tag->status == 1)
								{
									?>
									<a href="<?php echo base_url().'tags/deactivate/'.$tag->id; ?>">Inactive</a>
									<?php
								}
								else
								{
									?>
									<a href="<?php echo base_url().'tags/activate/'.$tag->id; ?>">Active</a> 
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