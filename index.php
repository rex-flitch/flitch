<?php get_header(); ?>
	<div class="entry container" role="main">
		 <?php
        if ( have_posts() ) : 
            while ( have_posts() ) : 
                the_post();
                get_template_part( 'content', get_post_format() );
            endwhile;
        else :
            get_template_part('section', 'no-results');
        endif;
        ?>
	</div> <!-- /.blog-main -->
<?php get_footer(); ?>