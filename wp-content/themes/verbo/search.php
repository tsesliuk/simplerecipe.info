<?php get_header(); ?>

    <?php global $wp_query; ?>

    <div class="mythemes-page-header second-pages">

      <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-2 col-lg-2">
            </div>

            <div class="col-sm-8 col-md-8 col-lg-8">
                <div class="header-main-search second-pages">
                    <h1>
                        <?php _e( '' , 'myThemes' ); ?><?php echo get_search_query( get_query_var( 'cat' ) ); ?>:
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
            </div>

          <div class="col-sm-2 col-md-2 col-lg-2 mythemes-posts-found">
                <div class="found-details">
                </div>
            </div>

        </div>
      </div>

    </div>

    <div class="content">
        <div class="container">
            <div class="row">

                <?php get_template_part( 'cfg/templates/loop' ); ?>

            </div>
        </div>
    </div>


<?php get_footer(); ?>