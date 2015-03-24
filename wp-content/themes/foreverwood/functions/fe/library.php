<?php 
/**
 * Library of Theme options functions.
 * @package ForeverWood
 * @since ForeverWood 1.0.0
*/

// Display Breadcrumb navigation
function foreverwood_get_breadcrumb() { 
global $foreverwood_options_db;
		if ($foreverwood_options_db['foreverwood_display_breadcrumb'] != 'Hide') { ?>
		<?php if(function_exists( 'bcn_display' ) && !is_front_page()){ _e('<p class="breadcrumb-navigation">', 'foreverwood'); ?><?php bcn_display(); ?><?php _e('</p>', 'foreverwood');} ?>
<?php } 
} 

// Display featured images on single posts
function foreverwood_get_display_image_post() { 
global $foreverwood_options_db;
		if ($foreverwood_options_db['foreverwood_display_image_post'] == '' || $foreverwood_options_db['foreverwood_display_image_post'] == 'Display') { ?>
		<?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail(); ?>
    <?php endif; ?>
<?php } 
}

// Display featured images on pages
function foreverwood_get_display_image_page() { 
global $foreverwood_options_db;
		if ($foreverwood_options_db['foreverwood_display_image_page'] == '' || $foreverwood_options_db['foreverwood_display_image_page'] == 'Display') { ?>
		<?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail(); ?>
    <?php endif; ?>
<?php } 
} ?>