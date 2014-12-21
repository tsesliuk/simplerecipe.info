<?php
class impro_editor {
	public static function init() {
		global $post;
		
		add_action("admin_print_footer_scripts", array('impro_editor',"do_scripts"));
		add_meta_box('impro_editor_box','Selected image', array('impro_editor','do_output'), 'post', 'side', 'high');
		add_meta_box('impro_editor_box','Selected image', array('impro_editor','do_output'), 'page', 'side', 'high');
		
		/* add plugin for all custom types */
		if ($post) {
			add_meta_box('impro_editor_box', __('Selected image', 'imagepro'), array('impro_editor','do_output'), get_post_type($post->ID), 'side', 'high');
		}
	}
	public static function do_output() {
		/* init view for folder */
		require_once('view/editor.php');	
	}
	public static function do_scripts() {
		echo impro_base::css("/src/view/css/editor.css");
		
		echo impro_base::inlinejs('var imageproEditorL10N = ' . json_encode(array(
			'enableTinyMCE' => __("You must enable the visual editor from your User Profile in order for Image Pro plugin to work", 'imagepro'),
			'differentDomain' => __("This image is from a different remote domain. To be able to resize it, upload the image on this domain!", 'imagepro'),
			'convertToImagePro' => __("This image was inserted through the normal WordPress picture upload. Would you like Image Pro plugin to take care of it's resize and become awesome?", 'imagepro'),
            'uploadNew' => __("Upload files", 'imagepro'),
            'noDrag' => __('You cannot drag images that have a caption or a frame. Please remove the caption and disable the frame, then drag to move it. After that you can add the caption and the frame again. This is a WordPress technical limitation.', 'imagepro')
		)));
		
		echo impro_base::js("/src/js/image.js");
		echo impro_base::js("/src/js/editor.js");
	}

    public static function list_thumbnail_sizes() {
        global $_wp_additional_image_sizes;
        $sizes = array();
        foreach (get_intermediate_image_sizes() as $s) {
            $sizes[$s] = array(0, 0);
            if (in_array($s, array('thumbnail', 'medium', 'large'))) {
                $sizes[$s][0] = get_option($s . '_size_w');
                $sizes[$s][1] = get_option($s . '_size_h');
            } else {
                if (isset($_wp_additional_image_sizes) && isset($_wp_additional_image_sizes[$s]))
                    $sizes[$s] = array($_wp_additional_image_sizes[$s]['width'], $_wp_additional_image_sizes[$s]['height'],);
            }
        }

        $finalSizes = array();
        foreach($sizes as $name => $attrs) {
            if (intval($attrs[0]) >= 30 && intval($attrs[1]) >= 30) {
                $finalSizes[$name] = array(intval($attrs[0]), intval($attrs[1]));
            }
        }

        return $finalSizes;
    }
}