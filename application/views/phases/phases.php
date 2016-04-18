<div class="row">
	<div class="col-md-12">
		<table class="table">			
			<tbody>
				<?php
				if(!empty($phases))
				{
					foreach($phases as $key => $phase)
					{
						?>
						<tr>
							<th><?php echo "Phase: ".$key; ?></th>
							<td><a onclick="return confirm('Are you sure, you want to delete this phase?');" class="pull-right" href="<?php echo base_url().'phases/delete/'.$phase[0]->phase_id; ?>">&nbsp;Delete</a><a class="pull-right" href="<?php echo base_url().'phases/edit/'.$phase[0]->phase_id; ?>">Edit | </a></td>
						</tr>
						<?php
						foreach($phase as $user)
						{
							?>
							<tr>
								<td colspan="2"><?php echo ucfirst($user->first_name)." ".ucfirst($user->last_name); ?></td>
							</tr>
							<?php
						}
					}
				}
				else
				{
					echo "<tr><td>No phases available</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div>