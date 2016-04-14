<?php
#-----------------------------------------------------------------
# Columns
#-----------------------------------------------------------------

$sp_shortcodes = array();

//Basic
$sp_shortcodes['header_1'] = array( 
    'type'=>'heading', 
    'title'=>__('Basic', SPTEXTDOMAIN)
    );


//container
$sp_shortcodes['sp_container'] = array( 
    'type'=>'simple', 
    'title'=>__('Container', SPTEXTDOMAIN),
    'attr'=>array(

        'class'=>array(
            'type'=>'select',
            'title'=>__('Select the color class', SPTEXTDOMAIN),
            'values'=>$color_classes,
            ),

        'id'=>array(
            'type'=>'text', 
            'title'=>__('Select the ID', SPTEXTDOMAIN)
            )
        )
    );



$sp_shortcodes['sp_divider'] = array( 
    'type'=>'radios', 
    'title'=>__('Divider', SPTEXTDOMAIN), 
    'attr'=>array(
        'size'=>array(
            'type'=>'select', 
            'title'=> __('Divider Size', SPTEXTDOMAIN), 
            'values'=>array(
                'divider-default'   =>'Default',
                'divider-lg'        =>'Large',
                'divider-md'        =>'Medium',
                'divider-sm'        =>'Small',
                'divider-xs'        =>'Extra Small'
                )
            )
        )
    );


//Dropcap
$sp_shortcodes['sp_dropcap'] = array( 
    'type'=>'simple', 
    'title'=>__('Dropcap', SPTEXTDOMAIN )
    );


//Columns
$sp_shortcodes['header_2'] = array( 
    'type'=>'heading', 
    'title'=>__('Columns', SPTEXTDOMAIN)
    );


//blocknumber
$sp_shortcodes['sp_blocknumber'] = array( 
    'type'=>'simple', 
    'title'=>__('Blocknumber', SPTEXTDOMAIN ),
    'attr'=>array(
        
        'number'=>array(
            'type'=>'text', 
            'title'=>__('Number. eg. 01,II,A',SPTEXTDOMAIN)
            ),
        
        'color'=>array(
            'type'=>'text', 
            'title'=>__('Number Color. eg. #fff',SPTEXTDOMAIN)
            ),
        'background'=>array(
            'type'=>'text', 
            'title'=>__('Background Color. eg. #000',SPTEXTDOMAIN)
            ),

        'borderradius'=>array(
            'type'=>'text', 
            'title'=>__('Type Border Radius. eg. 4px, 100%',SPTEXTDOMAIN)
            )
        )
    );


// columns
$sp_shortcodes['sp_columns'] = array( 
    'type'=>'dynamic', 
    'title'=>__('Columns', SPTEXTDOMAIN ), 
    'attr'=>array(
        'column'=>array('type'=>'custom')
        )
    );


//Elements
$sp_shortcodes['header_3'] = array( 
    'type'=>'heading', 
    'title'=>__('Elements', SPTEXTDOMAIN)
    );


//accordion
$sp_shortcodes['accordion'] = array( 
    'type'=>'simple', 
    'title'=>__('Accordion', SPTEXTDOMAIN ),
    'attr'=>array(
        
        'title'=>array(
            'type'=>'text', 
            'title'=>__('Title Text',SPTEXTDOMAIN)
            ),
        'id'=>array(
            'type'=>'text', 
            'title'=>__('Unique ID eg. accordion-1',SPTEXTDOMAIN)
            ),
        'state'=>array(
            'type'=>'select', 
            'title'=> __('Initial State', SPTEXTDOMAIN), 
            'values'=>array(
                'closed'        =>'Closed',
                'open'        =>'Open'
                )
            )
        )
    );


// alert
$sp_shortcodes['sp_alert'] = array( 
    'type'=>'simple', 
    'title'=>__('Alert', SPTEXTDOMAIN ),
    'attr'=>array(
        'close'=>array(
            'type'=>'select', 
            'title'=> __('Show Close Button', SPTEXTDOMAIN), 
            'values'=>  array( 'no'=>'No', 'yes'=>'Yes' )
            ),  
        'type'=>array(
            'type'=>'select', 
            'title'=> __('Alert Type', SPTEXTDOMAIN), 
            'values'=>  array( 'none'=>'None', 'success'=>'Success', 'info'=>'Info', 'warning'=>'Warning', 'danger'=>'Danger' )
            ),  
        'title'=>array(
            'type'=>'text', 
            'title'=> __('Alert Title', SPTEXTDOMAIN)
            )
        )
    );


//block
$sp_shortcodes['sp_block'] = array( 
    'type'=>'simple', 
    'title'=>__('Block', SPTEXTDOMAIN ),
    'attr'=>array(
        'background'=>array(
            'type'=>'text', 
            'title'=>__('Background Color. eg. #000',SPTEXTDOMAIN)
            ),
        
        'color'=>array(
            'type'=>'text', 
            'title'=>__('Text Color. eg. #fff',SPTEXTDOMAIN)
            ),

        'borderradius'=>array(
            'type'=>'text', 
            'title'=>__('Type Border Radius. eg. 4px, 100%',SPTEXTDOMAIN)
            ),

        'padding'=>array(
            'type'=>'text', 
            'title'=>__('Block Padding. eg. 15px',SPTEXTDOMAIN)
            )
        )
    );


//Button
$sp_shortcodes['sp_button'] = array( 
    'type'=>'radios', 
    'title'=>__('Button', SPTEXTDOMAIN), 
    'attr'=>array(

        'size'=>array(
            'type'=>'select', 
            'title'=> __('Button Size', SPTEXTDOMAIN), 
            'values'=>array(
                ''=>'Default',
                'xlg'=>'Extra Large',
                'lg'=>'Large',
                'sm'=>'Medium',
                'xs'    =>'Small',
                )
            ),

        'type'=>array(
            'type'=>'select', 
            'title'=> __('Button Type', SPTEXTDOMAIN), 
            'values'=>array(
                'default'=>'Default',
                'primary'=>'Primary',
                'success'=>'Success',
                'info'  =>'Info',
                'warning'=>'Warning',
                'danger'=>'Danger',
                'link'=>'Link',
                )
            ),

        'url'=>array(
            'type'=>'text', 
            'title'=>__('Link URL', SPTEXTDOMAIN)
            ),
			
        'text'=>array(
            'type'=>'text', 
            'title'=>__('Text', SPTEXTDOMAIN)
            ),

        'icon'=>array(
            'type'=>'icon', 
            'title'=>__('Select Icon', SPTEXTDOMAIN),
            'values'=> $fontawesome_icons
            )
        ) 
    );


//Icon
$sp_shortcodes['sp_icon'] = array( 
    'type'=>'regular', 
    'title'=>__('Icon', SPTEXTDOMAIN), 
    'attr'=>array(
		'size'=>array(
			'type'=>'select', 
			'title'=> __('Select size', SPTEXTDOMAIN),
			'values'=>array(
				'fa-lg'  =>__('Large Icon', SPTEXTDOMAIN),
                'fa-2x'     =>__('2x Large Icon', SPTEXTDOMAIN),
                'fa-3x'     =>__('3x Large Icon', SPTEXTDOMAIN),
                'fa'     =>__('4x Large Icon', SPTEXTDOMAIN)
			)
		),
        'icons' => array(
            'type'=>'icons', 
            'title'=>'Icon', 
            'values'=> $fontawesome_icons
            )
        ) 
    );


//modal
$sp_shortcodes['modal'] = array( 
    'type'=>'simple', 
    'title'=>__('Modal', SPTEXTDOMAIN ),
    'attr'=>array(
        
        'link_text'=>array(
            'type'=>'text', 
            'title'=>__('Link Text',SPTEXTDOMAIN)
            ),
        'id'=>array(
            'type'=>'text', 
            'title'=>__('Unique ID eg. modal-1',SPTEXTDOMAIN)
            ),
        'link_style'=>array(
            'type'=>'text', 
            'title'=>__('Link Class eg. btn btn-primary',SPTEXTDOMAIN)
            )
        )
    );


// progressbar
$sp_shortcodes['sp_progressbar'] = array( 
    'type'=>'dynamic', 
    'title'=>__('Progress Bars', SPTEXTDOMAIN ), 
    'attr'=>array(
        'progressbar'=>array('type'=>'custom')
        )
    );
?>