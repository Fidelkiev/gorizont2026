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
    
    // Register navigation menus
    register_nav_menus(array(
        'top' => __('Top Menu', 'gorizont'),
        'footer' => __('Footer Menu', 'gorizont'),
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
