<?php
//Button
add_shortcode( 'sp_button', function( $atts, $content= null ){
  $atts = shortcode_atts(
    array(
      'text'  => 'Button',
      'type'  => 'default',
      'size'  => '',
      'url'   => '#',
      'class' => '',
      'icon'  => '',
      'target'=>'_self'
      ), $atts);
  extract($atts);

  $classes  = 'btn';
  $output   = $text;
  if($type) $classes .= ' btn-'. $type;
  if($size) $classes .= ' btn-'. $size;
  if($class) $classes .= ' '. $class;
  if($icon) $output = '<i class="' . $icon . '"></i> ' . $text;
  return '<a target="' . $target . '" href="' . $url . '" class="' . $classes . '">' .  do_shortcode($output)  . '</a>';
});


//Alert
add_shortcode( 'sp_alert', function( $atts, $content= null ){
  $atts = shortcode_atts(
    array(
      "type" => 'info',
      "close" => 'no',
      "title" => '',
      ), $atts);
  //extract($atts);
  
  $output = '<div class="alert' 
  .  (($atts['type']=='none' ) ? '':' alert-'.$atts['type']) 
  .  (($atts['close']=='no' ) ? '':' alert-dismissable')  
  .' fade in">';
  if($atts['close']=='yes' ){
    $output .='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
  }
  if( $atts['title']!='' ){
    $output .='<h4>'. $atts['title']. '</h4>';
  }
  $output .= do_shortcode($content);
  $output .='</div>';
  return $output;
});


//divider
add_shortcode( 'sp_divider', function( $atts, $content= null ){
  $atts = shortcode_atts(
    array(
      'size'  => 'default'
      ), $atts);
  extract($atts);

  return '<div class="clearfix ' . $size . ' "></div>';
});


//progressbar
add_shortcode( 'sp_progressbar', function( $atts, $content= null ) {
  return '<div>' . do_shortcode( $content ) . '</div>';
});


add_shortcode( 'sp_bar', function( $atts, $content= null ) {
  $atts = shortcode_atts(
    array(
      "style"        => '',
      "width"        => '70%',
      "min"        => '0',
      "max"        => '100',
      "default"        => '70'
      ), $atts);
  extract($atts);

  return '<div class="progress">
  <div class="progress-bar ' . $style . '" role="progressbar" aria-valuenow="' . $default . '" aria-valuemin="'. $min .'" aria-valuemax="'. $max .'" style="width: ' . $width . '%">
  <span>' . do_shortcode( $content ) . '</span>
  </div></div>
  ';
});


//container
add_shortcode( 'sp_container', function( $atts, $content = null ) {
  $atts = shortcode_atts(
    array(
      "class"        => '',
      'id'           => ''
      ), $atts);
  extract($atts);
  if($id!='') $id = 'id=' . $id;
  return '<section ' . $id . ' class="' . $class . '"><div class="container">' . do_shortcode( $content ) . '</div></section>';
});


//columns
add_shortcode( 'sp_columns', function( $atts=array(), $content=null ){
 $atts = shortcode_atts(
  array(
    'animation' => '',
	'class' => ''
    ), $atts);
  $output = '<div class="row '. $atts['class'] . '" data-animation="' . $atts['animation'] . '">';
  $output .= do_shortcode( str_replace('<p></p>', '', $content) );
  $output .= '</div>';
  return $output;
});


//column
add_shortcode( 'sp_column', function( $atts, $content=null ){
 $atts = shortcode_atts(
  array(
    'size' => '1',
    'animation' => '',
	'class' => ''
    ), $atts);

 $output = '<div class="col-md-'.$atts['size'].' '. $atts['class'] . '" data-animation="' . $atts['animation'] . '">';
 $output .= do_shortcode( str_replace('<p></p>', '', $content) );
 $output .= '</div>';
 return $output;
});


//Icon
add_shortcode( 'sp_icon', function( $atts, $content=null ){
  $atts = shortcode_atts(array(
    'image' => 'icon-home',
    'size' => ''
    ), $atts);
  extract($atts);
  $icon = $image . ' ' . $size;
  return '<i class="' . $icon . '"></i>';
});


//Dropcap
add_shortcode( 'sp_dropcap',  function( $atts, $content="" ) {
  return '<p class="dropcap">' . do_shortcode( $content ) .'</p>';
} );


//Block Numbers
add_shortcode( 'sp_blocknumber', function( $atts, $content="" ) {
  extract(shortcode_atts(array(
    'number' => '01',
    'background' => '#333',
    'color' => '#999',
    'borderradius'=>'2px'
    ), $atts));

  return '<p class="blocknumber"><span style="background:'.$background.';color:'.$color.';border-radius:'.$borderradius.'">' . $number . '</span> ' . do_shortcode( $content ) . '</p>';
} );


//Block
add_shortcode( 'sp_block', function( $atts, $content="" ) {
  extract(shortcode_atts(array(
    'background' => 'transparent',
    'color' => '#666',
    'borderradius'=>'2px',
    'padding' => '15px'
    ), $atts));

  return '<div class="block" style="background:'.$background.';color:'.$color.';border-radius:'.$borderradius.';padding:'.$padding.'">'.$content.'</div>';
} );


//Accordion
add_shortcode( 'accordion', function( $atts, $content="" ) {
  extract(shortcode_atts(array(
    'title' => '',
    'id' => 'acc-1',
    'state' => 'closed'
    ), $atts));

  if($state == 'closed') {
	  $class = 'collapse';
	  $expanded = 'false';
  }
  else {
	  $class = 'collapse in';
	  $expanded = 'true';
  }

  return '<div class="accordion">

  <a data-toggle="collapse" class="accordion-question" href="#' . $id . '" aria-expanded="' . $expanded . '" aria-controls="' . $id . '"><i class="fa fa-angle-right"></i>' . $title .'</a>
  <div class="' . $class . '" id="' . $id . '">
  ' . $content . '
  </div>
  </div>';
} );

//Latest Posts
add_shortcode( 'latest_posts', function( $atts, $content="" ) {
  extract(shortcode_atts(array(
    'number' => 3,
	'posttype' => 'post'
    ), $atts));

  ob_start();
  
  $args = array(
    'posts_per_page' => $number,
	'post_type'      =>  $posttype
   );

  $data = get_posts( $args );

  if(count($data)>0){ ?>
  
	  <ul class="latest-posts row">
		<?php foreach ($data as $key => $value) { ?>
		<li class="col-md-4 col-sm-6">
			<a href="<?php echo get_permalink( $value->ID ); ?>">
			<div class="latest-title">
				<p><?php echo $value->post_title; ?></p>
			</div>
				<div class="byline">
					 <?php 
						$author_id = get_post_field( 'post_author', $value->ID );
					 	echo get_the_author_meta( 'display_name', $author_id ); 
					?> 
					<br />
					<?php echo get_the_date( 'F Y', $value->ID ); ?>
				</div>
			</a>
		</li>
		<?php } ?>
	  </ul>

  <?php } else { ?>
	  <p>
		<?php _e('No posts found.  Please check back again soon.', ZEETEXTDOMAIN); ?>
	  </p>
  <?php
}
return ob_get_clean();
} );


// Menu shortcode
//[menu name="Menu Name"]
add_shortcode('menu', 'sp_menu_shortcode');
function sp_menu_shortcode($atts, $content = null ) {
	extract( shortcode_atts( array(
	'name' => '', /* name of the menu */
	), $atts ) );
	
	$output = wp_nav_menu( array('menu' => $name, 'echo' => false ));
	
	return $output;
}

//Modal Shortcode
// [modal id="unique-modal-id" link_text="Click here"]Content[/modal]
function modal_shortcode( $atts, $content = null ) {
    extract( shortcode_atts(
		array(
			'id' => 'modal-1',
			'link_text' => 'Click here',
			'link_style' => ''
    	), $atts )
	);

    return '
		<!-- Link to trigger modal -->
		<a href="javascript:void(0);" data-toggle="modal" data-target="#'. $id .'" class="'. $link_style .'">
		  ' . $link_text . '
		</a>
		
		<!-- Modal -->
		<div class="modal fade" id="'. $id .'" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<div class="modal-body">
						'. do_shortcode($content) .'
					</div>
				</div>
			</div>
		</div>
	';
}
add_shortcode( 'modal', 'modal_shortcode' );

//Get Started Form
function gs_form_shortcode( $atts, $content = null ) {

    return '
<form action="">
	<div class="field-group">
		<fieldset class="form-group">
		<div class="input-group">
		  <input type="text" class="form-control" id="firstName" placeholder="First Name">
		  <input type="text" class="form-control" id="lastName" placeholder="Last Name">
		</div>
		</fieldset>
		<fieldset class="form-group float-md">
			<label class="sr-only" for="emailAddress">Email address</label>
			<input type="email" class="form-control" id="emailAddress" placeholder="Email">
		</fieldset>
		<fieldset class="form-group float-md">
			<label class="sr-only" for="phoneNumber">Phone Number</label>
			<input type="tel" class="form-control" id="phoneNumber" placeholder="Phone">
		</fieldset>
		<fieldset class="form-group clear">
			<label class="sr-only" for="timeZone">Time Zone</label>
			<select class="form-control" id="timeZone">
				<option>Time Zone</option>
				<option value="UTC-12">UTC-12</option>
				<option value="UTC-11.5">UTC-11:30</option>
				<option value="UTC-11">UTC-11</option>
				<option value="UTC-10.5">UTC-10:30</option>
				<option value="UTC-10">UTC-10</option>
				<option value="UTC-9.5">UTC-9:30</option>
				<option value="UTC-9">UTC-9</option>
				<option value="UTC-8.5">UTC-8:30</option>
				<option value="UTC-8">UTC-8</option>
				<option value="UTC-7.5">UTC-7:30</option>
				<option value="UTC-7">UTC-7</option>
				<option value="UTC-6.5">UTC-6:30</option>
				<option value="UTC-6">UTC-6</option>
				<option value="UTC-5.5">UTC-5:30</option>
				<option value="UTC-5">UTC-5</option>
				<option value="UTC-4.5">UTC-4:30</option>
				<option value="UTC-4">UTC-4</option>
				<option value="UTC-3.5">UTC-3:30</option>
				<option value="UTC-3">UTC-3</option>
				<option value="UTC-2.5">UTC-2:30</option>
				<option value="UTC-2">UTC-2</option>
				<option value="UTC-1.5">UTC-1:30</option>
				<option value="UTC-1">UTC-1</option>
				<option value="UTC-0.5">UTC-0:30</option>
				<option value="UTC+0">UTC+0</option>
				<option value="UTC+0.5">UTC+0:30</option>
				<option value="UTC+1">UTC+1</option>
				<option value="UTC+1.5">UTC+1:30</option>
				<option value="UTC+2">UTC+2</option>
				<option value="UTC+2.5">UTC+2:30</option>
				<option value="UTC+3">UTC+3</option>
				<option value="UTC+3.5">UTC+3:30</option>
				<option value="UTC+4">UTC+4</option>
				<option value="UTC+4.5">UTC+4:30</option>
				<option value="UTC+5">UTC+5</option>
				<option value="UTC+5.5">UTC+5:30</option>
				<option value="UTC+5.75">UTC+5:45</option>
				<option value="UTC+6">UTC+6</option>
				<option value="UTC+6.5">UTC+6:30</option>
				<option value="UTC+7">UTC+7</option>
				<option value="UTC+7.5">UTC+7:30</option>
				<option value="UTC+8">UTC+8</option>
				<option value="UTC+8.5">UTC+8:30</option>
				<option value="UTC+8.75">UTC+8:45</option>
				<option value="UTC+9">UTC+9</option>
				<option value="UTC+9.5">UTC+9:30</option>
				<option value="UTC+10">UTC+10</option>
				<option value="UTC+10.5">UTC+10:30</option>
				<option value="UTC+11">UTC+11</option>
				<option value="UTC+11.5">UTC+11:30</option>
				<option value="UTC+12">UTC+12</option>
				<option value="UTC+12.75">UTC+12:45</option>
				<option value="UTC+13">UTC+13</option>
				<option value="UTC+13.75">UTC+13:45</option>
				<option value="UTC+14">UTC+14</option>
			</select>
		</fieldset>
	</div>
	<div class="field-group">
		<fieldset class="form-group">
			<label class="sr-only" for="userName">User Name</label>
			<input type="text" class="form-control" id="userName" placeholder="User Name">
		</fieldset>
		<fieldset class="form-group float-md">
			<label class="sr-only" for="password">Password</label>
			<input type="password" class="form-control" id="password" placeholder="Password">
		</fieldset>
		<fieldset class="form-group float-md">
			<label class="sr-only" for="confirmPassword">Confirm Password</label>
			<input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
		</fieldset>
	</div>
	<div class="field-group">
		<fieldset class="form-group float-md">
			<label class="sr-only" for="companyName">Company Name</label>
			<input type="text" class="form-control" id="companyName" placeholder="Company Name">
		</fieldset>
		<fieldset class="form-group float-md">
			<label class="sr-only" for="companyEmail">Company Email</label>
			<input type="email" class="form-control" id="companyEmail" placeholder="Company Email">
		</fieldset>
		<fieldset class="form-group clear">
			<label class="sr-only" for="companyURL">Company URL</label>
			<input type="text" class="form-control" id="companyURL" placeholder="Company URL">
		</fieldset>
	</div>
	<p class="disclaimer">Your 30-day free trial lasts until midnight on June 2, 2015. By clicking the button BELOW, you are agreeing to the Terms of Service and Privacy Policy.</p>
	<div class="text-center">
	<button type="submit" class="btn btn-primary">Submit</button>
	</div>
</form>
	';
}
add_shortcode( 'gs_form', 'gs_form_shortcode' );

?>