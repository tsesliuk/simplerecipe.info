<?php
header('Content-Type: application/json');

require_once("../../../../../wp-load.php");
require_once("../base.php");

if (!current_user_can('edit_posts')) {
	print "Permission error! You must be logged in";
	exit;
}

/* if queried by attachment id */
if (intval($_REQUEST['id']) > 0) {
	$post = get_post(intval($_REQUEST['id']));
	$post->attachment_url = wp_get_attachment_url(intval($_REQUEST['id']));
	echo json_encode($post);
	exit;
}