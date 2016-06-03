<?php $this->load->view('partials/brand_nav'); ?>	

<section id="brand-manage" class="page-main bg-white col-sm-10">
	<header class="page-main-header calendar-header">
		<div class="clearfix">
			<a href="#" class="tf-icon-circle pull-xs-left" data-toggle="popover-calendar" data-popover-id="calendar-change-day" data-popover-class="popover-clickable popover-sm popover-date-filter" data-attachment="top left" data-target-attachment="bottom center" data-popover-width="300" data-popover-arrow="true" data-arrow-corner="top left" data-offset-x="-19" data-offset-y="5"><i class="tf-icon-calendar"></i></a>
			<h2 class="date-header pull-xs-left">Calendar | <strong><?php echo date('F'); ?></strong> <?php echo date('d') . ", " . date('Y'); ?></h2>

			<?php $this->load->view('partials/calender_nav'); ?>
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
				<button type="button" id="getPostsByDate" class="btn btn-sm btn-default btn-disabled qtip-hide" disabled>Apply</button>
			</div>
		</div>
	</header>
	<div class="row equal-cols-cal">
		<div class="col-md-9 equal-height">
			<div class="calendar-day">
				<?php 
					if(!empty($post_details)){
						foreach ($post_details as $key => $post) {
							$outlet_name = strtolower($post->outlet_name);
							$brand_onwer = $post->created_by;
							$brand_id = $post->brand_id;
							?>
							<div class="row bg-white clearfix post-day f-approved f-<?php echo $outlet_name; ?> f-brandbuilding f-orange f-retail">
								<div class="col-md-5 post-img">
									<?php 
									$display_img = 'false';
										if(!empty($post->post_images)){
											foreach ($post->post_images as $img) {
												if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$img->name)) {
													$display_img = 'true';
							                    	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name.'" class="img-responsive" /> ';
							                    	break;
							                    }
											}
										}
										if($display_img == 'false'){
											echo '<img class="default-img reblog-avatar-image-thumb" src="'.img_url().'post-img-3.jpg" class="img-responsive" >';
										}
									?>
								</div>
								<div class="col-md-7 post-content">
									<div class="row">
										<div class="col-md-2 outlet-list text-xs-center outlet-list">
											<i class="fa fa-<?php echo $outlet_name; ?>"><span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span></i>
										</div>
										<div class="col-md-10 post-meta">
											<span class="post-author"><?php echo $outlet_name; ?> Post By <?php echo (!empty($post->user))?$post->user :'';?>:</span>
											<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A' , strtotime($post->slate_date_time )); ?> PST <a href="#" class="btn-icon btn-gray" data-toggle="popover-ajax" data-content-src="<?php echo base_url()?>calender/edit_date" data-title="Reschedule Post" data-popover-width="415" data-popover-class="popover-post-date popover-clickable form-inline popover-lg" data-popover-id="date-postid-1223" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
												<i class="fa fa-pencil"></i>
												</a>
											</span>
											<span class="post-approval"><strong>All Approvals Received <i class="fa fa-check-circle color-success"></i></strong></span>
										</div>
									</div>
									<div class="row">
										<div class="col-md-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-<?php echo $post->id; ?>" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
										<?php 
											if(!empty($post->post_tags)){
												foreach ($post->post_tags as $key_1 => $val) {
													echo '<i class="fa fa-circle tag-'.$val["tag_name"].'" style="color:'.$val["tag_color"].'"></i>';
												}
												
											}
										?>
											<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
											<div id="tags-<?php echo $post->id; ?>" class="hidden">
												<div class="tag-list">
													<ul>
													<?php 
														if(!empty($post->post_tags)){
															foreach ($post->post_tags as $key_1 => $val) {
																echo '<li class="tag"><i class="fa fa-circle tag-'.$val["tag_name"].'" style="color:'.$val["tag_color"].'"></i>'.$val["name"].'</li>';
															}
															
														}
													?>
													</ul>
												</div>
											</div>								
										</div>
										<div class="col-md-10">
											<h6>POST COPY</h6>
											<div class="post-body">
												<p><?php echo (!empty($post->content))?$post->content :'';?></p>
											</div>
											<span class="post-actions pull-xs-left">
												<button class="btn btn-approved btn-sm" disabled>Approved</button><br>
												<a href="#">Undo</a>
											</span>
											<div class="hide-top-bx-shadow">
												<button class="btn-icon btn-icon-lg btn-menu popover-toggle" data-toggle="popover-ajax" data-content-src="<?php echo base_url()?>calender/edit_menu" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day">
													<i class="fa fa-circle-o"></i> 
													<i class="fa fa-circle-o"></i> 
													<i class="fa fa-circle-o"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<?php
						}
					}
				?>
			</div>
		</div>
		<div class="col-md-3 equal-height">
			<div class="calendar-summary bg-gray-dark">
				<div id="calendar"></div>
				<div class="today-summary">
					<h5 class="border-title"><span>Summary</span></h5>
					<ul class="timeframe-list calendar-list outlet-list">
						<li><i class="fa fa-facebook"><span class="bg-outlet bg-facebook"></span></i>5:05 PM <span class="excerpt-summary">Let whites influence your fre...</span></li>
						<li><i class="fa fa-twitter"><span class="bg-outlet bg-twitter"></span></i>5:05 PM <span class="excerpt-summary">Let whites influence your fre...</span></li>
						<li><i class="fa fa-instagram"><span class="bg-outlet bg-instagram"></span></i>5:05 PM <span class="excerpt-summary">Let whites influence your fre...</span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>