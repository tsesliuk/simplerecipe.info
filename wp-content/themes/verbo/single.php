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

                <?php
                    /* LEFT WRAPPER */
                    $myThemes_layout ->  contentWrapper( 'left' );

                    if( have_posts() ){
                        while( have_posts() ){
                            the_post();    
                ?>
                            <article <?php post_class( 'row-fluid' ); ?>>

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
                          
                                <!-- TOP META : AUTHOR / TIME / COMMENTS -->

                                <div class="row mb-10">
                                    
                                    <div class="col-sm-6 col-md-2 col-lg-2 ">
                                        <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                                    </div>
                                        
                                    <div class="col-sm-6 col-md-3 col-lg-2 post-short-info">
                                        <abbr title="Время приготовления <?php the_title(); ?>">
                                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                            
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
                                        </abbr>    
                                    </div>

                                    <div class="col-sm-6 col-md-2 col-lg-2">
                                        <span class="entry-author author hCard" itemprop="author">Автор: <?php the_author_link(); ?></span>
                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <span class="entry-date" itemprop="datePublished">Опубликован: <?php the_date(); ?></span>
                                    </div>
                                </div>

                                <div class="post-tags">
                                    <?php the_tags( '<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>',', <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>'); ?> 
                                </div>

                                <!-- CONTENT -->
                                <?php the_content(); ?>

                                <div class="clearfix"></div>

                                <?php get_template_part( 'cfg/templates/bottom-meta' ); ?>
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