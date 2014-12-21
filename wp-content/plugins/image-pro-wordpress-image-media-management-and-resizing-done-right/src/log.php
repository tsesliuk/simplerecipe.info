<?php
class impro_log {
	private static $log;
	
	/**
	 * Output errors. Contains last log entries and some description
	 * 
	 * @param string $str error information
	 */
	public static function displayError($str) {
		echo "<pre><strong>There has been an error in ImagePro</strong>";
		echo "\n\n" . $str . "\n\n";
		
		$logFile = impro::path() . "/logs/impro.log";
		
		/* open the log file and get the last lines */
		$logFileHandle = fopen($logFile, "r");
		$logFileSize = filesize($logFile);		
		$seek = ($logFileSize < 1000 ? $logFileSize : 1000);		
		fseek($logFileHandle, -$seek, SEEK_END);		
		$log = fread($logFileHandle, $seek);
		$pos = strpos($log, "\n");
		if ($pos !== false) {
			$log = substr($log, $pos);
		}		
		fclose($logFileHandle);
		
		echo $log;	
		
		echo "\nFor more information please see the log at " . impro::path() . "/logs/impro.log";
		echo "</pre>";
		exit;
	}
	
	public static function initLogging() {
		self::$log = new impro_klogger(impro::path().'/logs/impro.log', impro_klogger::DEBUG);
		add_action('admin_notices', array('impro_log', 'admin_notices'));
	}
		
	public static function admin_notices() {
		if (self::$log->Log_Status === impro_klogger::OPEN_FAILED) {
			echo '<div class="error">The log file <em>'.impro::path().'/logs/impro.log'.'</em> could not be opened for writing. The plugin will work, but in case of any errors, there will be no log file available! <strong>Please make sure both the file and log directory have write permissions!</strong></div>';
		}
	}
	
	public static function LogWarn($s) {
		self::$log->LogWarn($s);
	}
	
	public static function LogError($s) {
		self::$log->LogError($s);
	}
	
	public static function LogDebug($s) {
		self::$log->LogDebug($s);
	}
	
	public static function LogInfo($s) {
		self::$log->LogInfo($s);
	}
}