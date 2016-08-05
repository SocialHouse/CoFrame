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
						$outlet = get_outlet_by_id($post->outlet_id);

						$tags = get_post_tags($post->id);
						$tag_list = '';
						if(!empty($tags))
						{
							foreach ($tags as $tag) 
							{
								if(empty($tag_list))
								{
									$tag_list = ''.strtolower($tag['tag_name']);
								}
								else
								{
									$tag_list .= ' '.strtolower($tag['tag_name']);
								}
							}
						}
						?>
						<tr data-filters="<?php echo 'f-'.strtolower($outlet).' '.$tag_list.' '.'f-'.$post->status; ?>" class="post-approver f-<?php echo $post->status; ?> f-<?php echo strtolower($outlet); ?>">
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

							<td class="text-xs-center">
								<div class="post-tags">
									<?php													
									if(!empty($tags))
									{
										foreach($tags as $tag)
										{
											?>
											<i class="fa fa-circle" style="color:<?php echo $tag['tag_color']; ?>"></i>
											<?php
										}
									}
									?>
								</div>									
							</td>

							<td class="text-xs-center outlet-list">
								<i class="fa fa-<?php echo strtolower($outlet); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet); ?>"></span></i>
							</td>
							
							<td class="text-xs-center"><?php echo ucfirst($post->status); ?></td>

							<td><?php echo read_more($post->content,35); ?></td>
							<td class="text-xs-center">
								<?php 
								$approvers = get_post_approvers($post->id);
								if($approvers)
								{
									?>
									<ul class="timeframe-list approval-list">
										<?php
										$approver_status = '';
										$phase_id = '';
										foreach($approvers['result'] as $approver)
										{
											if($approver['user_id'] == $this->user_id)
											{
												$approver_status = $approver['status'];
												$phase_id = $approver['id'];
											}
											$image_path = img_url().'default_profile.jpg';
											if(file_exists(upload_path().$approvers['owner_id'].'/users/'.$approver['user_id'].'.png'))
											{
												$image_path = upload_url().$approvers['owner_id'].'/users/'.$approver['user_id'].'.png';
											}
											?>
											<li class="<?php echo $approver['status']; ?>">
												<img src="<?php echo $image_path; ?>" width="36" height="36" alt="<?php echo ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']); ?>" class="circle-img" data-toggle="popover-hover" data-content="<?php echo ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']); ?>">
											</li>
											<?php
										}
										?>
									</ul>
									<?php
								}
								?>	
							</td>										
							<td class="text-xs-center">
								<?php 
								// $is_edit_request = is_edit_request($post->id);
								// $btn_class = 'btn-disabled';
								// if($is_edit_request)
								// {
								// 	$btn_class = 'btn-secondary';
								// }

								if($approver_status == 'approved')
								{
									?>
									<a class="btn btn-xs btn-disabled btn-secondary">Approved</a>
									<?php
								}
								else
								{
									?>													
										<a class="btn btn-xs btn-secondary change-approve-status" data-post-id="<?php echo $post->id; ?>" id="approval_list_btn" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="approved">Approve</a>					
										<a class="btn btn-xs btn-disabled btn-secondary hide">Approved</a>
									<?php
								}

								?>
								
								<a href="<?php echo base_url().'edit-request/'.$post->id; ?>" class="btn btn-xs btn-wrap btn-default">Edit<br>Request</a></td>
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
		?>
		<tr>
			<td class="text-xs-center" colspan="8">Currently no approvals available.</td>
		</tr>
		<?php
	}
	?>
