<?php
/**
 * Builds the download package from an Ajax
 * request and sends back a final zip download
 * link.
 *
 * Note: This class does not handle removing
 * the temporary download directory and zip.
 */
class Create_Download {

	/**
	 * Any arguments needed for object.
	 *
	 * @var array
	 */
	private $args = array();

	/**
	 * String bits used in build.
	 *
	 * @var array
	 */
	private $bits = array();

	/**
	 * Full directory path to project root.
	 *
	 * @var string
	 */
	private $root_path = '';

	/**
	 * Name of temporary directory created.
	 *
	 * @var string
	 */
	private $temp_name = '';

	/**
	 * Path to temporary directory created.
	 *
	 * @var string
	 */
	private $temp_path = '';

	/**
	 * Name of final zip.
	 *
	 * @var string
	 */
	private $zip_name = '';

	/**
	 * Zip object.
	 *
	 * @var ZipArchive
	 */
	private $zip;

	/**
	 * Class constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args ) {

		$this->args = array_merge( array(
			'type'        => '',
			'name'        => '',
			'namespace'   => '',
			'text_domain' => '',
		), $args );

		// Set top-level root path to project.
		$this->root_path = str_replace( '/inc', '', dirname( __FILE__ ) );

		// Determine bits to get used in build.
		$this->set_bits();

		// Create and open new zip file.
		$this->create();

		// Copy static files to zip that don't require building.
		$this->copy();

		// Build PHP class files and add to zip.
		$this->build();

		// Finalize the zip.
		$this->close();

		// Send final response back with URL to download.
		$this->response();

	}

	/**
	 * Set string bits to get used throughout
	 * build process.
	 */
	private function set_bits() {

		$class_prefix = $this->args['name'];
		$class_prefix = str_replace( ' ', '_', $class_prefix );
		$class_prefix = preg_replace( '/[^A-Za-z0-9\_]/', '', $class_prefix );

		$class_file_prefix = strtolower( $class_prefix );
		$class_file_prefix = str_replace( '_', '-', $class_file_prefix );

		$this->bits = array(
			'name'              => $this->args['name'],
			'type'              => $this->args['type'],
			'text_domain'       => $this->args['text_domain'],
			'namespace'         => $this->args['namespace'],
			'class_prefix'      => $class_prefix,
			'class_file_prefix' => 'class-' . $class_file_prefix . '-',
		);

	}

	/**
	 * Create temporary directory for new
	 * download.
	 */
	private function create() {

		$hash = md5( microtime().rand() );

		$this->temp_name = $hash;

		$this->temp_path = $this->root_path . "/temp/{$hash}";

		mkdir( $this->temp_path );

		$this->zip_name = strtolower( $this->bits['class_prefix'] );
		$this->zip_name = str_replace( '_', '-', $this->zip_name );
		$this->zip_name = $this->zip_name . '-plugin-manager.zip';

		$zip_file = $this->temp_path . '/' . $this->zip_name;

		$this->zip = new ZipArchive();

		$this->zip->open( $zip_file, ZipArchive::CREATE );

	}

	/**
	 * Copy static files, that do not require any
	 * build process.
	 */
	private function copy() {

		$files = array(
			'/assets/css/plugin-manager.css',
			'/assets/css/plugin-manager.min.css',
			'/assets/js/plugin-manager.js',
			'/assets/js/plugin-manager.min.js',
			'/assets/js/plugin-notices.js',
			'/assets/js/plugin-notices.min.js',
		);

		foreach ( $files as $file ) {

			$this->zip->addfile(
				$this->root_path . '/plugin-manager/' . $file,
				'/plugin-manager/' . $file
			);

		}

	}

	/**
	 * Build PHP class files.
	 */
	private function build() {

		$parts = array(
			'my-text-domain' => $this->bits['text_domain'],
			'my_namespace'   => $this->bits['namespace'],
			'_My'            => $this->bits['class_prefix'],
			'class-my-'      => $this->bits['class_file_prefix'],
		);

		$files = array(
			'/class-my-plugin-manager.php',
			'/class-my-plugins.php',
			'/class-my-plugin-notices.php',
		);

		foreach ( $files as $file ) {

			$contents = str_replace(
				array_keys( $parts ),
				array_values( $parts ),
				file_get_contents( $this->root_path . '/plugin-manager' . $file )
			);

			if ( '/class-my-plugin-manager.php' === $file && 'plugin' === $this->bits['type'] ) {

				/*
				 * For use with plugins, replace add_theme_page()
				 * with add_submenu_page().
				 */
				$contents = str_replace(
					'add_theme_page(',
					"add_submenu_page(\n\t\t\t\t\$this->args['parent_slug'],",
					$contents
				);

				/*
				 * And make the default $args['parent_slug'] equal
				 * to 'plugins.php'.
				 */
				$contents = str_replace( 'themes.php', 'plugins.php', $contents );

			}

			$to = str_replace( 'class-my-', $this->bits['class_file_prefix'], $file );
			$to = 'plugin-manager/' . $to;

			$this->zip->addFromString( $to, $contents );

		}

	}

	/**
	 * Zip final download package.
	 */
	private function close() {

		$this->zip->close();

	}

	/**
	 * Send response back to Ajax.
	 */
	private function response() {

		$response = array(
			'zipName'     => $this->zip_name,
			'zipPath'     => $this->temp_path,
			'zipURL'      => $this->get_download_link(),
			'codeExample' => $this->get_code_block(),
			'codeExplain' => $this->get_code_explain(),
		);

		echo json_encode( $response );

	}

	/**
	 * Format download link.
	 */
	private function get_download_link() {

		$protocol = 'http';

		if ( isset( $_SERVER['HTTPS'] ) ) {

			if ( 'on' == strtolower( $_SERVER['HTTPS'] ) ) {
				$protocol = 'https';
			}

			if ( '1' == $_SERVER['HTTPS'] ) {
				$protocol = 'https';
			}
		} elseif ( isset( $_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			$protocol = 'https';
		}

		$bits = array(
			$protocol . '://' . $_SERVER['HTTP_HOST'],
			'temp',
			$this->temp_name,
			$this->zip_name
		);

		return implode( $bits, '/' );

	}

	/**
	 * Get code block for response.
	 */
	private function get_code_block() {

		if ( 'plugin' === $this->bits['type'] ) {
			$file = 'plugin-manager/example-plugin.txt';
		} elseif ( 'child-theme' === $this->bits['type'] ) {
			$file = 'plugin-manager/example-child-theme.txt';
		} else {
			$file = 'plugin-manager/example-theme.txt';
		}

		$file = $this->root_path . '/' . $file;

		$block = '';

		if ( file_exists( $file ) ) {
			$block = file_get_contents( $file );
		}

		if ( $block ) {

			$bits = array(
				'{{name}}'        => $this->bits['name'],
				'{{text-domain}}' => $this->bits['text_domain'],
				'{{my}}'          => $this->bits['namespace'],
				'{{My}}'          => $this->bits['class_prefix'],
				'{{class-my-}}'   => $this->bits['class_file_prefix'],
			);

			$block = str_replace(
				array_keys( $bits ),
				array_values( $bits ),
				$block
			);

		}

		return $block;

	}

	/**
	 * Get a customized explanation to go with
	 * the code block returned in the response.
	 */
	private function get_code_explain() {

		$message = array();

		$message[0] = sprintf(
			'Unzip your new <code>%s</code> and place the contained "plugin-manager" directory within your %s.',
			$this->zip_name,
			str_replace( '-', ' ', $this->bits['type'] )
		);

		if ( 'plugin' === $this->bits['type'] ) {

			$message[1] = 'Next, use the following code within your main plugin file as a starting point.';

		} else {

			$message[1] = sprintf(
				'Next, use the following code in you %s\'s <code>functions.php</code> as a starting point.',
				str_replace( '-', ' ', $this->bits['type'] )
			);

		}

		return '<p>' . implode( $message, ' ' ) . '</p>';

	}

}
