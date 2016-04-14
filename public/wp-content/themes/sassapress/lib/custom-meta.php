<?php
// page subtitle
$prefix = 'page_';
$fields = array(

    array( 
        'label' => __('Subtitle', SPTEXTDOMAIN), 
        'id'    => $prefix.'subtitle',
        'type'  => 'text'
        ) 
    );

new Custom_Add_Meta_Box( 'sp_page_box', __('Subtitle Options', SPTEXTDOMAIN), $fields, array( 'sp_product', 'page' ), true );

?>