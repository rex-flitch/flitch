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




// Create class attribute allowing for custom "className" and "align" values.
$className = 'fc-rotating-banner';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values

?>

<div class="<?php echo esc_attr($className); ?> alignfull" id="<?php echo esc_attr($id); ?>">
    <!-- Always-visible on desktop -->
    <div class="banner-hours-wrapper">
        <div class="banner-hours-container">
            <div class="banner-hours">
            <?php
                $hours = get_field('hours', 'options');
                $holiday_hours = get_field('holiday_hours', 'options');

                if ($hours) :
                    echo '<div class="banner-hours-info"><h5>REGULAR HOURS</h5>';
                    foreach ($hours as $row) :
                        $day = esc_html($row['day']);
                        $hour = esc_html($row['hour']);
                        echo "<div>$day</div><div> $hour</div>";
                    endforeach;
                    echo '</div>';
                endif;

                if ($holiday_hours) :
                    // Get today's date at midnight
                    $today = strtotime('today');
                    
                    // Filter and sort the holiday hours
                    $upcoming_holidays = array_filter($holiday_hours, function ($row) use ($today) {
                        return strtotime($row['day']) >= $today;
                    });

                    usort($upcoming_holidays, function ($a, $b) {
                        return strtotime($a['day']) - strtotime($b['day']);
                    });

                    // Get the next 2
                    $next_two = array_slice($upcoming_holidays, 0, 10);

                    if (!empty($next_two)) :
                        echo '<div class="banner-hours-info second"><h5>HOLIDAY HOURS</h5>';
                        foreach ($next_two as $row) :
                            $day = esc_html($row['day']);
                            $hour = esc_html($row['hour']);
                            echo "<div>$day</div><div> $hour</div>";
                        endforeach;
                        echo '</div>';
                    endif;
                endif;
                ?>

            </div>
        </div>
    </div>

    <!-- HOURS PANEL (mobile-only) -->
    <div id="hours-panel" class="hours-slideout mobile-only">
        <div id="hours-button" class="hours-button" onclick="toggleHoursPanel()">Hours</div>
        
        <div class="hours-panel-content">
            <div class="banner-hours-container">
                <div class="banner-hours">
                    <?php
                        $hours = get_field('hours', 'options');
                        $holiday_hours = get_field('holiday_hours', 'options');

                        if ($hours) :
                            echo '<div class="banner-hours-info"><h5>REGULAR HOURS</h5>';
                            foreach ($hours as $row) :
                                $day = esc_html($row['day']);
                                $hour = esc_html($row['hour']);
                                echo "<div>$day</div><div> $hour</div>";
                            endforeach;
                            echo '</div>';
                        endif;

                        if ($holiday_hours) :
                            // Get today's date at midnight
                            $today = strtotime('today');
                            
                            // Filter and sort the holiday hours
                            $upcoming_holidays = array_filter($holiday_hours, function ($row) use ($today) {
                                return strtotime($row['day']) >= $today;
                            });

                            usort($upcoming_holidays, function ($a, $b) {
                                return strtotime($a['day']) - strtotime($b['day']);
                            });

                            // Get the next 2
                            $next_two = array_slice($upcoming_holidays, 0, 10);

                            if (!empty($next_two)) :
                                echo '<div class="banner-hours-info second"><h5>HOLIDAY HOURS</h5>';
                                foreach ($next_two as $row) :
                                    $day = esc_html($row['day']);
                                    $hour = esc_html($row['hour']);
                                    echo "<div>$day</div><div> $hour</div>";
                                endforeach;
                                echo '</div>';
                            endif;
                        endif;
                        ?>
                </div>
            </div>
            <span class="close-panel" onclick="toggleHoursPanel()"><span>×</span></span>
        </div>
    </div>

    <div class="fc-rotating-banner-block">
        <div class="row">
            <?php if( have_rows('images') ): ?>
                <ul class="slides">
                    <?php while( have_rows('images') ): the_row(); 
                        $media_type = get_sub_field('media_type');
                        $image = get_sub_field('image');
                        $video = get_sub_field('slide_video'); // or video_url if using URL
                    ?>
                        <li>
                            <?php if ($media_type === 'video' && $video): ?>
                                <video class="banner-video" autoplay muted loop playsinline>
                                    <source src="<?php echo esc_url($video); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php elseif ($media_type === 'image' && $image): ?>
                                <?php echo wp_get_attachment_image($image['ID'], 'fullsize', false, array('class'=>'banner img-fluid')); ?>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>