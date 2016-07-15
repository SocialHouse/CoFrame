<?php 
	$this->load->view('partials/brand_nav'); 
	if(!empty($filters))
	{
		?>
		<input type="hidden" name="filter_id" id="filter-id" value="<?php echo $filters[0]->id; ?>">
		<?php
	}
?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<h2 class="date-header pull-xs-left">My Approvals</h2>	

			<div class="pull-md-right toolbar">
				<?php $this->load->view('partials/search_form'); ?>				
				<a href="#" class="tf-icon-circle pull-xs-left  post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/post_filters/'.$brand_id; ?>" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70" data-hide="false"><i class="tf-icon-filter"></i></a>
				<a href="#" class="tf-icon-circle pull-xs-left post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/print_posts/'.$brand_id; ?>" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20" data-hide="false"><i class="tf-icon-print"></i></a>

			</div>
		</div>
		<div id="selectedFilters" class="clearfix border-top border-black hidden">
			<strong class="uppercase">Filters: </strong>
			<ul class="filter-list tag-list">
				<?php 
				if(!empty($filters))
				{
					if(!empty($filters[0]->outlets))
					{
						$outlet_ids = explode(',',$filters[0]->outlets);
						foreach($outlet_ids as $id)
						{
							$outlet_name = strtolower(get_outlet_by_id($id));
							?>
							<li data-id="<?php echo $id; ?>" data-value="f-<?php echo $outlet_name; ?>" class="filter-remove-list outlet-list">
								<i class="fa fa-<?php echo $outlet_name; ?>">
									<span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span>
								</i>
							<i class="tf-icon-close"></i></li>
							<?php
						}
					}
					if(!empty($filters[0]->statuses))
					{
						$statuses = explode(',',$filters[0]->statuses);
						foreach($statuses as $status)
						{							
							?>
							<li data-status="<?php echo $status ?>" data-value="f-<?php echo $status; ?>" class="filter-remove-list outlet-list">
								<?php echo $status; ?>
								<i class="tf-icon-close"></i>
							</li>
							<?php
						}
					}

					if(!empty($filters[0]->tags))
					{
						$tags = explode(',',$filters[0]->tags);
						foreach($tags as $tag)
						{
							$tag = explode('__',$tag);
							?>
							<li data-value="<?php echo $tag[1]; ?>" class="filter-remove-list outlet-list">
								<i style="color:<?php echo $tag[0]; ?>" class="fa fa-circle tag-test"></i>
								<span class="tag-title"><?php echo $tag[1]; ?></span>
								<i class="tf-icon-close"></i>
							</li>
							<?php
						}
					}
				}
				?>
			</ul>
			<button type="button" class="btn btn-sm btn-secondary reset-filter pull-sm-right" data-filter="*">Reset Filters</button>
		</div>

		<div id="calendar-change-day" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
			<div class="text-xs-center">
				<hr>
				<button type="button" class="btn btn-sm btn-default qtip-hide">Cancel</button>
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-default btn-disabled qtip-hide approval-date-filter" disabled>Apply</button>
			</div>
		</div>

	</header>

	<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />	
	<input type="hidden" name="brand_id" id="brand-id" value="<?php echo $brand_id; ?>" />

	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-approvals">
				<thead>
					<tr>
						<th>Post Day</th>
						<th>Post Time</th>
						<th>Tags</th>
						<th>Outlet</th>
						<th>Status</th>
						<th>Post Copy</th>
						<?php
						$class = 'hide';
						$approval_shown = 1;
						if(!check_user_perm($this->user_id,'approve',$brand_id))
						{
							$class = '';
							$approval_shown = 0;
							?>
							<th>Approvals</th>
							<?php
						}

						if(check_user_perm($this->user_id,'create',$brand_id) AND $approval_shown == 1)
						{
							$class = '';
							?>
							<th>Approvals</th>
							<?php
						}

						if($this->user_id == $this->user_data['created_by'] OR $user_group == 'Manager' OR check_user_perm($this->user_id,'approve',$brand_id))
						{
							?>
							<th>Approval Deadline</th>
							<?php
						}
						?>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class="calendar-app">
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
												<td onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');"><?php echo $key; ?></td>
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
											<td onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');"><?php echo date('h:i A',strtotime($post->slate_date_time)); ?></td>

											<td class="text-xs-center" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');">
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

											<td class="text-xs-center outlet-list" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');">
												<i class="fa fa-<?php echo strtolower($outlet); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet); ?>"></span></i>
											</td>
											
											<td class="text-xs-center" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');"><?php echo ucfirst($post->status); ?></td>

											<td onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');"><?php echo read_more($post->content,35); ?></td>
											<?php
											$approvers = get_post_approvers($post->id);
											if($approvers)
											{
												$approver_status = '';
												$phase_status = '';
												$phase_id = '';
												$deadline = '';
												$approver_count = 0;
												if(!empty($approvers['result']))
												{
													$approver_count = 0;
													$show_additional_approvers = 0;
													$additional_approvers_html = '<ul class="timeframe-list approval-list"><li>
																			<button class="btn-icon btn-circle btn-menu showInvisible"><i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i> <i class="fa fa-circle-o"></i></button>
															<ul class="timeframe-list approval-list invisible">';
													$simple_user_list = '<ul class="timeframe-list approval-list">';
													$approved_status = [];
													foreach($approvers['result'] as $approver)
													{
														if($approver['status'] == 'approved')
														{
															array_push($approved_status, 'approved');
														}

														if($approver['user_id'] == $this->user_id)
														{
															$approver_status = $approver['status'];
															$phase_status = $approver['phase_status'];
															$phase_id = $approver['id'];
															$deadline = $approver['approve_by'];
														}
														$image_path = img_url().'default_profile.jpg';
														if(file_exists(upload_path().$approvers['owner_id'].'/users/'.$approver['user_id'].'.png'))
														{
															$image_path = upload_url().$approvers['owner_id'].'/users/'.$approver['user_id'].'.png';
														}
														$approver_count++;
														if($approver_count >= 4)
														{				
															$additional_approvers_html .= '<li class="'.$approver['status'].'">
																<img src="'.$image_path.'" width="36" height="36" alt="'.ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']).'" class="circle-img" data-toggle="popover-hover" data-content="'.ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']).'">
															</li>';
														
															$show_additional_approvers = 1;
														}
														else												
														{
															$approvers_html = '<li class="'.$approver['status'].'">
																<img src="'.$image_path.'" width="36" height="36" alt="'.ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']).'" class="circle-img" data-toggle="popover-hover" data-content="'.ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']).'">
															</li>';

															$simple_user_list .= $approvers_html;
															$additional_approvers_html .= $approvers_html;
														}
													}
												}
												
											}
											?>
											
												<?php
												if(isset($approvers['result']) AND count($approved_status) == count($approvers['result']))
												{
													?>
													<td class="<?php echo $class; ?>" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');">
													<a href="javascript:void(0)" class="btn btn-default color-success btn-xs">Complete</a>
													<?php
												}
												else
												{
													?>
													<td class="text-xs-center <?php echo $class; ?>" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');">
														<?php
														if($show_additional_approvers == 1)
														{
															echo $additional_approvers_html.'<li>
																<button class="btn-icon btn-circle btn-menu btn-close hideVisible">X</button>
															</li></ul>';
														}
														else
														{
															echo $simple_user_list;
														}
														?>
													</td>
													<?php
												}
												?>
											</td>
											
											<?php
											if($this->user_id == $this->user_data['created_by'] OR check_user_perm($this->user_id,'approve',$brand_id) OR !empty($deadline))
											{
												?>
												<td class="text-xs-center" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');">
													<?php
													if(!empty($deadline))
													{
														echo date('d/m/Y h:i A',strtotime($deadline));
													}
													else
													{
														echo "N/A";
													}
													?>
												</td>
												<?php
											}

											echo get_approval_list_buttons($post,$deadline,$phase_status,$user_group,$approver_status,$phase_id,$brand->id);
											?>
											
											<!-- <td class="text-xs-center">
												<?php
												if($approver_status == 'approved')
												{
													?>
													<a class="btn btn-xs btn-disabled btn-secondary">Approved</a>
													<?php
												}
												elseif($phase_status == 'pending' AND $post->status == 'pending')
												{
													?>	
													<div class="before-approve">
														<a class="btn btn-xs btn-secondary change-approve-status" data-post-id="<?php echo $post->id; ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="approved">Approve</a>
													</div>

													<div class="after-approve hide">
														<button class="btn btn-secondary btn-disabled btn-sm" disabled>Approved</button><br>
														<a class="change-approve-status"  data-post-id="<?php echo $post->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="pending" href="#">Undo</a>
													</div>
													<?php
												}
												elseif($post->status == 'pending')
												{
													?>
													<button class="btn btn-secondary btn-disabled btn-sm" disabled>Pending</button>
													<?php
												}
												elseif($post->status == 'scheduled')
												{
													if($user_group != 'Approver')
													{
														?>
														<div class="before-approve">
															<button class="btn btn-secondary btn-disabled btn-sm" disabled>Scheduled</button><br>
															<a class="change-approve-status"  data-post-id="<?php echo $post->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="unschedule" href="#">Undo</a>
														</div>

														<div class="after-approve hide">
															<a class="btn btn-xs btn-secondary change-approve-status" data-post-id="<?php echo $post->id; ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="schedule">Schedule</a>
														</div>
														<?php
													}
												}
												elseif($post->status == 'approved')
												{
													if($user_group != 'Approver')
													{
														?>
														<div class="before-approve">
															<a class="btn btn-xs btn-secondary change-approve-status" data-post-id="<?php echo $post->id; ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="schedule">Schedule</a>
														</div>

														<div class="after-approve hide">
															<button class="btn btn-secondary btn-disabled btn-sm" disabled>Scheduled</button><br>
															<a class="change-approve-status"  data-post-id="<?php echo $post->id ?>" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="unschedule" href="#">Undo</a>
														</div>
														<?php
													}
												}
												elseif($post->status == 'posted')
												{
													?>
													<button class="btn btn-approved btn-sm btn-default">View Live</button>
													<?php
												}
												else
												{													
													?>
														<button class="btn btn-secondary btn-disabled btn-sm" disabled>All phases approved</button>
													</div>
													<?php
												}
												$is_edit_request = is_edit_request($post->id);
												if($is_edit_request AND empty($approver_status) AND $user_group != 'Approver')
												{
													?>
													<a href="<?php echo base_url().'view-request/'.$post->id; ?>" class="btn btn-xs btn-wrap btn-default">View Edit<br>Requests</a>
													<?php
												}
												if(!empty($approver_status))
												{
													?>
													<a href="<?php echo base_url().'edit-request/'.$post->id; ?>" class="btn btn-xs btn-wrap btn-default">Suggest an<br>Edit</a>
													<?php
												}
												?>
												</td>											 -->
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
				</tbody>
			</table>
		</div>
	</div>
</section>
