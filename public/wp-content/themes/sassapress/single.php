<?php get_header(); ?>
		<div class="site-content blog-content" role="main">
			<div class="container page-content">
				<div class="row">
					<div class="col-sm-3 left-col">
						<?php get_sidebar(); ?>
					</div>
					<div class="col-sm-9">
						<?php /* The loop */ ?>
			
						<?php if(have_posts()){ while ( have_posts() ) { the_post(); ?>
			
							<?php get_template_part( 'post-templates/content', get_post_format() ); ?>
			
							<?php blog_comments(); ?>
			
						<?php } } ?>
					</div>
					
				</div>
			</div>
	    </div><!--/#content -->

		<?php get_footer();