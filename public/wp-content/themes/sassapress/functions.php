<?php

//Defined Textdomain
define('SPTEXTDOMAIN', wp_get_theme()->get( 'TextDomain' ));

define('SPTHEMENAME', wp_get_theme()->get( 'Name' ));

// admin directory constant
define( 'CUSTOM_ADMIN_DIR', get_template_directory_uri() . '/admin' );
// metaboxes directory constant
define( 'CUSTOM_METABOXES_DIR', get_template_directory_uri() . '/admin/metaboxes' );


// registaring menu
register_nav_menus( array(
    'primary'   => __('Primary', SPTEXTDOMAIN),
    'utility'   => __('Utility', SPTEXTDOMAIN),
    'footer'   => __('Footer', SPTEXTDOMAIN)
    ));

//mobile detection
//Detect Mobile & Tablet Devices
if (class_exists('Mobile_Detect')) {
	global $sp_detect_mobile;
	$sp_detect_mobile = new Mobile_Detect;
} else {
	require_once( get_template_directory()  . '/lib/Mobile_Detect.php');
	global $sp_detect_mobile;
	$sp_detect_mobile = new Mobile_Detect;
}

// fontawesome icons list
require_once( get_template_directory()  . '/admin/fontawesome-icons.php');

// css classes
require_once( get_template_directory()  . '/admin/css-color-classes.php');

//Google Fonts
require_once( get_template_directory()  . '/admin/themeoptions/functions/googlefonts.php');

// MCE Buttons
require_once( get_template_directory()  . '/admin/shortcodes/tinymce.button.php');

// Meta boxes
require_once( get_template_directory()  . '/admin/metaboxes/meta_box.php');

// Theme Option Settings
require_once( get_template_directory()  . '/admin/themeoptions/index.php');

// Shortcodes
require_once( get_template_directory()  . '/lib/shortcodes.php');

//Theme Functions
require_once( get_template_directory()  . '/lib/theme-functions.php');

// nav walker
require_once( get_template_directory()  . '/lib/navwalker.php');

// widgets
require_once( get_template_directory()  . '/lib/widgets.php');

//custom wysiwyg functions
require_once( get_template_directory()  . '/lib/editor.php');

//custom post types
require_once( get_template_directory()  . '/lib/custom-posts.php');

//custom fields
require_once( get_template_directory()  . '/lib/custom-meta.php');

// 
add_action('after_setup_theme', function(){

    // load textdomain
    load_theme_textdomain(SPTEXTDOMAIN, get_template_directory() . '/languages');

    // post format support
    add_theme_support( 
        'post-formats', array(
          'audio', 'gallery', 'image', 'video'
          ) 
        );

    // post thumbnail support
    add_theme_support('post-thumbnails');

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'html5' );
});

if ( is_singular() && get_option( 'thread_comments' ) ){
    wp_enqueue_script( 'comment-reply' );
}


/**
     * Getting theme option
     * @param  boolean $index  [first index of theme array]
     * @param  boolean $index2 [second index of first index array]
     * @return string          [return option data]
*/
if ( ! function_exists( 'sp_option' ) ) { 
    function sp_option($index=false, $index2=false ){

        global $data;

        if( $index2 ){
            return ( isset($data[$index]) and isset($data[$index][$index2]) ) ?  $data[$index][$index2] : '';
        } else {
            return isset( $data[$index] ) ?  $data[$index] : '';
        }
    }
}

// adding scripts at admin panel
add_action( 'admin_enqueue_scripts', function(){
    wp_enqueue_script( 'sp_admin_js', get_template_directory_uri() . '/admin/js/admin.js', false, '1.0.0' );
});

// decativate default gallery css
add_filter( 'use_default_gallery_style', '__return_false' );


//  Set title
add_filter( 'wp_title', function( $title, $sep ) {

    global $paged, $page;

    if ( is_feed() ){
        return $title;
    }

    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );

    if ( $site_description and ( is_home() or is_front_page() ) ){
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ){
        $title = "$title $sep " . sprintf( __( 'Page %s', SPTEXTDOMAIN ), max( $paged, $page ) );
    }

    return $title;
}, 10, 2 );


/**
 * Getting post thumbnail url
 * @param  [int]                $post_ID [Post ID]
 * @return [string]             [Return thumbail source url]
 */
function sp_get_thumb_url($post_ID){
    return wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) );
}


/**
* Add common scripts and stylesheets
*/
if( ! function_exists('sp_scripts') ){

// adding scripts
    add_action('wp_enqueue_scripts', 'sp_scripts');

    function sp_scripts() {

    // Javascripts
        wp_enqueue_script('modernizr',   get_template_directory_uri() . '/assets/js/vendor/modernizr.3.3.1.custom.js', array(), '3.3.1', false);
        wp_enqueue_script('tether-js',   get_template_directory_uri() . '/assets/js/vendor/tether.min.js', array('jquery'), '3.0.0', true);
        wp_enqueue_script('bootstrap-js',   get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array('jquery', 'tether-js'), '3.0.0', true);
        wp_enqueue_script('scrollify',        get_template_directory_uri() . '/assets/js/vendor/jquery.scrollify.min.js', array('jquery'), '0.1.12', true);
        wp_enqueue_script('main-js',        get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('webfonts', 'http://fast.fonts.net/jsapi/52d091f9-f8ff-4b93-9cd6-aeca0d7761f4.js');

    // Stylesheet
        wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), '1.0');
    // Inline css
        wp_add_inline_style( 'style', sp_style_options() );
    }
}

// add ie conditional scripts to header
function add_ie_scripts() {
    echo '<!--[if lt IE 9]>';
	echo '<script src="' . get_template_directory_uri(). '/assets/js/html5shiv.js"></script>';
    echo '<![endif]-->';
}
add_action('wp_head', 'add_ie_scripts');


/**
 * Display pagination
 * @return [string] [pagination]
 */
if( ! function_exists('sp_pagination') ){
	function sp_pagination() {
		global $wp_query;
		if ($wp_query->max_num_pages > 1) {
				$big = 999999999; // need an unlikely integer
				$items =  paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'prev_next'    => true,
					'prev_text'	=> __('Read Previous'),
					'next_text'	=> __('Read More'),
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages,
					'type'=>'array'
					) );
	
				$pagination ="<ul class='pagination'>\n\t<li>";
				$pagination .=join("</li>\n\t<li>", $items);
				$pagination ."</li>\n</ul>\n";
				
				return $pagination;
			}
			return;
		}
}


/**
 * Display post nav
 * @return [type] [description]
 */
if ( ! function_exists( 'sp_post_nav' ) ) {
	function sp_post_nav() {
		global $post;
	
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
	
		if ( ! $next and ! $previous ){
			return;
		} 
		?>
		<nav class="navigation post-navigation" role="navigation">
			<div class="pager">
				<?php if ( $previous ) { ?>
				<li class="previous">
					<?php previous_post_link( '%link', _x( '<i class="icon-long-arrow-left"></i> %title', 'Previous post link', SPTEXTDOMAIN ) ); ?>
				</li>
				<?php } ?>
	
				<?php if ( $next ) { ?>
				<li class="next"><?php next_post_link( '%link', _x( '%title <i class="icon-long-arrow-right"></i>', 'Next post link', SPTEXTDOMAIN ) ); ?></li>
				<?php } ?>
	
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}


if( ! function_exists('sp_link_pages') ){
    function sp_link_pages($args = '') {
        $defaults = array(
            'before' => '' ,
            'after' => '',
            'link_before' => '', 
            'link_after' => '',
            'next_or_number' => 'next', 
            'nextpagelink' => __('Read More', SPTEXTDOMAIN),
            'previouspagelink' => __('Read Previous', SPTEXTDOMAIN), 
            'pagelink' => '%',
            'echo' => 1
            );

        $r = wp_parse_args( $args, $defaults );
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';
        if ( $multipage ) {
            if ( 'number' == $next_or_number ) {
                $output .= $before . '<ul class="pagination">';
                $laquo = $page == 1 ? 'class="disabled"' : '';
                $output .= '<li ' . $laquo .'>' . _wp_link_page($page -1) . '&laquo;</li>';
                for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
                    $j = str_replace('%',$i,$pagelink);

                    if ( ($i != $page) || ((!$more) && ($page==1)) ) {
                        $output .= '<li>';
                        $output .= _wp_link_page($i) ;
                    }
                    else{
                        $output .= '<li class="active">';
                        $output .= _wp_link_page($i) ;
                    }
                    $output .= $link_before . $j . $link_after ;

                    $output .= '</li>';
                }
                $raquo = $page == $numpages ? 'class="disabled"' : '';
                $output .= '<li ' . $raquo .'>' . _wp_link_page($page +1) . '&raquo;</li>';
                $output .= '</ul>' . $after;
            } else {
                if ( $more ) {
                    $output .= $before . '<ul class="pager">';
                    $i = $page - 1;
                    if ( $i && $more ) {
                        $output .= '<li class="previous">' . _wp_link_page($i);
                        $output .= $link_before. $previouspagelink . $link_after . '</li>';
                    }
                    $i = $page + 1;
                    if ( $i <= $numpages && $more ) {
                        $output .= '<li class="next">' .  _wp_link_page($i);
                        $output .= $link_before. $nextpagelink . $link_after . '</li>';
                    }
                    $output .= '</ul>' . $after;
                }
            }
        }

        if ( $echo ){
            echo $output;
        } else {
            return $output;
        } 
    }
}



/**
 * Get avatar url
 * @param  [string] $get_avatar [Avater image link]
 * @return [string]             [image link]
 */
if( ! function_exists('sp_get_avatar_url') ){
	function sp_get_avatar_url($get_avatar){
		preg_match("/src='(.*?)'/i", $get_avatar, $matches);
		return $matches[1];
	}
}


/**
 * Comments link
 * @param   $comment [comments]
 * @param   $args    [arguments]
 * @param   $depth   [depth]
 * @return void          
 */
if( ! function_exists("sp_comments_list") ){
	function sp_comments_list($comment, $args, $depth) {
	
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments.
			?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', SPTEXTDOMAIN ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', SPTEXTDOMAIN ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
				default :
				// Proceed with normal comments.
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>" class="comment media">
						<div class="pull-left comment-author vcard">
							<?php 
							$get_avatar = get_avatar( $comment, 48 );
							$avatar_img = sp_get_avatar_url($get_avatar);
								 //Comment author avatar 
							?>
							<img class="avatar img-circle" src="<?php echo $avatar_img ?>" alt="">
						</div>
	
						<div class="media-body">
	
							<div class="well">
	
								<div class="comment-meta media-heading">
									<span class="author-name">
										<?php _e('By', SPTEXTDOMAIN); ?> <strong><?php echo get_comment_author(); ?></strong>
									</span>
									-
									<time datetime="<?php echo get_comment_date(); ?>">
										<?php echo get_comment_date(); ?> <?php echo get_comment_time(); ?>
										<?php edit_comment_link( __( 'Edit', SPTEXTDOMAIN ), '<small class="edit-link">', '</small>' ); //edit link ?>
									</time>
	
									<span class="reply pull-right">
										<?php comment_reply_link( array_merge( $args, array( 'reply_text' =>  sprintf( __( '%s Reply', SPTEXTDOMAIN ), '<i class="icon-repeat"></i> ' ) , 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
									</span><!-- .reply -->
								</div>
	
								<?php if ( '0' == $comment->comment_approved ) {  //Comment moderation ?>
								<div class="alert alert-info"><?php _e( 'Your comment is awaiting moderation.', SPTEXTDOMAIN ); ?></div>
								<?php } ?>
	
								<div class="comment-content comment">
									<?php comment_text(); //Comment text ?>
								</div><!-- .comment-content -->
	
							</div><!-- .well -->
	
	
						</div>
					</div><!-- #comment-## -->
				<?php
				break;
		} // end comment_type check
	}
}


// registering sidebar
register_sidebar(array(
  'name' => __( 'Sidebar', SPTEXTDOMAIN ),
  'id' => 'sidebar',
  'description' => __( 'Widgets in this area will be shown on left side.', SPTEXTDOMAIN ),
  'before_title' => '<h5>',
  'after_title' => '</h5>',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>'
  )
);

register_sidebar(array(
  'name' => __( 'Solutions Sidebar', SPTEXTDOMAIN ),
  'id' => 'solutions-sidebar',
  'description' => __( 'Widgets in this area will be shown on solutions pages.', SPTEXTDOMAIN ),
  'before_title' => '<h5>',
  'after_title' => '</h5>',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>'
  )
);

register_sidebar(array(
  'name' => __( 'Footer', ZEETEXTDOMAIN ),
  'id' => 'footer',
  'description' => __( 'Widgets in this area will be shown in the Footer.' , ZEETEXTDOMAIN),
  'before_title' => '<h5>',
  'after_title' => '</h5>',
  'before_widget' => '<div class="col-sm-4">',
  'after_widget' => '</div>'
  )
);


/**
 * Comment form
 */
if( ! function_exists('sp_comment_form') ){
function sp_comment_form($args = array(), $post_id = null ){

    if ( null === $post_id )
        $post_id = get_the_ID();
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    if ( ! isset( $args['format'] ) )
        $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';


    $req      = get_option( 'require_name_email' );

    $aria_req = ( $req ? " aria-required='true'" : '' );

    $html5    = 'html5' === $args['format'];

    $fields   =  array(
        'author' => '
        <div class="form-group">
        <div class="col-sm-6 comment-form-author">
        <input   class="form-control"  id="author" 
        placeholder="' . __( 'Name', SPTEXTDOMAIN ) . '" name="author" type="text" 
        value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
        </div>',

        'email'  => '<div class="col-sm-6 comment-form-email">
        <input id="email" class="form-control" name="email" 
        placeholder="' . __( 'Email', SPTEXTDOMAIN ) . '" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' 
        value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
        </div>
        </div>',

        'url'    => '<div class="form-group">
        <div class=" col-sm-12 comment-form-url">' .
        '<input  class="form-control" placeholder="'. __( 'Website', SPTEXTDOMAIN ) .'"  id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '"  />
        </div></div>',
        );

	$required_text = sprintf( ' ' . __('Required fields are marked %s', SPTEXTDOMAIN), '<span class="required">*</span>' );

	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	
		'comment_field'        => '
		<div class="form-group comment-form-comment">
		<div class="col-sm-12">
		<textarea class="form-control" id="comment" name="comment" placeholder="' . _x( 'Comment', 'noun', SPTEXTDOMAIN ) . '" rows="8" aria-required="true"></textarea>
		</div>
		</div>
		',
	
		'must_log_in'          => '
	
	
		<div class="alert alert-danger must-log-in">' 
		. sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) 
		. '</div>',
	
		'logged_in_as'         => '<div class="alert alert-info logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', SPTEXTDOMAIN ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</div>',
	
		'comment_notes_before' => '<div class="alert alert-info comment-notes">' . __( 'Your email address will not be published.', SPTEXTDOMAIN ) . ( $req ? $required_text : '' ) . '</div>',
	
		'comment_notes_after'  => '<div class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', SPTEXTDOMAIN ), ' <code>' . allowed_tags() . '</code>' ) . '</div>',
	
		'id_form'              => 'commentform',
	
		'id_submit'            => 'submit',
	
		'title_reply'          => __( 'Leave a Reply', SPTEXTDOMAIN ),
	
		'title_reply_to'       => __( 'Leave a Reply to %s', SPTEXTDOMAIN ),
	
		'cancel_reply_link'    => __( 'Cancel reply', SPTEXTDOMAIN ),
	
		'label_submit'         => __( 'Post Comment', SPTEXTDOMAIN ),
	
		'format'               => 'xhtml',
		);


	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
	
	if ( comments_open( $post_id ) ) { ?>
	
	<?php do_action( 'comment_form_before' ); ?>
	
	<div id="respond" class="comment-respond">
	
		<h5 id="reply-title" class="comment-reply-title primary-title">
			<?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> 
			<small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small>
		</h5>
	
		<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) { ?>
	
		<?php echo $args['must_log_in']; ?>
	
		<?php do_action( 'comment_form_must_log_in_after' ); ?>
	
		<?php } else { ?>
	
		<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" 
			class="form-horizontal comment-form"<?php echo $html5 ? ' novalidate' : ''; ?> role="form">
			<?php do_action( 'comment_form_top' ); ?>
	
			<?php if ( is_user_logged_in() ) { ?>
	
			<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
	
			<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
	
			<?php } else { ?>
	
			<?php echo $args['comment_notes_before']; ?>
	
			<?php
	
			do_action( 'comment_form_before_fields' );
	
			foreach ( (array) $args['fields'] as $name => $field ) {
				echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
			}
	
			do_action( 'comment_form_after_fields' );
	
		} 
	
		echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); 
	
		echo $args['comment_notes_after']; ?>
	
		<div class="form-submit">
			<input class="btn btn-primary" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
			<?php comment_id_fields( $post_id ); ?>
		</div>
	
		<?php do_action( 'comment_form', $post_id ); ?>
	
	</form>
	
	<?php } ?>
	
	</div><!-- #respond -->
	<?php do_action( 'comment_form_after' ); ?>
	<?php } else { ?>
	<?php do_action( 'comment_form_comments_closed' ); ?>
	<?php } ?>
	<?php
	}
}


/**
 * post password form
 */
if( ! function_exists('sp_post_password_form') ){
	function sp_post_password_form() {
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	
		$o = '
		<div class="row">
		<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<div class="col-lg-6">
		' . __( "To view this protected post, enter the password below:", SPTEXTDOMAIN ) . '
		<div class="input-group">
		<input class="form-control" name="post_password" placeholder="' . __( "Password:", SPTEXTDOMAIN ) . '" id="' . $label . '" type="password" /><span class="input-group-btn"><button class="btn btn-info" type="submit" name="Submit">' . esc_attr__( "Submit", SPTEXTDOMAIN ) . '</button></span>
		</div><!-- /input-group -->
		</div><!-- /.col-lg-12 -->
		</form>
		</div>';
		return $o;
	}
	
	add_filter( 'the_password_form', 'sp_post_password_form' );
}


/**
 * Prints the attached image with a link to the next attached image.
 *
 *
 * @return void
 */
if ( ! function_exists( 'sp_the_attached_image' ) ) {
	function sp_the_attached_image() {
		$post                = get_post();
		$attachment_size     = array( 724, 724 );
		$next_attachment_url = wp_get_attachment_url();
	
		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
			) );
	
		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}
	
			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );
	
			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	
		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, $attachment_size )
			);
	}
}

//Blog images
add_image_size( 'blog-thumb', 360, 270, true );

/*Custom Excerpts */
function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*Enables the Excerpt meta box in Page edit screen*/
function wpcodex_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'wpcodex_add_excerpt_support_for_pages' );

//set priority of Yoast Meta boxes to low
add_filter( 'wpseo_metabox_prio', function() { return 'low';});

//include advanced custom fields
include_once(get_template_directory() . '/acf-flexible-content/acf-flexible-content.php');

?>