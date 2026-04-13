<?php get_header(); ?>

<div class="content">
    <div class="page-width">
        <?php if (function_exists('gorizont_breadcrumbs')) gorizont_breadcrumbs(); ?>
        <div class="clearfix">
            <div class="main">
                <header class="page-header">
                    <h1><?php single_term_title(); ?></h1>
                    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                </header>
                
                <div class="products-grid">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="product-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="product-content">
                                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    
                                    <div class="product-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <div class="product-meta">
                                        <?php
                                        $price = get_post_meta(get_the_ID(), '_product_price', true);
                                        if ($price) {
                                            echo '<div class="product-price">';
                                            echo __('Price from:', 'gorizont') . ' <strong>' . $price . '</strong>';
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <?php _e('View Details', 'gorizont'); ?>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                        
                        <div class="pagination">
                            <?php
                            the_posts_pagination(array(
                                'mid_size' => 2,
                                'prev_text' => __('&laquo; Previous', 'gorizont'),
                                'next_text' => __('Next &raquo;', 'gorizont'),
                            ));
                            ?>
                        </div>
                    <?php else : ?>
                        <p><?php _e('No products found in this category.', 'gorizont'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
