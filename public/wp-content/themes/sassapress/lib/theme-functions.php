<?php
/*
* Theme Option Functions
*/

//Favicon Image
if (!function_exists("sp_favicon")) {
    function sp_favicon(){
        if(sp_option('sp_favicon') == ""){
            echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/favicon.png" >';
        } else {
            echo '<link rel="shortcut icon" href="' . sp_option('sp_favicon') .'" >';
        }
        if (sp_option('sp_show_apple_logo')) {
            echo sp_option('sp_apple_iphone_icon') != "" ? ('<link rel="apple-touch-icon" href="' . sp_option('sp_apple_iphone_icon') . '"/>') : '';
            echo sp_option('sp_apple_iphone_retina_icon') != "" ? ('<link rel="apple-touch-icon" sizes="114x114" href="' . sp_option('sp_apple_iphone_retina_icon') . '"/>') : '';
            echo sp_option('sp_apple_ipad_icon') != "" ? ('<link rel="apple-touch-icon" sizes="72x72" href="' . sp_option('sp_apple_ipad_icon') . '"/>') : '';
            echo sp_option('sp_apple_ipad_retina_icon') != "" ? ('<link rel="apple-touch-icon" sizes="144x144" href="' . sp_option('sp_apple_ipad_retina_icon') . '"/>') : '';
        }
    }
}

//Comments On Pages
if (!function_exists("comments_page")) {
    function comments_page(){
        if(sp_option('sp_blog_comments') && is_page()){
            comments_template();
        }
    }
}

//Logo Option
if (!function_exists("logo")) {
    function logo(){
        if( sp_option( 'sp_show_logo' ) == 0 ){ ?> 
        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><i class="icon-cloud"></i> <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
        <?php } else{ ?>
        <a class="navbar-brand hidden-print" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span class="brand-logo hide-text" style="background-image: url(<?php echo sp_option( 'site_logo' );?>);"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span>
        </a>
		<div class="visible-print-block logo-print">
       		<img src="<?php echo sp_option( 'site_logo' );?>" height="136" width="125" alt="">
		</div>
        <?php 
    	}
	}
}

//Copyright Text 
if( !function_exists('show_footer')){
    function show_footer(){
        if(sp_option( 'sp_footer_text_info' ) == 1){
            echo sp_option( 'sp_copyright_text' );
        }
    }
}

//Google Analytics
if( !function_exists('google_analytics') ){
    function google_analytics(){
        echo sp_option('sp_google_analytics');
    }
}

//Blog Sidebar Position
if(!function_exists('blog_date')){
    function blog_date(){
        if(sp_option('sp_blog_date')){
            echo sp_option('sp_blog_date');
        //the_time('$time');
        }
    }
}

//Featured Image on Single Post
if( !function_exists('featured_image_single_post')){
    function featured_image_single_post(){
        if(sp_option( 'sp_single_featured_image' ) == 1){
            the_post_thumbnail();
        } 
    }
}

//Post Author Section
if( !function_exists('sp_author_bio')){
    function sp_author_bio(){
        if( sp_option('sp_single_post_author') ){
            echo sp_option('sp_single_post_author');
        }
    }
}

//Comments On Blog
if (!function_exists("blog_comments")) {
    function blog_comments(){
        if(sp_option('sp_blog_comments') == 1 && is_single()){
            comments_template();
        }
    }
}

//Excerpt Length
function sp_excerpt_length($length) {
    return sp_option('sp_excerpt_len');
}
add_filter('excerpt_length', 'sp_excerpt_length');

//Styling Options
function sp_style_options(){
    ob_start();

    if( sp_option('sp_body_text_font','face') ){ 
		$fontfam = str_replace(' ','+',sp_option('sp_body_text_font','face'));
        wp_register_style( $fontfam, 'http://fonts.googleapis.com/css?family='. $fontfam .':100,100italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' );
        wp_enqueue_style( $fontfam );
    }

    if( sp_option('sp_heading_font','face') and ( sp_option('sp_body_text_font','face')!=sp_option('sp_heading_font','face') ) ){  
		$headerfam = str_replace(' ','+',sp_option('sp_heading_font','face'));
        wp_register_style( $headerfam, 'http://fonts.googleapis.com/css?family='. $headerfam .':100,100italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' );
        wp_enqueue_style( $headerfam );
    }

?>
    /* Body Style */
    body{
		<?php
			if( sp_option('sp_body_background') ){  
				echo  'background: ' . sp_option('sp_body_background') . ';';
			} 
		
			if( sp_option('sp_body_text_font','color') ){  
				echo  'color: ' . sp_option('sp_body_text_font','color') . ';';
			} 
				
			if( sp_option('sp_body_text_font','face')) {
				echo  'font-family: \'' . sp_option('sp_body_text_font','face') . '\';';
			}
			
			if( sp_option('sp_body_text_font','size') ){  
				echo  'font-size: ' . sp_option('sp_body_text_font','size') . ';';
			} 
		?>
	}
	
	 /* Heading Style */
	h1, h2, h3, h4, h5, h6{ 
		<?php
		if( sp_option('sp_heading_font','face') ){  
			echo  'font-family: \'' . sp_option('sp_heading_font','face') . '\';';
		}
		if( sp_option('sp_heading_font', 'weight') ){  
			echo  'font-weight: ' . sp_option('sp_heading_font', 'weight') . ';';
		}
		?>
	}
	/* Custom CSS */
	<?php echo sp_option('sp_custom_css');?>
	
	<?php 
	return ob_get_clean();
}


//Social Sharing
function sp_social_share(){
    global $sp_socials;
    foreach ($sp_socials as $key => $value) {
        # code...
        if(sp_option($value['name']) !=""){    
            echo '<a href="' . str_replace('*', sp_option($value['name']), $value['link']) . '" target="_blank" title="' . $key . '" class="' . $key . '"><span class="icon-'. $key . '"></span></a>';
        }
    }
}

global $sp_socials;
$sp_socials = array(
    'facebook' => array(
        'name' => 'sp_facebook_username',
        'link' => 'http://www.facebook.com/*',
    ),
    'google-plus' => array(
        'name' => 'sp_googleplus_username',
        'link' => 'https://plus.google.com/u/0/*'
     ),
    'twitter' => array(
        'name' => 'sp_twitter_username',
        'link' => 'http://twitter.com/*',
     ),
    'youtube-play' => array(
        'name' => 'sp_youtube_username',
        'link' => 'http://www.youtube.com/user/*',
     )
);

//Show Admin Bar
if(!function_exists('sp_adminbar')){
    function sp_adminbar(){
        if(sp_option('sp_admin_bar')==1){
            if(current_user_can( 'manage_options' ))
                return true;
            else 
                return false;
        }
        add_filter('show_admin_bar','sp_adminbar');
    }
}

if(!function_exists('sp_admin_logo')){
    function sp_admin_logo(){
        if(sp_option('sp_logo_login')){
            ?>
            <style type="text/css">
            body.login div#login h1 a {
                background-image: url(<?php echo sp_option('sp_logo_login');?>);
				background-size: contain;
				width: 200px;
				margin-bottom: 0;
            }
            </style>

         <?php } else { ?>

            <style type="text/css">
            body.login div#login h1 a {
                background-image: url(<?php echo admin_url('/images/wordpress-logo.png');?>);
				background-size: contain;
				width: 200px;
				margin-bottom: 0;
            }
            </style>

        <?php }
        }
        add_action( 'login_enqueue_scripts', 'sp_admin_logo' );
    }


    if(!function_exists('sp_logo_login_url')){
        function sp_logo_login_url(){
            return site_url();
        }
        add_filter( 'login_headerurl', 'sp_logo_login_url' );
    }
    
//
    function sp_exclude_search_pages($query) {
        if(sp_option('sp_exclude_search_page')==1 && !is_admin()){
          if ( $query->is_search ) {
            $query->set('post_type', 'post');

        }
        return $query;
    }
}
add_filter('pre_get_posts','sp_exclude_search_pages');


function get_video_ID($link){
    if( empty($link) ) return false;
    $path  =  trim(parse_url($link, PHP_URL_PATH), '/');
    $query_string = parse_url($link, PHP_URL_QUERY);
    parse_str($query_string, $output);
    if( empty($output) ){
        return $path;
    } else {
        return $output['v'];
    }
}
?>