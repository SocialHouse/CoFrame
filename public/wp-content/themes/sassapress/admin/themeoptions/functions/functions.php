<?php
add_action('init','of_options');

if (!function_exists('of_options'))
{
    function of_options()
    {
        global $of_options, $sp_googlefonts;

        $of_options     = array();

    // General Settings

        $of_options[]   = array(  
            "name"      => __('General Settings',SPTEXTDOMAIN),
            "type"      => "heading"
            );

        $of_options[]   = array(  
            "name"      => __("Favicon",SPTEXTDOMAIN),
            "desc"      => __("Upload favicon image", SPTEXTDOMAIN),
            "id"        => "sp_favicon",
            "folds"     => "favicon",
            "type"      => "upload",
            "mod"       => "min"
            );

        $of_options[]   = array(  
            "name"      => __("Logo option heading",SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_logo_opt_info",
            "std"       => "<h3 style=\"margin: 3px;\">Logo options</h3>",
            "icon"      => true,
            "type"      => "info"
            );

        $of_options[]   = array(  
            "name"      => __("Show Logo",SPTEXTDOMAIN),
            "desc"      => __("Show or hide site logo",SPTEXTDOMAIN),
            "id"        => "sp_show_logo",
            "std"       => 0,
            "folds"     => 1,
            "type"      => "switch"
            );

        $of_options[]   = array(  
            "name"      => __("Upload Standard Logo",SPTEXTDOMAIN),
            "desc"      => __("Upload logo and select from media manager.",SPTEXTDOMAIN),
            "id"        => "site_logo",
            "std"       => "",
            "type"      => "upload",
            "fold"      => "sp_show_logo", /* the switch hook */
            "mod"       => "min"                        
            );

        $of_options[]   = array(  
            "name"      => __("Logo Margin from Top",SPTEXTDOMAIN),
            "desc"      => __("Note: You need to insert only numeric value",SPTEXTDOMAIN),
            "id"        => "sp_logo_margin_top",
            "std"       => 0,
            "fold"      => "sp_show_logo",
            "type"      => "text"
            );

        $of_options[]   = array(  
            "name"      => __("Logo Margin from Bottom",SPTEXTDOMAIN),
            "desc"      => __("Note: You need to insert only numeric value",SPTEXTDOMAIN),
            "id"        => "sp_logo_margin_bottom",
            "std"       => 0,
            "fold"      => "sp_show_logo",
            "type"      => "text"
            );

        $of_options[]   = array(  
            "name"      => __("Apple Icon options",SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_apple_logo",
            "std"       => "<h3 style=\"margin: 3px;\">Apple Icon options</h3>",
            "icon"      => true,
            "type"      => "info",
            );

        $of_options[]   = array(  
            "name"      => __("Apple Icon",SPTEXTDOMAIN),
            "desc"      => __("Show or hide Apple Icon",SPTEXTDOMAIN),
            "id"        => "sp_show_apple_logo",
            "std"       => 0,
            "folds"     => 1,
            "type"      => "switch"
            );

        $of_options[]   = array(  
            "name"      => __("iPhone icon",SPTEXTDOMAIN),
            "desc"      => __("Upload iPhone icon",SPTEXTDOMAIN),
            "id"        => "sp_apple_iphone_icon",
            "type"      => "upload",
            "mod"       => "min",
            "fold"      => "sp_show_apple_logo"
            );

        $of_options[]   = array(  
            "name"      => __("iPhone retina icon", SPTEXTDOMAIN),
            "desc"      => __("Upload 114x114 px iPhone retina icon",SPTEXTDOMAIN),
            "id"        => "sp_apple_iphone_retina_icon",
            "type"      => "upload",
            "mod"       => "min",
            "fold"      => "sp_show_apple_logo"
            );

        $of_options[]   = array(  
            "name"      => __("iPad icon",SPTEXTDOMAIN),
            "desc"      => __("Upload 72x72 px iPad icon",SPTEXTDOMAIN),
            "id"        => "sp_apple_ipad_icon",
            "type"      => "upload",
            "mod"       => "min",
            "fold"      => "sp_show_apple_logo"
            );

        $of_options[]   = array(  
            "name"      => __("iPad retina icon",SPTEXTDOMAIN),
            "desc"      => __("Upload 144x144 px iPad retina icon",SPTEXTDOMAIN),
            "id"        => "sp_apple_ipad_retina_icon",
            "type"      => "upload",
            "mod"       => "min",
            "fold"      => "sp_show_apple_logo"
            );

        $of_options[]   = array(  
            "name"      => __("Theme Layout",SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_theme_layout_settings",
            "std"       => "<h3 style=\"margin: 3px;\">Theme Layout</h3>",
            "icon"      => true,
            "type"      => "info"
            );

        $of_options[]   = array(  
            "name"      => __("Theme Layout Style",SPTEXTDOMAIN),
            "desc"      => __("Choose the Theme layout style.",SPTEXTDOMAIN),
            "id"        => "sp_theme_layout",
            "std"       => 1,
            "folds"     => 1,
            "type"      => "select",
            "options"   => array("fullwidth" => "Full Width","boxed" => "Boxed Layout")
            );

    // Header Options

        $of_options[]   = array(  
            "name"      => __("Header and Footer", SPTEXTDOMAIN),
            "type"      => "heading",
            "icon"      => sp_IMAGES . "header-and-footer.png"
            );

        $of_options[]   = array(  
            "name"      => __("Header", SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_header",
            "std"       => "<h3 style=\"margin: 3px;\">Header</h3>",
            "icon"      => true,
            "type"      => "info"
            );

        $of_options[]   = array(  
            "name"      => __("Header Theme", SPTEXTDOMAIN),
            "desc"      => __("Header theme style (default: Dark Inverse).",SPTEXTDOMAIN),
            "id"        => "sp_header_theme",
            "std"       => 1,
            "type"      => "select",
            "options"   => array("dark-inverse" => "Dark Inverse","dark-primary" => "Dark Primary Color","light" => "Light")
            );

        $of_options[]   = array(  
            "name"      => __("Footer section", SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_footer_section_info",
            "std"       => "<h3 style=\"margin: 3px;\">Footer section</h3>",
            "icon"      => true,
            "type"      => "info"
            );

        $of_options[]   = array(  
            "name"      => __("Show Copyright", SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_footer_text_info",
            "std"       => 1,
            "folds"     => 1,
            "type"      => "switch"
            );

        $of_options[]   = array(  
            "name"      => __("Copyright Text", SPTEXTDOMAIN),
            "desc"      => __("Insert Copyright Text.",SPTEXTDOMAIN),
            "id"        => "sp_copyright_text",
            "fold"      => "sp_footer_text_info",
            "std"       => '&copy; 2013 <a target="_blank" href="http://shapebootstrap.net/" title="Free Twitter Bootstrap based WordPress Themes and HTML templates">ShapeBootstrap</a>. All Rights Reserved.',
            "type"      => "textarea"
            );  


        $of_options[]   = array(  
            "name"      => __("Google Analytics Code", SPTEXTDOMAIN),
            "desc"      => __("Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",SPTEXTDOMAIN),
            "id"        => "sp_google_analytics",
            "std"       => "",
            "type"      => "textarea"
            );


// Blog Options

        $of_options[]   = array(  
            "name"      => __("Blog",SPTEXTDOMAIN),
            "type"      => "heading",
            "icon"      => sp_IMAGES . "pencil.png"
            );

        $of_options[]   = array(  
            "name"      => __("Blog Title",SPTEXTDOMAIN),
            "desc"      => __("Blog Title",SPTEXTDOMAIN),
            "id"        => "sp_blog_title",
            "std"       => "Blog",
            "folds"     => 1,
            "type"      => "text"               
            );
        $of_options[]   = array(  
            "name"      => __("Blog Sub Title",SPTEXTDOMAIN),
            "desc"      => __("Blog Sub Title",SPTEXTDOMAIN),
            "id"        => "sp_blog_subtitle",
            "std"       => "Blog Sub Title",
            "folds"     => 1,
            "type"      => "text"               
            );


        $of_options[]   = array(  
            "name"      => __("Author BIO on Single Post?",SPTEXTDOMAIN),
            "desc"      => __("Whether to show or hide the Author BIO from single post",SPTEXTDOMAIN),
            "id"        => "sp_single_post_author",
            "std"       => "",
            "type"      => "switch"                 
            );

        $of_options[]   = array(  
            "name"      => __("Show Comments On Page",SPTEXTDOMAIN),
            "desc"      => __("On / Off comments from all pages",SPTEXTDOMAIN),
            "id"        => "sp_blog_comments",
            "std"       => 1,
            "folds"     => 1,
            "type"      => "switch"                 
            );


        $of_options[]   = array(  
            "name"      => __("Excerpt Length",SPTEXTDOMAIN),
            "id"        => "sp_excerpt_len",
            "std"       => "",
            "type"      => "text"   
            );


// Styling Options

        $of_options[]   = array(  
            "name"      => __("Styling Options",SPTEXTDOMAIN),
            "type"      => "heading"
            );

        $of_options[]   = array(  
            "name"      => __("Body Section",SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_body_section",
            "std"       => "<h3 style=\"margin: 3px;\">Body Section</h3>",
            "icon"      => true,
            "type"      => "info"
            );
        $of_options[]   = array(  
            "name"      => __("Body Background Color",SPTEXTDOMAIN),
            "desc"      => __("Pick a background color for the theme (default: #f5f5f5).",SPTEXTDOMAIN),
            "id"        => "sp_body_background",
            "std"       => "#f5f5f5",
            "type"      => "color"
            );

        $of_options[]   = array(  
            "name"      => __("Body Font Style",SPTEXTDOMAIN),
            "desc"      => __("Default color #34495e, font: Roboto, font-size:14px",SPTEXTDOMAIN),
            "id"        => "sp_body_text_font",
            "std"       => array('size' => '14px', 'color' =>"#34495e", 'google_fonts'=>array( 'fonts'=>$sp_googlefonts, 'preview_size'=>'16px', 'face' => 'Roboto' ) ), 
            "type"      => "typography"
            );
        
        $of_options[]   = array(  
            "name"      => __("Heading Font",SPTEXTDOMAIN),
            "desc"      => __("Default font: Roboto, weight: Bold",SPTEXTDOMAIN),
            "id"        => "sp_heading_font",
            "std"       => array('weight' => '800', 'google_fonts'=>array( 'fonts'=>$sp_googlefonts, 'face' => 'Roboto' ) ), 
            "type"      => "typography"
            );

// Contact Options
        $of_options[]   = array(    
            "name"      => __("Contact",SPTEXTDOMAIN),
            "type"      => "heading",                       
            "icon"      => sp_IMAGES . "folder_contact.png"
            );
        $of_options[]   = array(    
            "name"      => __("Contact Details",SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_contact_details",
            "std"       => "<h3 style=\"margin: 3px;\">Social Links</h3>",
            "icon"      => true,
            "type"      => "info"
            );
        $of_options[]   = array(    
            "name"      => __("Google Map Location",SPTEXTDOMAIN),
            "desc"      => __("(State,Country)",SPTEXTDOMAIN),
            "id"        => "sp_contact_map_location",
            "std"       => "",
            "type"      => "text"
            );
        $of_options[]   = array(    
            "name"      => __("Google Map Height",SPTEXTDOMAIN),
            "desc"      => __("(In pixels or percentage, e.g.:100px or 100%",SPTEXTDOMAIN),
                "id"        => "sp_contact_map_height",
                "std"       => "400px",
                "type"      => "text"
                );


        $of_options[]   = array(    
            "name"      => __("Contact Email Address",SPTEXTDOMAIN),
            "desc"      => "Example: admin@example.com",
            "id"        => "sp_contact_email",
            "std"       => "",
            "type"      => "text"
            );



//Advanced Settings

        $of_options[]   = array(  
            "name"      => __("Advanced Settings",SPTEXTDOMAIN),
            "type"      => "heading",
            "icon"      => sp_IMAGES . "icon-settings.png"
            );

        $of_options[]   = array(  
            "name"      => __("Exclude Pages from Search",SPTEXTDOMAIN),
            "desc"      => __("This will enable or disable Breadcrumbs.",SPTEXTDOMAIN),
            "id"        => "sp_exclude_search_page",
            "std"       => 1,
            "type"      => "switch"                 
            );

        $of_options[]   = array(  
            "name"      => __("Breadcrumbs",SPTEXTDOMAIN),
            "desc"      => __("This will enable or disable Breadcrumbs.",SPTEXTDOMAIN),
            "id"        => "sp_breadcumbs",
            "std"       => "",
            "type"      => "switch"                 
            );

        $of_options[]   = array(  
            "name"      => __("Login Logo",SPTEXTDOMAIN),
            "desc"      => __("Change Login Logo.",SPTEXTDOMAIN),
            "id"        => "sp_logo_login",
            "type"      => "upload",
            "mod"       => "min"
            );

// Custom CSS
        $of_options[]   = array(  
            "name"      => __("Custom CSS",SPTEXTDOMAIN),
            "type"      => "heading", 
            "icon"      => sp_IMAGES . "custom-css.png"
            );
        $of_options[]   = array(  
            "name"      => __("Custom CSS",SPTEXTDOMAIN),
            "desc"      => "",
            "id"        => "sp_custom_css_info",
            "std"       => "<h3 style=\"margin: 3px;\">Enter the Custom CSS of your custom Modify.</h3>",
            "icon"      => true,
            "type"      => "info"
            );

        $of_options[]   = array(  
            "name"      => __("Custom CSS",SPTEXTDOMAIN),
            "id"        => "sp_custom_css",
            "std"       => "",
            "type"      => "textarea"
            );

// Backup Options
        $of_options[]   = array(  
            "name"      => __("Backup Options",SPTEXTDOMAIN),
            "type"      => "heading",
            "icon"      => ADMIN_IMAGES . "icon-slider.png"
            );

        $of_options[]   = array(  
            "name"      => __("Backup and Restore Options",SPTEXTDOMAIN),
            "id"        => "sp_of_backup",
            "std"       => "",
            "type"      => "backup",
            "desc"      => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',SPTEXTDOMAIN),
            );

        $of_options[]   = array(  
            "name"      => __("Transfer Theme Options Data",SPTEXTDOMAIN),
            "id"        => "sp_of_transfer",
            "std"       => "",
            "type"      => "transfer",
            "desc"      => __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',SPTEXTDOMAIN),
            );

    } //End function: of_options()
} //End chack if function exists: of_options()