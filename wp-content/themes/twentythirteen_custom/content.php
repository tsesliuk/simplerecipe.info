<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Recipe">

	<?php if ( is_single($post) ) : ?>

	<!-- Header for single-->
	<header class="entry-header">
		
		<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		
			<div class="entry-thumbnail">
				<?php the_post_thumbnail('medium', array('itemprop' => 'image')); ?>
			</div>
		<?php endif; ?>

		<div class="row cooking_pameters">
			
			<div class="col-xs-3 .col-sm-3 col-md-3 col-lg-3">
				<div class="time_box">
				<abbr title="Время приготовления <?php the_title(); ?>"><span class="icons_sprite time_icon"></span>
				
				<?php  $books = get_post_meta( $post->ID, 'minutes', true ); 
				foreach( $books as $book){
					echo ('<meta itemprop="cookTime" content="PT'); echo $book['minutes']; echo ('M">');
				}?>

				<?php  $books = get_post_meta( $post->ID, 'minutes', true ); 
				foreach( $books as $book){
					echo ('<span class="hours"><span class="symbols">');
					echo $book['hours'];
					echo ('</span><span class="text">часа</span></span>');
					echo (' <span class="minutes">');
					echo $book['minutes']; 
					echo (' мин</span>');
				}?>
				</abbr>
				</div>
			</div>
			<div class="col-xs-9 .col-sm-9 col-md-9 col-lg-9">
				<?php if(function_exists('the_ratings')) { the_ratings(); } ?>

				<div class="sostav_box" itemprop="ingredients">
				<?php $sostav = get_post_meta( $post->ID, 'sostav', true );
				foreach( $sostav as $sostav){
					echo ('');
					echo $sostav['sostav'];
					echo (';');
				}
				?>
				</div>

				<span class="entry-author author hCard" itemprop="author">Автор: <?php the_author_link(); ?></span>
				<span class="entry-date" itemprop="datePublished">Date posted: <?php the_date(); ?></span>
			</div>
		</div>
		
	</header>
	<!-- end Header for single-->


	<?php else : ?>

	<!-- Header for loop-->
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>				
			<a title="<?php the_title(); ?>" class="entry-thumbnail" href="<?php the_permalink(); ?>" rel="bookmark" >
				<?php the_post_thumbnail('medium', array('itemprop' => 'image')); ?>
			</a>
		<?php endif; ?>


		<div class="row">
			<div class="col-sm-9 col-md-9 col-lg-9">
				<h2 class="entry-title">
					<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark" itemprop="name"><?php the_title(); ?></a>
				</h2>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<?php if(function_exists('the_ratings')) { the_ratings(); } ?>		
			</div>
		</div>

		<div class="row cooking_pameters">
			<div class="col-sm-9 col-md-9 col-lg-9">
				<div class="time_box">
				<?php  $books = get_post_meta( $post->ID, 'minutes', true ); 
				foreach( $books as $book){
					echo ('<meta itemprop="cookTime" content="PT'); echo $book['minutes']; echo ('M">');
				}?>
				<abbr title="Время приготовления <?php the_title(); ?>"><span class="icons_sprite time_icon"></span>
				<?php $books = get_post_meta( $post->ID, 'minutes', true ); 
				foreach( $books as $book){
					echo ('<span class="hours"><span class="symbols">');
					echo $book['hours'];
					echo ('</span><span class="text">часа</span></span>');
					echo (' <span class="minutes">');
					echo $book['minutes']; 
					echo (' мин</span>');
				}?>
				</abbr>
				</div>

				<div class="sostav_box" itemprop="ingredients">
				<?php $sostav = get_post_meta( $post->ID, 'sostav', true );
				foreach( $sostav as $sostav){
					echo ('');
					echo $sostav['sostav'];
					echo (';');
				}
				?>
				</div>
				<span class="entry-author author hCard" itemprop="author">Автор: <?php the_author_link(); ?></span>
				<span class="entry-date" itemprop="datePublished">Date posted: <?php the_date(); ?></span>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3">
				<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="more_book"><span class="icons_sprite book_ico"></span> Читать рецепт</a>
				<?php // the_content( __( ' <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
			</div>
		</div>
		
	</header>
	<!-- end Header for loop-->

	<?php endif;  ?>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	
	<div class="entry-content" itemprop="description">
		<?php the_content(); ?>
		
		<?php //comments_template(); ?>

			<?php if ( is_single($post) ) : ?>
				<!-- for single posts only -->
				<div class="advertise_holder">

					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- Prostoyrecept (0ResponsiveBannerRight) -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-3923388382694018"
					     data-ad-slot="6546321280"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>

				</div>

			<?php endif; ?>
<?
#comment
?>
<?php
	comments_template('', true);
?>


		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->

	<?php endif; ?>
	
	
</article><!-- #post -->
