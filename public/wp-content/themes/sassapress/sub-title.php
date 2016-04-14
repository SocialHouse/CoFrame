<?php

// Breadcrumbs
require_once(get_template_directory(). '/lib/breadcrumbs.php');

global $post;


if( is_single() ) {

    $title = sp_option('sp_blog_title');

    $sub_title = sp_option('sp_blog_subtitle');

} elseif ( is_category() ) {

    $title = __("Category", SPTEXTDOMAIN) . " : " . single_cat_title("", false);

    $sub_title = sp_option('sp_blog_subtitle');

} elseif ( is_archive() ) {
    if (is_day()) {
        $title = __("Daily Archives", SPTEXTDOMAIN) . " : " . get_the_date();

    } elseif (is_month()) {
        $title = __("Monthly Archives", SPTEXTDOMAIN) . " : " . get_the_date("F Y");

    } elseif (is_year()) {
        $title = __("Yearly Archives", SPTEXTDOMAIN) . " : " . get_the_date("Y");

    } else {
        $title = __("Blog Archives", SPTEXTDOMAIN);

    }

    $sub_title = sp_option('sp_blog_subtitle');

} elseif ( is_tag() ) {
    $title = $return .= __("Tag", SPTEXTDOMAIN) . " : " . single_tag_title("", false);
} elseif ( is_author() ) {
    $title = __("Author: ", SPTEXTDOMAIN);
} elseif ( is_search() ) {
    $title = __("Search results for", SPTEXTDOMAIN) . " : " . get_search_query();
} elseif ( is_tax( 'portfolios' ) ) {
    $title = __("Portfolio", SPTEXTDOMAIN);
} elseif ( is_home() and !is_front_page() ) {

    $page = get_queried_object();

    if( is_null( $page ) ){
        $title = sp_option('sp_blog_title');
        $sub_title = sp_option('sp_blog_subtitle');
    } else {

     $ID = $page->ID;
     $title = $page->post_title;
     $sub_title = get_post_meta($ID, 'page_subtitle', true);
	 $show_title = get_post_meta($ID, 'show_title', true );
 }


} elseif ( (is_page()) && (!is_front_page()) ) {
    $page = get_queried_object();

    $ID = $page->ID;

    $title = $page->post_title;
    $sub_title = get_post_meta($ID, 'page_subtitle', true);
	$show_title = get_post_meta($ID, 'show_title', true );
} elseif( is_front_page() ){

    unset($title);
}

echo (isset($title) && $show_title == true ? '

    <section id="title">
    <div class="container">
    <div class="row">
    <div class="col-sm-6">
    <h1>'.$title.'</h1>
    <p>'.$sub_title.'</p>
    </div>
    </div>
    </div>
    </section>

    ' : '');
?>