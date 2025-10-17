    </main> <!-- /.container -->
    <?php 
    
    $footerId = "footer_" . $post->ID;
    ?>
    <footer id="site-footer" class="container-fluid site-footer page-footer <?php echo $footerId; ?>">
        <div class="container">
            <div class="row footer-rows">
                <div class="col">
                    <h4>Quick Links</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'quick-links-menu',  // Matches the registered menu slug
                        'container'       => 'nav',          // Wraps the menu in a <nav> element
                        'container_class' => 'footer-nav',   // Adds a custom class for styling
                        'menu_class'      => 'footer-menu',  // Adds a class to the <ul> menu list
                        'fallback_cb'     => false           // Prevents WordPress from showing a default list if no menu is set
                    ));
                    ?>
                </div>
                <div class="col">
                    <h4>Get In Touch</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'get-in-touch-menu',  // Matches the registered menu slug
                        'container'       => 'nav',          // Wraps the menu in a <nav> element
                        'container_class' => 'footer-nav',   // Adds a custom class for styling
                        'menu_class'      => 'footer-menu',  // Adds a class to the <ul> menu list
                        'fallback_cb'     => false           // Prevents WordPress from showing a default list if no menu is set
                    ));
                    ?>
                </div>
                <div class="col">
                    <h4>Support</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'support-menu',  // Matches the registered menu slug
                        'container'       => 'nav',          // Wraps the menu in a <nav> element
                        'container_class' => 'footer-nav',   // Adds a custom class for styling
                        'menu_class'      => 'footer-menu',  // Adds a class to the <ul> menu list
                        'fallback_cb'     => false           // Prevents WordPress from showing a default list if no menu is set
                    ));
                    ?>
                </div>
                <div class="col">
                    <h4>Location</h4>
                    <?php
                    $location = get_field('location', 'options');
                    echo $location;
                    ?>
                </div>
                <div class="col">
                    <h4>Hours</h4>
                    <?php if( have_rows('hours', 'options') ): ?>
                        <div class="hours-container">
                        <?php while( have_rows('hours', 'options') ): the_row(); 
                            $days = get_sub_field('day');
                            $hours = get_sub_field('hour');
                            ?>
                            <div class="hours">
                                <div>
                                    <?php echo $days; ?>
                                </div>
                                <div>
                                    <?php echo $hours; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row footer-bottom">
            <div class="col-6 text-center text-uppercase">
                    &copy; <?php echo date("Y"); ?> | Fiesta Fun Center | Website by <a href="https://www.flitchcreative.com" target="_blank">Flitch</a>
            </div>
            <div class="col-6 footer-social">
                <?php if( have_rows('social_media', 'options') ): ?>
                    <?php while( have_rows('social_media', 'options') ): the_row(); 
                        $platform = get_sub_field('platform');
                        $icon = get_sub_field('icon');
                        $link = get_sub_field('link');
                        ?>
                        <a href="<?php echo $link; ?>"><?php echo $icon; ?></a>
                    <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </footer>
    
    <?php wp_footer(); ?> 
  </body>
</html>