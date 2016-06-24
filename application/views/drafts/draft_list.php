<?php $this->load->view('partials/brand_nav'); ?>
<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a class="btn btn-xs btn-disabled pull-xs-left delete-draft" disabled data-toggle="" data-target="#deleteDrafts"><i class="fa fa-trash"></i>Delete</a>
			
			<div class="pull-md-right toolbar">
				<?php $this->load->view('partials/search_form') ?>
			</div>
		</div>
	</header>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-approvals">
				<tbody>
					<tr>
						<th>
							<div class="select-box" data-value="check-all" data-group="delete-draft"><i class="tf-icon square-border border-black"><i class="fa fa-square"></i></i></div>
						</th>
						<th class="text-xs-left">Last Saved</th>
						<th>Tags</th>
						<th>Outlet</th>
						<th>Post Copy</th>
						<th>Edit</th>
						<th>Duplicate</th>
					</tr>					
					<?php
					if(!empty($drafts))
					{
						foreach($drafts as $draft)
						{
							?>
							<tr>
								<td class="text-xs-center">
									<div class="select-box" data-value="<?php echo $draft->id ?>" data-group="delete-draft"><i class="tf-icon square-border border-black"><i class="fa fa-square checkbox-top"></i></i></div>
								</td>
								<td><?php echo date('d M,Y',strtotime($draft->slate_date_time)); ?></td>
								<td class="text-xs-center">
									<div class="post-tags">
										<?php
										$tags = get_post_tags($draft->id);
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
								<td> <div class="post-copy-draft"><?php echo $draft->content; ?></div></td>
								<td class="text-xs-center">
									<a href="#" class="btn btn-xs btn-secondary" data-clear="yes" data-modal-src="<?php echo base_url()?>calendar/edit_post_calendar/drafts/<?php echo $brand->slug.'/'.$draft->id; ?>" data-toggle="modal-ajax" data-modal-id="edit-post-id<?php echo $draft->id; ?>" data-modal-size="lg">Edit</a>
								</td>
								<td class="text-xs-center"><a href="<?php echo base_url().'drafts/duplicate/'.$brand->slug.'/'.$draft->id; ?>" class="btn btn-xs btn-default">Duplicate</a></td>
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