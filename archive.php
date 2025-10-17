<?php
/** 
 * The archive template.
 * @package FlitchBasicWP5
 */

get_header();
?> 
	<div class="entry container" role="main">
        <?php if (have_posts()) { ?> 
            <header class="page-header archive-header">
            <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="taxonomy-description">', '</div>');
            ?>
            </header><!-- .page-header -->

            <?php 
                // Start the Loop
                while (have_posts()) {
                    the_post();
                    get_template_part('content', get_post_format());
                } //endwhile; 
            } else {
                get_template_part('section', 'no-results');
            } //endif; 
        ?>
    </div>
<?php
get_footer();