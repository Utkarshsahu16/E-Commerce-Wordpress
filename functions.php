<?php
/**
 * WordPress E-commerce Theme Functions
 * 
 * @package EcommerceTheme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function ecommerce_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ecommerce-theme'),
        'footer' => __('Footer Menu', 'ecommerce-theme'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'ecommerce_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function ecommerce_theme_scripts() {
    // Styles
    wp_enqueue_style('bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('responsive-style', get_template_directory_uri() . '/assets/css/responsive.css', array(), '1.0.0');
    
    // Scripts
    wp_enqueue_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // WooCommerce specific scripts
    if (is_woocommerce() || is_cart() || is_checkout()) {
        wp_enqueue_script('wc-cart-fragments');
        wp_enqueue_script('theme-cart', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), '1.0.0', true);
    }
    
    // Localize script for Ajax
    wp_localize_script('theme-main', 'ecommerce_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ecommerce_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'ecommerce_theme_scripts');

/**
 * Register Widget Areas
 */
function ecommerce_theme_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'ecommerce-theme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'ecommerce-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 1', 'ecommerce-theme'),
        'id' => 'footer-1',
        'description' => __('Add footer widgets here.', 'ecommerce-theme'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 2', 'ecommerce-theme'),
        'id' => 'footer-2',
        'description' => __('Add footer widgets here.', 'ecommerce-theme'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 3', 'ecommerce-theme'),
        'id' => 'footer-3',
        'description' => __('Add footer widgets here.', 'ecommerce-theme'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'ecommerce_theme_widgets_init');

/**
 * Custom Excerpt Length
 */
function ecommerce_custom_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'ecommerce_custom_excerpt_length');

/**
 * Custom Excerpt More
 */
function ecommerce_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'ecommerce_excerpt_more');

/**
 * Include additional functions
 */
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/woocommerce-functions.php';
require get_template_directory() . '/inc/ajax-functions.php';

/**
 * Add custom classes to body
 */
function ecommerce_body_classes($classes) {
    if (is_woocommerce()) {
        $classes[] = 'woocommerce-page';
    }
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    return $classes;
}
add_filter('body_class', 'ecommerce_body_classes');

/**
 * Custom logo output
 */
function ecommerce_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
    }
}

/**
 * Get cart count
 */
function ecommerce_get_cart_count() {
    if (class_exists('WooCommerce')) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

/**
 * Get cart total
 */
function ecommerce_get_cart_total() {
    if (class_exists('WooCommerce')) {
        return WC()->cart->get_cart_total();
    }
    return '$0.00';
}

/**
 * Product search shortcode
 */
function ecommerce_product_search_shortcode($atts) {
    $atts = shortcode_atts(array(
        'placeholder' => 'Search products...',
        'button_text' => 'Search'
    ), $atts);
    
    ob_start();
    ?>
    <form role="search" method="get" class="product-search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <div class="input-group">
            <input type="search" class="form-control" placeholder="<?php echo esc_attr($atts['placeholder']); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            <input type="hidden" name="post_type" value="product" />
            <button class="btn btn-primary" type="submit"><?php echo esc_html($atts['button_text']); ?></button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('product_search', 'ecommerce_product_search_shortcode');

/**
 * Featured products shortcode
 */
function ecommerce_featured_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 8,
        'columns' => 4,
        'orderby' => 'date',
        'order' => 'desc'
    ), $atts);
    
    if (class_exists('WooCommerce')) {
        return do_shortcode('[featured_products limit="' . $atts['limit'] . '" columns="' . $atts['columns'] . '" orderby="' . $atts['orderby'] . '" order="' . $atts['order'] . '"]');
    }
    
    return '';
}
add_shortcode('featured_products', 'ecommerce_featured_products_shortcode');

/**
 * Recent products shortcode
 */
function ecommerce_recent_products_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => 8,
        'columns' => 4,
        'orderby' => 'date',
        'order' => 'desc'
    ), $atts);
    
    if (class_exists('WooCommerce')) {
        return do_shortcode('[recent_products limit="' . $atts['limit'] . '" columns="' . $atts['columns'] . '" orderby="' . $atts['orderby'] . '" order="' . $atts['order'] . '"]');
    }
    
    return '';
}
add_shortcode('recent_products', 'ecommerce_recent_products_shortcode');

/**
 * Theme customization options
 */
function ecommerce_customize_register($wp_customize) {
    // Colors
    $wp_customize->add_section('ecommerce_colors', array(
        'title' => __('Theme Colors', 'ecommerce-theme'),
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('primary_color', array(
        'default' => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'ecommerce-theme'),
        'section' => 'ecommerce_colors',
        'settings' => 'primary_color',
    )));
    
    // Footer text
    $wp_customize->add_section('ecommerce_footer', array(
        'title' => __('Footer Settings', 'ecommerce-theme'),
        'priority' => 50,
    ));
    
    $wp_customize->add_setting('footer_text', array(
        'default' => '© 2024 Your Store Name. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_text', array(
        'label' => __('Footer Text', 'ecommerce-theme'),
        'section' => 'ecommerce_footer',
        'type' => 'text',
    ));
}
add_action('customize_register', 'ecommerce_customize_register');

/**
 * Output custom colors
 */
function ecommerce_custom_colors() {
    $primary_color = get_theme_mod('primary_color', '#007cba');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            opacity: 0.9;
        }
        a {
            color: var(--primary-color);
        }
        .site-header {
            border-bottom: 3px solid var(--primary-color);
        }
    </style>
    <?php
}
add_action('wp_head', 'ecommerce_custom_colors');

/**
 * Admin notice for required plugins
 */
function ecommerce_admin_notice() {
    if (!class_exists('WooCommerce')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>E-commerce Theme:</strong> This theme requires WooCommerce plugin to function properly. <a href="' . admin_url('plugin-install.php?s=woocommerce&tab=search&type=term') . '">Install WooCommerce</a></p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'ecommerce_admin_notice');

/**
 * Add security headers
 */
function ecommerce_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'ecommerce_security_headers');

/**
 * Clean up WordPress head
 */
function ecommerce_clean_head() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'ecommerce_clean_head');

/**
 * Optimize images
 */
function ecommerce_optimize_images() {
    add_filter('jpeg_quality', function($quality) {
        return 85;
    });
    
    add_filter('wp_image_editors', function($editors) {
        return array('WP_Image_Editor_Imagick', 'WP_Image_Editor_GD');
    });
}
add_action('init', 'ecommerce_optimize_images');

/**
 * Add schema markup
 */
function ecommerce_schema_markup() {
    if (is_home() || is_front_page()) {
        echo '<script type="application/ld+json">';
        echo json_encode(array(
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "name" => get_bloginfo('name'),
            "url" => home_url(),
            "potentialAction" => array(
                "@type" => "SearchAction",
                "target" => home_url('/?s={search_term_string}'),
                "query-input" => "required name=search_term_string"
            )
        ));
        echo '</script>';
    }
}
add_action('wp_head', 'ecommerce_schema_markup');

?>