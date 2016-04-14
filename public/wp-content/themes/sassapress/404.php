<?php get_header(); ?>
<div id="content" class="site-content" role="main">
    <div id="error" class="container">
        <h1><?php _e( '404, Page not found', SPTEXTDOMAIN );?> </h1>
        <p><?php _e( "The page you are looking for doesn't exist or another error occurred", SPTEXTDOMAIN );?> </p>
        <a class="btn btn-warning" href="<?php echo home_url(); ?>"><?php _e( 'GO BACK TO THE HOMEPAGE', SPTEXTDOMAIN );?></a>
    </div><!--/#error-->
</div><!-- #content -->
<?php get_footer();