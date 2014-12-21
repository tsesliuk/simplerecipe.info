<?php

class impro_thumbs {
	/**
	 * DO NOT CHANGE THIS AFTER THUMBNAILS HAVE BEEN GENERATED!
	 */
	const GENERATED_FILE = '_f_improf_';
	const GENERATED_DIR  = '_d_improd_';
	
	/**
	 * Init the thumbs generation and retreival module
	 */
	public static function init() {
		/* just before saving the content to DB, modify all /src/thumb/phpThumb.php links to static images */
		add_filter("content_save_pre", array('impro_thumbs', 'do_create_thumbs'));
		/* just before showing in editor, modify all static image files created with phpThumb back to /thumb/src/phpThumb.php */
		add_filter("content_edit_pre", array('impro_thumbs', 'do_get_thumbs'));
	}
	
	/**
	 * Replace the static images generated with phpThumb back to phpThumb urls
	 * @param string $content The content, just after being retreived from the database
	 * @return string the content
	 */
	public static function do_get_thumbs($content) {
		global $post_ID;

		/* Sometimes, in some configurations, this function gets called, but without any
		valid post_ID. In that case, we just return the content */
		if (!$post_ID) {
			return $content;
		}
		
		$content = impro_paths_manager::get()->generateOriginalFilesUrl($content, $post_ID);

		if ($content === impro_base::ERROR) {
			impro_log::displayError("Could not map the paths between the thumbs and the original files!");
		}
		
		return $content;
	}
	
	/**
	 * Create static image files for the exact sizes specified by phpThumb url
	 * @param string $content The content, just before being saved to the database
	 */
	public static function do_create_thumbs($content) {
		global $post_ID;
		
		/* Sometimes, in some configurations, this function gets called, but without any
		valid post_ID. In that case, we just return the content */
		if (!$post_ID) {
			return $content;
		}
		
		/* It seems that content_save_pre is called twice. This prevents doing so */
		remove_filter('content_save_pre', array('impro_thumbs', 'do_create_thumbs'));
		
		/* use a variable to store the old content */
		$newContent = $content;
		
		/* get WordPress upload dir */
		$upload_dir = wp_upload_dir();
		if ($upload_dir['error'] !== false) {
			$upload_dir_error = "wp_upload_dir function (WordPress) returned error! Make sure you have upload dir configured and writable!";
			impro_log::LogError($upload_dir_error);
			impro_log::displayError($upload_dir_error);
		}
		
		/* init phpThumb as class */
		$phpthumb = new imagepro_phpthumb();
		
		/* find images that seem to need resizing */
		preg_match_all('%<img [^>]*src=\\\\?[\'"]/[^>]*>%si', $content, $result, PREG_PATTERN_ORDER);

		impro_log::LogInfo("When saving post id = " . $post_ID . ", " . count($result[0]) . " thumbnails will require processing");
		
		/* if nothing to resize, just return the content */
		if (count($result[0]) === 0) {
			return $content;
		}
		
		/* for each found image that requires to be thumbed */
		for ($i = 0; $i < count($result[0]); $i++) {
			
			$tag = array();
			
			if (preg_match('/ src=\\\\?[\'"]([^\'"\\\\]+)\\\\?[\'"]+/si', $result[0][$i], $regs)) {
				$tag['src'] = $regs[1];
			}			
			if (preg_match('/ width=\\\\?[\'"]([^\'"\\\\]+)\\\\?[\'"]+/si', $result[0][$i], $regs)) {
				$tag['width'] = $regs[1];
			}			
			if (preg_match('/ height=\\\\?[\'"]([^\'"\\\\]+)\\\\?[\'"]+/si', $result[0][$i], $regs)) {
				$tag['height'] = $regs[1];
			}			
			if (preg_match('/ class=\\\\?[\'"]([^\'"\\\\]+)\\\\?[\'"]+/si', $result[0][$i], $regs)) {
				$tag['class'] = $regs[1];
			}			
			if (preg_match('/ alt=\\\\?[\'"]([^\'"\\\\]+)\\\\?[\'"]+/si', $result[0][$i], $regs)) {
				$tag['alt'] = $regs[1];
			}			
			if (preg_match('/ title=\\\\?[\'"]([^\'"\\\\]+)\\\\?[\'"]+/si', $result[0][$i], $regs)) {
				$tag['title'] = $regs[1];
			}
			
			/* if not all required components have been found, next */
			if (!(array_key_exists('src', $tag) && array_key_exists('width', $tag) && array_key_exists('height', $tag))) {
				impro_log::LogWarn("Cannot find src, width and height on tag " . $result[0][$i]. ". Will not process it!");
				continue;
			}
					
			$pathResult = impro_paths_manager::get()->generateThumbPath($tag['src'], $tag['width'], $tag['height'], $post_ID);
			
			if ($pathResult === impro_base::ERROR) {
				impro_log::displayError("Could not map the paths for saving the thumbs!");
			}
			
			$currentFile = $pathResult[0];
			$resizedFile = $pathResult[1];
			
			/* will resize the image if not exists */
			if (!is_file($resizedFile)) {
				impro_log::LogDebug("File " . $resizedFile . " does not exist. Will resize.");
				/* resize it using phpThumb class */
				$phpthumb->setSourceFilename($currentFile);
				$phpthumb->w = $tag['width'];
				$phpthumb->h = $tag['height'];
				$phpthumb->q = 86;
				
				if (strtolower(end(explode('.', $currentFile))) == 'png') {
					$phpthumb->f = 'png';
				}
				
				if ($phpthumb->GenerateThumbnail()) {
					impro_log::LogDebug("Generated the thumbnail in the memory for ".$currentFile);
					if ($phpthumb->RenderToFile($resizedFile)) {
						impro_log::LogDebug("Wrote the thumbnail to disk in ".$resizedFile);
					} else {
						$phpThumbError = "Could not write the thumbnail to disk in ".$resizedFile;
						impro_log::LogError($phpThumbError);
						impro_log::displayError($phpThumbError);
					}
				} else {
					$phpThumbError = "Could not generate the thumbnail for the file. Is the file valid? Is GD PHP module installed?";
					impro_log::LogError($phpThumbError);
					impro_log::displayError($phpThumbError);
				}
								
				$phpthumb->resetObject();
			} else {
				impro_log::LogDebug("File " . $resizedFile . " already exist. Will not resize.");
			}
			
			$urlResult = impro_paths_manager::get()->generateThumbUrl($currentFile, $resizedFile, $post_ID, $tag['src'], $tag['width'], $tag['height']);
			
			if ($urlResult === impro_base::ERROR) {
				impro_log::displayError("Could not map paths so to link the resized image to the resized url");
			}
			
			/* this only replaces urls inside "src" properties 
			in case an error occurs due to mis-matching, do the old
			str_replace (which was the only way until 0.14 */
			$newContentResult = preg_replace('/\s+src\s*=\s*(\\\\"|\\\\\'|"|\')' . preg_quote($tag['src'], '/') . '/si', ' src=$1' . $urlResult, $newContent);
			
			/* somehow regexp replacing failed,
			no problem, we use the classic way (str_replace) */
			if ($newContentResult === null) {
				$newContent = str_replace($tag['src'], $urlResult, $newContent);
			} else {
				$newContent = $newContentResult;
			}
		}
		
		return $newContent;
	}
}

?>