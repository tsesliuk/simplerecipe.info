<?php

/**
 * This class takes care of the browser support required for ImagePro
 */
class impro_requirements {
	/**
	 * Wether the browser is supported. Currently only Firefox 4+, Safari 5+ and Chrome
	 * 
     * @return boolean
	 */
	public static function isBrowserSupported() {
		$ua = $_SERVER['HTTP_USER_AGENT'];

        // check for Firefox and Webkit (Chrome, Safari etc)
		$compatible = stripos($ua, "firefox") > 0 || stripos($ua, "webkit") > 0;

        // if not compatible then check for IE >= 10
        if (!$compatible) {
            // if it is ie 10
            if (stripos($ua, "msie 10") > 0) {
                $compatible = true;
            }
            // if it is >= ie 11, where the user agent string has changed
            // http://msdn.microsoft.com/library/ms537503.aspx
            if (stripos($ua, "trident") > 0 && preg_match('/rv:[0-9][0-9]/i', $ua)) {
                $compatible = true;
            }
        }

		return $compatible;
	}
	
	/**
	 * Gets the memory limit
	 * 
	 * @return boolean|int Returns false if cannot get it, -1 if unlimited and the actual limit in bytes if defined
	 */
	public static function getMemoryLimit() {			
		/* get the memory limits from two possible places */
		$ini = ini_get('memory_limit');
		$cfg = get_cfg_var('memory_limit');
		
		$use = null;
		
		if ($ini === false || intval($ini) === 0) {
			if ($cfg === false || intval($cfg) === 0) {
				return false;
			} else {
				$use = $ini;
			}
		} else {
			$use = $ini;
		}
		
		if ($use === -1) {
			return $use;
		}
		
	    $val = trim($use);
	    $last = strtolower($val[strlen($val)-1]);
	    switch($last) {
	        // The 'G' modifier is available since PHP 5.1.0
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }

		return $val;		
	}
	
	/**
	 * Shows an error message if user is not using firefox or chrome
	 */
	public static function initRequirements() {
		add_action('admin_notices', array('impro_requirements', 'admin_notices'));
	}
	
	/**
	 * Shows the user he has an unsupported browser
	 */
	public static function admin_notices() {
		/* check if browser is supported */
		if (!self::isBrowserSupported()) {
			echo __('<div class="error">
				<strong>ImagePro plugin cannot run on this browser!</strong><br/>
				ImagePro currently supports Internet Explorer 10+, Firefox, Chrome, Safari.<br/>
				The plugin is currently <strong>NOT WORKING</strong>. Use one of the browsers suggested!
			</div>', 'imagepro');
		}
		
		/* check if memory limit defined */
		if (self::getMemoryLimit() === false) {
			echo __('<div class="error">
				<strong>Cannot get the memory limit!</strong>
				ImagePro is unable to determine your memory limit. It seems it is not defined. If you\'ll experience errors when resizing large images, perhaps it\'s because you should have such memory limit defined!
			</div>', 'imagepro');
		}
		
		/* warn if memory limit is low */
		if (self::getMemoryLimit() < 30 * 1024 * 1024) {
			$limit = self::getMemoryLimit();
			
			if (function_exists('memory_get_usage')) {
				$limit -= memory_get_usage();	
			}
			
			$limit -= 3000000;	// don't fill up everything
			$limit = intval(sqrt($limit / 4));	// 4 = r g b a
			
			echo sprintf(__('<div class="error">
				<strong>Low memory limit!</strong>
				ImagePro requires memory to perform image resizing. <br/>
				Large images such as 2600x2000 pixels will not be resized. You will only be able to resize pictures of maximum resolution %sx%s. Please increase your memory limit!
			</div>', 'imagepro'), $limit, $limit);
		}
	}
}

?>