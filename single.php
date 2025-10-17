<?php
/**
 * Single post container setup
 * 
 * @package FlitchBasicWP5
 */
 
get_header(); 
?>
	<div class="entry container">
	    <div class="row">
        	 <?php
                get_sidebar('sidebar-left');
                if (is_active_sidebar('sidebar-left')) {
                    echo "<div class='content has-sidebar col-md-9'>";
                }
                else {
                    echo "<div class='content col-12'>";
                }
                if ( have_posts() ) : 
                    while ( have_posts() ) : 
                        the_post();
                        get_template_part( 'content', 'single' );
                    endwhile;
                endif;
                
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                ?>
                    <section class='comments'>
                        <?php comments_template(); ?>
                    </section>
                <?php
                endif;
                ?>
            </div><!-- end content -->
        </div><!-- end row -->
	</div> <!-- /.blog-main -->
<?php get_footer(); ?>
