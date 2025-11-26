<?php
/**
 * Template Name: Blog Posts Page
 * Description: Main blog page with custom layout
 */
get_header();
?>

<div class="container blog-page">
    <div class="row">
        <?php if (have_posts()): ?>
            <?php $post_count = 0; ?>

            <?php while (have_posts()):
                the_post(); ?>
                <?php $post_count++; ?>

                <?php if ($post_count == 1): ?>
                    <!-- First Post - Featured Layout -->
                    <div class="col-12 first-post-featured mb-5">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('featured-post'); ?>>
                            <?php if (has_post_thumbnail()): ?>
                                <div class="featured-post-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="featured-post-content">
                                <div class="post-meta mb-2">
                                    <span class="author">By <?php the_author(); ?></span>
                                    <span class="seperator">|</span>
                                    <span class="date"><?php echo get_the_date(); ?></span>
                                </div>

                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="read-more btn btn-primary">
                                    Read More <i class="fa-solid fa-arrow-up"></i>
                                </a>
                            </div>
                        </article>
                    </div>

                    <!-- Start Grid Layout for Remaining Posts -->
                    <div class="col-12">
                        <div class="posts-grid">
                        <?php else: ?>
                            <!-- Grid Posts -->
                            <div class="post-grid-item">
                                <article id="post-<?php the_ID(); ?>" <?php post_class('grid-post'); ?>>
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="grid-post-image mb-3">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="grid-post-content">
                                        <div class="post-meta mb-2">
                                            <span class="author">By <?php the_author(); ?></span>
                                            <span class="date"><?php echo get_the_date(); ?></span>
                                        </div>

                                        <h3 class="post-title h5">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>

                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            Read More
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endif; ?>

                    <?php endwhile; ?>

                    <?php if ($post_count > 1): ?>
                    </div> <!-- Close .row.posts-grid -->
                </div> <!-- Close .col-12 -->
            <?php endif; ?>

            <!-- Pagination -->
            <div class="col-12">
                <div class="blog-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('&laquo; Previous'),
                        'next_text' => __('Next &raquo;'),
                    ));
                    ?>
                </div>
            </div>

        <?php else: ?>
            <div class="col-12">
                <p>No posts found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>