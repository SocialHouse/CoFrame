            <?php
            	if($p == 1 && !is_single()) {
            		$colclass = 'col-sm-8 feature-post';
            	}
            	elseif(is_single()) {
            		$colclass = 'col-sm-12';
            	}
             	else {
            		$colclass = 'col-sm-4';
            	}
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class($colclass); ?>>
            	<?php if($p == 1 && !is_single()) : ?>
            		<div class="row">
            			<div class="col-md-6 blog-img">
            	<?php endif; ?>
				<header class="entry-header">
					<?php if ( !is_single() ) { ?>
						<div class="entry-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo get_the_post_thumbnail( $post->ID, 'blog-thumb'); ?></a></div>
					<?php } //.entry-title ?>
					<?php if ( !is_single() ) { ?>
						<h1 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							<?php edit_post_link( __( 'Edit', SPTEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
						</h1>
					<?php } else { ?>
						<h1 class="entry-title">
							<?php the_title(); ?>
							<?php edit_post_link( __( 'Edit', SPTEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
						</h1>
					<?php } //.entry-title ?>
				</header><!--/.entry-header -->
            	<?php if($p == 1 && !is_single()) : ?>
            			</div>
            			<div class="col-md-6 blog-summary">
            	<?php endif; ?>	
				<?php if ( !is_single() ) { ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
					<div class="blog-meta">
						<?php echo get_the_category_list(); ?>
						<a href="<?php the_permalink(); ?>" class="arrow-link pull-right">Read More</a>
					</div>
				<?php } else { ?>
					<div class="entry-content">
						<div class="entry-thumbnail"><?php echo get_the_post_thumbnail( $post->ID, 'full'); ?></div>
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', SPTEXTDOMAIN ) ); ?>
					</div>
				<?php } //.entry-content ?>
            	<?php if($p == 1 && !is_single()) : ?>
            			</div>
            		</div>
            	<?php endif; ?>	
			</article><!--/#post-->
