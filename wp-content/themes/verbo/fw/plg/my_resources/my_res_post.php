<?php
class my_res_post
{
    static function run()
    {
        if( empty( myThemes_acfg::$res[ 'post' ] ) || !is_array( myThemes_acfg::$res[ 'post' ] ) ){
            return null;
        }

        foreach( myThemes_acfg::$res[ 'post' ] as $slug => & $d ){
            if( isset( $d[ 'noregister' ] ) && $d[ 'noregister' ] ){
                /* IF NOT REGISTER CUSTOM POST  */
            }
            else{
                /* LABELS FOR ADMIN SIDE */
                $labels = array(
                    'name' => _x( $d[ 'pluralTitle' ] , 'post type general name' ),
                    'singular_name' => _x( $d[ 'singularTitle' ] , 'post type singular name' ),
                    'add_new' => _x( 'Add new ' . $d[ 'singularTitle' ] , $d[ 'singularTitle' ] ),
                    'add_new_item' => __( 'Add new' , 'myThemes' ) . ' ' . $d[ 'singularTitle' ],
                    'edit_item' => __( 'Edit ', 'myThemes' ) . ' ' . $d[ 'singularTitle' ],
                    'new_item' => __( 'New ', 'myThemes' ) . ' ' . $d[ 'singularTitle' ],
                    'view_item' => __( 'View ', 'myThemes' ) . ' ' . $d[ 'singularTitle' ],
                    'search_items' =>  __( 'Search ', 'myThemes' ) . ' ' . $d[ 'singularTitle' ],
                    'not_found' =>  __( 'Nothing found' , 'myThemes' ),
                    'not_found_in_trash' => __( 'Nothing found in Trash' , 'myThemes' )
                );
                

                if( isset( $d[ 'fields' ] ) && is_array( $d[ 'fields' ] ) && !empty( $d[ 'fields' ] ) ){
                    $fields = $d[ 'fields' ];
                }else{
                    /* DEAFULT LIST WITH FIELDS */
                    $fields = array( 'title' , 'editor' , 'excerpt' , 'comments' , 'thumbnail' );
                }

                $args = array(
                    'public' => true,
                    'hierarchical' => false,
                    'menu_position' => 5,
                    'supports' => $fields,
                    'labels' => $labels
                );

                /* REGISTER CUSTOM POST */
                register_post_type( $slug , $args );
            }
        }
    }
}
?>