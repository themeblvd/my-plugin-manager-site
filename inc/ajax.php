<?php
/**
 * Include Bootstrap.
 */
require_once( dirname( __FILE__ ) . '/bootstrap.php' );

/**
 * Create a download package.
 */
if ( ! empty( $_POST['action'] ) && 'download' === $_POST['action'] ) {

	$download = new Create_Download( $_POST );

}

die();
