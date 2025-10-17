<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
    <link rel="stylesheet" href="https://use.typekit.net/sav5goa.css">
    
    <?php /*
	<title>
	    <?php echo bloginfo('name'); ?>
	    <?php if (bloginfo('description')) {
	        echo ' - ';
	        echo bloginfo('description');
	    } ?>
    </title>
	*/ ?>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<?php wp_head();?>
</head>

<body <?php body_class(); ?> >
<?php
$promotion = get_field('promotion', 'options');

if ($promotion) :
    $title = $promotion['title'] ?? '';
    $image = $promotion['promotion_image'] ?? '';
    $button_title = $promotion['button_title'] ?? '';
    $link = $promotion['promotion_link'] ?? '';
?>

<!-- Slide-out Panel including the Button -->
<div id="promo-panel" class="info-panel open">
    <!-- Rotated Button on edge of panel -->
    <div id="promo-button" class="info-button" onclick="togglePromoPanel()">News / Events</div>

    <!-- Content inside panel -->
    <div class="info-panel-content">
        
        <div>
            <a href="<?php echo esc_url($link); ?>">
            <?php if ($title) : ?>
                <h2><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($image) : ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" style="max-width: 100%; height: auto; margin-bottom: 20px;">
            <?php endif; ?>

            <?php if ($button_title) : ?>
                <a href="<?php echo esc_url($link); ?>" class="promo-btn"><?php echo esc_html($button_title); ?></a>
            <?php endif; ?>
            </a>
            <a href="/news-events/" class="promo-btn">More News/Events</a>
        </div>
        <span class="close-panel" onclick="togglePromoPanel()"><span>×</span></span>
    </div>
</div>

<?php endif; ?>


    <header id="site-header" class="page-header homepage-header">
        <div class="hamburger-menu">
            <div class="menu-icon homepage-icon">
                <span></span>
                <span></span> 
                <span></span>
            </div>
            <nav class="slide-menu">
                <ul id="menu-mobile">
                    <?php custom_mobile_menu(); ?>
                </ul>

                <?php
                wp_nav_menu(array(
                    'theme_location' => 'mobile-secondary',
                    'container' => 'nav',
                    'container_class' => 'mobile-secondary-menu',
                    'menu_class' => 'mobile-secondary-menu-items',
                    'fallback_cb' => false, // optional: prevents default page menu if not set
                ));
                ?>

            </nav>
        </div>
        <div class="menu-overlay"></div>

        <div class='container'>
            <div class="row site-branding">
                
                <div class="col-2 site-title">
                    <a href="/">
                        <?php
                            $logo = get_field('white_logo', 'options');
                            if ($logo) {
                                echo wp_get_attachment_image($logo['ID'], 'fullsize', false, array('class'=>'logo img-fluid'));
                            } else { ?>
                                <h1 class="site-title-heading"><?php echo get_bloginfo( 'name' ); ?></h1>
                        <?php } ?>
                    </a>
                </div>
                
                
                
                <div class="col-8 text-right">
                    <?php
                        // args ($location, $text, $classes)
                        // echo fl_menu_button('primary', '', 'd-lg-none');
                    ?>
                    
                    <nav class="navbar navbar-expand-md">
                        <div id="main-menu" class="collapse navbar-collapse">
                            <?php 
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'depth'				=> 2, // 1 = no dropdowns, 2 = with dropdowns.
                                	'container'			=> false,
                                	'menu_class'		=> 'navbar-nav mr-auto',
                                    'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'			=> new WP_Bootstrap_Navwalker() 
                                )
                            ); 
                            ?>
                        </div><!--.navbar-collapse-->
                    </nav>
                </div>
                <div class="col-2 contact-area">
                    <div class="contact-button">
                    <?php
                        $contact = get_field('contact_number', 'options');
                        echo "<a href='tel:" . $contact . "' class='btn-green'>" . $contact . "</a>";
                    ?>
                    </div>
                    <div class="contact-icon white">
                    <?php
                        echo "<a href='tel:" . $contact . "'><i class='fa-solid fa-phone'></i></a>";
                    ?> 
                    </div>
                </div>
            </div><!--.main-navigation-->
        </div>
    </header><!--.page-header-->

    <main id="content" class="site-content">

    <script>

function closeAllPanels() {
    document.getElementById('promo-panel')?.classList.remove('open');
    document.getElementById('hours-panel')?.classList.remove('open');
}

function togglePromoPanel() {
    const promo = document.getElementById('promo-panel');
    const isOpen = promo.classList.contains('open');
    closeAllPanels();
    if (!isOpen) promo.classList.add('open');
}

function toggleHoursPanel() {
    const hours = document.getElementById('hours-panel');
    const isOpen = hours.classList.contains('open');
    closeAllPanels();
    if (!isOpen) hours.classList.add('open');
}
</script>


