<?php
require_once("../../../../../wp-load.php");
require_once('../../../../../wp-admin/includes/image.php');
require_once('../../../../../wp-includes/post.php');
require_once("../base.php");

if (!current_user_can('edit_posts')) {
	print "Permission error! You must be logged in";
	exit;
}

/* get file contents */
$contents = @file_get_contents('php://input');

/* if empty file, error */
if (strlen($contents) === 0) {
	impro_log::LogError("Error uploading " . $_GET['name'] . ". File empty.");
	impro_base::err(array(
		'str' => __("The file you are trying to upload is empty!", 'imagepro')
	));
}

/* write the file in the corresponding location */
$upload = wp_upload_bits($_GET['name'], NULL, $contents, NULL);

/* if we have an upload error */
if ($upload['error'] !== false) {
	impro_log::LogError("Error uploading " . $_GET['name'] . ". " . $upload['error']);
	impro_base::err(array(
		'str' => $upload['error']
	));
}

$filename = $upload['file'];
$url = $upload['url'];

$filetype = wp_check_filetype($filename, null);

/* prepare the attachment */
$attachment = array(
	'post_mime_type' => $filetype['type'],
	'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
	'post_content' => '',
	'post_status' => 'inherit'
);

/* insert the attachment in the _posts */
$attach_id = wp_insert_attachment($attachment, $filename, 0);

/* if inserting attachment failed, error */
if (!$attach_id) {
	impro_log::LogError("Error uploading " . $_GET['name'] . ". The file was uploaded succesfuly but the attachment could not be added to the posts table");
	impro_base::err(array(
		'str' => __("The file was uploaded succesfully but the attachment could not be added to the posts table", 'imagepro')
	));
}

/* generate the attachment metadata - for images */
$attach_data = wp_generate_attachment_metadata($attach_id, $filename);
wp_update_attachment_metadata($attach_id, $attach_data);

/* return success */
if ($upload['error'] === false) {
	impro_log::LogInfo("New file uploaded. Name: ".$upload['file']." URL: " . $upload['url']. " Attachment ID: ".$attach_id);
	impro_base::ok(array(
		'file' => $upload['file'],
		'url'  => $upload['url'],
		'attach_id' => $attach_id
	));
}
  