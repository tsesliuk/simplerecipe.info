<?php
    class header{

        static function setup()
        {
            $args = array(
                'default-image'          => get_template_directory_uri() . '/media/img/header.jpg',
                'random-default'         => true,
                'flex-height'            => false,
                'flex-width'             => true,
                'default-text-color'     => 'ffffff',
                'header-text'            => true,
                'uploads'                => true,
                'wp-head-callback'       => array( 'header' , 'custom_style' ),
                'admin-head-callback'    => array( 'header' , 'admin' ),
                'admin-preview-callback' => array( 'header' , 'preview' )
            );

            add_theme_support( 'custom-header', $args );
        }

        static function preview()
        {
            get_template_part( 'cfg/templates/header' );
        }

        static function admin()
        {
            ?>
                <style>
                   
                    div.mythemes-header .valign-cell h1{
                        color: <?php echo get_header_textcolor(); ?>;
                    }
                    div.mythemes-header .valign-cell p{
                        color: rgba(<?php echo mythemes_hex2rgb( get_header_textcolor() ); ?> , 0.65 );
                    }
                    div.mythemes-header .valign-cell p.buttons a.btn{
                        background: <?php echo myThemes::get( 'first-color' ); ?>
                    }
                    div.mythemes-header .valign-cell p.buttons a.btn.second-button{
                        background: <?php echo myThemes::get( 'second-color' ); ?>
                    }
                </style>
            <?php
            wp_enqueue_style( 'effects', get_template_directory_uri() . '/media/css/effects.css' );
            wp_enqueue_style( 'header', get_template_directory_uri() . '/media/css/header.css' );
        }

        static function custom_style(){
            get_template_part( 'cfg/templates/custom-style' );
        }
    }
?>