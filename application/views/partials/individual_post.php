	<div class="row equal-cols">
		<div class="col-md-6 bg-white equal-height">
			<div class="container-post-preview">
				<div id="live-post-preview">

				<?php 
				if(!empty($post_images)){
					$img_count = count($post_images);

					if(!empty($post_deatils)){
						$outlet_id = $post_deatils->outlet_id;
					}
					switch ($outlet_id) {
						// image preview if the outlet id 1 ( facebook ) 
						case '1':
							?>
								<div id="outlet_1">
									<div class="post-container">
										<div class="padding_5">
											<div class="margin-bottom-10">
												<div class="pull-left user-img-border">
													<?php 
														if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
				                                        	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png" width="406" height="506" alt="" class="center-block" />';
					                                    }else{
					                                    	echo '<img class="user-profile-img" src="'.img_url().'default_profile.jpg">';	
					                                    }
													?>
													
												</div>
												<div class="pull-left padding-left-5">
													<span class="post-user-name">
														<?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?>
														<span class="no-of-photos"></span>
													</span><br/>
													<span class="time-color">
														Just now
													</span>
												</div>
												<div class="clearfix"></div>
												<br>
												<span class="post_copy_text">
													<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
												</span>
												<div class="img-div">
													<?php 
														$i = 0;
														$more_txt = '';
														foreach ($post_images as $key) {
															$cls = 'center-block';
															if($img_count == 2 ){
																$cls = 'width_50';
															}
															if($img_count == 3 ){
																if($i < 1){
																	$cls = 'post-img';
																}else{
																	$cls = 'width_50';	
																}
															}
															if($img_count == 4 ){
																if($i < 1){
																	$cls = 'post-img';
																}else{
																	$cls = 'width_33';	
																}
															}
															if($img_count > 4 ){
																if($i < 2){
																	$cls = 'width_50';
																}else{
																	$cls = 'width_33';	
																}
																if($img_count > 5 ){
																	$img_more  = $i -4;
																	$more_txt = '<div id="5" class="more-images">+'.$img_more.'</div>';
																}
															}
															if($i < 5){
																if (file_exists('uploads/posts/'.$key->name)) {
						                                        	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"class="'. $cls .'" />';
							                                    }
															}else{
																echo $more_txt ;
															}
															
														 $i ++;
														}
													
													?>
												</div>
											</div>
											<div class="bottom-div">
												<div>
													<div class="pull-left"><i class="fa fa-thumbs-up"></i> <span>Like</span>
													</div>
													<div class="pull-left margin-left-15">
														<i class="fa fa-comment-o"></i> Comment
													</div>
													<div class="pull-left margin-left-15">
														<i class="fa fa-share"></i> Share
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>
							
							<?php
						break;

						// image preview if the outlet id 2 ( facebook ) 
						case '2':
							?>
								<div id="outlet_2">
									<div class="twitter-post">
										<div class="pull-left" style="margin-right: 8px">
											<?php 
												if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
		                                        	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png" class="center-block" />';
			                                    }else{
			                                    	echo '<img class="twitter-default-img" src="'.img_url().'default_profile_twitter.png">';	
			                                    }
											?>
										</div>
										<div  style="margin-bottom:2px">
											<div >
												<div class="twitter-user-info">
													<?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?> 
													<span class="twitter_username">@ninadgaikwad - 1s</span>
												</div>
											</div>
											<div class="post_copy_text" style="height: 21px;">
												<?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?>
											</div>
											<div class="twitter-img-div twitter-post-img img-div" style="margin-left:40px;">
												<?php 
													$i = 1;
													$more_div = '';
													if($img_count == 1 ){
														if (file_exists('uploads/posts/'.$post_deatils[0]->name)) {
															echo '<div class="pull-left">';
				                                        		echo '<img src="'.base_url().'uploads/posts/'. $post_deatils[0]->name.'"  class="img-radious" />';
				                                        	echo '</div>';
					                                    }
													}
													if($img_count == 2 ){
														foreach ($post_images as $key) {
															if($i == 0) {
																$type = 'left' ;
															}else{
																$type = 'right' ;
															}

															echo '<div class="pull-'.$type.'  width_50">';
															if (file_exists('uploads/posts/'. $key->name)) {
					                                        	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class=" height_135 img-radious-'.$type.'" />';
						                                    }else{
						                                    	echo '<img src="'.img_url().'default_profile.jpg" class=" height_135 img-radious-'.$type.'" />';	
						                                    }
				                                        	echo '</div>';
				                                        	$i++;
														}
													}
													if($img_count == 3){
														$i = 1;
														foreach ($post_images as $key) {
															if($i == 1) {
																echo '<div class="pull-left section1" >';
																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="height_135 img-radious-left" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="height_135 img-radious-left" />';	
							                                    }
				                                        		echo '</div>';
				                                        		echo '<div class="pull-left width_50 section2">';
															}
															if($i == 2) {
																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="img-radious-right-top width_30 section_2_img padding_bottom" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="img-radious-right-top width_30 section_2_img padding_bottom"  />';	
							                                    }
															}
															if($i == 3) {
																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="width_30 section_2_img img-radious-right-bottom" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_2_img img-radious-right-bottom"  />';	
							                                    }

															}
				                                        	$i++;
														}
													echo '</div>';
													}

													if($img_count > 3){
														$i = 1;
														foreach ($post_images as $key) {
															if($i == 1) {
																echo '<div class="pull-left section1" style="width: 75%;" >';

																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="height_135 img-radious-left" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="height_135 img-radious-left"  />';	
							                                    }	
				                                        		echo '</div>';
				                                        		echo '<div class="pull-left width_50 section2" style="width: 25%;" > ';
															}
															if($i == 2) {
																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="width_30 section_3_img padding_bottom" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_3_img padding_bottom"  />';	
							                                    }
															}
															if($i == 3) {
																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="width_30 section_3_img padding_bottom" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_3_img padding_bottom"  />';	
							                                    }
															}
															if($i == 4 ) {
																if (file_exists('uploads/posts/'. $key->name)) {
																	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"  class="width_30 section_3_img" />';
							                                    }else{
							                                    	echo '<img src="'.img_url().'default_profile.jpg" class="width_30 section_3_img"  />';	
							                                    }
															}
				                                        	$i++;
														}
													echo '</div>';
													}
												?>
											</div>
											<div class="clearfix"></div>
											<div class="twitter-bottom-div" style="margin-left:40px;">
												<div class="pull-left">
													<i class="fa fa-mail-reply"></i>
													<span></span>
												</div>
												<div class="pull-left margin-left-15">
													<i class="fa fa-refresh"></i>
												</div>
												<div class="pull-left margin-left-15">
													<i class="fa fa-heart"></i>
												</div>
												<div class="pull-left margin-left-15">
													<i class="fa fa-ellipsis-h"></i>
												</div>					
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							<?php
							break;

						case '3':
							?>
							<div id="outlet_3">
								<div class="insta-post-div">
									<div class="insta-profile-div">
										<div class="pull-left">
											<?php 
												if (file_exists(upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png')) {
		                                        	echo '<img src="'.upload_url().$post_deatils->created_by.'/users/'.$post_deatils->user_id.'.png" class="img-circle insta-profile" />';
			                                    }else{
			                                    	echo '<img class="img-circle insta-profile" src="'.img_url().'default_profile.jpg">';	
			                                    }
											?>
										</div>
										<div class="margin-left-5 insta-username pull-left"><b><?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?></b></div>
										<div class="pull-right insta-time insta-username">0m</div>
									</div>
									<div class="clearfix"></div>

									<div class="insta-img-div">
										<?php 
											foreach ($post_images as $key) {
												if (file_exists('uploads/posts/'.$key->name)) {
		                                        	echo '<img src="'.base_url().'uploads/posts/'. $key->name.'"	/>';
		                                        	break;
			                                    }
											}
										?>										
									</div>	
									
									<div class="insta-post-copy">		
										<div class="insta-comment-div">
											<span class="insta-comment-user-name"><?php echo (!empty($post_deatils->user))? $post_deatils->user :''; ?> </span>
											<span class="post_copy_text"><?php echo (!empty($post_deatils->content)) ? $post_deatils->content : '';?></span>
										</div>
									</div>
									<div class="insta-add-comment">
										<i class="fa fa-heart-o" aria-hidden="true"></i><span class="margin-left-5 ">Add a comment...</span>		
									</div>
								</div>
							</div>
							<?php							
							break;

						default:
							echo '<img src="<?php echo base_url();?>assets/images/post-preview.png" width="406" height="506" alt="" class="center-block"/>';
							break;
					}
				}else{
					?>
					<img src="<?php echo base_url();?>assets/images/post-preview.png" width="406" height="506" alt="" class="center-block"/>';
					<?php 
				}
				?>
				</div>
				<footer class="post-content-footer">
					<a href="#" class="btn btn-secondary btn-xs">Approve</a>
					<div class="btn-group pull-md-right" role="group">
					  <button type="button" class="btn btn-xs btn-default">Edit</button>
					  <button type="button" class="btn btn-xs btn-default">Schedule</button>
					  <button type="button" class="btn btn-xs btn-default">Post Now</button>
					</div>
				</footer>
			</div>
		</div>
		<div class="col-md-6 bg-gray-lightest equal-height">
			<div class="container-phases">
				<div class="">
					<?php 
					if(!empty($phases)){
						foreach ($phases as $phase_no => $obj) {
							?>
							<div class="bg-white approval-phase animated fadeIn" id="approvalPhase<?php echo $phase_no ?>">
								<h2 class="clearfix">Phase <?php echo $phase_no ?> <button title="Edit Phase" class="btn-icon">
									<i class="fa fa-pencil"></i></button>
									<button class="btn btn-xs btn-secondary color-success pull-sm-right">Resubmit for Approval</button>
								</h2>
								<ul class="timeframe-list user-list approval-list border-bottom clearfix">
									<?php
									foreach ($obj as $key => $details) {
										if (!file_exists('uploads/users/'.$details->user_id.'.png')) {
											$user_img = '../../assets/images/default_profile.jpg';
										}else{
											$user_img = '../../uploads/users/'.$details->user_id.'.png';
										}
									?>
										<li class="pull-sm-left approved">
											<img  width="36" height="36" alt="Norel Mancuso" class="circle-img" src='<?php echo $user_img?>'/>
										</li>
									<?php 
									}
									?>
								</ul>
								<div class="approval-date">
									<span class="uppercase">Must approve by:</span> <?php echo date('m/d/Y', strtotime($obj[0]->approve_by)). ' at ' .date('h:i A', strtotime($obj[0]->approve_by));?> PST
								</div>
								<?php
								if(!empty($obj[0]->note))
								{
									?>
									<div class="approval-note">
										NOTE: <?php echo $obj[0]->note ?>
									</div>
									<?php
								}
								?>
							</div>
						<?php
						}
					}
				?>
				<footer class="post-content-footer">
					<div class="btn-group pull-md-right" role="group">
					  <button type="button" class="btn btn-xs btn-default">View Edit Requests</button>
					  <button type="button" class="btn btn-xs btn-default">Suggest an Edit</button>
					</div>
				</footer>
			</div>
		</div>
	</div>
