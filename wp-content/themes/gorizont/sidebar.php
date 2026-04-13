<?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="sidebar-widgets">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
<?php endif; ?>

<!-- Categories Widget -->
<div class="widget widget-categories">
    <h3 class="widget-title"><?php _e('Categories', 'gorizont'); ?></h3>
    <ul>
        <?php wp_list_categories(array(
            'title_li' => '',
            'show_count' => true,
        )); ?>
    </ul>
</div>

<!-- Products Categories -->
<div class="widget widget-product-categories">
    <h3 class="widget-title"><?php _e('Product Categories', 'gorizont'); ?></h3>
    <ul>
        <?php 
        $product_cats = get_terms(array(
            'taxonomy' => 'product-category',
            'hide_empty' => false,
        ));
        
        if ($product_cats && !is_wp_error($product_cats)) {
            foreach ($product_cats as $cat) {
                echo '<li><a href="' . get_term_link($cat) . '">' . $cat->name . '</a></li>';
            }
        }
        ?>
    </ul>
</div>

<!-- Contact Information -->
<div class="widget widget-contact">
    <h3 class="widget-title"><?php _e('Contact Information', 'gorizont'); ?></h3>
    <div class="contact-info">
        <p><strong><?php _e('Phone:', 'gorizont'); ?></strong><br>
        +380 44 123-45-67</p>
        
        <p><strong><?php _e('Email:', 'gorizont'); ?></strong><br>
        info@gorizont.com.ua</p>
        
        <p><strong><?php _e('Address:', 'gorizont'); ?></strong><br>
        <?php _e('Kiev, Ukraine', 'gorizont'); ?></p>
        
        <p><strong><?php _e('Working Hours:', 'gorizont'); ?></strong><br>
        <?php _e('Mon-Fri: 8:00 - 18:00', 'gorizont'); ?><br>
        <?php _e('Sat-Sun: 10:00 - 16:00', 'gorizont'); ?></p>
    </div>
</div>
