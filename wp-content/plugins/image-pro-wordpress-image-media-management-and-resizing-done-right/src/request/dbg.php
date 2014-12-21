<?php
require_once("../../../../../wp-load.php");
require_once("../base.php");
require_once("../thumb/phpthumb.class.php");

if (!current_user_can('edit_posts')) {
	print "Permission error! You must be logged in";
	exit;
}

$data = array();

/* doc roots */
$data['SERVER_DOCROOT'] = $_SERVER['DOCUMENT_ROOT'] . ' , readable:' . (is_readable($_SERVER['DOCUMENT_ROOT']) ? 'yes':'no');
$data['SERVER_PHPSELF'] = $_SERVER['PHP_SELF'];
$data['SERVER_SCRIPTNAME'] = $_SERVER['SCRIPT_NAME'];
$data['SERVER_SCRIPTFILENAME'] = $_SERVER['SCRIPT_FILENAME'] . ' , readable:' . (is_readable($_SERVER['SCRIPT_FILENAME']) ? 'yes':'no');;

$data['FALLBACK_DOCROOT'] = str_replace($_SERVER['SCRIPT_NAME'], "", $_SERVER['SCRIPT_FILENAME']) . "/";
$data['FALLBACK_DOCROOT'] .= ' , readable:' . (is_readable($data['FALLBACK_DOCROOT']) ? 'yes':'no');

/* browser */
$data['browser'] = $_SERVER['HTTP_USER_AGENT'];

/* platform */
$data['platform'] = php_uname();

/* php version */
$data['phpversion'] = phpversion();

/* php sapi */
$data['sapi'] = php_sapi_name();

/* error reporting */
$data['errorreporting'] = error_reporting();

/* document root */
$data['file'] = __FILE__;

/* url root */
$data['urlroot'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

/* gd extension */
$data['gdexists'] = extension_loaded("gd");

if ($data['gdexists']) {
    /* gd version */
    $data['gdinfo'] = print_r(gd_info(), true);
}

/* free space */
$data['freespace'] = disk_free_space("/") . " bytes";

/* tmp directory */
$data['tempdir'] = sys_get_temp_dir();

/* is writable tmp directory ? */
$data['writabletempdir'] = is_writable($data['tempdir']);

/* exists apache_lookup_uri ? */
$data['apache_lookup_uri'] = function_exists('apache_lookup_uri');

/* phpthumb cache path */
$data['thumbcache'] = realpath(dirname(__FILE__) . '/../thumb/cache');

/* writable path */
$data['thumbcachewritable'] = is_writable($data['thumbcache']);

$s = "";

/* build text */
foreach ($data as $key => $value) {
    $s.= '= '.$key.' =============================='."\n".$value."\n\n";
}

echo $s;