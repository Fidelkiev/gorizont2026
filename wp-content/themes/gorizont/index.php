<?php get_header(); ?>

<div class="content">
    <div class="page-width">
        <?php if (function_exists('gorizont_breadcrumbs')) gorizont_breadcrumbs(); ?>
        <div class="clearfix">
            <div class="main">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="post-meta">
                                <?php echo get_the_date(); ?> | <?php the_author(); ?>
                            </div>
                            <div class="post-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                    
                    <div class="pagination">
                        <?php 
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('&laquo; Previous'),
                            'next_text' => __('Next &raquo;'),
                        )); 
                        ?>
                    </div>
                <?php else : ?>
                    <p><?php _e('No posts found.', 'gorizont'); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
