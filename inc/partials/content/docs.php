
<p>After <a href="<?php echo get_site_url( '#download' ); ?>" title="Generate Your Download Package">generating a unqiue plugin manager for your project</a>, your package will begin to downlowd and you'll be shown a code snippet you can use to get started, which is tailored to your specific project.</p>

<p>This article may seem a bit overwhelming at first glance, but it's only meant to provide further details on the code snippet provided to you. For a quick start, simply download your custom plugin manager and then use the custom code snippet provided as starting point. If you have questions about any of the sections, use this documentation article.</p>

<h2 id="getting-started" class="h4">Getting Started</h2>

<p>Before implementing the plugin manager into your WordPress theme or plugin, please <a href="<?php echo get_site_url( '#download' ); ?>" title="Generate Your Download Package">generate a unqiue copy for your project</a>.</p>

<p>Our online generator tool will re-name the files, classes, and namepsaces, to match your specific project. This allows the plugin manager to play more nicely with implementations by other theme and plugin authors, used in conjunction with yours.</p>

<h2 id="add-directory" class="h4">Add the Drop-in Directory</h2>

<p>Upon unzipping your generated download package, you'll find a "plugin-manager" directory; add this entire directory to your WordPress theme or plugin.</p>

<p>Keep in mind that the sample code snippet provided to you assumes the "plugin-manager" directory is placed in the root of your theme or plugin, but you don't have to put it there, if you don't want. If you're placing the directory somewhere else nested within your theme or plugin, make sure to account for this when <a href="#include">including the plugin manager class</a>.</p>

<h2 id="setup" class="h4">Setting Up</h2>

<p>To keep organized, we suggest keeping your plugin manager setup code in its own function hooked to <code>after_setup_theme</code>. This will make it possible for other plugin and child theme developers to easily get rid of the plugin manager added by your product, if they wish.</p>

<pre class="docs-code-block">
function my_plugin_manager() {

	if ( ! is_admin() ) {
		return;
	}

	// Everything discussed througout this article
	// would go here.

}
add_action( 'after_setup_theme', 'my_plugin_manager' );
</pre>

<div class="alert info">
	<p><strong>Note:</strong> The above example uses a function prefixed with <code>my_</code>, but your implementation should use a namespace unique to your theme or plugin. For example, a theme named "Jump Start" might prefix the function with <code>jump_start_</code>, to implement a function <code>jump_start_plugin_manager()</code>.</p>
</div>

<h2 id="include" class="h4">Include Plugin Manager</h2>

<p>Although your "plugin-manager" is actually a directory of several files, you only need to include one file, <code>class-my-plugin-manager.php</code>.</p>

<div class="alert info">
	<p><strong>Note:</strong> Your custom plugin manager's class file will be named differently. For example, for a theme named "Jump Start", the plugin manager class file would be named <code>class-jump-start-plugin-manager.php</code>.</p>
</div>

<p>Below are some examples of you might include the plugin manager class, depending your project type.</p>

<h3 class="heading-sm">Standard Theme</h3>

<pre class="docs-code-block">
require_once( get_parent_theme_file_path( '/plugin-manager/class-my-plugin-manager.php' ) );
</pre>

<h3 class="heading-sm">Child Theme</h3>

<pre class="docs-code-block">
require_once( get_theme_file_path( '/plugin-manager/class-my-plugin-manager.php' ) );
</pre>

<h3 class="heading-sm">Plugin</h3>

<pre class="docs-code-block">
require_once( plugin_dir_path( __FILE__ ) . '/plugin-manager/class-my-plugin-manager.php' );
</pre>

<h2 id="plugins" class="h4">Suggested Plugins</h2>

<p>By "suggested plugins" we're referring to the plugins you are suggesting that your users install, <em>in addition to</em> your theme or plugin.</p>

<p>Within the example code snippet provided to you <a href="<?php echo get_site_url( '#download' ); ?>" title="Generate Your Download Package">upon generating your download package</a>, you'll see an example array of plugins something like the following.</p>

<pre class="docs-code-block">
$plugins = array(
	array(
		'name'    => 'Easy Digital Downloads',
		'slug'    => 'easy-digital-downloads',
		'version' => '3.0+',
	),
	array(
		'name'    => 'JetPack',
		'slug'    => 'jetpack',
		'version' => '5.0+',
	),
	array(
		'name'    => 'Gravity Forms',
		'slug'    => 'gravityforms',
		'version' => '2.2+',
		'url'     => 'http://www.gravityforms.com', // Only for non wp.org plugins.
	),
);
</pre>

<p>Each individual plugin's array needs be formatted with the following keys.</p>

<div class="table-responsive">
	<table class="table-bordered table-sm">
		<thead>
			<tr>
				<th>Key</th>
				<th>Required</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><code>name</code></td>
				<td>Required</td>
				<td>The user-facing name of the plugin.</td>
			</tr>
			<tr>
				<td><code>slug</code></td>
				<td>Required</td>
				<td>The slug of the plugin; this must match the name of the plugin's directory.</td>
			</tr>
			<tr>
				<td><code>version</code></td>
				<td>Required</td>
				<td>The minimum of version of that plugin your product is compatible with. We suggest using a plus sign for clearer communication to your user like <code>2.0+</code>.</td>
			</tr>
			<tr>
				<td><code>url</code></td>
				<td>Optional</td>
				<td>The website URL to purchase or download the suggested plugin, only if the plugin is <em>not</em> hosted on wordpress.org.</td>
			</tr>
		</tbody>
	</table>
</div><!-- .table-responsive -->

<p><span class="label-inline info">Important!</span> It's important that if the suggested plugin is hosted on wordpress.org, that you do <em>not</em> include a <code>url</code> for it in the plugin's array. This is meant to be an external non-wordpress.org URL. If it exists, it will disable the auto-install functionality for the given plugin, as auto-installing plugins from third-party sources is not supported.</p>

<h2 id="options" class="h4">Options</h2>

<p>Depending on your project, you'll most likely want to pass an array of options to your plugin manager.</p>

<pre class="docs-code-block">
$args = array(
	'page_title' => __( 'Suggested Plugins', 'my-project' ),
	'menu_slug'  => 'my-project-suggested-plugins',
	// Continue adding any more options you want...
);
</pre>

<p>Below are all the possible options you can utilize.</p>

<div class="table-responsive">
	<table class="table-bordered table-sm">
		<thead>
			<tr>
				<th width="24%">Option</th>
				<th width="38%">Default</th>
				<th width="38%">Description</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><code>page_title</code></td>
				<td><code>Suggested Plugins</code></td>
				<td>Title printed at the top of the plugin manager admin screen.</td>
			</tr>
			<tr>
				<td><code>views_title</code></td>
				<td><code>Suggested by {project name}</code></td>
				<td>Text for link to the plugin manager admin screen, which gets inserted at WordPress's main Plugins admin screen. Set to <code>false</code> to disable.</td>
			</tr>
			<tr>
				<td><code>tab_title</code></td>
				<td><code>Suggested by {project name}</code></td>
				<td>Text for link to the plugin manager admin screen, which gets inserted at WordPress's Install Plugins admin screen. Set to <code>false</code> to disable.</td>
			</tr>
			<tr>
				<td><code>extended_title</code></td>
				<td><code>Suggested Plugins by {project name}</code></td>
				<td>An extended title that gets used in the title tags of links generated from both <code>$views_title</code> and <code>$tab_title</code>.</td>
			</tr>
			<tr>
				<td><code>menu_title</code></td>
				<td><code>NULL</code></td>
				<td>Title of plugin manager menu item. If left blank, this will default to <code>$page_title</code>.</td>
			</tr>
			<tr>
				<td><code>parent_slug</code></td>
				<td><code>themes.php</code> or <code>plugins.php</code></td>
				<td>The WordPress parent admin screen slug for the plugin manager page.<br><br><strong>If implenting into a theme, this <em>must</em> be <code>themes.php</code>.</strong></td>
			</tr>
			<tr>
				<td><code>menu_slug</code></td>
				<td><code>suggested-plugins</code></td>
				<td>URL slug for the plugin manager admin screen; we suggest adding a unqiue namespacing key to this value like <code>my-project-suggested-pugins</code>.</td>
			</tr>
			<tr>
				<td><code>capability</code></td>
				<td><code>install_plugins</code></td>
				<td>WordPress user capability for seeing the plugin manager admin screen.</td>
			</tr>
			<tr>
				<td><code>nag_action</code></td>
				<td><code>Manage suggested plugins</code></td>
				<td>Text of the link, which leads the user to the plugin manager admin screen.</td>
			</tr>
			<tr>
				<td><code>nag_dimiss</code></td>
				<td><code>Dismiss this notice</code></td>
				<td>Screen reader text to dismiss plugin manager nags.</td>
			</tr>
			<tr>
				<td><code>nag_update</code></td>
				<td><code>Not all of your active, suggested plugins are compatible with {project name}.</code></td>
				<td>Text for the message, letting users know not all installed suggested plugins are compatible with your project.</td>
			</tr>
			<tr>
				<td><code>nag_install_single</code></td>
				<td><code>{project name} suggests installing 1 plugin.</code></td>
				<td>Text for the message, telling users to install suggested plugins (which are not already installed), if only one exists.</td>
			</tr>
			<tr>
				<td><code>nag_install_multiple</code></td>
				<td><code>{project name} suggests installing {amount} plugins.</code></td>
				<td>Text for the message, telling users to install suggested plugins (which are not already installed).</td>
			</tr>
			<tr>
				<td><code>child_theme</code></td>
				<td><code>false</code></td>
				<td>Whether you're implenting the plugin manager from a child theme.<br><br><strong>This is required if implementing the plugin manager from a child theme.</strong></td>
			</tr>
			<tr>
				<td><code>plugin_file</code></td>
				<td><code>NULL</code></td>
				<td>The full, absolute path to your plugin's main file. If your implementation code already exists in your plugin's main file, you can simply use <code>__FILE__</code>.<br><br><strong>This is required if implementing the plugin manager from a plugin.</strong></td>
			</tr>
		</tbody>
	</table>
</div><!-- .table-responsive -->

<h2 id="instantiate" class="h4">Add Plugin Manager Object</h2>

<p>Once you've included the plugin manager class, and you've got your array of options and array of suggested plugins, you'll use these to instantiate the plugin manager object.</p>

<pre class="docs-code-block">
$manager = new My_Plugin_Manager( $plugins, $args );
</pre>

<div class="alert info">
	<p><strong>Note:</strong> Every implementation of the plugin manager package will have a uniquely named plugin manager class. For example, for a theme named "Jump Start" the plugin manager class will be named <code>Jump_Start_Plugin_Manager</code>.</p>
</div>

<h2 id="examples" class="h4">Examples</h2>

<p>Putting together everything from this article, here are some examples of what the final code snippet might look like for different project types.</p>

<h3>Standard Theme</h3>

<p>A theme named "Jump Start" might setup the plugin manager something like the following.</p>

<?php
$block = file_get_contents( PROJECT_PATH . '/plugin-manager/example-theme.txt' );

$bits = array(
	'{{name}}'        => 'Jump Start',
	'{{text-domain}}' => 'jumpstart',
	'{{my}}'          => 'jumpstart',
	'{{My}}'          => 'Jump_Start',
	'{{class-my-}}'   => 'class-jump-start-',
);

$block = str_replace(
	array_keys( $bits ),
	array_values( $bits ),
	$block
);
?>

<pre class="docs-code-block">
<?php echo $block; ?>
</pre>

<h3>Child Theme</h3>

<p>A child theme named "Jimmy" might setup the plugin manager something like the following.</p>

<?php
$block = file_get_contents( PROJECT_PATH . '/plugin-manager/example-child-theme.txt' );

$bits = array(
	'{{name}}'        => 'Jimmy',
	'{{text-domain}}' => 'jimmy',
	'{{my}}'          => 'jimmy',
	'{{My}}'          => 'Jimmy',
	'{{class-my-}}'   => 'class-jimmy-',
);

$block = str_replace(
	array_keys( $bits ),
	array_values( $bits ),
	$block
);
?>

<pre class="docs-code-block">
<?php echo $block; ?>
</pre>

<h3>Plugin</h3>

<p>A plugin named "Simple Analytics" might setup the plugin manager something like the following.</p>

<?php
$block = file_get_contents( PROJECT_PATH . '/plugin-manager/example-plugin.txt' );

$bits = array(
	'{{name}}'        => 'Simple Analytics',
	'{{text-domain}}' => 'simple-analytics',
	'{{my}}'          => 'simple_analytics',
	'{{My}}'          => 'Simple_Analytics',
	'{{class-my-}}'   => 'class-simple-analytics-',
);

$block = str_replace(
	array_keys( $bits ),
	array_values( $bits ),
	$block
);
?>

<pre class="docs-code-block">
<?php echo $block; ?>
</pre>
