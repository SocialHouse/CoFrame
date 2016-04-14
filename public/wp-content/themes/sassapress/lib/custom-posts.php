<?php
// Post type: Sliders 
add_action('init', function(){

    $labels = array(
        'name'                  => __( 'Slider',                SPTEXTDOMAIN ),
        'singular_name'         => __( 'Slider',                SPTEXTDOMAIN ),
        'menu_name'             => __( 'Sliders',               SPTEXTDOMAIN ),
        'all_items'             => __( 'All Sliders',           SPTEXTDOMAIN ),
        'add_new'               => __( 'Add New',               SPTEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Slider',        SPTEXTDOMAIN ),
        'edit_item'             => __( 'Edit Slider',           SPTEXTDOMAIN ),
        'new_item'              => __( 'New Slider',            SPTEXTDOMAIN ),
        'view_item'             => __( 'View Slider',           SPTEXTDOMAIN ),
        'search_items'          => __( 'Search Sliders',        SPTEXTDOMAIN ),
        'not_found'             => __( 'No item found',         SPTEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No item found in Trash',SPTEXTDOMAIN )
        );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'menu_icon'             => 'dashicons-images-alt',
        'rewrite'               => false,
        'capability_type'       => 'post',
        'supports'              => array('title', 'page-attributes', 'editor', 'thumbnail') 
        );
    register_post_type('sp_slider', $args);
});

// slider metaboxes
$prefix = 'slider_';
$fields = array(
    array( 
        'label'                     => __('Background Image',          SPTEXTDOMAIN),
        'desc'                      => __('Show background image in slider', SPTEXTDOMAIN), 
        'id'                        => $prefix . 'background_image',
        'type'                      => 'image'
        ),

    array( 
        'label'                     => __('Button Text',          SPTEXTDOMAIN),
        'desc'                      => __('Show Slider Button and Button Text', SPTEXTDOMAIN), 
        'id'                        => $prefix . 'button_text',
        'type'                      => 'text'
        ),   

    array( 
        'label'                     => __('Button URL',       SPTEXTDOMAIN),
        'desc'                      => __('Slider URL link.', SPTEXTDOMAIN), 
        'id'                        => $prefix . 'button_url',
        'type'                      => 'text'
        ),

    array( 
        'label'                     => __('Boxed Style',       SPTEXTDOMAIN),
        'desc'                      => __('Show boxed Style.', SPTEXTDOMAIN), 
        'id'                        => $prefix . 'boxed',
        'type'                      => 'select',
        'options'                   => array(

            array(
                'value'=>'no',
                'label'=>__('No', SPTEXTDOMAIN)
                ),

            array(
                'value'=>'yes',
                'label'=>__('Yes', SPTEXTDOMAIN)
                )
            )
        )
    );

$fields_video = array(

    array( 
        'label'                     => __('Video Type',       SPTEXTDOMAIN),
        'desc'                      => __('Select video type.', SPTEXTDOMAIN), 
        'id'                        => $prefix . 'video_type',
        'type'                      => 'radio',
        'options'                   => array(

            array(
                'value'=>'',
                'label'=>__('None', SPTEXTDOMAIN)
                ),

            array(
                'value'=>'youtube',
                'label'=>__('Youtube', SPTEXTDOMAIN)
                ),   

            array(
                'value'=>'vimeo',
                'label'=>__('Vimeo', SPTEXTDOMAIN)
                )
            )
        ),

    array( 
        'label'                     => __('Video Link',          SPTEXTDOMAIN),
        'desc'                      => __('Video link', SPTEXTDOMAIN), 
        'id'                        => $prefix . 'video_link',
        'type'                      => 'text'
        ), 
    );

new Custom_Add_Meta_Box( 'sp_slider_box', __('Slider Settings', SPTEXTDOMAIN), $fields, 'sp_slider', true );
new Custom_Add_Meta_Box( 'sp_slider_box_video', __('Video Settings', SPTEXTDOMAIN), $fields_video, 'sp_slider', true );


/** 
* Post type: Solution
*/
add_action('init', function(){
    $labels = array(
        'name'                      => __( 'Solution',                         SPTEXTDOMAIN ),
        'singular_name'             => __( 'Solution',                         SPTEXTDOMAIN ),
        'menu_name'                 => __( 'Solutions',                        SPTEXTDOMAIN ),
        'all_items'                 => __( 'All Solutions',                    SPTEXTDOMAIN ),
        'add_new'                   => __( 'Add New',                           SPTEXTDOMAIN ),
        'add_new_item'              => __( 'Add New Solution',                 SPTEXTDOMAIN ),
        'edit_item'                 => __( 'Edit Solution',                    SPTEXTDOMAIN ),
        'new_item'                  => __( 'New Solution',                     SPTEXTDOMAIN ),
        'view_item'                 => __( 'View Solution',                    SPTEXTDOMAIN ),
        'search_items'              => __( 'Search Solutions',                 SPTEXTDOMAIN ),
        'not_found'                 => __( 'No Solution found',           SPTEXTDOMAIN ),
        'not_found_in_trash'        => __( 'No Solution found in Trash',  SPTEXTDOMAIN )
        );

$args = array(
    'labels'                        => $labels,
    'public'                        => true,
    'has_archive'                   => false,
	'hierarchical'					=> true,
    'exclude_from_search'           => false,
    'menu_icon'                     => 'dashicons-hammer',
    'rewrite'                       => array( 'slug' => 'solution'),
    'capability_type'               => 'post',
    'supports'                      => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions')
    );

register_post_type('sp_solution', $args);
});


/** 
* Post type: Product
*/
add_action('init', function(){
    $labels = array(
        'name'                      => __( 'Product',                         SPTEXTDOMAIN ),
        'singular_name'             => __( 'Product',                         SPTEXTDOMAIN ),
        'menu_name'                 => __( 'Products',                        SPTEXTDOMAIN ),
        'all_items'                 => __( 'All Products',                    SPTEXTDOMAIN ),
        'add_new'                   => __( 'Add New',                           SPTEXTDOMAIN ),
        'add_new_item'              => __( 'Add New Product',                 SPTEXTDOMAIN ),
        'edit_item'                 => __( 'Edit Product',                    SPTEXTDOMAIN ),
        'new_item'                  => __( 'New Product',                     SPTEXTDOMAIN ),
        'view_item'                 => __( 'View Product',                    SPTEXTDOMAIN ),
        'search_items'              => __( 'Search Products',                 SPTEXTDOMAIN ),
        'not_found'                 => __( 'No Product found',           SPTEXTDOMAIN ),
        'not_found_in_trash'        => __( 'No Product found in Trash',  SPTEXTDOMAIN )
        );

$args = array(
    'labels'                        => $labels,
    'public'                        => true,
    'has_archive'                   => false,
	'hierarchical'					=> true,
    'exclude_from_search'           => false,
    'menu_icon'                     => 'dashicons-cart',
    'rewrite'                       => array( 'slug' => 'product'),
    'capability_type'               => 'post',
    'supports'                      => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions')
    );

register_post_type('sp_product', $args);
});
// Product metaboxes
$prefix = 'product_';
$fields = array(

    array( 
        'label' => __('Site URL',                    SPTEXTDOMAIN), 
        'id'    => $prefix.'site_url',
        'type'  => 'text'
        )
    );
new Custom_Add_Meta_Box( 'sp_product_box', __('Additional Product Details', SPTEXTDOMAIN), $fields, 'sp_product', true );


// Post type:  Team
add_action('init', function(){

    $labels = array(
        'name'                  => __( 'Team',                      SPTEXTDOMAIN ),
        'singular_name'         => __( 'Team',                      SPTEXTDOMAIN ),
        'menu_name'             => __( 'Team',                      SPTEXTDOMAIN ),
        'all_items'             => __( 'Team Members',              SPTEXTDOMAIN ),
        'add_new'               => __( 'Add New',                   SPTEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Member',            SPTEXTDOMAIN ),
        'edit_item'             => __( 'Edit Member',               SPTEXTDOMAIN ),
        'new_item'              => __( 'New Member',                SPTEXTDOMAIN ),
        'view_item'             => __( 'View Member',               SPTEXTDOMAIN ),
        'search_items'          => __( 'Search Member',             SPTEXTDOMAIN ),
        'not_found'             => __( 'No Member found',           SPTEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No Member found in Trash',  SPTEXTDOMAIN )
        );

$args = array(
    'labels'                => $labels,
    'public'                => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'menu_icon'             => 'dashicons-groups',
    'rewrite'               => array( 'slug' => 'team'),
    'capability_type'       => 'post',
    'supports'              => array('title', 'editor', 'page-attributes', 'thumbnail', 'revisions')
    );
register_post_type('sp_team', $args);
});


// team metaboxes
$prefix = 'team_';

$fields = array(

    array( 
        'label' => __('Job Title',                    SPTEXTDOMAIN), 
        'id'    => $prefix.'job_title',
        'type'  => 'text'
        ),

    array( 
        'label' => __('Email', SPTEXTDOMAIN), 
        'desc'  => __('Email address of team member', SPTEXTDOMAIN), 
        'id'    => $prefix.'email', 
        'type'  => 'text'
        )
    );
new Custom_Add_Meta_Box( 'sp_team_box', __('Additional Team Member Details', SPTEXTDOMAIN), $fields, 'sp_team', true );
// Team Taxonomy
$pr_labels = array(
    'name'              => __( 'Team Categories', 'wpbootstrap' ),
   'singular_name'     => __( 'Category', 'wpbootstrap' ),
    'menu_name'         => __( 'Team Categories' )
);
register_taxonomy('cat_team',
    array('sp_team'), 
    array(
        'labels'                    => $pr_labels, 
        'show_admin_column'         => true,
        'hierarchical'              => true,
        'query_var'                 => true,
        'show_ui'                   => true,
        'public'                    => true
    )
);


/* Testimonial */
add_action('init', function(){

    $labels = array(
        'name'                  => __( 'Testimonials',              SPTEXTDOMAIN ),
        'singular_name'         => __( 'Testimonial',               SPTEXTDOMAIN ),
        'menu_name'             => __( 'Testimonials',              SPTEXTDOMAIN ),
        'all_items'             => __( 'All Items',                 SPTEXTDOMAIN ),
        'add_new'               => __( 'Add New',                   SPTEXTDOMAIN ),
        'add_new_item'          => __( 'Add New Item',              SPTEXTDOMAIN ),
        'edit_item'             => __( 'Edit Item',                 SPTEXTDOMAIN ),
        'new_item'              => __( 'New Item',                  SPTEXTDOMAIN ),
        'view_item'             => __( 'View Item',                 SPTEXTDOMAIN ),
        'search_items'          => __( 'Search Items',              SPTEXTDOMAIN ),
        'not_found'             => __( 'No item found',             SPTEXTDOMAIN ),
        'not_found_in_trash'    => __( 'No item found in Trash',    SPTEXTDOMAIN )
        );

$args = array(
    'labels'                => $labels,
    'public'                => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'menu_icon'             => 'dashicons-format-chat',
    'capability_type'       => 'post',
    'rewrite'               => false,
    'supports'              => array('title', 'editor')
    );

register_post_type('sp_testimonial', $args);
});

$prefix = 'testimonial_';
$fields = array(
    array( 
        'label' => __('Designation Primary', SPTEXTDOMAIN), 
        'id'    => $prefix.'designation',
        'type'  => 'text'
        ),
    array( 
        'label' => __('Designation Secondary', SPTEXTDOMAIN), 
        'id'    => $prefix.'designation_second',
        'type'  => 'text'
        )
    );

new Custom_Add_Meta_Box( 'sp_testimonial_meta', __('Testimonial Details', SPTEXTDOMAIN), $fields, 'sp_testimonial', true );


/* Post type: Press*/
add_action('init', function(){
    $labels = array(
        'name'                      => __( 'Press',                         SPTEXTDOMAIN ),
        'singular_name'             => __( 'Press',                         SPTEXTDOMAIN ),
        'menu_name'                 => __( 'Press',                        SPTEXTDOMAIN ),
        'all_items'                 => __( 'All Press',                    SPTEXTDOMAIN ),
        'add_new'                   => __( 'Add New',                           SPTEXTDOMAIN ),
        'add_new_item'              => __( 'Add New Press Item',                 SPTEXTDOMAIN ),
        'edit_item'                 => __( 'Edit Press Item',                    SPTEXTDOMAIN ),
        'new_item'                  => __( 'New Press Item',                     SPTEXTDOMAIN ),
        'view_item'                 => __( 'View Press Item',                    SPTEXTDOMAIN ),
        'search_items'              => __( 'Search Press',                 SPTEXTDOMAIN ),
        'not_found'                 => __( 'No Press found',           SPTEXTDOMAIN ),
        'not_found_in_trash'        => __( 'No Press found in Trash',  SPTEXTDOMAIN )
        );

$args = array(
    'labels'                        => $labels,
    'public'                        => true,
    'has_archive'                   => true,
	'hierarchical'					=> true,
    'exclude_from_search'           => false,
    'menu_icon'                     => 'dashicons-media-document',
    'rewrite'                       => array( 'slug' => 'press'),
    'capability_type'               => 'post',
    'supports'                      => array('title', 'editor', 'page-attributes', 'thumbnail', 'revisions')
    );

register_post_type('sp_press', $args);
});
// Press metaboxes
$prefix = 'sp_press_';
$fields = array(
    array( 
        'label' => __('External URL',                       ZEETEXTDOMAIN), 
        'desc'  => __('Website for press coverage',   ZEETEXTDOMAIN), 
        'id'    => $prefix.'external_url', 
        'type'  => 'text'
        ),
    array( 
        'label' => __('Publication',                       ZEETEXTDOMAIN), 
        'id'    => $prefix.'publication', 
        'type'  => 'text'
        )		
    );
new Custom_Add_Meta_Box( 'sp_press_box', __('Additional News Details', ZEETEXTDOMAIN), $fields, 'sp_press', true );

// Press Taxonomy
$labels = array(
    'name'              => __( 'Press Categories', 'wpbootstrap' ),
   'singular_name'     => __( 'Category', 'wpbootstrap' ),
    'menu_name'         => __( 'Press Categories' )
);
register_taxonomy('cat_press',
    array('sp_press'), 
    array(
        'labels'                    => $labels, 
        'show_admin_column'         => true,
        'hierarchical'              => true,
        'query_var'                 => true,
        'show_ui'                   => true,
        'public'                    => true
    )
);
?>