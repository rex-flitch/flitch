<?php

/**
 * FC Primary Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


// Load values

?>

<?php if (have_rows('slides')): ?>
<div class="mobile-slider-wrapper">
    <div class="slider-status">
        <span class="current-slide">01</span> / <span class="total-slides">04</span>
    </div>
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php while (have_rows('slides')): the_row(); 
                $title = get_sub_field('slide_title');
                $desc = get_sub_field('slide_description');
                $img = get_sub_field('slide_image');
                $icon = get_sub_field('icon_image');
                $link = get_sub_field('slide_link');
            ?>
            <div class="swiper-slide">
                <a href="<?php echo esc_url($link['url']); ?>">
                    <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" class="mobile-slide-icon" />
                    <div class="slide-content">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($desc); ?></p>
                    </div>
                    <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="mobile-slide-image" />
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="progress-bar">
            <div class="progress-indicator"></div>
        </div>
        
    </div>
</div>
<?php endif; ?>
