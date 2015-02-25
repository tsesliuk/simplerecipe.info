<?php global $post, $posts_total, $posts_index; ?>
        
        <article <?php post_class( 'row' ); ?>>

            <?php
                $classes = 'post-content col-md-12 col-lg-12';
                if( has_post_thumbnail() ){
            ?>
                    <div class="post-thumbnail col-md-4 col-lg-4">
                      <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $post -> post_title ); ?>">
                        <?php echo get_the_post_thumbnail( $post -> ID , 'grid-thumbnail' , esc_attr( $post -> post_title ) ); ?>
                      </a>
                    </div>
            <?php
                    $classes = 'post-content col-md-8 col-lg-8';
                }
            ?>

            <div class="<?php echo $classes; ?>">

                <h2 class="post-title">
                <?php if( !empty( $post -> post_title ) ) { ?>
            
                        <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( $post -> post_title ); ?>"><?php the_title(); ?></a>
            
                    <?php } else { ?>
                
                        <a href="<?php the_permalink() ?>"><?php _e( 'Read more about ..' , 'myThemes' ) ?></a>
                
                    <?php } ?>
                </h2>

                <div class="sostav_box" itemprop="ingredients">
                    <?php $sostav = get_post_meta( $post->ID, 'sostav', true );                   
                        foreach( $sostav as $sostav){
                            $newSostav = substr($sostav['sostav'], 0, 180);
                            echo $newSostav;
                        }
                    ?>
                </div>

                <?php get_template_part( 'cfg/templates/meta' ); ?>

                <?php
                    
                    if( !empty( $post -> post_excerpt ) ){
                        the_excerpt();
                        echo '<a href="' . get_permalink( $post -> ID ) . '">' . __( '' , 'myThemes' ) . '</a>';
                    }
                    else{
                        the_content( '' );    
                    }
                    
                ?>

                <div class="post-short-info">
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
                    <span class="author-and-rating">
                        <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                        <span class="entry-author author hCard" itemprop="author">Автор: <?php the_author_link(); ?></span>
                        <span class="entry-date" itemprop="datePublished">Опубликован: <?php the_date(); ?></span>
                    </span>
                </div>    
                <span class="post-tags">
                    <?php the_tags( '<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>',', <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>'); ?> 
                </span>
            </div>

            <!-- BOTTOM DELIMITER -->
            <div class="clear clearfix"></div>

            <?php if( $posts_total > $posts_index ){ ?>

                <div class="col-lg-12">
                  <div class="post-delimiter"></div>  
                </div>

            <?php } ?>


        </article>