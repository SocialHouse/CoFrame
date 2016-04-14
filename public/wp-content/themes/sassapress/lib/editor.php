<?php
// add shortcode tinymce button
add_filter('mce_buttons', function ($mce_buttons) {

    $pos = array_search('wp_more', $mce_buttons, true);

    if ($pos !== false) {
        $buttons = array_slice($mce_buttons, 0, $pos + 1);
        $buttons[] = 'wp_page';    
        $mce_buttons = array_merge($buttons, array_slice($mce_buttons, $pos + 1));
    }
    return $mce_buttons;
});

//add more buttons to visual editor
function enable_more_buttons($buttons) {        
	$buttons[] = 'styleselect';
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';
    return $buttons;
}
add_filter("mce_buttons", "enable_more_buttons");

//Add styles/classes to the "Styles" drop-down
add_filter( 'tiny_mce_before_init', 'at_mce_before_init' );

function at_mce_before_init( $settings ) {
    $style_formats = array(
		array(
            'title' => 'Primary Title Style',
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
			'classes' => 'primary-title'
		),
		array(
            'title' => 'Dark Gray Title Style',
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
			'classes' => 'gray-dark-title'
		),
		array(
            'title' => 'Border Title Style',
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
			'classes' => 'border-title'
		),
		array(
            'title' => 'Primary Button Style',
            'selector' => 'a',
			'classes' => 'btn btn-primary'
		),
		array(
            'title' => 'Secondary Button Style',
            'selector' => 'a',
			'classes' => 'btn btn-secondary'
		),
		array(
            'title' => 'Large Button Style',
            'selector' => 'a',
			'classes' => 'btn-lg'
		),
		array(
            'title' => 'Arrow Link Style',
            'selector' => 'a',
			'classes' => 'arrow-link'
		),
		array(
            'title' => 'Secondary Link Style',
            'selector' => 'a',
			'classes' => 'secondary'
		),
 		array(
            'title' => 'Highlight',
            'inline' => 'span',
			'classes' => 'highlight'
		),
 		array(
            'title' => 'Blue Highlight',
            'inline' => 'span',
			'classes' => 'blue-highlight'
		),
 		array(
            'title' => 'Intro Paragraph',
            'block' => 'p',
			'classes' => 'intro'
		),
        array(
            'title' => 'Narrow Paragraph',
            'block' => 'p',
            'classes' => 'center-block col-sm-8'
        ),        
        array(
            'title' => 'Blockquote Citation',
            'block' => 'footer'
        ),
        array(
            'title' => 'Small',
            'inline' => 'small'
        ),
 		array(
            'title' => 'Disclaimer',
            'block' => 'p',
			'classes' => 'disclaimer'
		)
   );
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}
?>