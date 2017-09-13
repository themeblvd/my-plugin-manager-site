
<!--  HOMEPAGE (start) -->

<div class="fs-section section-intro text-center">
	<div class="wrap">

		<div class="img-holder">
			<?php image( '/screenshots/intro.gif', 'Plugin Manager Demo' ); ?>
		</div>

		<p><strong>My Plugin Manager</strong> is a drop-in script for your WordPress theme or plugin, which gives your users an interface to manage plugins you suggest be used with your product.</p>

	</div><!-- .wrap -->
</div><!-- .fs-section.section-intro -->

<div id="download" class="fs-section section-download">
	<div class="wrap">

		<h2>Generate Your Plugin Manager</h2>

		<p class="lead">Every project is unique and so is every plugin manager. Please use the form below to generate your custom plugin manager and instructions tailored to your specific project.</p>

		<form method="post">
			<p class="field-type">
			    <label for="type">Usage Type</label>
			    <select id="type" name="type" class="field-xxl">
			        <option value="theme">Theme</option>
			        <option value="child-theme">Child Theme</option>
			        <option value="plugin">Plugin</option>
			    </select>
				<span class="help-text">Select what you'll be using your plugin manager with.</span>
			</p>
			<p class="field-name">
				<label for="name">Theme Name</label>
				<input type="text" id="name" name="name" class="field-xxl">
				<span class="help-text">Enter the name of your theme. Example: <code>Jump Start</code></span>
			</p>
			<p class="field-namespace">
				<label for="namespace">Namespace</label>
				<input type="text" id="namespace" name="namespace" class="field-xxl">
				<span class="help-text">Enter the unique identifier used to prefix your theme's functions. Example: <code>jumpstart</code> or <code>jump_start</code></span>
			</p>
			<p class="field-text_domain">
				<label for="text-domain">Text Domain</label>
				<input type="text" id="text-domain" name="text-domain" class="field-xxl">
				<span class="help-text">Enter the text domain used for localization in your WordPress theme; this usually matches the directory name of your theme. Example: <code>jumpstart</code> or <code>jump-start</code></span>
			</p>
			<p>
				<button type="submit" class="btn-primary btn-xxxl btn-block">Generate and Download</button>
			</p>
		</form>

	</div><!-- .wrap -->
</div><!-- .fs-section.section-download -->

<div class="fs-section section-code">
	<div class="wrap">

		<a href="#" class="code-reset" title="Start Again">
			<i class="fa fa-refresh"></i>
		</a>

		<div class="code-explain"></div>

		<div class="code-block">
			<pre></pre>
		</div>

	</div><!-- .wrap -->
</div><!-- .fs-section.section-download -->

<!--  HOMEPAGE (end) -->
