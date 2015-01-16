<?php get_header(); ?>


    <div class="content">
        <div class="container">
            <div class="row">

            <?php
                global $post;

                /* GET LAYOUT DETAILS */
                $myThemes_layout = new layout( 'single' , $post -> ID );

                /* LEFT SIDEBAR */
                $myThemes_layout -> echoSidebar( 'left' );
            ?>
                <!-- CONTENT -->
                <section class="<?php echo $myThemes_layout -> contentClass(); ?>">

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
                    /* LEFT WRAPPER */
                    $myThemes_layout ->  contentWrapper( 'left' );

                    if( have_posts() ){
                        while( have_posts() ){
                            the_post();    
                        ?>
                            <article <?php post_class( 'row-fluid' ); ?>>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 pull-right pl-0">
                                        <div class="first-plan-box">
                                            <ul class="param-list">
                                                <li>
                                                    <abbr title="Время приготовления <?php the_title(); ?>">
                                                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                                        Готовка:
                                                        <strong>
                                                            <?php  $books = get_post_meta( $post->ID, 'minutes', true ); 
                                                            foreach( $books as $book){
                                                                echo ('<meta itemprop="cookTime" content="PT'); echo $book['minutes']; echo ('M">');
                                                            }?>

                                                            <?php  $books = get_post_meta( $post->ID, 'minutes', true ); 
                                                            foreach( $books as $book){
                                                                echo ('<span class="hours"><span class="symbols">');
                                                                echo $book['hours'];
                                                                echo ('</span> <span class="text">часа</span></span>');
                                                                echo (' <span class="minutes">');
                                                                echo $book['minutes']; 
                                                                echo ('</span>');
                                                            }?>
                                                        </strong>
                                                    </abbr>
                                                </li>
                                                <li>
                                                    <span class="entry-author author hCard" itemprop="author">
                                                        Автор:
                                                        <strong><?php the_author_link(); ?></strong>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="entry-date" itemprop="datePublished">Опубликован: <strong><?php the_date(); ?></strong></span>
                                                </li>
                                                <li><?php if(function_exists('the_ratings')) { the_ratings(); } ?></li>
                                            </ul>
                                            <div class="post-tags small-info-box">
                                                <span class="small-info-box-title">Особенности рецепта: </span>
                                                <?php the_tags( '<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>',', <br><span class="glyphicon glyphicon-tag" aria-hidden="true"></span>'); ?> 
                                            </div>

                                            <div class="sostav_box sidebar" itemprop="ingredients" data-spy="affix" data-offset-top="60" data-offset-top="200">
                                            <?php $sostav = get_post_meta( $post->ID, 'sostav', true );
                                                foreach( $sostav as $sostav){
                                                    echo ('');
                                                    echo $sostav['sostav'];
                                                    echo (';');
                                                }
                                            ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8">

                                        <?php
                                            $classes = 'no-thumbnail';

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
                                                $classes = '';
                                            }
                                        ?>

                                        <!-- TITLE -->
                                        <h1 class="post-title <?php echo $classes; ?>"><?php the_title(); ?></h1>
                                  

                                        <!-- CONTENT -->
                                        <?php the_content(); ?>

                                        <div class="clearfix"></div>

                                        <?php get_template_part( 'cfg/templates/bottom-meta' ); ?>

                                    </div>

                                </div>
                            </article>

                            <!-- COMMENTS -->
                            <?php comments_template(); ?>

                <?php
                        } /* END ARTICLE */
                    }
                ?>

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

<?php get_footer(); ?>