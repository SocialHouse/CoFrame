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
						
						<header class="archive-header">
							<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', SPTEXTDOMAIN ), single_tag_title( '', false ) ); ?></h1>
							<?php if ( tag_description() ) { // Show an optional tag description ?>
							<div class="archive-meta"><?php echo tag_description(); ?></div>
							<?php } ?>
						</header><!-- .archive-header -->
				
						<?php 
						while ( have_posts() ) { 
							the_post();  get_template_part( 'post-templates/content', get_post_format() ); 
						} 
				
						} else { 
							get_template_part( 'post-templates/content', 'none' ); 
						} ?>
					</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div><!-- #content -->
		
		<?php get_footer(); ?>