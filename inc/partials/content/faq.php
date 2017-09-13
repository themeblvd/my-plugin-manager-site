<?php
$sections = array(
	'about' => array(
		'name' => 'About'
	),
	'usage' => array(
		'name' => 'Download and Implementation'
	),
);

$sections['about']['items'] = array(
	array(
		'q' => 'Is it free to use the plugin manager in my theme or plugin?',
		'a' => '<p>Yes. <em>My Plugin Manager</em> is licensed as 100% GPL. This means you can use it however you wish, at no cost.</p>',
	),
	array(
		'q' => 'Does the plugin manager support suggesting plugins not hosted on wordpress.org?',
		'a' => '<p>Yes, it does. However, the plugin manager will not directly install plugins that are not hosted on wordpress.org. Instead, a link will be provided to the user to get the plugin.</p><p>With that said, after the non-wordpress.org plugin is installed by the user, if it supports native WordPress in-dashboard updates (which many commercial plugins do), then this can be managed from your product\'s plugin manager interface to help the user make sure they\'re maintaining a compatible version.</p>',
	),
	array(
		'q' => 'When implemented into a theme, will my theme still pass <a href="https://wordpress.org/plugins/theme-check/" title="Theme Check Plugin" target="_blank">theme-check</a> so it can be sumbmitted to wordpress.org?',
		'a' => '<p>Yes, of course!</p>',
	),
	array(
		'q' => 'How is this plugin manager different from <a href="http://http://tgmpluginactivation.com/" target="_blank" rel="nofollow">TGM Plugin Activation</a>?',
		'a' => '<p>Our original goal was to create something conceptually similar to TGMPA, but with some important differences.</p><ul><li>Less overall features than TGMPA, making things simpler for the end-user.</li><li>Plugins are never required, only suggested.</li><li>For better security, while plugins from anywhere can be suggested, the auto-installer will only directly install wordpress.org hosted plugins.</li><li>A more Ajaxified experience for managing plugins, that blends more in with where WordPress is today.</li><li>The plugin manager admin screen always remains in place, listing all suggested plugins and their current status.</li></ul>',
	),
);

$sections['usage']['items'] = array(
	array(
		'q' => 'Where can I download the plugin manager?',
		'a' => sprintf( '<p>We ask that you please use the <a href="%s" title="Generate Your Download Package">online generator</a> to download a uniquely generated copy of the plugin manager that is specific to your project.</p>', get_site_url( '#download' ) ),
	),
	array(
		'q' => 'Can I just download the plugin manager directly from GitHub?',
		'a' => sprintf( '<p>For implementing the plugin manager into your project, we ask that you use the <a href="%s" title="Generate Your Download Package">online generator</a> to download. The distributed version on GitHub is not intended for direct production use.</p><p>Our online generator tool will re-name the files, classes, and namepsaces, to match your specific project. This allows the plugin manager to play more nicely with implementations by other theme and plugin authors, used in conjunction with yours.</p>', get_site_url( '#download' ) ),
	),
	array(
		'q' => 'How do I implement the plugin manager?',
		'a' => sprintf( '<p>The <a href="%s" title="Generate Your Download Package">online generator</a> will give you a ZIP package for your project. Unzip this and add the resulting "plugin-manager" directory to your theme or plugin.</p><p>Also, once your package has been generated and the download has started, you will be shown a code snippet that you can use to get started, which is specific to your project.</p>', get_site_url( '#download' ) ),
	),
	array(
		'q' => 'Does the "plugin-manager" directory <em>need</em> to go in the root of my theme or plugin?',
		'a' => 'No, it doesn\'t. You can organize the directory where ever you like in your theme or plugin. Just make sure to adjust the include path to your <code>class-{file-namespace}-plugin-manager.php</code> from the example code snippet provided.',
	),
);
?>


<?php foreach ( $sections as $section_id => $section ) : ?>

	<h2 id="<?php echo $section_id; ?>">
		<?php echo $section['name']; ?>
	</h2>

	<div class="toggle-group">

		<?php foreach ( $section['items'] as $item ) : ?>

			<?php toggle( $item['q'], $item['a'] ); ?>

		<?php endforeach; ?>

	</div><!-- .toggle-group -->

<?php endforeach; ?>
