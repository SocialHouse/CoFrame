<section id="overview" class="page-main col-sm-12">
	<header class="page-main-header header-fixed-top bg-white row">
		<h1 class="center-title section-title border-none">Today's Approvals</h1>
	</header>
	<div id="selectedFilters" class="hidden" style="">
		<ul class="filter-list tag-list clearfix"></ul>
	</div>
	<div class="bg-white col-sm-12 content-shadow brand-main">
		<div class="content-shadow brand-header row">
			<div class="col-sm-12">
				<?php
				$image_path = img_url().'default_brand.png';				
				if(file_exists(upload_path().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png'))
				{
					$image_path = upload_url().$this->user_data['account_id'].'/brands/'.$brand->id.'/'.$brand->id.'.png';					
				}									
				?>
				<img src="<?php echo $image_path; ?>" class="circle-img pull-xs-left" height="75" width="75"> <?php echo $brand->name; ?>
			</div>
		</div>
		<div class="date-header row">
			<div class="col-sm-12">
				<div class="pull-xs-left">
					<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '-1 days' ) ); ?>" class="next-date"><i class="fa fa-angle-left fa-custom-circle bg-black"></i></a>
				</div>
				<div class="pull-xs-right">
					<a href="#" data-date="<?php echo date('Y-m-d', strtotime( '+1 days' ) ); ?>" class="next-date"><i class="fa fa-angle-right fa-custom-circle bg-black"></i></a>
				</div>
				<div class="center-title"><a href="#calendarSelectModal" data-toggle="modal"><?php echo date('F d, Y'); ?></a></div>
			</div>
		</div>
		<ul class="my-approvals">
			<?php
			if(!empty($approval_list))
			{
				foreach($approval_list as $approval)
				{
					?>
					<li>
						<div class="post-meta clearfix pos-relative">
							<a href="edit-requests.php">
							<div class="outlet-list pull-xs-left">
								<i class="fa fa-twitter" title="twitter"><span class="bg-outlet bg-twitter"></span></i>
							</div>
							<div class="post-meta-content">
								<span class="post-author"><?php echo get_outlet_by_id($approval->outlet_id); ?> Post By <?php //echo get_users_full_name($this->user_id); ?>:</span>
								<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A',strtotime($approval->slate_date_time)); ?> PST</span>
							</div>
							<i class="fa fa-angle-right expand-collapse pull-xs-right"></i>
							</a>
						</div>
						<div class="post-content clearfix">
							<?php
							$medias = get_post_media($approval->id);
							if(!empty($medias))
							{
								foreach ($medias as $media) 
								{
									if($media->type == 'images')
									{
										?>
										<img src="<?php echo base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$brand_id.'/posts/'. $media->name; ?>" class="pull-xs-left" width="420">
										<?php
									}
									else
									{
										?>
										<video class="pull-xs-left" width="420" src="'.base_url().'uploads/'.$this->user_data['account_id'].'/brands/'.$brand_id.'/posts/'. $media->name.'"></video>
										<?php
									}
								}
							}
							?>							
							<div class="post-body">								
								<?php 
								$title = '';
								if(!empty($approval->tumblr_content_type))
								{
									if($approval->tumblr_content_type == 'Photo')
									{
										$title = $approval->tumblr_caption;
									}
									else if($approval->tumblr_content_type == 'Text')
									{
										$title = $approval->tumblr_title;
									}
									else if($approval->tumblr_content_type == 'Quote')
									{
										$title = $approval->tumblr_quote;
									}
									else if($approval->tumblr_content_type == 'Link')
									{
										$title = $approval->tumblr_custom_url;
									}
									else if($approval->tumblr_content_type == 'Chat')
									{
										$title = $approval->tumblr_chat_title;
									}
									else if($approval->tumblr_content_type == 'Video')
									{
										$title = $approval->tumblr_video_caption;
									}
								}
								else
									$title = strip_tags($approval->content);
								?>
								<p><?php echo (!empty($title))? read_more(nl2br(strip_tags($title)), 100) :'&nbsp;';?></p>
							</div>
						</div>
						<div class="post-footer clearfix">
							<span class="pull-xs-left post-actions">
								<div class="before-approve">
									<a class="btn btn-sm btn-secondary change-approve-status" data-post-id="28" data-phase-id="" data-phase-status="approved">Approve</a>
								</div>
								<div class="after-approve hidden">
									<button class="btn btn-secondary btn-disabled btn-sm" disabled="">Approved</button>
								</div>
							</span>
							<button class="btn-icon btn-icon-lg btn-menu pull-xs-right" data-toggle="modal-ajax" data-hide="false" data-modal-src="lib/calendar-edit-menu.php" data-modal-id="modal-post-menu">
								<i class="fa fa-circle-o"></i> 
								<i class="fa fa-circle-o"></i> 
								<i class="fa fa-circle-o"></i>
							</button>
						</div>
					</li>
					<?php
				}
			}
			else
			{
				?>
				<li>
					<div class="post-meta clearfix pos-relative">
					<?php echo $this->lang->line('no_post_found'); ?>
					</div>
				</li>
				<?php
			}
			?>			
		</ul>
	</div>
</section>

<div class="modal hide fade" id="calendarSelectModal" data-keyboard="false" role="dialog" aria-hidden="true" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content bg-white">
		  <div class="modal-body">
			<div id="calendar-change-day" class="calendar-select-date">
				<div class="date-select-calendar"></div>
			</div>
			<div class="text-xs-center overlay-footer border-gray-lighter">
				<button type="button" class="btn btn-sm btn-default modal-hide">Cancel</button>
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-secondary btn-disabled modal-hide" disabled="">Apply</button>
			</div>			
		  </div>
		</div>
	</div>
</div>	

<!-- Blank Modal -->
<div class="modal fade" id="emptyModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-body">
	  </div>
	</div>
  </div>
</div>