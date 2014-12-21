<?php

class impro_base {
	
	/* the return error constant. This value is just for unicity */
	const ERROR = '__df_10294536_13245664_0000000__';
	
	
	public static function css($path) {return '<link rel="stylesheet" type="text/css" href="'.impro::url().$path.'?version=' . impro::getVersion().'" />';}
	public static function js($path) {return '<script type="text/javascript" language="javascript" src="'.impro::url().$path.'?version=' . impro::getVersion().'"></script>';}
	public static function inlinejs($js) {return '<script type="text/javascript" language="javascript">'.$js.'</script>';}
	
	public static function docroot() {return realpath((getenv('DOCUMENT_ROOT') && ereg('^'.preg_quote(realpath(getenv('DOCUMENT_ROOT'))), realpath(__FILE__))) ? getenv('DOCUMENT_ROOT') : str_replace(dirname(@$_SERVER['PHP_SELF']), '', str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__))));}
	
	/* prepare ok message */
	public static function ok($arr, $more = NULL) {
		echo json_encode(array(
			'ok' => true,
			'data' => $arr,
			'more' => $more		
		));
		exit;
	}
	
	/* prepare error message */
	public static function err($arr, $more = NULL) {
		echo json_encode(array(
			'ok' => false,
			'data' => $arr,
			'more' => $more		
		));
		exit;
	}
}