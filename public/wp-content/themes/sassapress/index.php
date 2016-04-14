<?php get_header(); ?>
		<div class="site-content blog-list" role="main">
			<div class="container page-content">
				<h5 class="bg-primary blog-title">FilmTrack Editorial</h5>
				<div class="row">
						<?php
						if ( have_posts() ) { 
							$p = 1;
							set_query_var( 'p', $p );
						?>
							<?php /* The loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'post-templates/content', get_post_format() ); ?>
							<?php 
								$p++;
								set_query_var( 'p', $p );
								endwhile; 
							?>
						<?php } else { ?>
								<?php get_template_part( 'post-templates/content', 'none' ); ?>
						<?php } ?>
				</div>
			</div>
		</div>
<?php get_footer();