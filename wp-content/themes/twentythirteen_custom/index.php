<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
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
		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php twentythirteen_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->

		<div class="archive-meta bottom-description" id="description">
		
			<h3>Рецепты простые для мужиков и не опытных девушек, в готовке:)</h3>

			<p>
				Сайт простых и быстрых рецептов. На столько простых, чтобы вы могли <strong>проще простого рецепты эти использлвать</strong>  для торта из того, что у вас есть в холодильнике или использовать легкий рецепт торта чтобы приготовить простой торт своей девушке или жене:). Свой сайт <strong>“простые рецепты”</strong> мы создали, чтобы вы могли легко найти рецепт простого тортика и приготовить будь то шоколадный торт или чизкейк.
			</p>
			<h3>
				Простые рецепты даже для профессионалов
			</h3>
			<p>
				<strong>Простые рецепты</strong> ищут не только те, кто готовит для себя и семьи, а и профессиональные повара. Сегодня у каждого много дел, забот, все очень заняты и именно поэтому мы Вам предлагаем познать немного простых и вкусных рецептов, которые можно применять в повседневной жизни.
			</p>
			<p>— <em>Наши простые рецепты помогут даже профессионалам испечь что–то простое и быстрое из того что есть в холодильнике.</em>
			</p>
			<h3>Просто рецепты для ленивых;)</h3>

			<p>ежели вы представитель сильного пола, который ищет простой рецепт – вы отыщете его тут! либо ежели вы женщина с небольшим опытом готовки однако вам нужно к вечеру изготовить собственному любимому торт – вам также несомненно поможет наш <strong>“простой рецепт”</strong></p>

			<p>— <em>Наши простые рецепты не требовательны, не нужно иметь определенных навыков в кулинарии и готовятся они из простых составляющих.</em>
			</p>
			<p>Со временем мы будем пополнять свои коллекции простых рецептов, простых тортиков и не только.</p> 

			<p>Чтобы быть в курсе событий и несколько раз в неделю получать новый <strong>простой рецепт</strong> просто подпишитесь на рассылку в правой колонке сайта.</p> 

			<p>Домохозяйкам мы предложим рецепты вкусных тортиков, выпечки, печенек и всяких вкусняшек. Рецептики для любимых и для того, чтобы приготовить шарлотку своему мужчине или детям.</p>

			<p>— <em>Мужчинам мы предложим простые рецепты и быстрые рецепты, простые рецепты тортов на 8 марта и другие праздники.</em></p> 

			<p>Множество простых рецептов для того, чтобы легко приготовить простой торт своей половинке:)</p>

			<p>Наши простые рецепты шарлоток подойдут чтобы научить готовить деток или показать им как легко приготовить торт.</p>

			<p><strong>Все, что мы хотели этим сказать: “Простые рецепты” – это простые рецепты:)</strong></p>

		</div>
		
		

	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>