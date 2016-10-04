<div class="row">
	<div class="col-sm-12">
		<table class="table">
			<thead>
				<tr>
					<th>Content</th>
					<th>Slated at</th>
					<th>Created at</th>
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
							<td><?php echo $post->content; ?></td>
							<td><?php echo date('d M,Y',strtotime($post->slate_date_time)); ?></td>
							<td><?php echo date('d M,Y',strtotime($post->created_at)); ?></td>							
							<td>
								<a onclick="return confirm('Are you sure, you want to delete this post?');" href="<?php echo base_url().'posts/delete/'.$post->brand_id.'/'.$post->id; ?>">Delete</a>
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