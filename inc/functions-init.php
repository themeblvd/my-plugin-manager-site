<?php
/**
 * Initiate the site, determine the current page to
 * display and set the global template attributes.
 */
function site_init() {

	$pages = array( 'home', 'about', 'faq', 'docs' );

	$page = '';

	// Parse development URL like `/?page=foo`.
	if ( ! empty( $_GET['page'] ) ) {
		$page = $_GET['page'];
	}

	/*
	 * If we're not debugging, and the URL was as a
	 * dev URL, forward to a production URL.
	 */
	if ( $page && ! PROJECT_DEBUG ) {

		$url = get_site_url();

		header( "Location: {$url}/{$page}" ) ;

	}

	// Parse standard URL like `/foo`.
	if ( ! $page ) {

		$uri = rtrim( $_SERVER['REQUEST_URI'], '/' );

		$uri = explode( '/', $uri );

		$page = end( $uri );

	}

	// Verify page and include main template.
	if ( ! $page ) {
		$page = 'home';
	}

	if ( ! in_array( $page, $pages ) ) {
		$page = '404';
	}

	// if ( ! empty( $_GET['page'] ) ) {
	// 	$page = $_GET['page'];
	// }

	include_template( get_page_args( $page ) );

}

/**
 * Generate site arguments that we'll use to buld the
 * current page.
 *
 * @param  string $page Slug of the current page to display.
 * @return array  $args Arguments to pass to template functions.
 */
function get_page_args( $page ) {

	$args = array(
		'slug'      => $page,
		'title_tag' => '',
		'meta_desc' => '',
		'title'     => '',
	);

	switch ( $page ) {

		case 'about':
			$args['title_tag'] = 'About';
			$args['meta_desc'] = '';
			$args['title'] = 'About';
			break;

		case 'faq':
			$args['title_tag'] = 'Frequently Asked Questions';
			$args['meta_desc'] = '';
			$args['title'] = 'Frequently Asked Questions';
			break;

		case 'docs':
			$args['title_tag'] = 'Documentation';
			$args['meta_desc'] = '';
			$args['title'] = 'Documentation';
			break;

		case 'home':
			$args['title_tag'] = 'WordPress Plugin Dependency Manager';
			$args['meta_desc'] = '';
			$args['title'] = 'Homepage';
			break;

		default:
			$args['title_tag'] = '404 - Page not found.';
			$args['title'] = 'Oops! Page Not Found';

	}

	return $args;

}
