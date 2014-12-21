<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>

	<div id="primary" class="content-area col-xs-12 col-sm-9 col-md-9 col-lg-9">
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
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				
				<?php twentythirteen_post_nav(); ?>
				<?//php comments_template(); ?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>