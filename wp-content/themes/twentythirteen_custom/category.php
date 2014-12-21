<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area col-xs-12 col-sm-8 col-md-8 col-lg-8">
		<div id="content" class="site-content" role="main">

			<div class="breadcrumb">
				<?php 

					if (function_exists('show_full_breadcrumb')) show_full_breadcrumb(
					    array(
					        'labels' => array(
					            'local'  => __('You are here:'), // set FALSE to hide
					            'home'   => __('Home'),
					            'page'   => __('Page'),
					            'tag'    => __('Tag'),
					            'search' => __('Searching for'),
					            'author' => __('Published by'),
					            '404'    => __('Error 404 &rsaquo; Page not found')
					        ),
					        'separator' => array(
					            'element' => 'span',
					            'class'   => 'separator',
					            'content' => '&rsaquo;'
					        ), // set FALSE to hide
					        'local' => array(
					            'element' => 'span',
					            'class'   => 'local'
					        ),
					        'home' => array(
					            'showLink'       => true,
					            'showBreadcrumb' => true
					        ),
					        'actual' => array(
					            'element' => 'span',
					            'class'   => 'actual'
					        ), // set FALSE to hide
					        'quote' => array(
					            'tag'    => true,
					            'search' => true
					        ),
					        'page_ancestors' => array(
					            'showLink' => false
					        )
					    )
					);


				 ?>
			</div>

			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php printf(single_cat_title( '', false ) ); ?> <a href="#description" title='Описание <?php printf(single_cat_title( "", false ) ); ?>' class="icons_sprite chevron-down scrolingTo"></a></h1>
				</header><!-- .archive-header -->

				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>

				<?php twentythirteen_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</div><!-- #content -->
		<?php if ( category_description() ) : // Show an optional category description ?>
			<div class="archive-meta bottom-description" id="description"><?php echo category_description(); ?></div>
		<?php endif; ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>