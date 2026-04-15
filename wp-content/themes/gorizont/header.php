<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php echo esc_attr(get_the_excerpt() ? get_the_excerpt() : 'Маркизы, перголы, навесы, зонты от Горизонт - солнцезащитные системы премиум класса. Бесплатный замер, установка, гарантия 5 лет.'); ?>">
    <meta name="keywords" content="маркизы, перголы, навесы, зонты, солнцезащитные системы, Киев, Украина">
    <meta name="author" content="Горизонт">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="og:title" content="<?php echo esc_attr(wp_title('|', false, 'right') . get_bloginfo('name')); ?>">
    <meta property="og:description" content="<?php echo esc_attr(get_the_excerpt() ? get_the_excerpt() : 'Маркизы, перголы, навесы от Горизонт - солнцезащитные системы премиум класса.'); ?>">
    <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large') ? get_the_post_thumbnail_url(null, 'large') : get_template_directory_uri() . '/images/og-image.jpg'); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:locale" content="ru_RU">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr(wp_title('|', false, 'right') . get_bloginfo('name')); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr(get_the_excerpt() ? get_the_excerpt() : 'Маркизы, перголы, навесы от Горизонт - солнцезащитные системы премиум класса.'); ?>">
    <meta name="twitter:image" content="<?php echo esc_url(get_the_post_thumbnail_url(null, 'large') ? get_the_post_thumbnail_url(null, 'large') : get_template_directory_uri() . '/images/og-image.jpg'); ?>">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- DNS Prefetch for external resources -->
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/style.css" as="style">
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/js/main.js" as="script">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="bone">
    <div class="bg-top">
        <div class="page-width">
            <div class="header">
                <div class="clearfix">
                    <strong class="logo">
                        <a href="<?php echo home_url('/'); ?>">
                            <?php bloginfo('name'); ?> &reg; <?php _e('Sun Protection Systems', 'gorizont'); ?>
                        </a>
                    </strong>
                    
                    <div class="topnav">
                        <ul>
                            <li><a href="<?php echo home_url('/category/novosti'); ?>"><?php _e('News', 'gorizont'); ?></a></li>
                            <li><a href="<?php echo home_url('/o-kompanii-gorizont.html'); ?>"><?php _e('Company', 'gorizont'); ?></a></li>
                            <li><a href="<?php echo home_url('/kak-sdelat-zakaz.html'); ?>"><?php _e('How to Order', 'gorizont'); ?></a></li>
                            <li><a href="<?php echo home_url('/servis-i-garantiya.html'); ?>"><?php _e('Service & Warranty', 'gorizont'); ?></a></li>
                            <li><a href="<?php echo home_url('/contacts.html'); ?>"><?php _e('Contacts', 'gorizont'); ?></a></li>
                        </ul>
                        
                        <ul>
                            <li><?php _e('Working Hours:', 'gorizont'); ?></li>
                            <li><?php _e('Office: 8:00 - 18:00', 'gorizont'); ?></li>
                            <li><?php _e('Monday - Friday', 'gorizont'); ?></li>
                            <li><?php _e('Measurer: 8:00 - 22:00', 'gorizont'); ?></li>
                            <li><?php _e('Daily!', 'gorizont'); ?></li>
                        </ul>
                        
                        <ul>
                            <li><b><?php _e('Order through site - discount:', 'gorizont'); ?></b></li>
                            <li><img src="<?php echo get_template_directory_uri(); ?>/images/ico/10.jpg" alt="<?php _e('Discount', 'gorizont'); ?>" /></li>
                        </ul>
                    </div>
                </div>
                
                <button class="menu-toggle" aria-label="Toggle Menu" aria-expanded="false">☰</button>
                
                <?php wp_nav_menu(array(
                    'theme_location' => 'top',
                    'menu_class' => 'main-menu',
                    'container' => 'nav',
                    'container_class' => 'main-navigation',
                    'container_aria_label' => 'Primary Menu'
                )); ?>
            </div>
        </div>
    </div>
