<?php get_header(); ?>

    <div class="content">
        <div class="container">

            <?php
                ob_start();
                get_sidebar( 'front-page-header-first' );
                $first = ob_get_clean();

                ob_start();
                get_sidebar( 'front-page-header-second' );
                $second = ob_get_clean();

                ob_start();
                get_sidebar( 'front-page-header-third' );
                $third = ob_get_clean();

                $sidebar_content = $first . $second . $third;

                if( !empty( $sidebar_content ) ){
            ?>

                    <!-- FEATURES -->
                    <aside class="row mythemes-features">

                        <!-- FEATURE 1 -->
                        <div class="col-md-4 col-lg-4 feature-item">
                            <?php echo $first; ?>
                        </div>

                        <!-- FEATURE 2 -->
                        <div class="col-md-4 col-lg-4 feature-item">
                            <?php echo $second; ?>
                        </div>

                        <!-- FEATURE 3 -->
                        <div class="col-md-4 col-lg-4 feature-item">
                            <?php echo $third; ?>
                        </div>

                        <div class="col-lg-12 mythemes-delimiter"><div class="delimiter-item"></div></div>
                    </aside>

            <?php
                }
            ?>

            <div class="row">

            <?php
                if( get_option( 'show_on_front' ) == 'page' ){

                    /* GET LAYOUT DETAILS */
                    $myThemes_layout = new layout( 'front-page' );

                    /* LEFT SIDEBAR */
                    $myThemes_layout -> echoSidebar( 'left' );
            ?>
                    <!-- CONTENT -->
                    <section class="<?php echo $myThemes_layout -> contentClass(); ?>">
                    <?php

                        /* LEFT WRAPPER */
                        $myThemes_layout ->  contentWrapper( 'left' );

                        /* CONTENT WRAPPER */
                        $wp_query = new WP_Query( array(
                            'p' => get_option( 'page_on_front' ),
                            'post_type' => 'page'
                        ) );
                    ?>
                        <article>

                        <?php

                            if( count( $wp_query -> posts ) ){
                                foreach( $wp_query -> posts as $post ){

                                    $wp_query -> the_post();

                                    if( has_post_thumbnail() ){ ?>

                                        <div class="my-thumbnail">
                                        <?php echo get_the_post_thumbnail( $post -> ID , array( 9999 , 9999 ) , esc_attr( $post -> post_title ) ); ?>
                                        <?php $caption = get_post( get_post_thumbnail_id() ) -> post_excerpt; ?>
                                        <?php
                                            if( !empty( $caption ) ) {
                                        ?>
                                                <footer class="wp-caption">
                                                    <?php echo $caption; ?>
                                                </footer>
                                        <?php
                                            }
                                        ?>
                                        </div>

                                    <?php } ?>

                                    <?php the_content(); ?>

                                    <div class="clearfix"></div>

                                    <?php wp_link_pages( array( 'before' => '<div><p style="color: #000000;">' . __( 'Pages', "myThemes" ) . ':', 'after' => '</p></div>' ) );
                                }
                            }
                        ?>
                        <article>

                    <?php
                        /* RIGHT WRAPPER */
                        $myThemes_layout ->  contentWrapper( 'right' );
                    ?>
                    </section>
            <?php
                    /* RIGHT SIDEBAR */
                    $myThemes_layout -> echoSidebar( 'right' );

                }else{
                    get_template_part( 'cfg/templates/loop' );
                }
            ?>


            </div>

            <div class="row">
                
                <div class="col-sm-4 col-md-2 col-lg-2"></div>
                <div class="col-sm-8 col-md-8 col-lg-8">
                    
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

                </div>
                <div class="col-sm-4 col-md-2 col-lg-2"></div>

            </div>

        </div>

    </div>

<?php get_footer(); ?>