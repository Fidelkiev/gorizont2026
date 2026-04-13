<?php get_header(); ?>

<div class="content">
    <div class="page-width">
        <?php if (function_exists('gorizont_breadcrumbs')) gorizont_breadcrumbs(); ?>
        <div class="clearfix">
            <div class="main">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('product-single'); ?>>
                        <h1><?php the_title(); ?></h1>
                        
                        <div class="product-gallery">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="product-main-image">
                                    <?php the_post_thumbnail('large', array('class' => 'product-image')); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <div class="product-description">
                                <?php the_content(); ?>
                            </div>
                            
                            <div class="product-meta">
                                <?php
                                $price = get_post_meta(get_the_ID(), '_product_price', true);
                                if ($price) {
                                    echo '<div class="product-price">';
                                    echo '<span>' . __('Price from:', 'gorizont') . '</span> ';
                                    echo '<strong>' . $price . '</strong>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            
                            <div class="product-actions">
                                <a href="#popupOrderNow" class="btn btn-primary popup-caller">
                                    <?php _e('Make Order', 'gorizont'); ?>
                                </a>
                                <a href="#popupMasterCall" class="btn btn-secondary popup-caller">
                                    <?php _e('Call Measurer', 'gorizont'); ?>
                                </a>
                            </div>
                        </div>
                        
                        <?php
                        $product_cats = get_the_terms(get_the_ID(), 'product-category');
                        if ($product_cats && !is_wp_error($product_cats)) :
                        ?>
                            <div class="product-categories">
                                <h3><?php _e('Categories:', 'gorizont'); ?></h3>
                                <?php foreach ($product_cats as $cat) : ?>
                                    <a href="<?php echo get_term_link($cat); ?>" class="category-tag">
                                        <?php echo $cat->name; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                    
                    <!-- Related Products -->
                    <?php
                    $related_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand',
                    );
                    
                    $related_query = new WP_Query($related_args);
                    
                    if ($related_query->have_posts()) :
                    ?>
                        <div class="related-products">
                            <h2><?php _e('Related Products', 'gorizont'); ?></h2>
                            <div class="products-grid">
                                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                    <div class="product-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="product-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('medium'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
            
            <div class="sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
