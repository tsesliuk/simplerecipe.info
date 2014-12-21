<?php
require_once("../../../../../wp-load.php");
require_once("../base.php");

if (!current_user_can('edit_posts')) {
	print "Permission error! You must be logged in";
	exit;
}

/* get parameters */
$filetype = $_GET['filetype'];
$search   = $_GET['search'];

/* query the attachments */
$query = new WP_Query(array(
	'post_type' => 'attachment',
	'post_status' => 'inherit',
	'posts_per_page' => 1000000,
	's' => $search,
	'post_mime_type' => $filetype,
	'suppress_filters' => true
));

$attachments = array();

/* build attachments array */
while($query->have_posts()):
	$query->the_post();
	
	$id = get_the_ID();
	$name = get_the_title();
	$path = get_attached_file($id);
	$url = wp_get_attachment_url($id);
	$size = @filesize($path);
	$type = wp_check_filetype($path);
	$ext = strtolower($type['ext']);
		
	$thumb = impro_paths_manager::get()->generateFolderThumbUrl($id, $name, $path, $url, $size, $type, $ext);
		
	$attachments[] = array(
		"id" => $id,
		"name" => $name,
		//"size" => $size, // not needed for now
		"ext" => $ext,
		//"url" => $url, // not needed for now
		"thumb" => $thumb
	);
	
endwhile;

/* output as json */
header('Content-Type: application/json');
echo json_encode(array(
    'ok' => true,
    'data' => $attachments
));
exit;