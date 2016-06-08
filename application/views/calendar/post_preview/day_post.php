<?php 
	//echo '<pre>'; print_r($post_details);echo '</pre>'; 
	if(!empty($post_details)){
		$selected_date =  date('Y-m-d',strtotime($post_details[0]->slate_date_time));
		echo '<input type="hidden" id="selected_date" value="'.$selected_date .'"/>' ;
		foreach ($post_details as $key => $post) {
			$outlet_name = strtolower($post->outlet_name);
			$brand_onwer = $post->created_by;
			$brand_id = $post->brand_id;
			$tag_list = '' ;
			if(!empty($post->post_tags)){
				foreach ($post->post_tags as $key_1 => $val) {
					if(empty($tag_list)){
						$tag_list = ''.strtolower($val['tag_name']);
					}else{
						$tag_list .= ' '.strtolower($val['tag_name']);
					}
				}
				
			}

			?>
			<div  data-filters="approved <?php echo $outlet_name.' '.$tag_list; ?>" class="row bg-white clearfix post-day f-approved f-<?php echo $outlet_name; ?>"style="width:97% !important;">
				<div class="col-md-5 post-img day-image">
					<?php 
					$display_img = 'false';
						if(!empty($post->post_images)){
							foreach ($post->post_images as $img) {
								if (file_exists('uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'.$img->name)) {
									$display_img = 'true';
			                    	echo '<img src="'.base_url().'uploads/'.$brand_onwer.'/brands/'.$brand_id.'/posts/'. $img->name.'"  width="228px"/> ';
			                    	break;
			                    }
							}
						}
						if($display_img == 'false'){
							echo '<img class="default-img reblog-avatar-image-thumb" src="'.img_url().'post-img-3.jpg"  width="228px"  >';
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
							<span class="post-date"><?php echo date('l, m/d/y \a\t h:i A' , strtotime($post->slate_date_time )); ?> PST <a href="#" class="btn-icon btn-gray post-filter-popup" data-toggle="popover-ajax"  data-hide="false" data-content-src="<?php echo base_url()?>calendar/get_view/edit_date/<?php echo $post->slug.'/'.$post->id; ?>" data-title="Reschedule Post" data-popover-width="415" data-popover-class="popover-post-date popover-clickable form-inline popover-lg" data-popover-id="date-postid-<?php echo $post->id; ?>" data-attachment="top center" data-target-attachment="bottom center" data-popover-arrow="true" data-arrow-corner="top center" data-popover-container=".calendar-day">
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
									echo '<i class="fa fa-circle '.strtolower($val["tag_name"]).'" style="color:'.$val["tag_color"].'"></i>';
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
												echo '<li class="tag"><i class="fa fa-circle '.strtolower($val["tag_name"]).'" style="color:'.$val["tag_color"].'"></i>'.$val["name"].'</li>';
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
								<p><?php echo (!empty($post->content))? read_more($post->content, 100) :'&nbsp;';?></p>
							</div>
							<span class="post-actions pull-xs-left">
								<button class="btn btn-approved btn-sm" disabled>Approved</button><br>
								<a href="#">Undo</a>
							</span>
							<div class="hide-top-bx-shadow">
								<button class="btn-icon btn-icon-lg btn-menu popover-toggle" data-toggle="popover-ajax"  data-hide="false" data-content-src="<?php echo base_url()?>calendar/get_view/edit_menu/<?php echo $post->slug.'/'.$post->id; ?>" data-popover-class="popover-menu popover-clickable" data-popover-id="popover-post-menu" data-attachment="bottom left" data-target-attachment="top left" data-offset-x="6" data-offset-y="0" data-popover-container=".calendar-day">
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
	}else{
		echo '<div class="row bg-white clearfix post-day no-data">No data found </div>';
	}

?>
