<?php
class impro_default_paths {
	
	/**
	 * Called by the folder panel to create the thumbs of the resources
	 * 
	 * @param int $id
	 * @param string $name
	 * @param string $path
	 * @param string $url
	 * @param int $size
	 * @param string $type
	 * @param string $ext
	 * @return string the url of the thumb
	 */
	public function generateFolderThumbUrl($id, $name, $path, $url, $size, $type, $ext) {				
		/* build the phpThumb url */
		$thumb = impro::url()."/src/thumb/phpThumb.php?w=80&h=60&src=";
		
		/* if pictures, show their thumbnail */
		if (in_array($ext, array('jpg','jpeg','gif','png'))) {
			$resource = parse_url($url, PHP_URL_PATH);
			$thumb .= $resource;
		} else {	/* if not, just their file type icon */
			$icon = parse_url(impro::url() . "/src/view/img/" . $ext . ".png", PHP_URL_PATH);
			$thumb .= $icon;
		}

		return $thumb;
	}
	
	/** 
	 * Based on the full url, we will create the paths for the thumbs
	 * 
	 * @param string $src the source, relative to docroot path
	 * @param int $width the width to which the thumb should be resized
	 * @param int $height the height to which the thumb should be resized
	 * @param int $post_ID the post id for which the thumbnails should be generated
	 * @return [currentFile, resizedFile]
	 */
	public function generateThumbPath($src, $width, $height, $post_ID) {
		/* hint the path. it's ussually like this */
		$currentFile = realpath(ABSPATH . $src);
		
		/* if it was not hinted, perhaps it's because wordpress it's in a dir */
		if (!is_file($currentFile)) {
			impro_log::LogWarn("Could not hint file system path for src = " . $src . " => " . $currentFile . ". Trying up one level.");
			$upOneLevel = realpath(ABSPATH . "/../" . $src);
			
			/* try hinting on up one level */
			if (!is_file($upOneLevel)) {
				impro_log::LogWarn("Could not hint file system path for src = " . $src . " => " . $upOneLevel . ". Trying up one level.");
				$upOneLevel = realpath(ABSPATH . "/../../" . $src);
				
				/* try hinting even up one level */
				if (!is_file($upOneLevel)) {
					impro_log::LogError("Could not get the file system path for src = " . $src . " => " . $upOneLevel);
					return impro_base::ERROR;	/* can't do anything now. user should fix this error */
				} else {
					$currentFile = $upOneLevel;
					impro_log::LogDebug("Succesfully hinted path (up two levels though) for src = " . $src . " => " . $currentFile);
				}			
			} else {
				$currentFile = $upOneLevel;
				impro_log::LogDebug("Succesfully hinted path (up one level though) for src = " . $src . " => " . $currentFile);
			}
		} else {
			impro_log::LogDebug("Succesfully hinted path for src = " . $src . " => " . $currentFile);
		}
			
		/* make sure the directory for writing thumbs exists */
		$dir = dirname($currentFile);
		
		/* the name of the thumbs dir */
		$thumbDir = $dir . "/" . impro_thumbs::GENERATED_DIR;

		/* check thumbs dir if exists and create it if not */
		if (is_dir($thumbDir)) {
			impro_log::LogDebug("Directory " . $thumbDir . " exists");			
		} else {
			impro_log::LogWarn("Directory " . $thumbDir . " does not exist! Will attempt to create it!");
			if (@mkdir($thumbDir)) {	/* attempting to create the dir */
				impro_log::LogInfo("Directory " . $thumbDir . " has been created succesfully!");
			} else {
				impro_log::LogError("Could not create " . $thumbDir . "! Make sure it's parent directory has the neccessary permissions (try make it 777)");
				return impro_base::ERROR; /* can't do anything now. user should fix this error */
			}
		}
		
		/* check thumbs dir if writable and create it if not */
		if (is_writable($thumbDir)) {
			impro_log::LogDebug("Directory " . $thumbDir . " is writable");
		} else {
			impro_log::LogError("Directory " . $thumbDir . " is not writable! Make sure it has write permissions (for example 777)");
			return impro_base::ERROR;	/* can't do anything now. user should fix this error */
		}
	
		/* get file path info */
		$fileinfo = pathinfo($currentFile);
		
		/* build resizedFile */
		$resizedFile = $thumbDir . "/" . $fileinfo['filename'].impro_thumbs::GENERATED_FILE.$width.'x'.$height.'.'.$fileinfo['extension'];
		impro_log::LogDebug("Resized file name will be " . $resizedFile);
		
		return array($currentFile, $resizedFile);
	}
	
	/**
	 * Get the url of the resized thumbnail file
	 * 
	 * @param string $originalFile the file path of the original file
	 * @param string $resizedFile the file path of the resized file
	 * @param int $post_ID
	 * @param string $original_src
	 * @param int $width
	 * @param int $height
	 * @return string the url of the resized file
	 */
	public function generateThumbUrl($originalFile, $resizedFile, $post_ID, $original_src, $width, $height) {	
		$url = impro_paths_manager::normalizePath($resizedFile);
		$pos = strpos($url, dirname($original_src));		
		$url = substr($url, $pos);
		return $url;
	}
	
	/**
	 * Get the original files url from the thumbnails url
	 * 
	 * @param string $content the content
	 * @param int $post_ID
	 */
	public function generateOriginalFilesUrl($content, $post_ID) {
		/* it is really simple. just replace the thumbnails strings */
		
		$count = 0;
		
		$content = str_replace(impro_thumbs::GENERATED_DIR . "/", "", $content, $count);
		$content = preg_replace('/' . preg_quote(impro_thumbs::GENERATED_FILE) . '[0-9]+x[0-9]+/si', '', $content);
		
		impro_log::LogInfo("When loading post id = " . $post_ID . ", " . $count . " thumbnails where found");
		
		return $content;
	}
}