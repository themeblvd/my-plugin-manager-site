<?php
/**
 * Includes template parts and content.
 *
 * @param array $args Arguments passed to global $_template_vars.
 */
function include_template( $args = array() ) {

	$args = array_merge( array(
		'slug'      => '',
		'title_tag' => '',
		'meta_desc' => '',
		'title'     => '',
		'content'   => '',
	), $args );

	// Build content for the page.
	ob_start();

	require_once( get_content_part( $args['slug'] ) );

	$args['content'] = ob_get_clean();

	// Store global template vars.
	foreach ( $args as $key => $value ) {
		set_template_var( $key, $value );
	}

	// Determine top-level template.
	if ( 'home' === $args['slug'] ) {
		$template = 'home';
	} else {
		$template = 'page';
	}

	/**
	 * Include top-level template file so we can store
	 * its content to the output buffer.
	 */
	require_once( PROJECT_PATH . "/inc/partials/templates/{$template}.php" );

	$output = ob_get_clean();

	// Compress content.
	if ( ! PROJECT_DEBUG ) {
		$output = str_replace( array( "\n", "\t" ), '', $output );
	}

	// Print content.
	echo $output;

}

/**
 * Set template variable.
 *
 * @uses global $_template_vars
 *
 * @param  string $key   Template variable key.
 * @return string $value Template variable value.
 */
function set_template_var( $key, $value ) {

	global $_template_vars;

	if ( empty( $_template_vars ) ) {
		$_template_vars = array();
	}

	$_template_vars[ $key ] = $value;

}

/**
 * Get template variable.
 *
 * @uses global $_template_vars
 *
 * @param  string $key   Template variable key.
 * @return string $value Template variable value.
 */
function get_template_var( $key ) {

	global $_template_vars;

	$value = '';

	if ( isset( $_template_vars[ $key ] ) ) {
		$value = $_template_vars[ $key ];
	}

	return $value;

}

/**
 * Get the absolute path to the file holding the
 * content for a given page.
 *
 * @param  string $slug Slug of current page.
 * @return string       Path to content template.
 */
function get_content_part( $slug ) {

	$template = PROJECT_PATH . '/inc/partials/content/' . $slug . '.php';

	if ( file_exists( $template ) ) {

		return $template;

	}

	return PROJECT_PATH . '/inc/partials/content/404.php';

}

/**
 * Get website header.
 */
function get_header() {

	/**
	 * Include site-wide header.
	 */
	include( PROJECT_PATH . '/inc/partials/templates/header.php' );

}

/**
 * Get website footers.
 */
function get_footer() {

	/**
	 * Include site-wide footer.
	 */
	include( PROJECT_PATH . '/inc/partials/templates/footer.php' );

}

/**
 * Get the title tag.
 *
 * @return string $title Title used with <title>.
 */
function get_title_tag() {

	$title = get_template_var( 'title_tag' );

	if ( $title ) {
		$title .= ' | ' . 'My Plugin Manager';
	}

	return $title;

}

/**
 * Display the title tag.
 */
function title_tag() {

	echo get_title_tag();

}

/**
 * Get URL to website.
 *
 * @param  string $local Optional. Path to local URL to add to site url.
 * @return string $url   Final full url to page of site.
 */
function get_site_url( $path = '' ) {

	$protocol = 'http';

	if ( isset( $_SERVER['HTTPS'] ) ) {

		if ( 'on' == strtolower( $_SERVER['HTTPS'] ) ) {
			$protocol = 'https';
		}

		if ( '1' == $_SERVER['HTTPS'] ) {
			$protocol = 'https';
		}
	} elseif ( isset($_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		$protocol = 'https';
	}

	$url = $protocol . '://' . $_SERVER['HTTP_HOST'];

	if ( $path ) {
		$url .= '/' . $path;
	}

	/*
	 * Point all .js and .css files to minified versions,
	 * when DEBUG isn't enabled.
	 */
	if ( ! PROJECT_DEBUG ) {

		if ( false !== strpos( $url, '.css' ) || false !== strpos( $url, '.js' ) ) {

			$url = str_replace(
				array( '.css', '.js' ),
				array( '.min.css', '.min.js' ),
				$url
			);

		}
	}

	return $url;

}

/**
 * Display URL to website.
 *
 * @param  string $local Optional. Path to local URL to add to site url.
 */
function site_url( $path = '' ) {

	echo get_site_url( $path );

}

/**
 * Get URL to a subpage, taking into account
 * whether it should be a pretty permalink
 * or not.
 *
 * @param  string $slug Slug of the current page.
 * @return string $link Link to page.
 */
function get_permalink( $slug ) {

	$link = '';

	if ( PROJECT_DEBUG ) {
		$link = get_site_url( "?page={$slug}" );
	} else {
		$link = get_site_url( $slug );
	}

	return $link;

}

/**
 * Display URL to a subpage, taking into account
 * whether it should be a pretty permalink
 * or not.
 */
function the_permalink( $slug ) {

	echo get_permalink( $slug );

}

/**
 * Whether page has a title to display.
 *
 * @return bool Whether there's a title for the current page.
 */
function has_title() {

	if ( get_template_var( 'title' ) ) {
		return true;
	}

	return false;

}

/**
 * Display the title for a page.
 */
function the_title() {

	echo get_template_var( 'title' );

}

/**
 * Whether content was generated from a
 * content/*.php file.
 */
function has_content() {

	if ( get_template_var( 'content' ) ) {
		return true;
	}

	return false;

}

/**
 * Display the content generated from a
 * contnet/*.php file.
 */
function the_content() {

	echo get_template_var( 'content' );

}

/**
 * Get the HTML for an image, with proper
 * srcset.
 *
 * @param  string $img    Image file name like `logo.png`.
 * @param  string $alt    Alt tag for image.
 * @param  bool   $hi_res Whether to include 2x image.
 * @return string $output Final HTML output of image.
 */
function get_image( $img, $alt = '', $hi_res = false ) {

	$src = ltrim( $img, '/' );

	$src = get_site_url( 'assets/img/' . $src );

	$output = sprintf( '<img src="%s"', $src );

	if ( $alt ) {
		$output .= sprintf( ' alt="%s"', $alt );
	}

	if ( false !== strpos( $img, '/screenshots' ) ) {
		$output .= ' class="screenshot"';
	}

	if ( $hi_res ) {

		$src_2x = str_replace(
			array( '.png', '.jpg' ),
			array( '@2x.png', '@2x.jpg' ),
			$src
		);

		$output .= sprintf( ' srcset="%s 1x, %s 2x"', $src, $src_2x );

	}

	$output .= '>';

	return $output;

}

/**
 * Get the HTML for an image, with proper
 * srcset.
 *
 * @param  string $img     Image file name like `logo.png`.
 * @param  string $alt     Alt tag for image.
 * @param  bool   $hi_res  Whether to include 2x image.
 */
function image( $img, $alt = '', $hi_res = false ) {

	echo get_image( $img, $alt, $hi_res );

}

/**
 * Output footer copyright HTML.
 */
function the_copyright() {

	printf(
		'&copy; %s - A WordPress plugin manager by %s and %s.',
		'<a href="' . get_site_url() . '" title="WordPress Plugin Manager Drop-in Script">My Plugin Manager</a>',
		'<a href="http://themeblvd.com" title="WordPress Themes and Website Templates" target="_blank">Theme Blvd</a>',
		'<a href="http://jasonbobich.com" title="WordPress Developer" target="_blank">Jason Bobich</a>'
	);

	echo '<br>';

	printf(
		'<span>&#123;</span> This website was styled with %s. <span>&#125;</span>',
		'<a href="http://frontstreet.io" title="Front Street Front-end Web Development Framework" target="_blank">Front Street</a>'
	);

}
