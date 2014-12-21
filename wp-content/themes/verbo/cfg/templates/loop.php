<?php
    global $posts_total, $posts_index;
    $myThemes_layout = new layout( );

    /* LEFT SIDEBAR */
    $myThemes_layout -> echoSidebar( 'left' );
?>

<!-- CONTENT -->
<section class="<?php echo $myThemes_layout -> contentClass(); ?> list-preview">
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
        }
    }
    else{
        echo '<h3>' . __( 'Not found results' , 'myThemes' ) . '</h3>';
        echo '<p>' . __( 'We apologize but this page, post or resource does not exist or can not be found. Perhaps it is necessary to change the call method to this page, post or resource.' , 'myThemes' ) . '</p>';
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