<?php
/**
 * Standard footer template, used across
 * entire website.
 */
?>

		<footer class="site-footer">

			<p class="copyright"><?php the_copyright(); ?></p>

			<div class="footer-logos">

				<a href="http://themeblvd.com" title="WordPress Themes and Website Templates" target="_blank">
					<?php
					image(
						'footer-tb-logo.png',
						'WordPress Themes and Website Templates',
						true
					);
					?>
				</a>

				<a href="https://wpjumpstart.com" title="Ultimate WordPress Theme and Framework" target="_blank">
					<?php
					image(
						'footer-js-logo.png',
						'Ultimate WordPress Theme and Framework',
						true
					);
					?>
				</a>

				<a href="http://frontstreet.io" title="Frontend Web Development Framework" target="_blank">
					<?php
					image(
						'footer-fs-logo.png',
						'Frontend Web Development Framework',
						true
					);
					?>
				</a>

			</div>

		</footer>

		<?php include_once( 'scripts.php' ); ?>

	</body>
</html>
