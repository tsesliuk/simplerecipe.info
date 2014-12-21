<?php
/**
 * The sidebar containing the secondary widget area, displays on posts and pages.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div id="tertiary" class="sidebar-container col-xs-12 col-sm-4 col-md-4 col-lg-4" role="complementary">
		<div class="sidebar-inner">
			<div class="widget-area">
				<h3 class="widget-title">Поиск рецептов</h3>

				<form role="search" method="get" id="searchform" class="search-form" action="<?php echo home_url( '/' ); ?>">
				    <div><label class="screen-reader-text" for="s">Search for:</label>
				        <input type="text" value="" name="s" id="s" class="search-field" placeholder="Что ищем?">
				        <input type="submit" id="searchsubmit" value="Искать" class="search-submit">
				        <span class="clear"></span>
				    </div>
				</form>

			</div>
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>				
			</div><!-- .widget-area -->
			
		</div><!-- .sidebar-inner -->
	</div><!-- #tertiary -->
<?php endif; ?>