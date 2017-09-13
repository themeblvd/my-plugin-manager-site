<?php
/**
 * Standard header template, used across
 * entire website.
 */
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>

		<meta charset="UTF-8" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />

		<title><?php title_tag(); ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php if ( get_template_var( 'meta_desc' ) ) : ?>
			<meta name="description" content="<?php echo get_template_var( 'meta_desc' ); ?>">
		<?php endif; ?>

		<link rel="stylesheet" href="<?php site_url( 'assets/frontstreet/plugins/font-awesome/css/font-awesome.css' ); ?>" type="text/css" media="all" />
		<link rel="stylesheet" href="<?php site_url( 'assets/frontstreet/css/frontstreet.css' ); ?>" type="text/css" media="all" />

		<?php if ( 'home' === get_template_var( 'slug' ) ) : ?>

			<link rel="stylesheet" href="<?php site_url( 'assets/css/monokai.css' ); ?>" type="text/css" media="all" />

		<?php elseif ( 'docs' === get_template_var( 'slug' ) ) : ?>

			<link rel="stylesheet" href="<?php site_url( 'assets/css/syntax-default.css' ); ?>" type="text/css" media="all" />

		<?php endif; ?>

		<link rel="stylesheet" href="<?php site_url( 'assets/css/site.css' ); ?>" type="text/css" media="all" />

	</head>
	<body>

		<header class="site-header">

			<a href="#" class="fs-menu-toggle menu-toggle-light menu-toggle-md" title="Toggle Menu">
			    <span class="hamburger">
			        <span></span>
			    </span>
			    <span class="sr-only">Toggle Menu</span>
			</a>

			<ul class="site-logo-container list-unstyled clearfix">
				<li>
					<a href="<?php site_url(); ?>" title="WordPress Plugin Manager" class="site-logo">
						<?php image( 'logo.png', 'WordPress Plugin Manager Logo', true ); ?>
					</a>
				</li>
				<li>
					<span>by</span>
				</li>
				<li>
					<a href="http://themeblvd.com" title="WordPress Themes by Theme Blvd" class="tb-logo">
						<?php image( 'tb-logo.png', 'Theme Blvd Logo', true ); ?>
					</a>
				</li>
			</ul>

			<ul class="site-follow clearfix">
				<li>
					<a href="https://twitter.com/jasonbobich" title="Follow on Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
				</li>
				<li>
					<a href="https://github.com/themeblvd/my-plugin-manager" title="Follow on GitHub" target="_blank"><i class="fa fa-github"></i></a>
				</li>
			</ul>

			<ul class="site-menu submenu-bar submenu-horz-md text-light">
				<li class="<?php if ( 'home' === get_template_var( 'slug' ) ) echo 'current'; ?>">
					<a href="<?php site_url(); ?>" class="menu-btn" title="Home">Home</a>
				</li>
				<li class="<?php if ( 'about' === get_template_var( 'slug' ) ) echo 'current'; ?>">
					<a href="<?php the_permalink( 'about' ); ?>" class="menu-btn" title="About">About</a>
				</li>
				<li class="<?php if ( 'faq' === get_template_var( 'slug' ) ) echo 'current'; ?>">
					<a href="<?php the_permalink( 'faq' ); ?>" class="menu-btn" title="About">FAQ</a>
				</li>
				<li class="<?php if ( 'docs' === get_template_var( 'slug' ) ) echo 'current'; ?>">
					<a href="<?php the_permalink( 'docs' ); ?>" class="menu-btn" title="Docs">Docs</a>
				</li>
				<li class="download">
					<a href="<?php site_url( '#download' ); ?>" class="menu-btn highlight" title="Download">Download</a>
				</li>
			</ul>

		</header>

		<?php if ( false === strpos( get_site_url(), '.dev' ) ) : ?>

			<?php include_once( 'analytics.php' ); ?>

		<?php endif; ?>
