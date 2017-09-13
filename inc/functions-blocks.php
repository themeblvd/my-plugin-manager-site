<?php
/**
 * Output a Front Street toggle.
 *
 * @param string $title   Title of toggle.
 * @param string $content Content of toggle.
 */
function toggle( $title, $content ) {

	?>
	<div class="fs-toggle">

	    <p class="toggle-title">
			<strong><?php echo $title; ?></strong>
		</p>

	    <div class="toggle-content">
			<?php echo $content; ?>
	    </div><!-- .toggle-content -->

	</div><!-- .fs-toggle -->
	<?php

}
