<?php
/**
 * Check if we have valid $_POST data to serve
 * a download.
 */
function has_download() {

	if ( empty( $_POST['zip_name'] ) ) {
		return false;
	}

	if ( empty( $_POST['zip_path'] ) ) {
		return false;
	}

	if ( empty( $_POST['text_domain'] ) ) {
		return false;
	}

	if ( empty( $_POST['namespace'] ) ) {
		return false;
	}

	if ( empty( $_POST['class_prefix'] ) ) {
		return false;
	}

	if ( empty( $_POST['class_file_prefix'] ) ) {
		return false;
	}

	return true;

}
