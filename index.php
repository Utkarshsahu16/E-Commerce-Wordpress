<?php
/**
 * The main template file
 *
 * @package EcommerceTheme
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="posts-container">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-item mb-4'); ?>>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail mb-3">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="post-meta mb-3">
                                        <span class="post-date">
                                            <i class="fas fa-calendar"></i>
                                            <?php echo get_the_date(); ?>
                                        </span>
                                        <span class="post-author">
                                            <i class="fas fa-user"></i>
                                            <?php echo get_the_author(); ?>
                                        </span>
                                        <span class="post-comments">
                                            <i class="fas fa-comments"></i>
                                            <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="post-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <div class="post-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                        
                        <div class="pagination-wrapper">
                            <?php
                            the_posts_pagination(array(
                                'mid_size' => 2,
                                'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
                                'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="no-posts">
                <h2><?php _e('Nothing Found', 'ecommerce-theme'); ?></h2>
                <p><?php _e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'ecommerce-theme'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>