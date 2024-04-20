<?php
/************************************************************/
# Declares the DOCTYPE for the site and include the <head>.
/************************************************************/
global $post;

$wrt_layout_style	= esc_attr(get_theme_mod('wrt_layout_settings','un-boxed'));
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="no-js ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  
	<?php
		wp_head(); 
	?>
  
</head>
<body id="site-body" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-mobile-navigation"></div>
<div class="site-wrapper <?php if($wrt_layout_style == 'boxed'): echo 'boxed-wrapper ';endif; ?> shadow-wrapper">
	<?php get_template_part('inc/theme/headers/header1'); ?>