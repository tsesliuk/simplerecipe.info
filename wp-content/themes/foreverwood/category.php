<?php
/**
 * The category archive template file.
 * @package ForeverWood
 * @since ForeverWood 1.0.0
*/
get_header(); ?>
<div id="wrapper-content">
<?php if ( have_posts() ) : ?>
  <div class="container">
  <div id="main-content">
    <div class="content-headline">
      <h1 class="entry-headline"><?php single_cat_title(); ?></h1>
<?php foreverwood_get_breadcrumb(); ?>
    </div>
<?php if ( category_description() ) : ?><div class="archive-meta"><?php echo category_description(); ?></div><?php endif; ?>
    <div id="content"<?php if ($foreverwood_options_db['foreverwood_post_entry_format'] == 'Grid - Masonry') { ?> class="js-masonry"<?php } ?>> 
<?php while (have_posts()) : the_post(); ?>      
<?php if ($foreverwood_options_db['foreverwood_post_entry_format'] == 'Grid - Masonry') {
get_template_part( 'content', 'grid' ); } else {
get_template_part( 'content', 'archives' ); } ?>
<?php endwhile; endif; ?>
    </div> <!-- end of content -->
<?php foreverwood_content_nav( 'nav-below' ); ?>
  </div>
<?php if ($foreverwood_options_db['foreverwood_display_sidebar_archives'] != 'Hide') { ?>
<?php get_sidebar(); ?>
<?php } ?>
  </div>
</div>     <!-- end of wrapper-content -->
<?php get_footer(); ?>