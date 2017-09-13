<?php
/**
 * Serve download package and then delete it.
 */
class Serve_Download {

	private $file = array();

	private $package = array();

	/**
	 * Class constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args ) {

		// Set file properties.
		$this->file = array(
			'name' => '',
			'path' => '',
		);

		if ( ! empty( $args['zip_name'] ) ) {
			$this->file['name'] = $args['zip_name'];
		}

		if ( ! empty( $args['zip_path'] ) ) {
			$this->file['path'] = $args['zip_path'];
		}

		// Set package properties.
		$this->package = array(
			'text_domain'       => '',
			'namespace'         => '',
			'class_prefix'      => '',
			'class_file_prefix' => '',
		);

		if ( ! empty( $args['text_domain'] ) ) {
			$this->package['text_domain'] = $args['text_domain'];
		}

		if ( ! empty( $args['namespace'] ) ) {
			$this->package['namespace'] = $args['namespace'];
		}

		if ( ! empty( $args['class_prefix'] ) ) {
			$this->package['class_prefix'] = $args['class_prefix'];
		}

		if ( ! empty( $args['class_file_prefix'] ) ) {
			$this->package['class_file_prefix'] = $args['class_file_prefix'];
		}

		// Download the file, if valid.
		if ( $this->file ) {

			$this->download();

		}

	}

	/**
	 * Download the file.
	 */
	private function download() {

		$file = $this->file['path'] . '/' . $this->file['name'];

		header( 'Content-Type: application/zip' );
		header( 'Content-Disposition: attachment; filename="' . basename( $this->file['name'] ) . '"' );
		header( 'Content-Length: ' . filesize( $file ));

		readfile( $file );

		unlink( $file );

	}

}
