<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php sp_favicon();?>
<?php wp_head(); ?>

<!--Facebook Tracking Pixel-->
<script>(function(){
  window._fbds = window._fbds || {};
  _fbds.pixelId = 258446684329792;
  var fbds = document.createElement('script');
  fbds.async = true;
  fbds.src = '//connect.facebook.net/en_US/fbds.js';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(fbds, s);
})();
window._fbq = window._fbq || [];
window._fbq.push(["track", "PixelInitialized", {}]);
</script>
<noscript><img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=258446684329792&amp;ev=NoScript" /></noscript>
</head><!--/head-->
<body <?php body_class() ?> data-spy="scroll" data-target=".navbar-main">
  <?php if(sp_option('sp_theme_layout')=='boxed'){ ?>
    <div id="boxed">
  <?php }
	if( sp_option('sp_header_theme') ){  
		if(sp_option('sp_header_theme') == "light") {
			$navclass = "navbar-light";
		}
		elseif(sp_option('sp_header_theme') == "dark-primary") {
			$navclass = "navbar-dark bg-primary";
		}
		else {
			$navclass = "navbar-dark bg-inverse";
		}
	}
 ?>
  <div class="container-fluid container-head">
  	<nav class="navbar-fixed-top home">
		<div class="col-sm-12">
			<button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".nav-toggle">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php logo();?>
			<div class="pull-right btn-login"><a class="btn btn-default btn-sm" href="#" data-backdrop="static" data-toggle="modal" data-target="#loginModal">Log in</a></div>
			<div class="collapse navbar-main-wrapper nav-toggle navbar-toggleable-lg">
				<?php 
				  if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
					  'theme_location'  => 'primary',
					  'container'       => false,
					  'menu_class'      => 'nav navbar-nav navbar-main',
					  'fallback_cb'     => 'wp_page_menu',
					  'walker'          => new wp_bootstrap_navwalker()
					  )
					); 
				  }
				  ?>
				  <div class="copyright">
				  <?php
				  if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array(
					  'theme_location'  => 'footer',
					  'container'       => false,
					  'menu_class'      => 'nav navbar-nav navbar-footer',
					  'fallback_cb'     => 'wp_page_menu',
					  'walker'          => new wp_bootstrap_navwalker()
					  )
					); 
				  }
				  ?>
				  |  &copy; <?php echo date('Y');?> Social House, Inc.
				  </div>
				<div class="overlay"></div>
		  </div>
		</div>
	</nav><!--/#header-->
  </div>
  <div class="container-fluid content-container">
      <div class="content-area row">

