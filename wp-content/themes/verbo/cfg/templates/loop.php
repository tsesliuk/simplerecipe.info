<?php
    global $posts_total, $posts_index;
    $myThemes_layout = new layout( );

    /* LEFT SIDEBAR */
    $myThemes_layout -> echoSidebar( 'left' );
?>

<!-- CONTENT -->
<section class="<?php echo $myThemes_layout -> contentClass(); ?> list-preview">

    <?php if (is_home()) { ?>
        <div class="header-main-search">
            <span class="glyphicon glyphicon-search"></span>
            <?php echo do_shortcode('[searchandfilter fields="search,category,post_tag" submit_label="Искать"]'); ?>
        </div>
    <?php } ?>

    <?php if (!is_home()) { ?>
        <div class="header-main-search second-pages">
            <h1>
                <?php _e( '' , 'myThemes' ); ?><?php echo get_cat_name( get_query_var( 'cat' ) ); ?>:
                <strong>
                    <?php

                        echo $wp_query -> found_posts . ' ';

                        if( $wp_query -> found_posts == 1 ){
                            _e( 'Рецепт' , 'myThemes' );
                        }
                        else{
                            _e( 'Рецептов' , 'myThemes' );
                        }
                    ?>
                </strong>
            </h1>
            
            <div class="header-main-filter">
                <?php echo do_shortcode('[searchandfilter fields="category,post_tag" submit_label="Отфильтровать"]'); ?>
            </div>

            <nav class="mythemes-nav-inline">
              <ul class="mythemes-menu">
                <li><a href="<?php echo home_url(); ?>" title="<?php _e( 'go home' , 'myThemes' ); ?>"><i class="icon-home"></i> <?php _e( 'Home' , 'myThemes' ); ?></a></li>
                <li><?php echo get_cat_name( get_query_var( 'cat' ) ); ?></li>
              </ul>
            </nav>
        </div>
    <?php } ?>

<?php

    /* LEFT WRAPPER */
    $myThemes_layout ->  contentWrapper( 'left' );
    
    /* CONTENT WRAPPER */ 
    if( have_posts() ){
        $posts_total = count( $wp_query -> posts );
        $posts_index = 0;
        while( have_posts() ){
            $posts_index++;
            the_post();
            get_template_part( 'cfg/templates/view/list-view' );

            if ($posts_index % 6 == 3) {
                //echo("<div class='advertise-taxonomy'>Место для Вашей рекламы</div>");

                /*
                echo('
                    <!-- advertise-taxonomy banners -->
                    <div class="advertise-taxonomy">
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-3923388382694018"
                             data-ad-slot="8519316889"
                             data-ad-format="auto"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                ');
                */

            }
            else {}

        }
    }
    else{
        echo '<h3>' . __( 'Не найдено' , 'myThemes' ) . '</h3>';
        echo '<p>' . __( 'Мы приносим свои извинения, но рецепта с таким словом в имени или инградиенте мы не нашли. Попробуйте поискать по другому слову.' , 'myThemes' ) . '</p>';
    }

    /* PAGINATION */
    get_template_part( 'cfg/templates/pagination' );

    /* RIGHT WRAPPER */
    $myThemes_layout ->  contentWrapper( 'right' );
?>
</section>
<aside class="col-sm-4 col-md-2 col-lg-2 sidebar-to-right">
    <?php
        ob_start();
        get_sidebar( 'footer-third' );
        $third = ob_get_clean();

        $sidebar_content = $third;
    ?>
    <?php echo $third; ?>
</aside>

<?php
    /* LEFT SIDEBAR */
    $myThemes_layout -> echoSidebar( 'right' );
?>