<?php

/**
 * FC Primary Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'fc-homepage-attractions-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}




// Create class attribute allowing for custom "className" and "align" values.
$className = 'fc-homepage-attractions';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Query Attractions with display_on_homepage set to true
$args = array(
    'post_type'      => 'attraction',
    'posts_per_page' => -1,            // Retrieve all matching posts
    'meta_query'     => array(
        array(
            'key'     => 'display_on_homepage', // ACF field name
            'value'   => '1',                   // '1' for true in ACF
            'compare' => '=',                   // Exact match
        ),
    ),
);

$attractions_query = new WP_Query($args);

if ($attractions_query->have_posts()) :
    ?>
    <div class="purple-background alignfull pd-tb-75">
        <div class="container">
            <h2 class="large center white">Attractions</h2>
            <div class="attractions-grid">
                
                <?php
                while ($attractions_query->have_posts()) : $attractions_query->the_post();
                $slug = get_post_field('post_name', get_post());
                $bottom_link = get_field('bottom_link', get_the_ID());
            
                $link = (!empty($bottom_link) && !empty($bottom_link['url'])) 
                    ? esc_url($bottom_link['url']) 
                    : '/attractions/#' . esc_attr($slug);
                ?>
                <div class="attraction-item">
                    <a href="<?php echo $link; ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="attraction-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="large attraction-title"><?php the_title(); ?></h3>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <?php
else :
    echo '<p>No attractions found.</p>';
endif;

// Reset post data
wp_reset_postdata();
?>

<!-- 
<div class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">
    <div class="fc-homepage-attractions-block container">
        <div class="row">
            <div class="col-12">
                <p><?php echo $text ?></p>
            </div>
            
            <div class="col-12">
                <img src=<?php echo $image ?> alt="primary image"></img>
                
            </div>
        </div>

    </div>
</div> -->