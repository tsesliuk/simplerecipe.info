<?php
    if( !myThemes::get( 'show-bottom-meta' ) ){
        return;
    }
    if( is_singular( 'post' ) && ( has_category( ) || has_tag() ) ){
?>
        <div class="post-meta-terms">
            <?php

                if( is_singular( 'post' ) && has_category( ) ){
                    echo '<div class="post-meta-categories">';
                    echo '<strong><i class="icon-list"></i> ' . __( 'Категории рецепта' , 'myThemes' ) . '</strong>: ';
                    the_category( ' ' );
                    echo '</div>';
                }

                if( is_singular( 'post' ) && has_tag() ){
                    echo '<div class="post-meta-tags">';
                    echo '<strong><i class="icon-tags"></i> ' . __( 'Ключевые теги рецепта' , 'myThemes' ) . '</strong>: ';
                    the_tags( ' ' , ' ' , ' ' );
                    echo '</div>';
                }
            ?>
        </div>
<?php
    }
?>