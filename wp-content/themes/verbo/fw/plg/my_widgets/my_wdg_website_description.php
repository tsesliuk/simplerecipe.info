<?php
class my_wdg_website_description extends WP_Widget {
    
	function my_wdg_website_description() {
        
        /* INIT CONSTRUCTOR */
        $widget_ops = array(
            'classname' => 'website-description', 
            'description' => __( 'Website description' , 'myThemes' ) 
        );
        
	   $this -> WP_Widget( 'my_wdg_website_description' , myThemes::group() . ' : ' . __( 'Website Description' , 'myThemes' ) , $widget_ops );
    }

    function widget( $args, $instance )
    {
        extract( $args , EXTR_SKIP );

        $title  = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
        $desc   = !empty( $instance[ 'desc' ] ) ? $instance[ 'desc' ] : '';

        echo $before_widget;

        if( !empty( $title ) ){
            echo '<h1><a href="<?php echo home_url(); ?>" title="' . $title . ' ' . $desc . '">' . $title . '</a></h1>';
        }

        if( !empty( $desc ) ){
            echo '<p>' . $desc . '</p>';
        }

        echo $after_widget;
    }

    function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance[ 'title' ] = $new_instance[ 'title' ];
        $instance[ 'desc' ] = $new_instance[ 'desc' ];
        return $instance;
    }

    function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 
            'title' => get_option( 'blogname' ),
            'desc' => get_option( 'blogdescription' )
        ));
        
        $title  = $instance[ 'title' ];
        $desc  = $instance[ 'desc' ];
        
        /* WIDGET TITLE */
        echo '<p>';
        echo '<label for="' . $this -> get_field_id( 'title' ) . '">' . __( 'Title' , 'myThemes' );
        echo '<input type="text" class="widefat" id="' . $this -> get_field_id( 'title' ) . '" name="' . $this -> get_field_name( 'title' ) . '" value="' . $title . '">';
        echo '</label>';
        echo '</p>';

        echo '<p>';
        echo '<label for="' . $this -> get_field_id( 'desc' ) . '">' . __( 'Description' , 'myThemes' );
        echo '<textarea class="widefat" id="' . $this -> get_field_id( 'desc' ) . '" name="' . $this -> get_field_name( 'desc' ) . '">' . $desc . '</textarea>';
        echo '</label>';
        echo '</p>';
        
    }
}
?>