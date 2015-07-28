<?php

if ( ! class_exists('WPLA_Logger') ) :

class WPLA_Logger{

	var $file;
	var $strdate;
	var $level = array('debug'=>7,'info'=>6,'notice'=>5,'warn'=>4,'critical'=>3,'error'=>2);

	var $timer_start      = array();
	var $accumulated_time = array();

	function __construct($file = false){

		if ( ! defined('WPLA_DEBUG') ) return;

		// build logfile path
		$uploads = wp_upload_dir();
		$uploaddir = $uploads['basedir'];
		$logdir = $uploaddir . '/wp-lister';
		$logfile = $logdir.'/wpla.log';

		if ( WPLA_DEBUG == '' ) {
			// remove logfile when logging is disabled
			if ( file_exists($logfile) ) unlink( $logfile );
		} else {

			if ( $file ) {
				$this->file = $file;
			} else {
				// make sure logfile exists
				if ( !is_dir($logdir) ) mkdir($logdir);
				if ( !file_exists($logfile) ) touch($logfile);
				$this->file = $logfile;
			}
			$this->strdate = 'Y/m/d H:i:s';
			// $this->debug('Start Session:'.print_r($_SERVER,1));
			
			$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
			if ( $action == 'heartbeat' ) return;
			if ( $action == 'wpla_tail_log' ) return;
			if ( $action == 'wplister_tail_log' ) return;

			// $this->debug('Start Session:'.print_r($_SERVER,1));
			// only log request for admin pages or post requests
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' || is_admin() ) {
				$this->info( 
					$_SERVER['REQUEST_METHOD'] . ': ' . 
					$_SERVER['QUERY_STRING'] . ' - ' . 
					( isset( $_POST['action'] ) ? $_POST['action'] : '' ) .' - '. 
					( isset( $_POST['do'] ) ? $_POST['do'] : '' )  
				);
			}

		}

	} // __contruct()

	function log($level=debug,$msg=false){
		//If debug is not on, then don't log
		if(defined('WPLA_DEBUG')){
			if(WPLA_DEBUG >= $this->level[$level]){
				return error_log('['.date($this->strdate).'] '.strtoupper($level).' '.$msg."\n",3,$this->file);
			}
		}
	}

	function debug($msg=false){
		return $this->log('debug',$msg);
	}

	function info($msg=false){
		return $this->log('info',$msg);
	}

	function notice($msg=false){
		return $this->log('notice',$msg);
	}

	function warn($msg=false){
		return $this->log('warn',$msg);
	}

	function critical($msg=false){
		return $this->log('critical',$msg);
	}

	function error($msg=false){
		return $this->log('error',$msg);
	}


	function start($key){
		$this->timer_start[$key] = microtime(true) * 1000;
	}

	function logTime($key){
		$now  = microtime(true) * 1000;
		$msec = round( $now - $this->timer_start[$key], 3 );
		$this->debug("*** It took $msec ms to process '$key'");
	}

	function startTimer($key){
		$this->timer_start[$key] = microtime(true) * 1000;
	}
	function endTimer($key){
		$now  = microtime(true) * 1000;
		$msec = $now - $this->timer_start[$key];
		if ( ! isset( $this->accumulated_time[$key] ) ) $this->accumulated_time[$key] = 0;
		$this->accumulated_time[$key] += $msec;
	}
	function logSpentTime($key){
		if ( ! isset( $this->accumulated_time[$key] ) ) return;
		$msec = round( $this->accumulated_time[$key], 3 );
		$this->debug("*** I spent $msec ms in total to '$key'");
	}


	// custom call stack trace
	// usage: WPLA()->logger->callStack( debug_backtrace() );
    function callStack($stacktrace) {
        $this->info( str_repeat("=", 50) );
        $i = 1;
        foreach($stacktrace as $node) {
            $this->info( "$i. ".basename($node['file']) .":" .$node['function'] ."(" .$node['line'].")" );
            $i++;
        }
        $this->info( str_repeat("=", 50) );
    } 

}

endif;
