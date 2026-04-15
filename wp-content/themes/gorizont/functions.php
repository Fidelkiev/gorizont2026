<?php
/**
 * Gorizont Theme Functions
 */

/**
 * Theme setup
 */
function gorizont_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('responsive-embeds');
    add_theme_support('customize-selective-refresh-widgets');
    
    // Responsive image sizes
    add_image_size('mobile-thumb', 480, 0, false);
    add_image_size('tablet-thumb', 768, 0, false);
    add_image_size('mobile-product', 600, 400, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'top' => __('Top Menu', 'gorizont'),
        'footer' => __('Footer Menu', 'gorizont'),
        'mobile' => __('Mobile Menu', 'gorizont'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'gorizont_setup');

/**
 * Enqueue scripts and styles
 */
function gorizont_scripts() {
    // Main stylesheet
    wp_enqueue_style('gorizont-style', get_stylesheet_uri(), array(), '2.0.0');
    
    // Google Fonts
    wp_enqueue_style('gorizont-fonts', 'https://fonts.googleapis.com/css2?family=Trebuchet+MS:wght@400;700&display=swap', array(), null);
    
    // Theme scripts
    wp_enqueue_script('gorizont-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '2.0.0', true);
    
    // Localize script
    wp_localize_script('gorizont-script', 'gorizont_vars', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gorizont_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'gorizont_scripts');

/**
 * Register widget areas
 */
function gorizont_widgets_init() {
    register_sidebar(array(
        'name' => __('Main Sidebar', 'gorizont'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'gorizont'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Area', 'gorizont'),
        'id' => 'footer-1',
        'description' => __('Add widgets here to appear in your footer.', 'gorizont'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'gorizont_widgets_init');

/**
 * Custom post types for products
 */
function gorizont_post_types() {
    register_post_type('product', array(
        'labels' => array(
            'name' => __('Products', 'gorizont'),
            'singular_name' => __('Product', 'gorizont'),
            'add_new' => __('Add New', 'gorizont'),
            'add_new_item' => __('Add New Product', 'gorizont'),
            'edit_item' => __('Edit Product', 'gorizont'),
            'new_item' => __('New Product', 'gorizont'),
            'all_items' => __('All Products', 'gorizont'),
            'view_item' => __('View Product', 'gorizont'),
            'search_items' => __('Search Products', 'gorizont'),
            'not_found' => __('No products found', 'gorizont'),
            'not_found_in_trash' => __('No products found in Trash', 'gorizont'),
            'parent_item_colon' => '',
            'menu_name' => __('Products', 'gorizont'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-products',
        'rewrite' => array('slug' => 'products'),
    ));
    
    register_taxonomy('product-category', 'product', array(
        'labels' => array(
            'name' => __('Product Categories', 'gorizont'),
            'singular_name' => __('Product Category', 'gorizont'),
            'search_items' => __('Search Categories', 'gorizont'),
            'all_items' => __('All Categories', 'gorizont'),
            'parent_item' => __('Parent Category', 'gorizont'),
            'parent_item_colon' => __('Parent Category:', 'gorizont'),
            'edit_item' => __('Edit Category', 'gorizont'),
            'update_item' => __('Update Category', 'gorizont'),
            'add_new_item' => __('Add New Category', 'gorizont'),
            'new_item_name' => __('New Category Name', 'gorizont'),
            'menu_name' => __('Categories', 'gorizont'),
        ),
        'hierarchical' => true,
        'rewrite' => array('slug' => 'product-category'),
    ));
}
add_action('init', 'gorizont_post_types');

/**
 * Custom excerpt length
 */
function gorizont_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'gorizont_excerpt_length');

/**
 * Custom excerpt more
 */
function gorizont_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '">' . __('Read More', 'gorizont') . '</a>';
}
add_filter('excerpt_more', 'gorizont_excerpt_more');

/**
 * SEO: Disable WordPress version in head
 */
remove_action('wp_head', 'wp_generator');

/**
 * SEO: Remove wlwmanifest link
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * SEO: Remove RSD link
 */
remove_action('wp_head', 'rsd_link');

/**
 * SEO: Remove shortlink
 */
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * SEO: Remove adjacent posts links
 */
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * SEO: Add breadcrumb structured data
 */
function gorizont_breadcrumbs() {
    if (is_home() || is_front_page()) {
        return;
    }
    
    $sep = ' > ';
    echo '<nav aria-label="Breadcrumb" class="breadcrumbs">';
    echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';
    
    // Home
    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a itemprop="item" href="' . home_url() . '"><span itemprop="name">' . __('Home', 'gorizont') . '</span></a>';
    echo '<meta itemprop="position" content="1" />';
    echo '</li>';
    
    if (is_category() || is_single()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . $sep . get_the_category_list(', ') . '</span>';
        echo '<meta itemprop="position" content="2" />';
        echo '</li>';
        
        if (is_single()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . $sep . get_the_title() . '</span>';
            echo '<meta itemprop="position" content="3" />';
            echo '</li>';
        }
    } elseif (is_page()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . $sep . get_the_title() . '</span>';
        echo '<meta itemprop="position" content="2" />';
        echo '</li>';
    } elseif (is_search()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . $sep . __('Search Results', 'gorizont') . '</span>';
        echo '<meta itemprop="position" content="2" />';
        echo '</li>';
    } elseif (is_404()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . $sep . __('404 Not Found', 'gorizont') . '</span>';
        echo '<meta itemprop="position" content="2" />';
        echo '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * SEO: Add alt text to images without it
 */
function gorizont_add_alt_tags($content) {
    preg_match_all('/<img[^>]+>/', $content, $images);
    if (!is_null($images)) {
        foreach ($images[0] as $index => $image) {
            if (!preg_match('/alt=/', $image)) {
                $new_image = preg_replace('/<img/', '<img alt="' . get_the_title() . '"', $image);
                $content = str_replace($image, $new_image, $content);
            }
        }
    }
    return $content;
}
add_filter('the_content', 'gorizont_add_alt_tags');

/**
 * SEO: Lazy loading for images
 */
add_filter('wp_lazy_loading_enabled', '__return_true');

/**
 * SEO: Add responsive images
 */
add_theme_support('responsive-embeds');

/**
 * SEO: Disable attachment pages
 */
function gorizont_disable_attachment_pages() {
    if (is_attachment()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }
}
add_action('template_redirect', 'gorizont_disable_attachment_pages');

/**
 * SEO: Add schema.org to navigation menus
 */
function gorizont_nav_menu_args($args) {
    $args['container'] = 'nav';
    $args['container_aria_label'] = 'Primary Navigation';
    return $args;
}
add_filter('wp_nav_menu_args', 'gorizont_nav_menu_args');

// =====================================================
// SECURITY HARDENING
// =====================================================

/**
 * Security: Hide WordPress version completely
 */
function gorizont_hide_wp_version($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'gorizont_hide_wp_version', 9999);
add_filter('script_loader_src', 'gorizont_hide_wp_version', 9999);

/**
 * Security: Remove version from RSS feeds
 */
add_filter('the_generator', '__return_empty_string');

/**
 * Security: Disable author enumeration
 */
function gorizont_disable_author_enumeration() {
    if (is_author()) {
        wp_redirect(home_url());
        exit;
    }
    if (preg_match('/author=([0-9]*)/', $_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'gorizont_disable_author_enumeration');

/**
 * Security: Disable REST API for guests
 */
function gorizont_restrict_rest_api($access) {
    if (!is_user_logged_in()) {
        return new WP_Error('rest_restricted', __('REST API restricted to authenticated users.'), array('status' => 401));
    }
    return $access;
}
add_filter('rest_authentication_errors', 'gorizont_restrict_rest_api');

/**
 * Security: Limit login attempts (basic implementation)
 */
function gorizont_check_login_attempts($user, $password) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);
    
    if ($attempts === false) {
        $attempts = 0;
    }
    
    if ($attempts >= 5) {
        return new WP_Error('too_many_attempts', __('Too many failed login attempts. Please try again in 15 minutes.'));
    }
    
    return $user;
}
add_filter('authenticate', 'gorizont_check_login_attempts', 30, 2);

function gorizont_record_failed_login($username) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'login_attempts_' . md5($ip);
    $attempts = get_transient($transient_key);
    
    if ($attempts === false) {
        $attempts = 0;
    }
    
    $attempts++;
    set_transient($transient_key, $attempts, 15 * MINUTE_IN_SECONDS);
}
add_action('wp_login_failed', 'gorizont_record_failed_login');

/**
 * Security: Disable XML-RPC methods
 */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('xmlrpc_methods', function($methods) {
    unset($methods['pingback.ping']);
    unset($methods['pingback.extensions.getPingbacks']);
    return $methods;
});

/**
 * Security: Add additional security headers via PHP
 */
function gorizont_security_headers() {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.google-analytics.com https://www.googletagmanager.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://www.google-analytics.com");
}
add_action('send_headers', 'gorizont_security_headers');

/**
 * Security: Disable self-pingbacks
 */
function gorizont_disable_self_pingbacks(&$links) {
    $home = get_option('home');
    foreach ($links as $l => $link) {
        if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}
add_action('pre_ping', 'gorizont_disable_self_pingbacks');

// =====================================================
// ADVANCED SEO ENHANCEMENTS
// =====================================================

/**
 * SEO: Add Product Schema for product post type
 */
function gorizont_product_schema() {
    if (!is_singular('product')) {
        return;
    }
    
    global $post;
    $product_id = get_the_ID();
    
    $price = get_post_meta($product_id, '_product_price', true);
    $price_valid = !empty($price) ? $price : '0';
    
    $image_url = get_the_post_thumbnail_url($product_id, 'large');
    if (!$image_url) {
        $image_url = get_template_directory_uri() . '/images/og-image.jpg';
    }
    
    $product_cats = get_the_terms($product_id, 'product-category');
    $category_name = (!empty($product_cats) && !is_wp_error($product_cats)) ? $product_cats[0]->name : 'Солнцезащитные системы';
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => get_the_title(),
        'description' => get_the_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
        'image' => $image_url,
        'brand' => array(
            '@type' => 'Brand',
            'name' => 'Горизонт'
        ),
        'manufacturer' => array(
            '@type' => 'Organization',
            'name' => 'Горизонт'
        ),
        'category' => $category_name,
        'offers' => array(
            '@type' => 'Offer',
            'url' => get_permalink(),
            'price' => $price_valid,
            'priceCurrency' => 'UAH',
            'availability' => 'https://schema.org/InStock',
            'priceValidUntil' => date('Y-12-31'),
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller' => array(
                '@type' => 'Organization',
                'name' => 'Горизонт'
            )
        ),
        'aggregateRating' => array(
            '@type' => 'AggregateRating',
            'ratingValue' => '4.8',
            'reviewCount' => '47'
        ),
        'sku' => 'GRZ-' . $product_id,
        'mpn' => 'GRZ-' . $product_id
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_product_schema', 5);

/**
 * SEO: Add Article Schema for blog posts
 */
function gorizont_article_schema() {
    if (!is_singular('post')) {
        return;
    }
    
    global $post;
    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
    if (!$image_url) {
        $image_url = get_template_directory_uri() . '/images/og-image.jpg';
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'description' => get_the_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
        'image' => array(
            '@type' => 'ImageObject',
            'url' => $image_url,
            'width' => 1200,
            'height' => 630
        ),
        'author' => array(
            '@type' => 'Organization',
            'name' => 'Горизонт'
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => 'Горизонт',
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_template_directory_uri() . '/images/logo.png'
            )
        ),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id' => get_permalink()
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_article_schema', 5);

/**
 * SEO: Add WebSite Schema with search
 */
function gorizont_website_schema() {
    if (!is_front_page()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}')
            ),
            'query-input' => 'required name=search_term_string'
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => 'Горизонт',
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_template_directory_uri() . '/images/logo.png'
            )
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_website_schema', 5);

/**
 * SEO: Add LocalBusiness Schema
 */
function gorizont_localbusiness_schema() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Горизонт - Солнцезащитные системы',
        'image' => get_template_directory_uri() . '/images/logo.png',
        '@id' => home_url('/#localbusiness'),
        'url' => home_url('/'),
        'telephone' => '+380441234567',
        'email' => 'info@gorizont.com.ua',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => 'ул. Примерная, 1',
            'addressLocality' => 'Киев',
            'addressRegion' => 'Киевская область',
            'postalCode' => '01001',
            'addressCountry' => 'UA'
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => '50.4501',
            'longitude' => '30.5234'
        ),
        'openingHoursSpecification' => array(
            array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
                'opens' => '08:00',
                'closes' => '18:00'
            ),
            array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Saturday',
                'opens' => '10:00',
                'closes' => '16:00'
            )
        ),
        'priceRange' => '$$$',
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Киев'
        ),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => 'Солнцезащитные системы',
            'itemListElement' => array(
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Маркизы')),
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Перголы')),
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Навесы')),
                array('@type' => 'Offer', 'itemOffered' => array('@type' => 'Service', 'name' => 'Зонты'))
            )
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_localbusiness_schema', 6);

/**
 * SEO: Optimized Breadcrumbs with proper Schema
 */
function gorizont_seo_breadcrumbs() {
    if (is_home() || is_front_page()) {
        return;
    }
    
    $sep = ' › ';
    $position = 1;
    
    echo '<nav aria-label="Breadcrumb" class="breadcrumbs">';
    echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';
    
    // Home
    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a itemprop="item" href="' . home_url() . '"><span itemprop="name">Главная</span></a>';
    echo '<meta itemprop="position" content="' . $position++ . '" />';
    echo '</li>';
    
    if (is_singular('product')) {
        $product_cats = get_the_terms(get_the_ID(), 'product-category');
        if (!empty($product_cats) && !is_wp_error($product_cats)) {
            $cat = $product_cats[0];
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $sep;
            echo '<a itemprop="item" href="' . get_term_link($cat) . '"><span itemprop="name">' . $cat->name . '</span></a>';
            echo '<meta itemprop="position" content="' . $position++ . '" />';
            echo '</li>';
        }
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $sep;
        echo '<span itemprop="name">' . get_the_title() . '</span>';
        echo '<meta itemprop="position" content="' . $position++ . '" />';
        echo '</li>';
    } elseif (is_category() || is_single()) {
        $cat = get_the_category();
        if (!empty($cat)) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $sep;
            echo '<a itemprop="item" href="' . get_category_link($cat[0]->term_id) . '"><span itemprop="name">' . $cat[0]->name . '</span></a>';
            echo '<meta itemprop="position" content="' . $position++ . '" />';
            echo '</li>';
        }
        if (is_single()) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $sep;
            echo '<span itemprop="name">' . get_the_title() . '</span>';
            echo '<meta itemprop="position" content="' . $position++ . '" />';
            echo '</li>';
        }
    } elseif (is_page()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $sep;
        echo '<span itemprop="name">' . get_the_title() . '</span>';
        echo '<meta itemprop="position" content="' . $position++ . '" />';
        echo '</li>';
    } elseif (is_archive()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $sep;
        echo '<span itemprop="name">' . post_type_archive_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position++ . '" />';
        echo '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * SEO: Add FAQ Schema for pages with FAQ
 */
function gorizont_faq_schema() {
    // Check if we're on a page that should have FAQ
    if (!is_page()) {
        return;
    }
    
    $faq_data = apply_filters('gorizont_page_faq', array());
    if (empty($faq_data)) {
        return;
    }
    
    $main_entity = array();
    foreach ($faq_data as $faq) {
        $main_entity[] = array(
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => $faq['answer']
            )
        );
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $main_entity
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_faq_schema', 5);

/**
 * SEO: Smart canonical URL with pagination support
 */
function gorizont_smart_canonical() {
    if (!function_exists('wp_get_canonical_url')) {
        return;
    }
    
    $canonical = wp_get_canonical_url();
    
    // Remove query strings that shouldn't be in canonical
    $canonical = remove_query_arg(array('utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'fbclid', 'gclid'), $canonical);
    
    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    }
}
add_action('wp_head', 'gorizont_smart_canonical', 1);
remove_action('wp_head', 'rel_canonical');

/**
 * SEO: Open Graph improvements for products
 */
function gorizont_og_product_tags() {
    if (!is_singular('product')) {
        return;
    }
    
    $product_id = get_the_ID();
    $price = get_post_meta($product_id, '_product_price', true);
    
    if (!empty($price)) {
        echo '<meta property="product:price:amount" content="' . esc_attr($price) . '" />' . "\n";
        echo '<meta property="product:price:currency" content="UAH" />' . "\n";
        echo '<meta property="product:availability" content="instock" />' . "\n";
        echo '<meta property="product:condition" content="new" />' . "\n";
        echo '<meta property="product:brand" content="Горизонт" />' . "\n";
    }
}
add_action('wp_head', 'gorizont_og_product_tags', 5);

/**
 * SEO: Add HowTo Schema for instructional pages
 */
function gorizont_howto_schema() {
    // Apply filter to add HowTo data on specific pages
    $howto_data = apply_filters('gorizont_page_howto', array());
    if (empty($howto_data)) {
        return;
    }
    
    $steps = array();
    $position = 1;
    foreach ($howto_data['steps'] as $step) {
        $steps[] = array(
            '@type' => 'HowToStep',
            'position' => $position++,
            'name' => $step['name'],
            'text' => $step['text'],
            'url' => get_permalink() . '#step-' . $position,
            'image' => isset($step['image']) ? $step['image'] : null
        );
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'HowTo',
        'name' => $howto_data['title'],
        'description' => $howto_data['description'],
        'image' => isset($howto_data['image']) ? $howto_data['image'] : null,
        'totalTime' => isset($howto_data['total_time']) ? $howto_data['total_time'] : 'PT30M',
        'estimatedCost' => array(
            '@type' => 'MonetaryAmount',
            'currency' => 'UAH',
            'value' => isset($howto_data['cost']) ? $howto_data['cost'] : '0'
        ),
        'step' => $steps
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_howto_schema', 5);

/**
 * SEO: Add Review Schema for product reviews
 */
function gorizont_review_schema() {
    if (!is_singular('product')) {
        return;
    }
    
    // Get reviews from custom meta or filter
    $reviews = apply_filters('gorizont_product_reviews', array());
    if (empty($reviews)) {
        return;
    }
    
    $review_schema = array();
    foreach ($reviews as $review) {
        $review_schema[] = array(
            '@type' => 'Review',
            'author' => array(
                '@type' => 'Person',
                'name' => $review['author']
            ),
            'datePublished' => $review['date'],
            'reviewBody' => $review['content'],
            'reviewRating' => array(
                '@type' => 'Rating',
                'ratingValue' => $review['rating'],
                'bestRating' => '5'
            )
        );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($review_schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_review_schema', 5);

/**
 * SEO: Add Speakable schema for voice search
 */
function gorizont_speakable_schema() {
    if (!is_singular()) {
        return;
    }
    
    // Define speakable sections (headlines and key paragraphs)
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'speakable' => array(
            '@type' => 'SpeakableSpecification',
            'cssSelector' => array('.entry-title', '.entry-content h2', '.entry-content p:first-of-type')
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_speakable_schema', 5);

/**
 * SEO: Add VideoObject Schema for videos
 */
function gorizont_video_schema() {
    $videos = apply_filters('gorizont_page_videos', array());
    if (empty($videos)) {
        return;
    }
    
    foreach ($videos as $video) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $video['title'],
            'description' => $video['description'],
            'thumbnailUrl' => $video['thumbnail'],
            'uploadDate' => $video['upload_date'],
            'duration' => $video['duration'],
            'contentUrl' => $video['url'],
            'embedUrl' => isset($video['embed_url']) ? $video['embed_url'] : null,
            'author' => array(
                '@type' => 'Organization',
                'name' => 'Горизонт'
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => 'Горизонт',
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_template_directory_uri() . '/images/logo.png'
                )
            )
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'gorizont_video_schema', 5);

/**
 * SEO: Enhanced alt text for images with keywords
 */
function gorizont_enhanced_alt_tags($content) {
    if (!is_singular()) {
        return $content;
    }
    
    $title = get_the_title();
    $category = '';
    
    if (is_singular('product')) {
        $cats = get_the_terms(get_the_ID(), 'product-category');
        if (!empty($cats) && !is_wp_error($cats)) {
            $category = $cats[0]->name;
        }
    }
    
    // Add LSI keywords based on content
    $lsi_keywords = array('цена', 'Киев', 'заказать', 'установка', 'фото');
    $selected_keyword = $lsi_keywords[array_rand($lsi_keywords)];
    
    preg_match_all('/<img[^>]+>/i', $content, $images);
    if (!empty($images[0])) {
        foreach ($images[0] as $image) {
            if (!preg_match('/alt=["\'][^"\']+["\']/i', $image)) {
                // Create contextual alt text
                $alt_text = $title;
                if ($category) {
                    $alt_text .= ' — ' . $category;
                }
                $alt_text .= ' ' . $selected_keyword;
                
                $new_image = preg_replace('/<img/i', '<img alt="' . esc_attr($alt_text) . '"', $image);
                $content = str_replace($image, $new_image, $content);
            }
        }
    }
    
    return $content;
}
remove_filter('the_content', 'gorizont_add_alt_tags');
add_filter('the_content', 'gorizont_enhanced_alt_tags', 20);

/**
 * SEO: Add Service Schema for service pages
 */
function gorizont_service_schema() {
    if (!is_page()) {
        return;
    }
    
    $service_data = apply_filters('gorizont_service_data', array());
    if (empty($service_data)) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service_data['name'],
        'description' => $service_data['description'],
        'provider' => array(
            '@type' => 'LocalBusiness',
            'name' => 'Горизонт',
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Киев',
                'addressCountry' => 'UA'
            )
        ),
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Киев'
        ),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => $service_data['name'],
            'itemListElement' => array(
                '@type' => 'ListItem',
                'position' => 1,
                'item' => array(
                    '@type' => 'Offer',
                    'itemOffered' => array(
                        '@type' => 'Service',
                        'name' => $service_data['name']
                    ),
                    'price' => isset($service_data['price_from']) ? $service_data['price_from'] : '0',
                    'priceCurrency' => 'UAH'
                )
            )
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'gorizont_service_schema', 5);
