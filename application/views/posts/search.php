<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<div class="row">
		<div class="col-sm-3">
			<div class="row post-filters search-filters">
				<div class="col-sm-12">
					<h2 class="text-xs-center">Refine Search</h2>
					<h4 class="text-xs-center">Post Status</h4>					
					<div class="form-group filter" data-status="posted" data-value="f-posted" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-posted">Posted</label></div>
					<div class="form-group filter" data-status="draft" data-value="f-draft" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-draft">Draft</label></div>
					<div class="form-group filter" data-status="scheduled" data-value="f-scheduled" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-scheduled">Scheduled</label></div>
					<div class="form-group filter" data-status="pending" data-value="f-pending" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for=".f-pending">Pending</label></div>
					<div class="form-group filter" data-status="posted" data-value="check-all" data-group="post-status"><i class="tf-icon square-border border-black pull-xs-left"><i class="fa fa-square"></i></i> <label class="label-check-box" data-for="check-all">All</label></div>
					<h4 class="text-xs-center">Outlets</h4>
					<div class="outlet-list">
						<ul>
							<?php
							if(!empty($outlets))
							{
								foreach($outlets as $outlet)
								{
									?>
									<li class="disabled filter" data-id="<?php echo $outlet->id; ?>" data-value="<?php echo "f-".strtolower($outlet->outlet_name); ?>" data-group="post-outlet">
										<i class="fa fa-<?php echo strtolower($outlet->outlet_name); ?>">
											<span class="bg-outlet bg-<?php echo strtolower($outlet->outlet_name); ?>"></span>
										</i>
									</li>
									<?php
								}
								echo '<li class="filter" data-value="check-all" data-group="post-outlet"><i class="fa"><span class="bg-outlet bg-all"></span><span class="outlet-text">All</span></i></li>';
							}
							?>	
						</ul>
					</div>
					<h4 class="text-xs-center">Tags</h4>
					<div class="tag-list">
						<ul>
							<?php 
							if(!empty($tags)){
								$count = 1;
								foreach ($tags as $key => $obj) {
									?>
									<li class="tag filter" data-group="post-tag" data-value="<?php echo strtolower($obj->tag_name); ?>"  data-tag-id="<?php echo $obj->id ?>" >
										<i class="fa fa-circle tag-<?php echo $obj->tag_name; ?>" style="color:<?php echo $obj->color ; ?>"></i><span class="tag-title"><?php echo $obj->name?></span>
									</li>
									<?php
									if($count %7 == 0){
										?>
											</ul>
										</div>
										<div class="col-sm-6 tag-list">
											<ul>
										<?php
									}
									$count++;
								}
								echo '<li data-group="post-tag" data-value="check-all" class="tag filter"><i class="fa fa-circle tag-custom"></i><span class="tag-title">All</span></li>';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-9">
			<header class="page-main-header search-header">
				<div class="clearfix">
					<?php
					if(!empty($posts))
					{
						?>
						<h1 class="pull-md-left title-search"><?php echo count($posts); ?> refined search results for search term</h1>
						<?php
					}
					?>
					<div class="pull-md-right toolbar">
						<?php $this->load->view('partials/search_form'); ?>
					</div>
				</div>
			</header>
			<table class="table table-striped table-approvals">
				<thead>
					<tr>
						<th>Post Date</th>
						<th>Post Time</th>
						<th>Tags</th>
						<th>Outlet</th>
						<th>Post Copy</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody  class="calendar-app">
					<?php
					if(!empty($posts))
					{
						foreach($posts as $post)
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
							<tr onClick="showPostPopover(jQuery(this).find('.bg-outlet'),<?php echo $post->id; ?>, 'click', 'approvals-post');" data-filters="<?php echo 'f-'.strtolower($outlet).' '.$tag_list.' '.'f-'.$post->status; ?>" class="post-approver f-<?php echo $post->status; ?> f-<?php echo strtolower($outlet); ?>">
								<td><?php echo date('D m/d',strtotime($post->slate_date_time)); ?></td>
								<td><?php echo date('g:i A',strtotime($post->slate_date_time)); ?></td>
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

								<td><?php echo read_more($post->content,35); ?></td>
								<td class="text-xs-center"><?php echo ucfirst($post->status); ?></td>
							</tr>
							<?php
						}
					}
					else
					{
						?>
						<tr>
							<td class="text-xs-center" colspan="8">No post matching to your search.</td>
						</tr>
						<?php
					}
					?>					
				</tbody>
			</table>

		</div>
	</div>
</section>

<button type="button" class="modal-toggler">
	<span class="sr-only">Toggle Modal</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>
<!-- Blank Modal -->
<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content bg-white">
	  <div class="modal-body">
	  </div>
	</div>
  </div>
</div>