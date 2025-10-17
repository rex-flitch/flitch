<?php
/**
 * Display the post content in "generic" or "standard" format.
 * This will be use in the loop and full page display.
 * 
 * @package FlitchBasicWP5
 */


$FCB5 = new \FlitchBasicWP5\FlitchBasicWP5();
?> 
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        
        <!--SEARH BAR FUNCTION -->
        <!--<?php get_search_form( ); ?>-->
        

        <?php if ('post' == get_post_type()) { ?> 
        <div class="entry-meta">
            <?php the_date(); ?> 
        </div><!-- .entry-meta -->
        <?php } //endif; ?> 
        
    
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?> 
        <div class="clearfix"></div>
        <?php 
        /**
         * This wp_link_pages option adapt to use bootstrap pagination style.
         */
        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'bootstrap-basic4') . ' <ul class="pagination">',
            'after'  => '</ul></div>',
            'separator' => ''
        ));
        ?> 
    </div><!-- .entry-content -->



    <footer class="entry-meta">
        <?php if ('post' == get_post_type()) { // Hide category and tag text for pages on Search ?> 
        <div class="entry-meta-category-tag">
            <?php
                $categories_list = get_the_category_list(__(', ', 'bootstrap-basic4'));
                if (!empty($categories_list)) {
            ?> 
                <div class="category-links">
                    <?php
                    echo "<i class='far fa-folder'></i>";
                    foreach ((array)$categories_list as $cl) {
                        echo "<span class='category-link'>$cl</span>";
                    } ?>
                </div>
            <?php } // End if categories ?>

            <?php if (get_the_tags()) { ?> 
                <div class="tags-links">
                    <?php the_tags(); ?> 
                </div>
            <?php } // End if $tags_list ?> 
        </div><!--.entry-meta-category-tag-->
        <?php } // End if 'post' == get_post_type() ?> 
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
<?php unset($FCB5); ?> 