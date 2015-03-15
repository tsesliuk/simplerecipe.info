<?php
    if ( dynamic_sidebar( 'front-page-header-third' ) ){
        /* IF NOT EMPTY */    
    }
    else{
        /* IF EMPTY */
        if( myThemes::get( 'default-content' ) ){
            echo '<div class="widget widget_text">';
            echo '<h3>Responsive Layout</h3>';
            echo '<div class="textwidget"></div>';
            echo '</div>';
        }
    }
?>