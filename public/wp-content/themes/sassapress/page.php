<?php get_header(); ?>
		<div class="site-content" role="main">
			<section class="grid-section content-item bg-primary">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<h1 style="text-align: center; margin-bottom:5px"><?php the_title(); ?></h1>
							<p class="center-block col-sm-8" style="text-align: center;"></p>
						</div>
					</div>
				</div>
			</section>	
	
			<?php get_template_part( 'bread', 'crumbs' ); ?>

			<div class="container page-content">
				<div class="row">
					<div class="col-sm-3 col-md-2 left-col">
						<?php
							if ($post->post_parent)	{
								$ancestors=get_post_ancestors($post->ID);
								$depth = count($ancestors);
								$root=count($ancestors)-1;
								$parent = $ancestors[$root];
							} else {
								$parent = $post->ID;
							}
							$args = array(
								'title_li' => '',
								'child_of' => $parent,
								'echo' => 0,
								'depth' => $depth
							);
							$children = wp_list_pages($args);
							$sect_title = get_the_title($parent);
							if ($children) {
								echo '<h5 class="nav-title">' . $sect_title . '</h5>';
								echo '<ul class="nav">' . $children . '</ul>';
							}
						?>
					</div>
					<?php /* The loop */ ?>
					<?php if(have_posts()){ while ( have_posts() ) { the_post(); ?>
					<div class="col-sm-9 col-md-10">

						<?php the_content(); ?>					</div>
					<?php } 
					} else { ?>
						<div class="col-sm-9 col-md-10">
							<?php get_template_part( 'post-templates/content', 'none' ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php get_template_part( 'post-templates/content', 'grid' ); ?>
		</div><!--/.site-content -->
<?php get_footer();