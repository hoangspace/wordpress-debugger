<?php

global $wp_filesystem;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

include_once ABSPATH . 'wp-admin/includes/file.php';

/**
 * Class Logger is responsible for logging operations
 */
class Logger {

	public $active;
    public $logId;
	private $logfile;

    function __construct($id = "wpdebug_log"){
        $this->logId = $id;
    }
	/**
	 * @param $dir
	 */
	function init( $dir = null ) {
		global $wp_filesystem;

        if (empty($dir)){
			$wp_upload_dir = wp_upload_dir();
			$dir = $wp_upload_dir['basedir'];
        }
		$this->active = true;
		$this->logfile = trailingslashit( $dir ) . $this->logId . '.log';

		// init environment
		if ( ! file_exists( $this->logfile ) ) {
			WP_Filesystem();
			if ( method_exists( $wp_filesystem, 'put_contents' ) ) {
				if ( ! $wp_filesystem->put_contents( $this->logfile, '' ) ) {
					$this->active = false;
				}
			}
		}

		// after determining whether we can write to the logfile, add our action
		if ( $this->active ) {
			add_action( $this->logId, array( $this, 'log' ), 1, 2 );
		}
	}

	/**
	 * @param string $message
	 * @param string $type
	 *
	 * @return bool
	 */
	function log( $message = '', $type = 'INFO' ) {
		global $wp_filesystem;
		WP_Filesystem();

		// if we're not active, don't do anything
		if ( ! $this->active || ! file_exists( $this->logfile ) ) {
			return false;
		}

		if ( ! method_exists( $wp_filesystem, 'get_contents' ) ) {
			return false;
		}

		if ( ! method_exists( $wp_filesystem, 'put_contents' ) ) {
			return false;
		}

		// get the existing log
		$existing = $wp_filesystem->get_contents( $this->logfile );

		// format our entry
		$entry = '[' . date( 'Y-d-m G:i:s', current_time( 'timestamp' ) ) . '][' . $type . ']';

		// flag it with the process ID
		$entry .= '[' . SearchWP::instance()->get_pid() . ']';

		// finally append the message
		$entry .= ' ' . $message;

		// append the entry
		$log = $existing . "\n" . $entry;

		// write log
		$wp_filesystem->put_contents( $this->logfile, $log );

		return true;
	}

}
