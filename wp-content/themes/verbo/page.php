<?php get_header(); ?>
<?php
    if( have_posts() ){
        while( have_posts() ){
            the_post();
?>
            <div class="mythemes-page-header">

              <div class="container">
                <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                    </div>
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <h1><?php the_title(); ?></h1>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2">
                    </div>
                </div>
              </div>

            </div>

            <div class="content">
                <div class="container">
                    <div class="row">

                    <?php
                        global $post;

                        /* GET LAYOUT DETAILS */
                        $myThemes_layout = new layout( 'page' , $post -> ID );

                        /* LEFT SIDEBAR */
                        $myThemes_layout -> echoSidebar( 'left' );
                    ?>
                        <!-- CONTENT -->
                        <section class="<?php echo $myThemes_layout -> contentClass(); ?>">

                        <?php
                            /* LEFT WRAPPER */
                            $myThemes_layout ->  contentWrapper( 'left' );

                        ?>
                            <article <?php post_class( 'row-fluid' ); ?>>
                                <div class="breadcrumb">
                                        <?php

                                            if (function_exists('show_full_breadcrumb')) show_full_breadcrumb(
                                                array(
                                                    'labels' => array(
                                                        'local'  => __('<i class="glyphicon glyphicon-home"></i>'), // set FALSE to hide
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
                                <?php 
                                    if( has_post_thumbnail() ){
                                ?>
                                        <div class="post-thumbnail">
                                            <?php echo get_the_post_thumbnail( $post -> ID , 'full-thumbnail' , esc_attr( $post -> post_title ) ); ?>
                                            <?php $caption = get_post( get_post_thumbnail_id() ) -> post_excerpt; ?>
                                            <?php if( !empty( $caption ) ) { ?>
                                                <footer><?php echo $caption; ?></footer>
                                            <?php } ?>
                                        </div>
                                <?php
                                    }
                                ?>

                                <!-- CONTENT -->
                                <?php the_content(); ?>
                                <div class="clearfix"></div>
                            </article>

                            <!-- COMMENTS -->
                            <?php comments_template(); ?>

                        <?php
                            /* RIGHT WRAPPER */
                            $myThemes_layout ->  contentWrapper( 'right' );
                        ?>

                        </section>

                    <?php
                        /* RIGHT SIDEBAR */
                        $myThemes_layout -> echoSidebar( 'right' );
                    ?>
                        <aside class="col-sm-4 col-md-2 col-lg-2 sidebar-to-right">
                            <?php
                                ob_start();
                                get_sidebar( 'footer-third' );
                                $third = ob_get_clean();

                                $sidebar_content = $third;
                            ?>
                            <?php echo $third; ?>
                        </aside>
                    
                    </div>
                </div>
            </div>

<?php
        } /* END PAGE */
    }
?>



<?php get_footer(); ?>