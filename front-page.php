<?php get_header('home'); ?>
	<div class="entry container" role="main">
		 <?php
        if ( have_posts() ) : 
            while ( have_posts() ) : 
                the_post();
                get_template_part( 'content', 'single' );
            endwhile;
        endif;
        ?>
	</div> <!-- /.blog-main -->
<?php get_footer(); ?>