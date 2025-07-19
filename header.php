<?php
/**
 * The header template file
 *
 * @package EcommerceTheme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main"><?php _e('Skip to content', 'ecommerce-theme'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-container">
                <div class="site-branding">
                    <?php ecommerce_custom_logo(); ?>
                    <?php if (display_header_text()) : ?>
                        <div class="site-description">
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) :
                            ?>
                                <p class="site-description"><?php echo $description; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'menu_class' => 'nav-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </nav>

                <div class="header-icons">
                    <!-- Search Form -->
                    <div class="header-search">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" 
                                   class="form-control" 
                                   placeholder="<?php _e('Search products...', 'ecommerce-theme'); ?>" 
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s" />
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                    </div>

                    <!-- User Account -->
                    <div class="header-account">
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="account-link">
                                <i class="fas fa-user"></i>
                                <span class="sr-only"><?php _e('My Account', 'ecommerce-theme'); ?></span>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="account-link">
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="sr-only"><?php _e('Login', 'ecommerce-theme'); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Shopping Cart -->
                    <?php if (class_exists('WooCommerce')) : ?>
                        <div class="header-cart">
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                <span class="sr-only"><?php _e('View cart', 'ecommerce-theme'); ?></span>
                            </a>
                            
                            <!-- Mini Cart -->
                            <div class="mini-cart-dropdown">
                                <div class="widget_shopping_cart_content">
                                    <?php woocommerce_mini_cart(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle d-lg-none" type="button" aria-label="<?php _e('Toggle mobile menu', 'ecommerce-theme'); ?>">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu d-lg-none">
            <div class="container">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id' => 'mobile-menu',
                    'menu_class' => 'mobile-nav-menu',
                    'container' => false,
                    'fallback_cb' => false,
                ));
                ?>
            </div>
        </div>
    </header>

    <?php
    // Display WooCommerce notices
    if (function_exists('woocommerce_output_all_notices')) {
        woocommerce_output_all_notices();
    }
    ?>

    <div id="content" class="site-content">