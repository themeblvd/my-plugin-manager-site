<?php
/**
 * Standard page template, used for all pages
 * except homepage.
 */

get_header();
?>

<div class="site-content">
	<article>

		<?php if ( has_title() ) : ?>

			<h1><?php the_title(); ?></h1>

		<?php endif; ?>

		<?php if ( has_content() ) : ?>

			<?php the_content(); ?>

		<?php else : ?>

			<p>Oops, no content found.</p>

		<?php endif; ?>

	</article>
</div><!-- .site-content -->

<?php
get_footer();
