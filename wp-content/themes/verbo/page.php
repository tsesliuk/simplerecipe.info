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
                        <nav class="mythemes-nav-inline">
                          <ul class="mythemes-menu">
                            <li><i class="glyphicon glyphicon-home"></i> <a href="<?php echo home_url(); ?>" title="<?php _e( 'На главную' , 'myThemes' ); ?>"> <?php _e( 'Главная' , 'myThemes' ); ?></a></li>
                            <li><i class="glyphicon glyphicon-play"></i><?php the_title(); ?></li>
                          </ul>
                        </nav>
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