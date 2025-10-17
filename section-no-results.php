<?php
/**
 * Display no results from condition if not have posts.
 * @package FlitchBasicWP5
 */
?> 
<section class="no-results not-found entry container text-center">
	<header class="page-header">
		<h1 class="page-title">Nothing Found</h1>
	</header><!-- .page-header -->

	<div class="page-content row-with-vspace">
	    <h1>I didn't find anything</h1>
		<?php if (is_home() && current_user_can('publish_posts')) { ?> 
			<p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'bootstrap-basic4'), esc_url(admin_url('post-new.php'))); ?></p>
		<?php } elseif (is_search()) { ?> 
			<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
		<?php } else { ?> 
			<p>It seems we can't find what you're looking for</p>
		<?php } //endif; ?> 
	</div><!-- .page-content -->
</section><!-- .no-results -->