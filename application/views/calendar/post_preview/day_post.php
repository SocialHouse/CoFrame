<input type="hidden" name="user_id" id="user-id" value="<?php echo $this->user_id; ?>" />
<?php 

	if(!empty($post_details))
	{
		$selected_date =  date('Y-m-d',strtotime($post_details[0]->slate_date_time));
		echo '<input type="hidden" id="selected_date" value="'.$selected_date .'"/>' ;
		foreach ($post_details as $key => $post) 
		{
			$outlet_name = strtolower($post->outlet_name);
			$brand_onwer = $this->user_data['account_id'];
			$brand_id = $post->brand_id;
			$tag_list = '' ;
			if(!empty($post->post_tags))
			{
				foreach ($post->post_tags as $key_1 => $val) 
				{
					if(empty($tag_list))
					{
						$tag_list = ''.strtolower($val['tag_name']);
					}
					else
					{
						$tag_list .= ' '.strtolower($val['tag_name']);
					}
				}
				
			}
			?>
			

			<div  data-filters="<?php echo 'f-'.$outlet_name.' '.$tag_list.' '.'f-'.$post->status; ?>" class="row bg-white clearfix post-day f-<?php echo $post->status; ?> f-<?php echo $outlet_name; ?>">
				<div class="col-sm-4 post-img day-image">
					<?php 
					$display_img = 'false';
						if(!empty($post->post_images))
						{
							foreach ($post->post_images as $img) 
							{
								if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$img->name)) 
								{
									if($img->type == 'images'){
										
										echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name.'"  class="default-img reblog-avatar-image-thumb" width="228px"/> ';
										$display_img = 'true';
										break;
									}elseif ($img->type == 'video') {
										echo '<video autobuffer autoloop loop controls width="100%" >
												<source src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name.'">
												<object type="'.$img->mime.'">
													<param name="src" value="/media/video.oga">
													<param name="autoplay" value="false">
													<param name="autoStart" value="0">
													<p><a href="/media/video.oga">Download this video file.</a></p>
												</object>
											</video>';
											$display_img = 'true';
											break;
									}
									
			                    }
							}
						}
					?>
				</div>
				<div class="col-sm-8 post-content">
					<div class="row">
						<div class="col-sm-2 outlet-list text-xs-center">
							<i class="fa fa-<?php echo $outlet_name; ?>" title="<?php echo $outlet_name; ?>"><span class="bg-outlet bg-<?php echo $outlet_name; ?>"></span></i>
						</div>
						<div class="col-sm-10 post-meta">
							<span class="post-author"><?php echo $outlet_name; ?> Post By <?php echo (!empty($post->user))?$post->user :'';?>:</span>
							<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A' , strtotime($post->slate_date_time )); ?> PST <a href="#" class="btn-icon btn-gray hidden-print" data-toggle="popover-ajax" data-hide="false" data-content-src="<?php echo base_url()?>calendar/get_view/edit_date/<?php echo $post->slug.'/'.$post->id; ?>" title="Reschedule Post" data-title="Reschedule Post" data-popover-width="415" data-popover-class="popover-post-date popover-clickable form-inline popover-lg" data-popover-id="date-postid-<?php echo $post->id; ?>" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
								<i class="fa fa-pencil"></i>
								</a>
							</span>
							<?php 
								if($post->status == 'scheduled')
								{
									?>
									<span class="post-approval">
										<strong>All Approvals Received 
											<i class="fa fa-check-circle color-success"></i>
										</strong>
									</span>
									<?php 
								}
								if($post->status == 'pending')
								{
									?>
									<span class="post-approval">
										<strong>Pending Approvals <i class="icon-clock2 color-danger post-filter-popup" data-hide="false"  data-popover-id="approvals-postid-<?php echo $post->id; ?>" data-toggle="popover-ajax" data-content-src="<?php echo base_url()?>calendar/approval_list/<?php echo $post->id; ?>" data-popover-class="popover-sm popover-post-approvals" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day"></i>
										</strong>
									</span>
									<?php
								}
								if($post->status == 'posted')
								{
									?>
									<span class="post-approval">
										<strong>Published 
											<i class="fa fa-globe color-gray-lighter"></i>
										</strong>
									</span>
									<?php
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2 post-tags text-xs-center" tabindex="0" data-toggle="popover-inline" data-popover-id="tags-<?php echo $post->id; ?>" data-popover-class="popover-inline popover-sm" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
						<?php 
							if(!empty($post->post_tags))
							{
								echo '<span class="hidden-print">';
								foreach ($post->post_tags as $key_1 => $val) 
								{
									echo '<i class="fa fa-circle '.strtolower($val["tag_name"]).'" style="color:'.$val["tag_color"].'" title="' . $val["name"] . '"></i>';
								}
								echo '</span>';
								//print list
								echo '<span class="visible-print-block">Tags: ';
								foreach ($post->post_tags as $key_1 => $val) 
								{
									echo $val["name"] . ' ';
								}
								echo '</span>';
							}
						?>
							<i class="fa fa-circle color-gray-lighter" style="display: none;"></i>
							<div id="tags-<?php echo $post->id; ?>" class="hidden">
								<div class="tag-list">
									<ul>
									<?php 
										if(!empty($post->post_tags))
										{
											foreach ($post->post_tags as $key_1 => $val) 
											{
												echo '<li class="tag"><i class="fa fa-circle '.strtolower($val["tag_name"]).'" style="color:'.$val["tag_color"].'"></i>'.$val["name"].'</li>';
											}
											
										}
									?>
									</ul>
								</div>
							</div>								
						</div>
						<div class="col-sm-10">
							<h6>POST COPY</h6>
							<div class="post-body">
								<?php 
								$title = '';
								if(!empty($post->tumblr_content_type))
								{
									if($post->tumblr_content_type == 'Photo')
									{
										$title = $post->tumblr_caption;
									}
									else if($post->tumblr_content_type == 'Text')
									{
										$title = $post->tumblr_title;
									}
									else if($post->tumblr_content_type == 'Quote')
									{
										$title = $post->tumblr_quote;
									}
									else if($post->tumblr_content_type == 'Link')
									{
										$title = $post->tumblr_custom_url;
									}
									else if($post->tumblr_content_type == 'Chat')
									{
										$title = $post->tumblr_chat_title;
									}
									else if($post->tumblr_content_type == 'Video')
									{
										$title = $post->tumblr_video_caption;
									}
								}
								else
									$title = strip_tags($post->content);
								
								?>
								<p><?php echo (!empty($title))? read_more(nl2br(strip_tags($title)), 100) :'&nbsp;';?></p>
							</div>
							<span class="post-actions pull-xs-left">
								<?php 
								$all_phases = get_post_approvers($post->id);								
								$user_is = '';
								$approver_status = '';
								$phase_id = '';
								$phase_status = '';
								if(isset($all_phases['result']) and !empty($all_phases['result']))
								{
									foreach($all_phases['result'] as $phase)
									{
										if($phase['user_id'] == $this->user_id)
										{
											$user_is = 'approver';
											$approver_status = $phase['status'];
											$phase_status = $phase['phase_status'];
											$phase_id = $phase['id'];
										}
									}
								}

								echo get_day_cal_buttons($user_is,$approver_status,$phase_status,$phase_id,$post);
								?>
							</span>	
							<?php
							if($post->status != 'posted' AND $this->user_id == $post->user_id)
							{
								?>
								<div class="hide-top-bx-shadow">
									<button class="btn-icon btn-icon-lg btn-menu popover-toggle" data-toggle="popover-ajax"  data-hide="false" data-content-src="<?php echo base_url()?>calendar/get_view/edit_menu/<?php echo $post->slug.'/'.$post->id.'/'.$user_is; ?>" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day">
										<i class="fa fa-circle-o"></i> 
										<i class="fa fa-circle-o"></i> 
										<i class="fa fa-circle-o"></i>
									</button>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	else
	{
		echo '<div class="row bg-white post-day no-data"><div class="col-sm-12">'.$this->lang->line('no_post_found').'</div></div>';
	}

?>
