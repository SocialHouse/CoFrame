<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<h2 class="date-header pull-xs-left">Approvals</h2>		

			<div class="pull-md-right toolbar">
				<?php $this->load->view('partials/search_form'); ?>				
				<a href="#" class="tf-icon-circle pull-xs-left  post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/post_filters/'.$brand_id; ?>" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70" data-hide="false"><i class="tf-icon-filter"></i></a>
				<a href="#" class="tf-icon-circle pull-xs-left post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/print_posts/'.$brand_id; ?>" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20" data-hide="false"><i class="tf-icon-print"></i></a>

			</div>
		</div>
		<div id="selectedFilters" class="clearfix border-top border-black hidden">
			<strong class="uppercase">Filters: </strong>
			<ul class="filter-list tag-list">
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
						<th>Approvals</th>
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
											<td class="text-xs-center" onClick="showPostPopover(jQuery(this).parent().find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');">
												<?php 
												$approvers = get_post_approvers($post->id);
												if($approvers)
												{
													?>
													<ul class="timeframe-list approval-list">
														<?php
														$approver_status = '';
														$phase_status = '';
														$phase_id = '';
														foreach($approvers['result'] as $approver)
														{
															if($approver['user_id'] == $this->user_id)
															{
																$approver_status = $approver['status'];
																$phase_status = $approver['phase_status'];
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
												$is_edit_request = is_edit_request($post->id);
												$btn_class = 'btn-disabled';
												if($is_edit_request)
												{
													$btn_class = 'btn-secondary';
												}

												if($approver_status == 'approved')
												{
													?>
													<a class="btn btn-xs btn-disabled btn-secondary">Approved</a>
													<?php
												}
												elseif($phase_status == 'pending' AND $post->status == 'pending')
												{
													?>													
														<a class="btn btn-xs btn-secondary change-approve-status" data-post-id="<?php echo $post->id; ?>" id="approval_list_btn" data-phase-id="<?php echo $phase_id; ?>" data-phase-status="approved">Approve</a>					
														<a class="btn btn-xs btn-disabled btn-secondary hide">Approved</a>
													<?php
												}
												elseif($post->status == 'scheduled')
												{
													?>
													<button type="button" class="btn btn-xs btn-disabled">Scheduled</button>
													<?php
												}
												elseif($post->status == 'posted')
												{
													?>
													<button class="btn btn-approved btn-sm btn-default">View Live</button>
													<?php
												}
												
												?>												
												<a href="<?php echo base_url().'edit-request/'.$post->id; ?>" class="btn btn-xs btn-wrap btn-default">View Edit<br>Requests</a></td>
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
