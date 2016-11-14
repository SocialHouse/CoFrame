<?php
				if(!empty($accounts))
				{
					foreach ($accounts as $account) 
					{
						?>
						<tr>
							<td><?php echo ucfirst($account->first_name).' '.ucfirst($account->last_name); ?></td>
							<td><?php echo $account->email; ?></td>
							<td><?php echo $account->phone; ?></td>
							<td><?php echo ucfirst($account->company_name); ?></td>
							<td><?php echo $account->brands_count; ?></td>
							<td><?php echo get_user_count($account->id); ?></td>
							<td><?php echo account_post_count($account->id); ?></td>
							<td><?php echo isset(get_last_transaction($account->id)->created_at) ? get_last_transaction($account->id)->created_at : '-'; ?></td>
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