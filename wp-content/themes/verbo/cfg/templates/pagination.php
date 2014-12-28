<?php 
    global  $wp_query;
    $pagination = array(
        'base'          => get_pagenum_link(1) . '%_%',
        'format'        => '?paged=%#%',
        'total'         => $wp_query -> max_num_pages,
        'current'       => max( 1, get_query_var( 'paged' ) ),
        'show_all'      => False,
        'end_size'      => 1,
        'mid_size'      => 2,
        'prev_next'     => True,
        'prev_text'     => __( 'Назад' , 'myThemes' ),
        'next_text'     => __( 'Далее' , 'myThemes' ),
        'type'          => 'list',
        'add_args'      => false,
        'add_fragment'
    );
    
    if( isset( $_GET[ 's' ] ) ){ /* IF IS SEARCH PAGE */
        $pagination[ 'base' ] = '%_%';
        $pagination[ 'format' ] = '?page=%#%';
        $pagination[ 'add_args' ] = array();
        $pagination[ 'add_args' ][ 's' ] = get_query_var( 's' );
    }
    
    $pgn = paginate_links( $pagination );
    
    if( !empty( $pgn ) ){
?>
<div class="row">
    <div class="col-lg-12">
        <div class="pagination aligncenter">
            <nav class="mythemes-nav-inline">
                <?php echo $pgn ?>
            </nav>
        </div>
    </div>
</div>
<?php		
    }
?>