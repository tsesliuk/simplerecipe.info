<?php
header('Content-Type: application/json');

require_once("../../../../../wp-load.php");
require_once("../base.php");

if (!current_user_can('edit_posts')) {
	print "Permission error! You must be logged in";
	exit;
}

/* if no nonce was provided or was incorrect */ 
if (!wp_verify_nonce($_POST['_ajax_nonce'], 'impro-delete-attachment')) {
	impro_base::err(array('msg' => 'Nonce incorrect!'));
}

$post_id = intval($_POST['id']);

/* delete the attachment */
$result = wp_delete_attachment($post_id);

/* return the message */
if ($result === false) {
	impro_log::LogError("Cannot delete the attachment with ID: " . $post_id);
	impro_base::err(array('msg' => __('There was an error removing the attachment. Please try again later.', 'imagepro')));
} else {
	impro_base::ok(array());
}