<?php get_header(); ?>
		<?php 
		$pid = get_option( 'page_for_posts' );
		if ( has_post_thumbnail($pid) && ! post_password_required($pid) ) { ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail($pid); ?>
			</div>
			<?php } ?>
        <div id="content" class="site-content blog-content col-sm-12" role="main">
			<div class="col-sm-12 col-lg-10 center-block">
				<div class="row">
					<div class="col-sm-9">
						<?php if ( have_posts() ) { ?>
						<header class="page-header">
							<h1 class="page-title"><?php printf( __( 'Search Results for: %s', SPTEXTDOMAIN ), get_search_query() ); ?></h1>
						</header>
						<?php /* The loop */ ?>
						<?php while ( have_posts() ) { the_post(); 
							?>
							<?php get_template_part( 'post-templates/content', 'search' ); ?>
							<?php } ?>
							<footer class="more-pages">
								 <div class="posts-link more-posts"><?php next_posts_link( 'Read More' , $max_pages ); ?></div>
								 <div class="posts-link previous-posts"><?php previous_posts_link( 'Read Previous' , $max_pages ); ?></div>
							</footer>
							<?php } else { ?>
							<?php get_template_part( 'post-templates/content', 'none' ); ?>
							<?php } ?>
					</div><!-- .col-sm-8 -->
					<?php get_sidebar(); ?>
				</div>
			</div>
    	</div>
    	<?php get_footer(); ?>