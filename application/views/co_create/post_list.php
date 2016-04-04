<div class="row">
	<div class="form-group col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Content</th>
					<th>Slated at</th>
					<th>Created at</th>					
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