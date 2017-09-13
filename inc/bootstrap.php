<?php
/*
 * Define global constants.
 */

define( 'PROJECT_DEBUG', false ); // Use FALSE for production.

define( 'PROJECT_PATH', str_replace( '/inc', '', dirname( __FILE__ ) ) );

/**
 * Include functions for initiating the website and
 * determing which page should show.
 */
require_once( PROJECT_PATH . '/inc/functions-init.php' );

/**
 * Include download helper functions.
 */
require_once( PROJECT_PATH . '/inc/functions-download.php' );

/**
 * Include template functions.
 */
require_once( PROJECT_PATH . '/inc/functions-template.php' );

/**
 * Include content blocks.
 */
require_once( PROJECT_PATH . '/inc/functions-blocks.php' );

/**
 * Include class to create a download package.
 */
require_once( PROJECT_PATH . '/inc/class-create-download.php' );

/**
 * Include class to serve and delete a temporary download
 * package.
 */
require_once( PROJECT_PATH . '/inc/class-serve-download.php' );
