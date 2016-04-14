<?php

			$feat_img = get_the_post_thumbnail( $post->ID, 'thumbnail', $img_attr);

			$post_type = get_post_type();

			$post_slug=$post->post_name;

			$parent_id = $post->post_parent;

			$parent_post = get_post($parent_id);

			$parent_slug = $parent_post->post_name;

			if($post_type == 'sp_cheese') {

				$permalink = '/cheese/' . $parent_slug . '/#' . $post_slug;

			}

			else {

				$permalink = get_permalink();

			}



?>

<article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

	<?php if ( $img) { ?>

		<div class="entry-thumbnail col-sm-4"><a href="<?php echo $permalink; ?>" rel="bookmark"><?php echo $feat_img; ?></a></div>

	<?php } ?>

	<div class="col-sm-8 post-details">

		<header class="entry-header">

			<h2 class="entry-title">

				<a href="<?php echo $permalink; ?>" rel="bookmark"><?php the_title(); ?></a>

			</h2>

		</header><!--/.entry-header -->

		<div class="entry-summary">

			<?php the_excerpt(); ?>

			<a href="<?php echo $permalink; ?>" rel="bookmark" class="read-more">Read More</a>

		</div>

	</div>

</article><!--/#post-->