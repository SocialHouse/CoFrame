		<?php
			if( have_rows('page_grid') ):
				// loop through the rows of data
				while ( have_rows('page_grid') ) : the_row();
					//Slider Content
					if( get_row_layout() == 'slider-block' ): 
						$slide_objects = get_sub_field('slider');
						set_query_var( 'slide_objects', $slide_objects );
						if( $slide_objects ):
							echo '<section class="main-slider grid-section">';
							get_template_part( 'post-templates/content', 'slider' );
							echo '</section>';
						endif;
					endif;


					//Content Block
					if( get_row_layout() == 'content_item' ): 
						$content = get_sub_field('content_block');
						$bg = get_sub_field('background_color');
					?>
						<section class="grid-section content-item<?php if( $bg ) { echo ' ' . $bg; } else {echo ' bg-none';} ?>">
							<div class="container">
								<div class="row">
									<div class="col-sm-12">
										<?php echo $content; ?>
									</div>
								</div>
							</div>
						</section>
					<?php
					endif;


					//Full Width Content Block
					if( get_row_layout() == 'full_width_block' ): 
						$content = get_sub_field('content_block');
						$bg = get_sub_field('background_color');
					?>
						<section class="grid-section full-width-content content-item<?php if( $bg ) { echo ' ' . $bg; } else {echo ' bg-none';} ?>">
							<div class="container-fluid">
								<div class="row">
									<?php echo $content; ?>
								</div>
							</div>
						</section>
					<?php
					endif;


					//Border Title
					if( get_row_layout() == 'border_title_block' ): 
						$title = get_sub_field('title');
						$bg = get_sub_field('background_color');
					?>
						<section class="grid-section border-title-block<?php if( $bg ) { echo ' ' . $bg; } else {echo ' bg-none';} ?>">
							<div class="container">
								<div class="row">
									<div class="col-sm-12">
										<h3 class="border-title"><span><?php echo $title; ?></span></h3>
									</div>
								</div>
							</div>
						</section>
					<?php
					endif;


					//Column Content
					if( get_row_layout() == 'column_content' ): 
						$bg = get_sub_field('background_color');
						$row_class = get_sub_field('class');
					?>
						<section class="grid-section column-content<?php if( $bg ) { echo ' ' . $bg; } else {echo ' bg-none';} ?>">
							<div class="container">
								<div class="row <?php echo $row_class; ?>">
									<?php
										$cols = count(get_sub_field(content_column));
										$colwidth = 12 / $cols;
										while ( have_rows('content_column') ) : the_row();
											$content = get_sub_field('content');
											$class = get_sub_field('column_class');
											$center = get_sub_field('vertically_centered');
											if( !$center ) { 
												$ctrclass = ' not-centered';
											} else {
												$ctrclass = '';
											}
										?>
										<div class="col-md-<?php echo $colwidth . $ctrclass; ?>">
											<?php echo $content; ?>
										</div>
									<?php 
										endwhile;
									?>
								</div>
							</div>
						</section>
							<?php
					endif;


					//Product Content
					if( get_row_layout() == 'product_downloads' ): 
						$bg = get_sub_field('background_color');
						$numItems = 0;
						while(have_rows('product_sheet')) : the_row();
							$numItems++;
						endwhile;
						while ( have_rows('case_study') ) : the_row();
							$numItems++;
						endwhile;
						while(have_rows('demo_video')) : the_row();
							$numItems++;
						endwhile;
						if($numItems == 1) {
							$wrapCols = 3;
							$smallCols = 12;
						}
						elseif($numItems == 2) {
							$wrapCols = 6;
							$smallCols = 6;
						}
						else {
							$wrapCols = 9;
							$smallCols = 4;
						}
					?>
						<section class="grid-section product-downloads<?php if( $bg ) { echo ' ' . $bg; } else {echo ' bg-none';} ?>">
							<div class="container">
								<div class="row">
									<div class="center-block col-xl-<?php echo $wrapCols; ?>">
										<div class="row">
										<?php
											while ( have_rows('product_sheet') ) : the_row();
												$content = get_sub_field('content');
												$pdf = get_sub_field('downloadable_asset');
											?>
											<div class="col-sm-6 col-md-<?php echo $smallCols; ?>">
												<div class="card">
													<div class="card-block">
														<h4 class="card-title">Product Sheet</h4>
														<div class="card-text"><?php echo $content; ?></div>
														<a href="<?php echo $pdf; ?>" class="btn btn-primary" target="_blank">Read Our Product Sheet</a>
													</div>
												</div>
											</div>
										<?php 
											endwhile;
										?>
										<?php
											while ( have_rows('case_study') ) : the_row();
												$content = get_sub_field('content');
												$title = get_sub_field('case_study_title');
												$form = get_sub_field('pardot_form_shortcode');
											?>
											<div class="col-sm-6 col-md-<?php echo $smallCols; ?>">
												<div class="card">
													<div class="card-block">
														<h4 class="card-title">Case Study</h4>
														<div class="card-text"><?php echo $content; ?></div>
														<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#caseStudy">Read Our Case Study</a>
													</div>
												</div>
											</div>
											<div class="modal fade" id="caseStudy" tabindex="-1" role="dialog" aria-hidden="true">
											  <div class="modal-dialog modal-sm" role="document">
												<div class="modal-content">
												  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">X</span>
												  </button>
												  <div class="modal-body">
												  <?php echo $title; ?>
												  <p> <?php echo do_shortcode( $form ); ?></p>
												  </div>
												</div>
											  </div>
											</div>
										<?php 
											endwhile;
										?>
										<?php
											while ( have_rows('demo_video') ) : the_row();
												$content = get_sub_field('content');
												$video = get_sub_field('video_embed_url');
											?>
											<div class="col-sm-6 col-md-<?php echo $smallCols; ?>">
												<div class="card">
													<div class="card-block">
														<h4 class="card-title">Demo Video</h4>
														<div class="card-text"><?php echo $content; ?></div>
														<a href="#" data-toggle="modal" data-target="#demoVideo" class="btn btn-primary">Watch our Video</a>
													</div>
												</div>
											</div>
											<div class="modal fade" id="demoVideo" tabindex="-1" role="dialog" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">X</span>
												  </button>
												  <div class="modal-body">
													  <?php echo $video; ?>
												  </div>
												</div>
											  </div>
											</div>
										<?php 
											endwhile;
										?>
										</div>
									</div>
								</div>
							</div>
						</section>
							<?php
					endif;


					//Testimonial
					if( get_row_layout() == 'testimonial' ):
						$post = get_sub_field('testimonial_post');
						if( $post ): 
						$designation = get_post_meta($post->ID, 'testimonial_designation', true);
						$designation2 = get_post_meta($post->ID, 'testimonial_designation_second', true);
					?>
						<?php setup_postdata($post); ?>
						<section class="grid-section testimonial bg-primary">
							<div class="container">
								<div class="row">
									<div class="col-sm-12">
										<blockquote>
											<p><?php echo $post->post_content; ?></p>
											<footer>
												<cite>
												<?php 
													echo $designation; 
													if($designation2) {
														echo ' ' .$designation2;
													}
												?>
												</cite>
											</footer>
										</blockquote>
									</div>
								</div>
							</div>
						</section>	
						<?php wp_reset_postdata(); // reset the $post object so the rest of the page works correctly ?>
						<?php 
						endif;		
					endif;		


					//Testimonial List
					if( get_row_layout() == 'testimonial_list' ):
						$testimonial_list = get_sub_field('testimonial_post');
						if( $testimonial_list ):
					?>
						<section class="grid-section testimonial-list">
							<div class="container">
								<ul class="row">
								<?php
									foreach( $testimonial_list as $post):
										$designation = get_post_meta($post->ID, 'testimonial_designation', true);
										$designation2 = get_post_meta($post->ID, 'testimonial_designation_second', true);
								?>
									<?php setup_postdata($post); ?>
									<li class="col-sm-12">
										<blockquote>
											<p><?php echo $post->post_content; ?></p>
											<footer>
												<cite>
												<?php 
													echo '<strong>' . $designation . '</strong>';
													if($designation2) {
														echo '<br>' . $designation2;
													}
												?>
												</cite>
											</footer>
										</blockquote>
									</li>
								<?php
									wp_reset_postdata(); // reset the $post object so the rest of the page works correctly
									endforeach;
								?>
								</ul>
							</div>
						</section>							
					<?php
						endif;		
					endif;		


					//CTA
					if( get_row_layout() == 'call_to_action' ): 
						$headline = get_sub_field('headline');
						$link_text = get_sub_field('link_text');
						$link = get_sub_field('page_url');
						$bg = get_sub_field('background_color');
						$font = get_sub_field('small_font_version');
						$lightbox = get_sub_field('open_form_in_lightbox');
						if($font) {
							$size = "cta-small";
						}
						else {
							$size = "";
						}
					?>
						<section class="grid-section cta<?php if( $bg ) { echo ' ' . $bg; } else {echo ' bg-none';} echo ' ' . $size; ?>">
							<div class="container">
								<div class="row">
									<div class="col-sm-9 col-md-8">
										<?php if( $headline ) :?>
											<h2><?php echo $headline; ?></h2>
										<?php endif; ?>
									</div>
									<div class="col-sm-3 col-md-4<?php if($lightbox) { echo ' get-more-info-modal'; } ?>">
										<a href="<?php echo $link; ?>" class="btn btn-lg<?php if($bg != 'bg-gray-dark') { echo ' btn-secondary'; } else { echo ' btn-primary'; } ?>">
										<?php echo $link_text; ?>
										</a>
									</div>
								</div>
							</div>
						</section>
					<?php
					endif;


					//Team Members
					if( get_row_layout() == 'team_members' ):
						$team_objects = get_sub_field('team_member');
						if( $team_objects ): ?>
						
						<section class="grid-section nerds-section" id="section-team">
							<div class="container">
								<div class="row">
									  <ul class="nerd-list row">
										<?php foreach( $team_objects as $post): // run the loop ?>
										<?php setup_postdata($post); ?>
										<li class="col-md-4 col-xs-6">
											<?php 
												$content = $post->post_content;
												$img_attr = array(
													'class' => "img-responsive", 
													'alt' => trim(strip_tags( get_the_title() )),
													'title' => trim(strip_tags( get_the_title() ))
												);
											?>
												<div class="nerd-img">
													<?php echo get_the_post_thumbnail( $post->ID, 'full', $img_attr); ?>
												</div>
												<p class="nerd-name"><?php the_title() ?><br>
												<em class="job-title"><?php echo get_post_meta($post->ID, 'team_job_title', true); ?></em></p>
												<?php if($content) { ?>
												<blockquote class="team-bio">
													<?php echo $content  ?>
												</blockquote>
												<?php } ?>
										  </li>
										  <?php endforeach; ?>
										</ul>
									</div>
								</div>
						  </section>
						  
					<?php wp_reset_postdata(); // reset the $post object so the rest of the page works correctly
		
						endif;		
					endif;

				endwhile;
			endif;
		?>