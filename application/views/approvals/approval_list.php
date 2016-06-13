<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-date-approvals" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
			<h2 class="date-header pull-xs-left">Approvals</h2>

			<div class="pull-md-right toolbar">
				<a href="#" class="tf-icon-circle pull-xs-left"><i class="tf-icon-search"></i></a>
				<a href="#" class="tf-icon-circle pull-xs-left post-filter-popup" data-toggle="popover-ajax" data-content-src="<?php echo base_url().'calendar/post_filters/'.$brand_id; ?>" data-popover-width="100%" data-popover-class="popover-post-filters popover-clickable popover-lg" data-popover-id="calendar-post-filters" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="70"><i class="tf-icon-filter"></i></a>
				<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-ajax" data-content-src="lib/print-posts.php" data-popover-width="50%" data-popover-class="popover-post-print popover-clickable popover-lg" data-popover-id="calendar-post-print" data-attachment="top right" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top right" data-popover-container=".page-main-header" data-offset-x="20"><i class="tf-icon-print"></i></a>
			</div>
		</div>
		<div id="selectedFilters" class="clearfix border-top border-black hidden">
			<strong class="uppercase">Filters: </strong>
			<ul class="filter-list tag-list">
			</ul>
			<button type="button" class="btn btn-sm btn-secondary reset-filter pull-sm-right" data-filter="*">Reset Filters</button>
		</div>
		<div id="calendar-change-date-approvals" class="hidden calendar-select-date">
			<div class="date-select-calendar"></div>
			<div class="text-xs-center">
				<hr>
				<button type="button" class="btn btn-sm btn-default qtip-hide">Cancel</button>
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-default btn-disabled qtip-hide" disabled>Apply</button>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-approvals">
				<tbody>
					<tr>
						<th>Post Day</th>
						<th>Post Time</th>
						<th>Tags</th>
						<th>Outlet</th>
						<th>Status</th>
						<th>Post Copy</th>
						<th>Approvals</th>
						<th>Schedule / View Edit Requests</th>
					</tr>
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

											<td class="text-xs-center">
												<div class="post-tags">
													<?php
													$tags = get_post_tags($post->id);
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
												<?php
												$outlet = get_outlet_by_id($post->outlet_id);
												?>
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
														foreach($approvers['result'] as $approver)
														{
															$image_path = img_url().'default_profile.jpg';
															if(file_exists(upload_path().$approvers['owner_id'].'/users/'.$approver['user_id'].'.png'))
															{
																$image_path = upload_url().$approvers['owner_id'].'/users/'.$approver['result']['user_id'].'.png';
															}
															?>
															<li class="approved">
																<img src="<?php echo $image_path; ?>" width="36" height="36" alt="<?php echo ucfirst($approver['first_name']).' '.ucfirst($approver['last_name']); ?>" class="circle-img">
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
												?>
												<a class="btn btn-xs btn-disabled btn-secondary">Scheduled</a>
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
