<?php
/**
 * The header template file.
 * @package ForeverWood
 * @since ForeverWood 1.0.0
*/
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php global $foreverwood_options_db; ?>
  <meta charset="<?php bloginfo( 'charset' ); ?>" /> 
  <meta name="viewport" content="width=device-width" />  
<?php if ( ! function_exists( '_wp_render_title_tag' ) ) { ?><title><?php wp_title( '|', true, 'right' ); ?></title><?php } ?>  
<?php if ($foreverwood_options_db['foreverwood_favicon_url'] != ''){ ?>
	<link rel="shortcut icon" href="<?php echo esc_url($foreverwood_options_db['foreverwood_favicon_url']); ?>" />
<?php } ?>
<?php wp_head(); ?>   
</head>
 
<body <?php body_class(); ?> id="wrapper">
<div id="container-boxed"> 
<div id="container-boxed-inner">
<header id="wrapper-header">  
  <div class="header-content-wrapper">
    <div class="header-content">
      <div class="title-box">
<?php if ( $foreverwood_options_db['foreverwood_logo_url'] == '' ) { ?>
        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
<?php } else { ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="header-logo" src="<?php echo esc_url($foreverwood_options_db['foreverwood_logo_url']); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
<?php } ?>
      </div>
<?php if ( !is_page_template('template-landing-page.php') ) { ?>
<?php if ( $foreverwood_options_db['foreverwood_header_layout'] == 'Wide' ) { ?>
      <div class="menu-box">
<?php wp_nav_menu( array( 'menu_id'=>'nav', 'theme_location'=>'main-navigation' ) ); ?>
      </div>
<?php }} ?>
    </div>
  </div>
<?php if ( !is_page_template('template-landing-page.php') ) { ?>
<?php if ( $foreverwood_options_db['foreverwood_header_layout'] != 'Wide' ) { ?>
  <div class="menu-panel-wrapper">
    <div class="menu-panel">
<?php wp_nav_menu( array( 'menu_id'=>'main-nav', 'theme_location'=>'main-navigation' ) ); ?>
    </div>
  </div>
<?php }} ?>

<?php if ( is_home() || is_front_page() ) { ?>
<?php if ( get_header_image() != '' && $foreverwood_options_db['foreverwood_display_header_image'] != 'Everywhere except Homepage' ) { ?>
  <div class="header-image">
    <img class="header-img" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" />
    <div class="header-image-container">
    <div class="header-image-text-wrapper">
      <div class="header-image-text">
<?php if ( $foreverwood_options_db['foreverwood_header_image_headline'] != '' ) { ?>
        <p class="header-image-headline"><?php echo esc_attr($foreverwood_options_db['foreverwood_header_image_headline']); ?></p>
<?php } if ( $foreverwood_options_db['foreverwood_header_image_link_url'] != '' && $foreverwood_options_db['foreverwood_header_image_link_text'] != '' ) { ?>
        <p class="header-image-link-wrapper"><a class="header-image-link" href="<?php echo esc_url($foreverwood_options_db['foreverwood_header_image_link_url']); ?>"><?php echo esc_attr($foreverwood_options_db['foreverwood_header_image_link_text']); ?></a></p>
<?php } ?>
      </div>
    </div>
    </div>
  </div>
<?php } ?>
<?php } else { ?>
<?php if ( get_header_image() != '' && $foreverwood_options_db['foreverwood_display_header_image'] != 'Only on Homepage' ) { ?>
  <div class="header-image">
    <img class="header-img" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" />
  </div>
<?php }} ?>
</header> <!-- end of wrapper-header -->