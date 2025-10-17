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
$text = get_field('text');
$image = get_field('image');

?>

<div class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">
    <div class="fc-primary-block container">
        <div class="row">
            <div class="col-12">
                <p><?php echo $text ?></p>
            </div>
            
            <div class="col-12">
                <img src=<?php echo $image ?> alt="primary image"></img>
                
            </div>
        </div>

    </div>
</div>