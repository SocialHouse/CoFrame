<div class="row">
	<div class="col-sm-12">
		<table class="table">
			<thead>
				<tr>
					<th colspan="2">Reminders</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($reminders))
				{
					foreach($reminders as $reminder)
					{
						?>
							<tr>
								<td><?php echo $reminder->content.' '.date('D m/d',strtotime($reminder->approve_by)); ?></td>
								<?php
								$symbol = '';
								if(date('Y-m-d',strtotime('-12 hours')) <= date('Y-m-d',strtotime($reminder->approve_by)) AND date('Y-m-d') >= date('Y-m-d',strtotime($reminder->approve_by)))
								{
									$symbol = '<span class="badge" >!</span>';
								}
								?>
								<td><?php echo $symbol; ?></td>
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