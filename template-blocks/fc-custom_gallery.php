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

$id = 'fc-rotating-banner-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = 'fc-rotating-banner';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$gallery = get_field('custom_gallery');
$selected_category = isset($_GET['gallery_filter']) ? sanitize_text_field($_GET['gallery_filter']) : 'overview';

if ($gallery):
    $categories = [];

    foreach ($gallery as $image) {
        $image_id = $image['ID'];
        $image_categories = get_field('image_category', $image_id); // Now an array
        if (!empty($image_categories) && is_array($image_categories)) {
            foreach ($image_categories as $cat) {
                if (!in_array($cat, $categories)) {
                    $categories[] = $cat;
                }
            }
        }
    }

    $category_labels = [
        'overview' => 'Overview',
        'bowling' => 'Bowling',
        'mini' => 'Mini Golf',
        'boats' => 'Bumper Boats',
        'karts' => 'Go Karts',
        'laser' => 'Laser Tag',
        'arcade' => 'Arcade',
        'grill' => 'Barre Grill',
        'batting' => 'Batting Cages',
        'entrance' => 'Entrance',
        'redemption' => 'Redemption',
    ];
    ?>

<div class="gallery-flex">
    <!-- Filter Buttons -->
    <div class="gallery-filters gallery-column-1">
        <ul class="filter-list">
            <li><a href="?gallery_filter=all" class="filter-btn <?php echo ($selected_category === 'all') ? 'active' : ''; ?>">All</a></li>
            <?php foreach ($categories as $category): ?>
                <li><a href="?gallery_filter=<?php echo esc_attr($category); ?>" 
                    class="filter-btn <?php echo ($selected_category === $category) ? 'active' : ''; ?>">
                    <?php echo esc_html($category_labels[$category]); ?>
                </a></li>
            <?php endforeach; ?>
        </ul>

        <!-- Filter Dropdown (Mobile) -->
        <select class="filter-dropdown" onchange="location = this.value;">
            <option value="?gallery_filter=all" <?php echo ($selected_category === 'all') ? 'selected' : ''; ?>>All</option>
            <?php foreach ($categories as $category): ?>
                <option value="?gallery_filter=<?php echo esc_attr($category); ?>" <?php echo ($selected_category === $category) ? 'selected' : ''; ?>>
                    <?php echo esc_html($category_labels[$category]); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    

    <!-- Gallery Wrapper -->
    <div class="custom-gallery gallery-column-2">
        <?php foreach ($gallery as $image):
            $image_id = $image['ID'];
            $image_categories = get_field('image_category', $image_id);
            $image_url = $image['url'];
            $image_alt = $image['alt'];

            $should_display = false;
            if ($selected_category === 'all') {
                $should_display = true;
            } elseif (is_array($image_categories) && in_array($selected_category, $image_categories)) {
                $should_display = true;
            }

            if ($should_display):
                ?>
                <div class="gallery-item" data-category="<?php echo esc_attr(implode(', ', $image_categories)); ?>">
                    <a href="<?php echo esc_url($image_url); ?>" data-lightbox="custom-gallery" data-title="<?php echo esc_attr($image_alt); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
