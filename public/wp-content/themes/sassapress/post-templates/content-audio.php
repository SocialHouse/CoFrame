<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if ( is_single() ) { ?>
        <h1 class="entry-title"><?php the_title(); ?>
            <?php edit_post_link( __( 'Edit', SPTEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
        </h1>
        <?php } else { ?>
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            <?php edit_post_link( __( 'Edit', SPTEXTDOMAIN ), '<small class="edit-link pull-right">', '</small>' ); ?>
        </h2>
        <?php } //.entry-title ?>

        <div class="entry-meta">
            <ul>                                                
                <li class="date"><?php echo __('Posted On', SPTEXTDOMAIN ); ?> <time class="entry-date" datetime="<?php the_time( 'c' ); ?>"><?php the_time('j M Y'); ?></time></li>
                <li class="author"><?php echo __('By', SPTEXTDOMAIN ); ?> <?php the_author_posts_link() ?></li>
                <li class="category"><?php echo __('In', SPTEXTDOMAIN ); ?> <?php echo get_the_category_list(', '); ?></li> 
                <?php if ( comments_open() && ! is_single() ) { ?>
                <li class="comments-link">
                    <?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', SPTEXTDOMAIN ) . '</span>', __( 'One comment so far', SPTEXTDOMAIN ), __( 'View all % comments', SPTEXTDOMAIN ) ); ?>
                </li>
                <?php } //.comment-link ?>                       
            </ul>
        </div><!--/.entry-meta -->

    </header><!--/.entry-header -->

    <div class="entry-content">
        <div class="audio-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', SPTEXTDOMAIN ) ); ?>
        </div><!--/.audio-content -->
    </div><!--/.entry-content -->

    <footer>
        <?php sp_link_pages(); ?>
    </footer>
</article><!--/#post -->

<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) { ?>
<?php get_template_part( 'author-bio' ); ?>
<?php } ?>