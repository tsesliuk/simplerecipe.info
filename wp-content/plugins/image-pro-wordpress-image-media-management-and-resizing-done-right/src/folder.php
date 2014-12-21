<?php
class impro_folder {
	public static function init() {
		global $post;
		
		/* init meta box for post and page */
		add_meta_box('impro_folder_box', __('Available images', 'imagepro'), array('impro_folder','do_output'), 'post', 'normal');
		add_meta_box('impro_folder_box', __('Available images', 'imagepro'), array('impro_folder','do_output'), 'page', 'normal');
		
		/* add plugin for all custom types */
		if ($post) {
			add_meta_box('impro_folder_box', __('Available images', 'imagepro'), array('impro_folder','do_output'), get_post_type($post->ID), 'normal');
		}
		
		add_action("admin_print_footer_scripts", array('impro_folder',"do_scripts"));
	}
	public static function do_output() {
		/* init view for folder */
		require_once('view/folder.php');	
	}
	public static function do_scripts() {  
		echo impro_base::css("/src/view/css/folder.css"); 
		echo impro_base::js("/src/js/dragdropupload.js");
		
		echo impro_base::inlinejs('var imageproFolderL10N = ' . json_encode(array(
			'popupOpenError' => __("The pop-up window containing the attachment could not be opened! Make sure you do not have a popup-blocker active!", 'imagepro'),
			'attachmentLink' => __('The box below contains the full link of the attachment. You can press CTRL + C (or Command + C on Mac) to copy it to the clipboard.\n\nPress OK or Cancel to continue.', 'imagepro'),
			'deleteAttachmentConfirmation' => __("Are you sure you want to delete this attachment?\n\nBE AWARE THAT IF IT IS ADDED TO ANOTHER POST, REMOVING IT WILL REMOVE IT FROM THERE TOO!\n\nHowever, if you would like to recover it, you can at any time restore it from the \"Trash\".", 'imagepro')
		)));
		
		echo impro_base::js("/src/js/folder.js");
	}
}