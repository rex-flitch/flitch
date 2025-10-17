<?php
/*
Template Name: News & Events Archive
*/

get_header(); ?>

<div class="news-events-archive">
    <div class="container">
        <?php
        // Output any Gutenberg/editor content added to this page
        while (have_posts()) : the_post();
            the_content();
        endwhile;

        $categories = get_categories(array(
            'hide_empty' => true,
        ));

        ?>
        <div class="news-filters">
            <div class="news-col-1"><h2 class="black">Filters</h2></div>
            <div class="news-col-2 filters-bar">
            <select id="category-filter">
                <option value="all">All News & Events</option>
                <?php foreach ($categories as $cat) : ?>
                <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="flex-end news-col-3">
            <div class="view-toggle">
                <div class="toggle-button" data-view="list"><img src="/wp-content/uploads/2025/04/list-icon.svg"></div>
                <div class="toggle-button active" data-view="grid"><img src="/wp-content/uploads/2025/04/box-icon.svg"></div>
            </div>
            </div>
        </div>
        <div class="events-grid view-grid">
            
            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 9,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'paged'          => $paged,
            );

            $events = new WP_Query($args);

            if ($events->have_posts()) :
                while ($events->have_posts()) : $events->the_post();
                
                    $event_price = get_field('event_price');
                    $date_range = get_field('date_range');
                    $link_title = get_field('link_title');
                    $preview_text = get_field('preview_text');
                    $custom_link = get_field('custom_link');
                    $link_title = get_field('link_title');
                    $link_to_post_or_custom_link = get_field('link_to_post_or_custom_link');
                    $content_raw = get_the_content();
                    $content_trimmed = wp_strip_all_tags($content_raw);
                    $has_more = strlen($preview_text) > 150;
                    $excerpt = substr($preview_text, 0, 150);
                    

                    $categories = get_the_category();
                    $category_name = $categories ? esc_html($categories[0]->name) : '';
                    $category_slugs = array_map(function ($cat) {
                        return $cat->slug;
                    }, get_the_category());
                    
                    $data_categories = implode(' ', $category_slugs);
                    ?>

                    <div class="event-item" data-category="<?php echo esc_attr($data_categories); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="event-thumbnail">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($event_price) : ?>
                            <div class="event-price boxview"><?php echo esc_html($event_price); ?></div>
                        <?php endif; ?>
                        
                        <!-- BOX LAYOUT -->
                        <div class="event-info boxview">
                            <?php if ($category_name) : ?>
                                <p class="event-category"><?php echo $category_name; ?></p>
                            <?php endif; ?>

                            <h2 class="event-title black"><?php the_title(); ?></h2>

                            <p class="event-excerpt">
                                <?php echo esc_html($excerpt); ?>
                                <?php if ($has_more) : ?>...<?php endif; ?>
                            </p>

                            <?php if ($link_to_post_or_custom_link === 'custom') : ?>
                                <div class="btn-purple-100"><a href="<?php echo esc_url($custom_link['url']); ?>" 
                                target="<?php echo esc_attr($custom_link['target']); ?>">
                                <?php echo esc_html($custom_link['title']); ?>
                                </a></div>
                            <?php endif; ?>
                            <?php if ($link_to_post_or_custom_link === 'post') : ?>
                                <div class="btn-purple-100"><a href="<?php the_permalink(); ?>"><?php echo $link_title; ?></a></div>
                            <?php endif; ?>
                            
                        </div>
                        <?php if ($date_range) : ?>
                            <div class="event-dates boxview"><p><?php echo $date_range; ?></p></div>
                        <?php endif; ?>

                        <!-- LIST LAYOUT -->
                        <div class="event-info listview">
                            <div class="list-flex list-col-1">
                                <?php if ($category_name) : ?>
                                    <p class="event-category"><?php echo $category_name; ?></p>
                                <?php endif; ?>
                                <?php if ($date_range) : ?>
                                    <div class="event-dates-list"><p><?php echo $date_range; ?></p></div>
                                <?php endif; ?>
                            </div>
                            <div class="list-flex list-col-2">
                                <h2 class="event-title black"><?php the_title(); ?></h2>

                                <p class="event-excerpt">
                                    <?php echo esc_html($excerpt); ?>
                                    <?php if ($has_more) : ?>...<?php endif; ?>
                                </p>
                            </div>
                            <div class="list-col-3">
                            <?php if ($event_price) : ?>
                                <div class="event-price-list"><?php echo esc_html($event_price); ?></div>
                            <?php endif; ?>
                            </div>
                            <div class="list-col-4">
                            <?php if ($link_to_post_or_custom_link === 'custom') : ?>
                                <div class="btn-purple"><a href="<?php echo esc_url($custom_link['url']); ?>" 
                                target="<?php echo esc_attr($custom_link['target']); ?>">
                                <?php echo esc_html($custom_link['title']); ?>
                                </a></div>
                            <?php endif; ?>
                            <?php if ($link_to_post_or_custom_link === 'post') : ?>
                                <div class="btn-purple"><a href="<?php the_permalink(); ?>"><?php echo $link_title; ?></a></div>
                            <?php endif; ?>
                            </div>
                            
                        </div>

                    </div>

                    <?php
                endwhile;
                ?>

        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'total'   => $events->max_num_pages,
                'current' => $paged,
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
            ));
            ?>
        </div>

        <?php
        wp_reset_postdata();
    else :
        echo '<p>No posts found.</p>';
    endif;
    ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const buttons = document.querySelectorAll('.toggle-button');
  const grid = document.querySelector('.events-grid');

  buttons.forEach(btn => {
    btn.addEventListener('click', function () {
      buttons.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const view = this.getAttribute('data-view');
      grid.classList.remove('view-grid', 'view-list');
      grid.classList.add('view-' + view);
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const filter = document.getElementById('category-filter');
  const items = document.querySelectorAll('.event-item');

  filter.addEventListener('change', function () {
    const selected = this.value;

    items.forEach(item => {
      const cats = item.getAttribute('data-category').split(' ');
      if (selected === 'all' || cats.includes(selected)) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });
});
</script>
<?php get_footer(); ?>