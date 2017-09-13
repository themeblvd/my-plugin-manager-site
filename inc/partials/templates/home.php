<?php
/**
 * Standard page template, used for all pages
 * except homepage.
 */

get_header();

if ( has_content() ) {

	the_content();

} else {

	echo '<p>Oops, no content found.</p>';

}

get_footer();
