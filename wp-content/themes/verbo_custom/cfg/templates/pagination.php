<?php
    global  $wp_query;

    $big = 999999999; // need an unlikely integer
    $pagination = array(
        'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'        => '?paged=%#%',
        'total'         => $wp_query -> max_num_pages,
        'current'       => max( 1, get_query_var( 'paged' ) ),
        'show_all'      => False,
        'end_size'      => 1,
        'mid_size'      => 2,
        'prev_next'     => True,
        'prev_text'     => __( 'Предыдущие' , 'myThemes' ),
        'next_text'     => __( 'Следующие' , 'myThemes' ),
        'type'          => 'list',
        'add_args'      => false,
        'add_fragment'
    );

    $pgn = paginate_links( $pagination );

    if( !empty( $pgn ) ){
?>
<div class="row">
    <div class="col-lg-12">
        <div class="pagination aligncenter">
            <nav class="mythemes-nav-inline">
                <?php echo $pgn; ?>
            </nav>
        </div>
    </div>
</div>
<?php
    }
?>