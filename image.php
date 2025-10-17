<?php
    // redirect attachment pages to their post parent
    wp_redirect(get_permalink($post->post_parent));
?>