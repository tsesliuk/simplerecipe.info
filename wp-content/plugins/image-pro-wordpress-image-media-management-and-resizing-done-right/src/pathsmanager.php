<?php
class impro_paths_manager {
	private static $pathManager = null;
	
	public static function initPaths() {
		self::$pathManager = new impro_default_paths(); 
	}
	
	/**
	 * Gets the current path manager
	 * @return impro_path_manager the current path manager
	 */
	public static function get() {
		return self::$pathManager;
	}
	
	/**
	 * Whether the path given is a Windows path or not
	 * @param string $path
	 * @return boolean is a path or not?
	 */
	public static function isWindowsPath($path) {
		if (false !== strpos($path, ':')) {
			return is_dir(substr($path, 0, 2));
		} else {
			return false;
		}
	}
	
	/**
	 * Normalize path
	 * Converts \ to / for Windows paths. For Linux, does nothing, as \ is permitted to be inside a path
	 * @param string $path
	 * @return string normalized path
	 */
	public static function normalizePath($path) {
		if (self::isWindowsPath($path)) {
			$path = str_replace('\\', '/', $path);
		}
		return $path;
	}
}