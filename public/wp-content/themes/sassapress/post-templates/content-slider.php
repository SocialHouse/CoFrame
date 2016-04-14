									<div class="carousel slide" data-ride="carousel" data-interval="6500" data-pause="false">
										<div class="carousel-inner">
											<?php foreach ($slide_objects as $key => $slider) { 

												$full_img           =   wp_get_attachment_image_src( get_post_thumbnail_id( $slider->ID ), 'full');
												$slider_position    =   get_post_meta($slider->ID, 'slider_position', true );
												$boxed              =   (get_post_meta($slider->ID, 'slider_boxed', true )=='yes') ? 'boxed' : '';
												$has_button         =   (get_post_meta($slider->ID, 'slider_button_text', true )=='') ? false : true;
												$button             =   get_post_meta($slider->ID, 'slider_button_text', true );
												$button_url         =   get_post_meta($slider->ID, 'slider_button_url', true );
												$video_url          =   get_post_meta($slider->ID, 'slider_video_link', true );
												$video_type         =   get_post_meta($slider->ID, 'slider_video_type', true );
												$bg_image_url       =   get_post_meta($slider->ID, 'slider_background_image', true );
												$background_image   =   'background-image: url('.wp_get_attachment_url($bg_image_url).')';
												$columns            =   false;

												if( !empty($image_url) or !empty($video_url) ){
													$columns        =   true;
												}

												if($slider_position == 'left') {
													$box_align = 'pull-left';
												}
												else {
													$box_align = 'pull-right';
												}

												if( $video_type=='youtube' ) {
													$embed_code = '<iframe width="640" height="480" src="//www.youtube.com/embed/' . get_video_ID( $video_url ) . '?rel=0" frameborder="0" allowfullscreen></iframe>';
												} elseif( $video_type=='vimeo' ) {
													$embed_code = '<iframe src="//player.vimeo.com/video/' . get_video_ID( $video_url ) . '?title=0&amp;byline=0&amp;portrait=0&amp;color=a22c2f" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
												}
												
												if( $full_img ){
													$embed_code     = '<img src="' . $full_img[0] . '" alt="">';
													$columns        =   true;
												}
												global $sp_detect_mobile;
												?>
													<div class="item <?php echo ($key==0) ? 'active' : '' ?>" style="background-image: url(<?php echo wp_get_attachment_url( $bg_image_url ); ?>);">

														<?php if($button_url) { ?>
															<a href="<?php echo $button_url ?>" <?php echo $target; ?>>
														<?php }  ?>
														<img src="<?php echo wp_get_attachment_url( $bg_image_url ); ?>" alt="<?php echo $slider->post_title ?>" class="slider-img invisible" />
														<?php if($button_url) { ?>
															</a>
														<?php } ?>

														<div class="carousel-content animated animated-item-1 fadeIn">
															<div class="container">
																<div class="row">
																	<div class="col-sm-12">
																		<?php echo apply_filters('the_content', $slider->post_content); ?>
																		<?php if( $has_button ){ ?>
																		<a class="btn btn-lg btn-secondary animated animated-item-3 fadeInRight" href="<?php echo $button_url ?>"  <?php echo $target; ?>><?php echo $button ?></a>
																		<?php } ?>
																	</div>
																</div>
															</div>
														</div>
														
													<?php if($columns){ ?>
													<div class="col-sm-6 hidden-xs animation animated-item-4">
														<div class="centered" style="margin-top: 129px;">
															<div class="embed-container">
																<?php echo $embed_code; ?>
															</div>
														</div>
													</div>
													<?php } ?>
												</div>
												<?php } // endforeach ?>
											</div><!--/.carousel-inner-->
											<?php if($total_sliders > 1) { ?>
											<a class="prev hidden-xs carousel-nav" href="#main-slider" data-slide="prev">
												<i class="icon-angle-left"></i>
											</a>
											<a class="next hidden-xs carousel-nav" href="#main-slider" data-slide="next">
												<i class="icon-angle-right"></i>
											</a>
											<?php } ?>
										</div><!--/.carousel-->