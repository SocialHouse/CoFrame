<div class="row">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr>
					<th>Post day</th>
					<th>Post time</th>
					<th>Tags</th>
					<th>Outlet</th>
					<th>Post copy</th>
					<th>Approvals</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($approval_list))
				{
					$i = 0;
					$previous_date = '';
					foreach($approval_list as $key=>$approval)
					{						
						?>						
							<?php
								$show_date = 0;
								if($i == 0)
								{
									$previous_date = $key;
									$show_date = 1;
								}
								else
								{
									if($previous_date != $key)
									{
										$previous_date = $key;
										$show_date = 1;
									}
								}								

								foreach($approval as $post)
								{
									?>
									<tr>
										<?php
										if($show_date == 1)
										{
											?>
											<td><?php echo $key; ?></td>
											<?php
											$show_date = 0;
										}
										else
										{
											?>
											<td></td>
											<?php
										}
										?>										
										<td><?php echo date('h:i A',strtotime($post->slate_date_time)); ?></td>
										<?php $tags = get_post_tags($post->post_id); ?>
										<td><?php echo !empty($tags) ? implode(',',(array_column($tags,'name'))): ''; ?></td>
										<td><?php echo get_outlet_by_id($post->outlet_id); ?></td>
										<td><?php echo $post->content; ?></td>
										<?php $approvers = get_approvers_by_phase($post->phase_id); ?>
										<td><?php echo !empty($approvers) ? implode(',',(array_column($approvers,'first_name'))): ''; ?></td>
										<td><button type="button" class="btn btn-default">Approve</button>&nbsp;<button type="button" class="btn btn-primary">Suggest edit request</button></td>
									</tr>
									<?php
								}
							?>						
						<?php
						$i++;
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