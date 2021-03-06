<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a class="btn btn-xs btn-disabled pull-xs-left delete-draft btn-secondary hidden-print" disabled data-toggle="" data-target="#deleteDrafts"><i class="fa fa-trash"></i>Delete</a>
			<div class="pull-md-right toolbar hidden-print">
				<?php $this->load->view('partials/search_form') ?>
			</div>
			<h2 class="date-header center-title">Drafts</h2>
		</div>
	</header>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-striped table-approvals table-drafts">
				<thead>
					<tr>
						<th class="hidden-print">
							<div class="select-box" data-value="check-all" data-group="delete-draft"><i class="tf-icon square-border border-black"><i class="fa fa-square"></i></i></div>
						</th>
						<th class="text-xs-left">Last Saved</th>
						<th>Tags</th>
						<th>Outlet</th>
						<th>Post Copy</th>
						<th class="hidden-print">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(!empty($drafts))
					{
						foreach($drafts as $draft)
						{
							?>
							<tr>
								<td class="text-xs-center hidden-print">
									<div class="select-box" data-value="<?php echo $draft->id ?>" data-group="delete-draft"><i class="tf-icon square-border border-black"><i class="fa fa-square checkbox-top"></i></i></div>
								</td>
								<td><?php echo date('D n/d',strtotime($draft->updated_at)); ?> at <?php echo date('g:ia',strtotime($draft->updated_at)); ?></td>
								<td class="text-xs-center">
									<?php
									$tags = get_post_tags($draft->id);
									$tag_names = '';
									if(!empty($tags)) {
										foreach ($tags as $tag) 
										{
											if(empty($tag_names))
											{
												$tag_names = $tag['name'];
											}
											else
											{
												$tag_names .= ', '.$tag['name'];
											}
										}
									}
									?>
									<div class="post-tags" data-toggle="popover-hover" data-content="<?php echo $tag_names;?>">
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
									<?php
									$outlet = get_outlet_by_id($draft->outlet_id);
									?>
									<i class="fa fa-<?php echo strtolower($outlet); ?>"><span class="bg-outlet bg-<?php echo strtolower($outlet); ?>"></span></i>
								</td>
								<td><span class="post-excerpt"><?php echo $draft->content; ?></span></td>
								<td class="text-xs-center hidden-print">
									<a href="#" class="btn btn-sm btn-secondary" data-clear="yes" data-modal-id="edit-post-modal" data-toggle="modal-ajax" data-modal-size="lg" data-modal-src="<?php echo base_url()?>calendar/edit_post_calendar/drafts/<?php echo $brand->slug.'/'.$draft->id; ?>" >Edit</a>
									<a href="<?php echo base_url().'drafts/duplicate/'.$brand->slug.'/'.$draft->id; ?>" class="btn btn-sm btn-default">Duplicate</a>
								</td>
							</tr>
							<?php
						}
					}
					else
					{
						?>
						<tr>
							<td class="text-xs-center" colspan="7">
							Currently no drafts available
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

		</div>
	</div>
</section>