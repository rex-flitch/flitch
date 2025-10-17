<?php
/**
 * Single post container setup
 * 
 * @package FlitchBasicWP5
 */
 
get_header(); 
?>
<div class="purple-header">
    <h1><?php the_title(); ?></h1>
</div>
	<div class="entry container ff-posts">
	    <div class="row">
            <div class='content col-12'>
            
        	 <?php
                if ( have_posts() ) : 
                    while ( have_posts() ) : 
                        the_post();
                        get_template_part( 'content', 'single' );
                    endwhile;
                endif;
                ?>
            </div><!-- end content -->
        </div><!-- end row -->
	</div> <!-- /.blog-main -->
<?php get_footer(); ?>
