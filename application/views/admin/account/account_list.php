<header class="section-header">
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h2>Accounts</h2>				
			</div>
		</div>
	</div>
</header>


		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Company</th>
					<th>Plan</th>
					<th class="tabledit-toolbar-column">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(!empty($accounts))
				{
					foreach ($accounts as $account) 
					{
						?>
						<tr>
							<td><?php echo ucfirst($account->first_name); ?></td>
							<td><?php echo ucfirst($account->last_name); ?></td>
							<td><?php echo $account->email; ?></td>
							<td><?php echo $account->phone; ?></td>
							<td><?php echo ucfirst($account->company_name); ?></td>
							<td><label class="label label-success"><?php echo ucfirst($account->plan); ?></label></td>
							<td style="white-space: nowrap; width: 1%;">
								<div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
                                    <div class="btn-group btn-group-sm" style="float: none;">
                                    	<a data-toggle="tooltip" data-placement="bottom" target="_blank" data-original-title="Login" href="<?php echo base_url().'tour/login_fast/'.$account->id; ?>" class="tabledit-edit-button btn btn-sm btn-default" style="float: none;">
                                    		<span class="font-icon font-icon-user"></span>
                                    	</a>
                                    	<?php
										$class = 'glyphicon glyphicon-ok-circle';
										$title = "Unban";
										if($account->banned == 0)
										{
											$title = "Ban";
											$class = 'glyphicon glyphicon-ban-circle';
										}
										?>
                                    	<a  data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $title; ?>" href="<?php echo base_url().'admin/accounts/change_status/'.$account->id.'/'.$account->banned; ?>" class="tabledit-delete-button btn btn-sm btn-default" style="float: none;">
                                    		<span class="<?php echo $class; ?>"></span>
                                    	</a>
                                    </div>                                  
                               </div>
                            </td>

							<!-- <td style="white-space: nowrap; width: 1%;">
								<div class="tabledit-toolbar btn-toolbar" style="text-align: left;">
									<div class="btn-group btn-group-sm" style="float: none;">
										<button type="button" class="tabledit-edit-button btn btn-sm btn-default" style="float: none;">
											<span class="font-icon font-icon-user"></span>
										</button>
										<button type="button" class="tabledit-delete-button btn btn-sm btn-default" style="float: none;">
											<span class="glyphicon glyphicon-trash"></span>
										</button>
									</div>
								</div> -->

								<!-- <a target="_blank" href="<?php echo base_url().'tour/login_fast/'.$account->id; ?>">Login</a> |
								<a href="<?php echo base_url().'accounts/edit-account/'.$account->id; ?>">Edit</a> |
								<a href="<?php echo base_url().'accounts/sub-users/'.$account->id; ?>">Users</a> |
								<a href="<?php echo base_url().'accounts/brands/'.$account->id; ?>">Brands</a> |
								<?php
								$text = 'Unban';
								if($account->banned == 0)
								{
									$text = 'Ban';
								}
								?>
								<a href="<?php echo base_url().'admin/accounts/change_status/'.$account->id.'/'.$account->banned; ?>"><?php echo $text; ?></a> -->
							<!-- </td> -->
						</tr>
						<?php
					}
				}
				else
				{
					?>
					<tr>
						<td colspan="5">No data available</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>