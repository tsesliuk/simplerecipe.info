<?php
/*
Plugin Name: Image Pro
Plugin URI: http://www.mihaivalentin.com/image-pro-wordpress-image-management/
Description: WordPress media & images management done right!
Author: Mihai Valentin
Version: 0.35
Author URI: http://www.mihaivalentin.com/
*/

/*  Copyright 2012  Mihai Valentin  (email : http://www.mihaivalentin.com/about-me/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* load external components */
require_once('src/thumb/phpthumb.class.php');
require_once('src/klogger/klogger.php');

/* load plugin classes */
require_once('src/base.php');
require_once('src/log.php');
require_once('src/pathsmanager.php');
require_once('src/paths/default.php');
require_once('src/requirements.php');
require_once('src/folder.php');
require_once('src/editor.php');
require_once('src/thumbs.php');

class impro {

    /* holding the version of the plugin */
    private static $version;

	/**
	 * Initializes the Image Pro plugin
	 */
	public static function init() {
        // frames support - before initializing requirements - necessary for public view
        add_filter('img_caption_shortcode', array('impro', 'provide_frames'), 10, 10);

		/* init browser support */
		impro_requirements::initRequirements();
		
		/* init logging (will be in plugin/logs/impro.log) */
		impro_log::initLogging();

		/* setup the paths */
		impro_paths_manager::initPaths();
			
		/* use the plugin only if in post/page editing and browser is supported */
		if (self::isPostPage() && impro_requirements::isBrowserSupported()) {
			add_action("admin_print_footer_scripts", array('impro',"do_scripts"));
			add_action('add_meta_boxes', array('impro_editor','init'));
			add_action('add_meta_boxes', array('impro_folder','init'));

            add_filter('mce_css', array('impro', 'do_editor_styles'));

			impro_thumbs::init();			
		}

        // TODO perhaps wp_enqueue styles is better?
        add_action('wp_head', array('impro', 'add_styles'));

        /* get version */
        if (!function_exists('get_plugin_data')) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if (function_exists('get_plugin_data')) {
            $pluginData = get_plugin_data(__FILE__, false, false);
            self::$version = $pluginData['Version'];
        } else {
            self::$version = md5(file_get_contents(__FILE__));
        }

        /* initialize internationalization */
        load_plugin_textdomain('imagepro', false, basename(dirname( __FILE__ )) . '/languages');
	}

    public static function add_styles() {
        echo '<link type="text/css" rel="stylesheet" href="' . plugins_url( 'src/editor-styles.css', __FILE__ ) . '" />';
    }

    public static function do_editor_styles($mce_css) {
        if ( ! empty( $mce_css ) ) {
            $mce_css .= ',';
        }

        // TODO investigate whether version string is needed
        $mce_css .= plugins_url( 'src/editor-styles.css', __FILE__ );
        return $mce_css;
    }

	/**
	 * Returns if the current page is "New Post/Page" or "Edit Post/Page"
	 * @return Boolean whether is a new/edit post/page
	 */
	public static function isPostPage() {
		global $pagenow;

        /* if not a post page, don't show */
        if (!in_array($pagenow, array('post.php', 'post-new.php'))) {
            return false;
        }

        /* if post page and editing a post */
        if (isset($_GET['post']) && intval($_GET['post']) > 0) {
            /* get the post id */
            $postId = intval($_GET['post']);
            if (function_exists('get_post_type')) {
                /* get post type */
                $postType = get_post_type($postId);
                /* if it's not an attachment, then it's ok */
                if ('attachment' !== $postType) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }

        return true;
	}
	
	/**
	 * Callback to out script loading tags for the plugin
	 */
	public static function do_scripts() {
		echo impro_base::js("/src/js/impro.js");
		echo impro_base::inlinejs('impro.url = "' . impro::url() . '";');	// set url to javascript
		echo impro_base::inlinejs('impro.admin_url = "' . get_admin_url() . '";');	// set url to javascript
		echo impro_base::inlinejs('impro.nonce.deleteNonce = "' . wp_create_nonce('impro-delete-attachment') . '"');	
	}
	
	/* these two methods should be here, in this dir, otherwise they would not return correctly */
	public static function path() {return WP_PLUGIN_DIR.'/'.dirname(plugin_basename( __FILE__ ));}
	public static function url() {return WP_PLUGIN_URL.'/'.dirname(plugin_basename( __FILE__ ));}

    /* gets the version of the plugin */
    public static function getVersion() { return self::$version; }

    public static function provide_frames($unknown, $attr, $content = null) {
        // New-style shortcode with the caption inside the shortcode with the link and image tags.
        if ( ! isset( $attr['caption'] ) ) {
            if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
                $content = $matches[1];
                $attr['caption'] = trim( $matches[2] );
            }
        }

        $atts = shortcode_atts( array(
            'id'	  => '',
            'align'	  => 'alignnone',
            'width'	  => '',
            'caption' => ''
        ), $attr, 'caption' );

        $atts['width'] = (int) $atts['width'];
        if ( $atts['width'] < 1 || empty( $atts['caption'] ) )
            return $content;

        if ( ! empty( $atts['id'] ) )
            $atts['id'] = 'id="' . esc_attr( $atts['id'] ) . '" ';

        $caption_width = 10 + $atts['width'];

        /**
         * Filter the width of an image's caption.
         *
         * By default, the caption is 10 pixels greater than the width of the image,
         * to prevent post content from running up against a floated image.
         *
         * @since 3.7.0
         *
         * @param int $caption_width Width in pixels. To remove this inline style, return zero.
         * @param array $atts {
         *     The attributes of the caption shortcode.
         *
         *     @type string 'id'      The ID of the div element for the caption.
         *     @type string 'align'   The class name that aligns the caption. Default 'alignnone'.
         *     @type int    'width'   The width of the image being captioned.
         *     @type string 'caption' The image's caption.
         * }
         * @param string $content The image element, possibly wrapped in a hyperlink.
         */
        $caption_width = apply_filters( 'img_caption_shortcode_width', $caption_width, $atts, $content );

        $style = '';
        if ( $caption_width )
            $style = 'style="width: ' . (int) $caption_width . 'px" ';

        if (strpos($content, 'data-imagepro-frames=') !== false) {
            $frameResult = preg_match('/data-imagepro-frames\s*=\s*["\']\s*(imagepro[^"\']+)["\']/i', $content, $frame);
            if ($frameResult && is_array($frame) && 2 <= count($frame)) {
                $atts['align'] .= ' ' . $frame[1];
            }
        }

        return '<div ' . $atts['id'] . $style . 'class="wp-caption ' . esc_attr( $atts['align'] ) . '">'
        . do_shortcode( $content ) . '<p class="wp-caption-text">' . $atts['caption'] . '</p></div>';
    }
}

impro::init();


