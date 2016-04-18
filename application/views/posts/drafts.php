<div class="row">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th><input type="checkbox"/></th>
					<th>Last saved</th>
					<th>Tags</th>
					<th>Outlet</th>
					<th>Post copy</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($posts))
				{
					foreach($posts as $post)
					{
						?>
						<tr>
							<td><input type="checkbox"/></td>
							<td><?php echo date('d M,Y',strtotime($post->slate_date_time)); ?></td>
							<td><?php echo !empty(get_post_tags($post->id)) ? implode(',',(array_column(get_post_tags($post->id),'name'))): ''; ?></td>
							<td><?php echo $post->outlet_name; ?></td>
							<td><?php echo $post->content; ?></td>
							<td>
								<a href="<?php echo base_url().'posts/edit/'.$post->id; ?>">Edit</a> |
								<a href="<?php echo base_url().'posts/duplicate/'.$post->brand_id.'/'.$post->id; ?>">Duplicate</a>
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