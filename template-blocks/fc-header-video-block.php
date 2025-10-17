<?php

/**
 * FC Header Video Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'fc-header-video-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'fc-header-video';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values
$video = get_field('video');
$title = get_field('title');
$cta_link = get_field('cta_link');
?>

<div class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">
    <div class="fc-header-video-container">
    <div class="embed-responsive embed-responsive-16by9 video-container">
        <video class="embed-responsive-item" id="home-header-video" autoplay loop muted>
          <source src="<?php echo $video; ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <div class="video-titles">
            <h1 class="video-title"><?php echo $title; ?></h1>
            <a href="<?php echo $cta_link['url']; ?>" class="btn btn-video-cta" target="<?php echo $cta_link['target']; ?>"><?php echo $cta_link['title']; ?><img src="/wp-content/uploads/2020/02/long-arrow.svg" class="btn-video-cta-arrow" /></a>
            
        </div>
        <div class="video-sound">
            <i class="fas fa-volume-mute" id="home-video-mute"></i>
            <i class="fas fa-volume-up" id="home-video-sound"></i>
        </div>
    </div>
    </div>
</div>