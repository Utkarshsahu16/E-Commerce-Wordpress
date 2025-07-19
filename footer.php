(cd "$(git rev-parse --show-toplevel)" && git apply --3way <<'EOF'
diff --git a/header.php b/header.php
--- a/header.php
+++ b/header.php
@@ -0,0 +1,229 @@
+<!DOCTYPE html>
+<html <?php language_attributes(); ?>>
+<head>
+    <meta charset="<?php bloginfo('charset'); ?>">
+    <meta name="viewport" content="width=device-width, initial-scale=1.0">
+    <meta http-equiv="X-UA-Compatible" content="IE=edge">
+    
+    <!-- SEO Meta Tags -->
+    <meta name="description" content="<?php bloginfo('description'); ?>">
+    <meta name="keywords" content="ecommerce, online store, shopping, products">
+    <meta name="author" content="<?php bloginfo('name'); ?>">
+    
+    <!-- Open Graph Meta Tags for Social Media -->
+    <meta property="og:title" content="<?php wp_title('|', true, 'right'); bloginfo('name'); ?>">
+    <meta property="og:description" content="<?php bloginfo('description'); ?>">
+    <meta property="og:type" content="website">
+    <meta property="og:url" content="<?php echo home_url(); ?>">
+    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
+    
+    <!-- Twitter Card Meta Tags -->
+    <meta name="twitter:card" content="summary_large_image">
+    <meta name="twitter:title" content="<?php wp_title('|', true, 'right'); bloginfo('name'); ?>">
+    <meta name="twitter:description" content="<?php bloginfo('description'); ?>">
+    
+    <!-- Favicon -->
+    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
+    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
+    
+    <!-- Preconnect to external domains for performance -->
+    <link rel="preconnect" href="https://fonts.googleapis.com">
+    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
+    
+    <!-- WordPress Head Hook -->
+    <?php wp_head(); ?>
+</head>
+
+<body <?php body_class(); ?>>
+    <?php wp_body_open(); ?>
+    
+    <!-- Skip to content link for accessibility -->
+    <a class="skip-link screen-reader-text" href="#main"><?php _e('Skip to content', 'textdomain'); ?></a>
+    
+    <!-- Header Section -->
+    <header id="masthead" class="site-header" role="banner">
+        <!-- Top Bar (Optional) -->
+        <div class="top-bar">
+            <div class="container">
+                <div class="top-bar-left">
+                    <span class="contact-info">
+                        <?php if (get_theme_mod('header_phone')) : ?>
+                            <i class="fas fa-phone"></i>
+                            <a href="tel:<?php echo esc_attr(get_theme_mod('header_phone')); ?>">
+                                <?php echo esc_html(get_theme_mod('header_phone')); ?>
+                            </a>
+                        <?php endif; ?>
+                        
+                        <?php if (get_theme_mod('header_email')) : ?>
+                            <i class="fas fa-envelope"></i>
+                            <a href="mailto:<?php echo esc_attr(get_theme_mod('header_email')); ?>">
+                                <?php echo esc_html(get_theme_mod('header_email')); ?>
+                            </a>
+                        <?php endif; ?>
+                    </span>
+                </div>
+                
+                <div class="top-bar-right">
+                    <!-- User Account Links -->
+                    <div class="user-links">
+                        <?php if (is_user_logged_in()) : ?>
+                            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
+                                <i class="fas fa-user"></i> <?php _e('My Account', 'textdomain'); ?>
+                            </a>
+                            <a href="<?php echo wp_logout_url(home_url()); ?>">
+                                <i class="fas fa-sign-out-alt"></i> <?php _e('Logout', 'textdomain'); ?>
+                            </a>
+                        <?php else : ?>
+                            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
+                                <i class="fas fa-sign-in-alt"></i> <?php _e('Login', 'textdomain'); ?>
+                            </a>
+                            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
+                                <i class="fas fa-user-plus"></i> <?php _e('Register', 'textdomain'); ?>
+                            </a>
+                        <?php endif; ?>
+                    </div>
+                    
+                    <!-- Social Media Links -->
+                    <div class="social-links">
+                        <?php if (get_theme_mod('facebook_url')) : ?>
+                            <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>" target="_blank" rel="noopener">
+                                <i class="fab fa-facebook-f"></i>
+                            </a>
+                        <?php endif; ?>
+                        
+                        <?php if (get_theme_mod('twitter_url')) : ?>
+                            <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>" target="_blank" rel="noopener">
+                                <i class="fab fa-twitter"></i>
+                            </a>
+                        <?php endif; ?>
+                        
+                        <?php if (get_theme_mod('instagram_url')) : ?>
+                            <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>" target="_blank" rel="noopener">
+                                <i class="fab fa-instagram"></i>
+                            </a>
+                        <?php endif; ?>
+                    </div>
+                </div>
+            </div>
+        </div>
+        
+        <!-- Main Header -->
+        <div class="main-header">
+            <div class="container">
+                <div class="header-content">
+                    <!-- Site Logo/Branding -->
+                    <div class="site-branding">
+                        <?php if (has_custom_logo()) : ?>
+                            <div class="site-logo">
+                                <?php the_custom_logo(); ?>
+                            </div>
+                        <?php else : ?>
+                            <h1 class="site-title">
+                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
+                                    <?php bloginfo('name'); ?>
+                                </a>
+                            </h1>
+                            <?php $description = get_bloginfo('description', 'display'); ?>
+                            <?php if ($description || is_customize_preview()) : ?>
+                                <p class="site-description"><?php echo $description; ?></p>
+                            <?php endif; ?>
+                        <?php endif; ?>
+                    </div>
+                    
+                    <!-- Search Bar -->
+                    <div class="header-search">
+                        <?php if (class_exists('WooCommerce')) : ?>
+                            <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
+                                <input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php echo esc_attr__('Search products...', 'textdomain'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
+                                <button type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'textdomain'); ?>" class="search-submit">
+                                    <i class="fas fa-search"></i>
+                                </button>
+                                <input type="hidden" name="post_type" value="product" />
+                            </form>
+                        <?php else : ?>
+                            <?php get_search_form(); ?>
+                        <?php endif; ?>
+                    </div>
+                    
+                    <!-- Header Actions (Cart, Wishlist, etc.) -->
+                    <div class="header-actions">
+                        <?php if (class_exists('WooCommerce')) : ?>
+                            <!-- Wishlist (if plugin is active) -->
+                            <?php if (function_exists('yith_wcwl_count_products')) : ?>
+                                <div class="wishlist-icon">
+                                    <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>">
+                                        <i class="fas fa-heart"></i>
+                                        <span class="wishlist-count"><?php echo yith_wcwl_count_products(); ?></span>
+                                    </a>
+                                </div>
+                            <?php endif; ?>
+                            
+                            <!-- Shopping Cart -->
+                            <div class="cart-icon">
+                                <a href="<?php echo wc_get_cart_url(); ?>" class="cart-link">
+                                    <i class="fas fa-shopping-cart"></i>
+                                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
+                                    <span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
+                                </a>
+                                
+                                <!-- Mini Cart Dropdown -->
+                                <div class="mini-cart-dropdown">
+                                    <?php woocommerce_mini_cart(); ?>
+                                </div>
+                            </div>
+                        <?php endif; ?>
+                    </div>
+                    
+                    <!-- Mobile Menu Toggle -->
+                    <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
+                        <span class="hamburger-line"></span>
+                        <span class="hamburger-line"></span>
+                        <span class="hamburger-line"></span>
+                        <span class="screen-reader-text"><?php _e('Toggle Menu', 'textdomain'); ?></span>
+                    </button>
+                </div>
+            </div>
+        </div>
+        
+        <!-- Navigation Menu -->
+        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Main Navigation', 'textdomain'); ?>">
+            <div class="container">
+                <?php
+                wp_nav_menu(array(
+                    'theme_location' => 'primary',
+                    'menu_id'        => 'primary-menu',
+                    'menu_class'     => 'nav-menu',
+                    'container'      => false,
+                    'fallback_cb'    => 'wp_page_menu',
+                    'walker'         => new WP_Bootstrap_Navwalker(), // If using Bootstrap walker
+                ));
+                ?>
+                
+                <!-- Mobile Menu -->
+                <div class="mobile-menu">
+                    <?php
+                    wp_nav_menu(array(
+                        'theme_location' => 'mobile',
+                        'menu_id'        => 'mobile-menu',
+                        'menu_class'     => 'mobile-nav-menu',
+                        'container'      => false,
+                        'fallback_cb'    => 'wp_page_menu',
+                    ));
+                    ?>
+                </div>
+            </div>
+        </nav>
+        
+        <!-- Breadcrumbs (Optional) -->
+        <?php if (!is_front_page() && function_exists('woocommerce_breadcrumb')) : ?>
+            <div class="breadcrumbs-wrapper">
+                <div class="container">
+                    <?php woocommerce_breadcrumb(); ?>
+                </div>
+            </div>
+        <?php endif; ?>
+    </header>
+    
+    <!-- Main Content Area -->
+    <div id="content" class="site-content">
+        <div class="container">
EOF
)