<?php
/**
 * Any JavaScript files included in the
 * bottom of the document should go here.
 */
?>
<script src="<?php site_url( 'assets/js/jquery-1.12.4.js' ); ?>"></script>

<?php if ( 'home' === get_template_var( 'slug' ) || 'docs' === get_template_var( 'slug' ) ) : ?>

	<script type="text/javascript" src="<?php site_url( 'assets/js/highlight.js' ); ?>"></script>

<?php endif; ?>

<?php if ( 'faq' === get_template_var( 'slug' ) ) : ?>

	<script type='text/javascript'>
	/* <![CDATA[ */
	var FrontStreetConfig = {
		'background'  : false,
		'menu'        : false,
		'mobile-menu' : false,
		'modal'       : false,
		'jump-menu'   : false,
		'slider'      : false,
		'tabs'        : false,
		'tooltip'     : false,
		'toggles'     : true
	};
	</script>

	<script type="text/javascript" src="<?php site_url( 'assets/frontstreet/js/frontstreet.js' ); ?>"></script>

<?php endif; ?>

<script type="text/javascript" src="<?php site_url( 'assets/js/site.js' ); ?>"></script>
