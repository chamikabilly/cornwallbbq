<?php

/**
 * The Front Page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miheli_Solutions
 */

get_header();
$home = home_url();


// Our Category Section 
$pop_categories = get_field('popular_categories');
$cat_title = isset($pop_categories['section_title']) ? $pop_categories['section_title'] : '';
$cat_items = isset($pop_categories['popular_categories']) ? $pop_categories['popular_categories'] : array();

// Our Story Section 
$our_story_section = get_field('our_story');

// Shop Section 
$shop_section = get_field('shop');

// Testimonial Section
$testimonial_section = get_field('testimonial');

// Contact Us Section
$contact_us_section = get_field('contact_us');

?>


<!-- Hero Section  -->
<section class="hero-section">
    <?php

    if( have_rows('hero_slides') ):
    ?>
        <!-- Slider main container -->
        <div class="swiper hero_swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php
                while( have_rows('hero_slides') ) : the_row();
                    $hero_slide = get_sub_field('hero_slide');
                    $background_image = isset($hero_slide['background_image']) ? $hero_slide['background_image'] : '';
                    $large_text = isset($hero_slide['large_text']) ? $hero_slide['large_text'] : '';
                    $small_text = isset($hero_slide['small_text']) ? $hero_slide['small_text'] : '';

                    // Get image URL if it's an image ID
                    if (is_numeric($background_image)) {
                        $image_url = wp_get_attachment_image_url($background_image, 'full');
                    } else {
                        $image_url = $background_image; // if it's already a URL
                    }
                ?>
                    <!-- Slides -->
                    <div class="swiper-slide" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                        <div class="swiper-overlay"></div>
                        <div class="swiper-content-wrapper">
                            <h1 class="swiper-large-text animate-fade-down" data-delay="0.3s">
                                <?php echo esc_html($large_text); ?>
                            </h1>
                            <h6 class="swiper-small-text animate-fade-down" data-delay="0.8s">
                                <?php echo esc_html($small_text); ?>
                            </h6>
                        </div>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
    <?php endif; ?>
</section>
<!-- Hero Section end -->


<!-- Ash Background Section -->
<section class="bg-ash">

    <!-- Popular Categories Section -->
    <section class="fe-cat">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <h3 class="fe-cat-title animate-on-scroll">
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png"
                            alt="text-bg" class="text-bg" loading="lazy">
                        <?php echo $cat_title; ?>
                    </h3>

                    <div class="pop-cat-list">
                        <?php 
                        if (!empty($cat_items)) :
                            foreach ($cat_items as $index => $item) :
                                $category_item = isset($item['category_item']) ? $item['category_item'] : array();
                                $product_category = isset($category_item['product_category']) ? $category_item['product_category'] : '';
                                $category_image = isset($category_item['category_image']) ? $category_item['category_image'] : '';
                                $category_page_id = isset($category_item['category_page']) ? $category_item['category_page'] : 0;
                                
                                // Get the category link
                                $category_link = $category_page_id ? get_term_link((int)$category_page_id, 'product_cat') : '#';
                                if (is_wp_error($category_link)) {
                                    $category_link = '#';
                                }
                        ?>
                                <div class="cat-container animate-on-scroll">
                                    <a href="<?php echo esc_url($category_link); ?>">
                                        <?php if ($category_image) : ?>
                                            <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($product_category); ?>"
                                                class="img-fluid" loading="lazy">
                                        <?php endif; ?>
                                        <div class="cat-name-container">
                                            <?php echo esc_html($product_category); ?>
                                        </div>
                                    </a>
                                </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular Categories Section End -->

    <!-- Our Story Section -->
    <section class="our-story">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <div class="os-title-holder animate-on-scroll">
                        <h3 class="os-title"><?php echo $our_story_section['section_title'] ?></h3>
                        <h6 class="os-sub-title"> <?php echo $our_story_section['section_sub_title'] ?></h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <img src="<?php echo $our_story_section['about_image'] ?>"
                            alt="<?php echo $our_story_section['section_title'] ?>-img"
                            class="img-fluid animate-on-scroll" loading="lazy">
                    </div>
                    <div class="col-lg-8">
                        <div class="os-content-holder animate-on-scroll">
                            <div class="os-para">
                                <?php echo $our_story_section['about_us_description'] ?>
                            </div>
                            <a href="<?php echo $our_story_section['read_more_link'] ?>" class="readmore-btn">Read More
                                <i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Story Section End -->

    <!-- Shop Section -->
    <section class="shop-section">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <div class="ss-title-holder animate-on-scroll">
                        <h3 class="ss-title animate-on-scroll">
                            <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png"
                                alt="text-bg" class="text-bg" loading="lazy">
                            <?php echo empty($shop_section['section_title']) ? 'Please set a title in the Shop section' : esc_html($shop_section['section_title']); ?>
                        </h3>
                        <h6 class="ss-sub-title animate-on-scroll"><?php echo empty($shop_section['section_sub_title']) ? 'Please set a subtitle in the Shop section' : esc_html($shop_section['section_sub_title']); ?></h6>
                    </div>
                    <div class="ss-tab-section animate-on-scroll">
                        <ul>
                            <li class="active" data-category="all">All</li>
                            <li data-category="featured">Featured</li>
                            <li data-category="on-sale">On Sale</li>
                            <li data-category="top-rated-product">Top Rated</li>
                        </ul>
                    </div>
                </div>

                <div class="row g-md-3 g-0" id="product-grid">
                    <?php
                    // Initial load - show all products
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 8,
                        'status' => 'publish'
                    );

                    $products = new WP_Query($args);

                    if ($products->have_posts()) {
                        while ($products->have_posts()) {
                            $products->the_post();
                            global $product;
                            $product_id = $product->get_id();
                            $product_type = $product->get_type();
                            $is_variable = $product_type === 'variable';
                            $has_price = $product->get_price() !== '' && $product->get_price() !== null;
                    ?>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="product-container animate-on-scroll">
                                    <div class="product-img-holder ">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('medium');
                                        } else {
                                            echo '<img src="' . $home . '/wp-content/themes/miheli-solutions/assets/images/test-img.png" alt="' . get_the_title() . '" loading="lazy">';
                                        }
                                        ?>
                                        <div class="product-hover-actions">
                                            <?php if ($has_price) : ?>
                                                <button class="add-to-cart-btn" data-product-id="<?php echo $product_id; ?>"
                                                    data-is-variable="<?php echo $is_variable ? 'true' : 'false'; ?>">
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                </button>
                                            <?php endif; ?>
                                            <a href="<?php the_permalink(); ?>" class="quick-view-btn">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </div>
                                        <?php
                                        if ($product->is_on_sale()) {
                                        ?>
                                            <div class="product-sale-badge">
                                                <span class="sale-text">Sale</span>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="product-content-holder ">
                                        <h6 class="product-title"><?php the_title(); ?></h6>
                                        <p class="product-prize"><?php echo $product->get_price_html(); ?></p>
                                        <p class="star-ratings">
                                            <?php
                                            // Display star ratings as SVG stars (fallback uses SVG too)
                                            $rating = floatval($product->get_average_rating());
                                            // Normalize rating between 0 and 5
                                            if ($rating < 0) {
                                                $rating = 0;
                                            }
                                            if ($rating > 5) {
                                                $rating = 5;
                                            }
                                            for ($s = 1; $s <= 5; $s++) {
                                                // Calculate how much of this star should be filled (0.0 - 1.0)
                                                $star_fill = max(0, min(1, $rating - ($s - 1)));
                                                $clip_width = 17 * $star_fill; // SVG viewBox is 0 0 17 17
                                                $clip_id = 'clip-' . $product_id . '-' . $s;
                                            ?>
                                                <svg class="star" width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                                    <defs>
                                                        <clipPath id="<?php echo esc_attr($clip_id); ?>">
                                                            <rect x="0" y="0" width="<?php echo esc_attr(number_format((float) $clip_width, 3, '.', '')); ?>" height="17" />
                                                        </clipPath>
                                                    </defs>
                                                    <!-- Filled portion (clipped to percentage) -->
                                                    <path d="M7.87292 2.00164C8.06503 1.42216 8.16104 1.13243 8.30311 1.05213C8.42601 0.982624 8.57397 0.982624 8.69696 1.05213C8.83895 1.13243 8.93496 1.42216 9.12707 2.00164L10.397 5.83256C10.4517 5.99749 10.479 6.07995 10.5283 6.14136C10.5718 6.19561 10.6273 6.23789 10.6899 6.26452C10.7608 6.29467 10.844 6.29644 11.0105 6.3L14.8774 6.38264C15.4624 6.39513 15.7548 6.40139 15.8716 6.51821C15.9726 6.61932 16.0183 6.76693 15.9933 6.91099C15.9644 7.07747 15.7313 7.26273 15.2651 7.63343L12.1829 10.0836C12.0502 10.1892 11.9839 10.2419 11.9434 10.31C11.9077 10.3702 11.8865 10.4386 11.8817 10.5092C11.8763 10.5893 11.9003 10.6728 11.9486 10.84L13.0686 14.722C13.238 15.3092 13.3227 15.6028 13.2528 15.7553C13.1923 15.8873 13.0726 15.9785 12.9342 15.9981C12.7743 16.0206 12.5342 15.8454 12.054 15.495L8.87919 13.1785C8.74252 13.0787 8.67422 13.0289 8.59995 13.0095C8.53431 12.9924 8.46568 12.9924 8.40012 13.0095C8.32585 13.0289 8.25747 13.0787 8.12079 13.1785L4.94607 15.495C4.46586 15.8454 4.22575 16.0206 4.06583 15.9981C3.92744 15.9785 3.80769 15.8873 3.7472 15.7553C3.67731 15.6028 3.76203 15.3092 3.93144 14.722L5.05145 10.84C5.09966 10.6728 5.12377 10.5893 5.11834 10.5092C5.11355 10.4386 5.09235 10.3702 5.05659 10.31C5.01612 10.2419 4.94978 10.1892 4.81709 10.0836L1.73499 7.63343C1.26878 7.26273 1.03567 7.07747 1.00674 6.91099C0.981685 6.76693 1.02743 6.61932 1.12844 6.51821C1.24515 6.40139 1.53762 6.39514 2.12254 6.38264L5.98949 6.3C6.15596 6.29644 6.2392 6.29467 6.31012 6.26452C6.37276 6.23789 6.42826 6.19561 6.47177 6.14136C6.52103 6.07995 6.54837 5.99749 6.60304 5.83256L7.87292 2.00164Z" fill="#FFAC42" clip-path="url(#<?php echo esc_attr($clip_id); ?>)" />
                                                    <!-- Stroke (outline) on top so shape remains visible when partially filled) -->
                                                    <path d="M7.87292 2.00164C8.06503 1.42216 8.16104 1.13243 8.30311 1.05213C8.42601 0.982624 8.57397 0.982624 8.69696 1.05213C8.83895 1.13243 8.93496 1.42216 9.12707 2.00164L10.397 5.83256C10.4517 5.99749 10.479 6.07995 10.5283 6.14136C10.5718 6.19561 10.6273 6.23789 10.6899 6.26452C10.7608 6.29467 10.844 6.29644 11.0105 6.3L14.8774 6.38264C15.4624 6.39513 15.7548 6.40139 15.8716 6.51821C15.9726 6.61932 16.0183 6.76693 15.9933 6.91099C15.9644 7.07747 15.7313 7.26273 15.2651 7.63343L12.1829 10.0836C12.0502 10.1892 11.9839 10.2419 11.9434 10.31C11.9077 10.3702 11.8865 10.4386 11.8817 10.5092C11.8763 10.5893 11.9003 10.6728 11.9486 10.84L13.0686 14.722C13.238 15.3092 13.3227 15.6028 13.2528 15.7553C13.1923 15.8873 13.0726 15.9785 12.9342 15.9981C12.7743 16.0206 12.5342 15.8454 12.054 15.495L8.87919 13.1785C8.74252 13.0787 8.67422 13.0289 8.59995 13.0095C8.53431 12.9924 8.46568 12.9924 8.40012 13.0095C8.32585 13.0289 8.25747 13.0787 8.12079 13.1785L4.94607 15.495C4.46586 15.8454 4.22575 16.0206 4.06583 15.9981C3.92744 15.9785 3.80769 15.8873 3.7472 15.7553C3.67731 15.6028 3.76203 15.3092 3.93144 14.722L5.05145 10.84C5.09966 10.6728 5.12377 10.5893 5.11834 10.5092C5.11355 10.4386 5.09235 10.3702 5.05659 10.31C5.01612 10.2419 4.94978 10.1892 4.81709 10.0836L1.73499 7.63343C1.26878 7.26273 1.03567 7.07747 1.00674 6.91099C0.981685 6.76693 1.02743 6.61932 1.12844 6.51821C1.24515 6.40139 1.53762 6.39514 2.12254 6.38264L5.98949 6.3C6.15596 6.29644 6.2392 6.29467 6.31012 6.26452C6.37276 6.23789 6.42826 6.19561 6.47177 6.14136C6.52103 6.07995 6.54837 5.99749 6.60304 5.83256L7.87292 2.00164Z" fill="none" stroke="#FFAC42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<p>No products found</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

</section>


<!-- Customer Testimonial Section  -->
<section class="testimonail-section">
    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <div class="ts-title-holder animate-on-scroll">
                    <h3 class="ts-title animate-on-scroll">
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png"
                            alt="text-bg" class="text-bg" loading="lazy">
                        <?php echo isset($testimonial_section['title']) ? esc_html($testimonial_section['title']) : 'Please add a title in the Testimonial section of the ACF fields.'; ?>
                    </h3>
                    <h6 class="ts-sub-title animate-on-scroll">
                        <?php echo isset($testimonial_section['sub_title']) ? esc_html($testimonial_section['sub_title']) : 'Please add a subtitle in the Testimonial section of the ACF fields.'; ?>
                    </h6>
                </div>
            </div>
            <div class="col-12">
                <div class="testimonial-slider-holder animate-on-scroll">
                    <!-- Slider main container -->
                    <div class="testimonials-swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <?php
                            $testimonial_args = array(
                                'post_type' => 'testimonial',
                                'posts_per_page' => 10,
                                'post_status' => 'publish'
                            );
                            $testimonial_query = new WP_Query($testimonial_args);

                            if ($testimonial_query->have_posts()) :
                                while ($testimonial_query->have_posts()) :
                                    $testimonial_query->the_post();
                                    $testimonial_id = get_the_ID();
                                    $reviewer_name = get_field('reviewer_name', $testimonial_id);
                                    $reviewer_image = get_field('reviewer_image', $testimonial_id);
                                    $review_rating = intval(get_field('review_rating', $testimonial_id));
                                    $review_text = get_field('review_text', $testimonial_id);

                                    $display_name = $reviewer_name ? $reviewer_name : get_the_title();
                                    $avatar_url = $reviewer_image ? $reviewer_image : $home . '/wp-content/themes/miheli-solutions/assets/images/fallback-avatar.png';
                                    $safe_rating = max(0, min(5, $review_rating));
                            ?>
                                    <div class="swiper-slide">
                                        <div class="ts-wrp">
                                            <div class="ts-top">
                                                <div class="ts-avatar">
                                                    <img src="<?php echo esc_url($avatar_url); ?>"
                                                        alt="<?php echo esc_attr($display_name); ?>" loading="lazy">
                                                </div>
                                                <div class="ts-top-content">
                                                    <h6><?php echo esc_html($display_name); ?></h6>
                                                    <p class="star-rating" aria-label="<?php echo esc_attr($safe_rating); ?> out of 5">
                                                        <?php for ($s = 1; $s <= 5; $s++) {
                                                            $is_filled = $s <= $safe_rating;
                                                        ?>
                                                            <svg class="star" width="17" height="17" viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                                                <path d="M7.87292 2.00164C8.06503 1.42216 8.16104 1.13243 8.30311 1.05213C8.42601 0.982624 8.57397 0.982624 8.69696 1.05213C8.83895 1.13243 8.93496 1.42216 9.12707 2.00164L10.397 5.83256C10.4517 5.99749 10.479 6.07995 10.5283 6.14136C10.5718 6.19561 10.6273 6.23789 10.6899 6.26452C10.7608 6.29467 10.844 6.29644 11.0105 6.3L14.8774 6.38264C15.4624 6.39513 15.7548 6.40139 15.8716 6.51821C15.9726 6.61932 16.0183 6.76693 15.9933 6.91099C15.9644 7.07747 15.7313 7.26273 15.2651 7.63343L12.1829 10.0836C12.0502 10.1892 11.9839 10.2419 11.9434 10.31C11.9077 10.3702 11.8865 10.4386 11.8817 10.5092C11.8763 10.5893 11.9003 10.6728 11.9486 10.84L13.0686 14.722C13.238 15.3092 13.3227 15.6028 13.2528 15.7553C13.1923 15.8873 13.0726 15.9785 12.9342 15.9981C12.7743 16.0206 12.5342 15.8454 12.054 15.495L8.87919 13.1785C8.74252 13.0787 8.67422 13.0289 8.59995 13.0095C8.53431 12.9924 8.46568 12.9924 8.40012 13.0095C8.32585 13.0289 8.25747 13.0787 8.12079 13.1785L4.94607 15.495C4.46586 15.8454 4.22575 16.0206 4.06583 15.9981C3.92744 15.9785 3.80769 15.8873 3.7472 15.7553C3.67731 15.6028 3.76203 15.3092 3.93144 14.722L5.05145 10.84C5.09966 10.6728 5.12377 10.5893 5.11834 10.5092C5.11355 10.4386 5.09235 10.3702 5.05659 10.31C5.01612 10.2419 4.94978 10.1892 4.81709 10.0836L1.73499 7.63343C1.26878 7.26273 1.03567 7.07747 1.00674 6.91099C0.981685 6.76693 1.02743 6.61932 1.12844 6.51821C1.24515 6.40139 1.53762 6.39514 2.12254 6.38264L5.98949 6.3C6.15596 6.29644 6.2392 6.29467 6.31012 6.26452C6.37276 6.23789 6.42826 6.19561 6.47177 6.14136C6.52103 6.07995 6.54837 5.99749 6.60304 5.83256L7.87292 2.00164Z" fill="<?php echo $is_filled ? '#FFAC42' : 'none'; ?>" stroke="#FFAC42" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        <?php } ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="ts-content">
                                                <?php echo wp_kses_post(nl2br(esc_html($review_text))); ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                        <!-- If we need pagination -->
                        <div class="testimonials-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Contact Form Section -->
<section class="contact-form-section ">
    <div class="container-fluid g-0">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="contact-form-holder animate-on-scroll">
                    <div class="contact-form-title">
                        <h3 class="cft-title animate-on-scroll">
                            <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png"
                                alt="text-bg" class="text-bg" loading="lazy">
                            <?php echo empty($contact_us_section['title']) ? 'Please set a title in the Contact Us section' : esc_html($contact_us_section['title']); ?>
                        </h3>
                    </div>
                    <div class="contact-form-container">
                        <?php
                        $contact_shortcode = empty($contact_us_section['shortcode']) ? '' : $contact_us_section['shortcode'];
                        echo $contact_shortcode ? do_shortcode($contact_shortcode) : '<p class="text-light">Please add a contact form shortcode in the ACF fields for the Contact Us section.</p>';
                        ?>
                    </div>

                    <div class="contact-animated-img-holder mobile-img">
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/contact-img.png"
                            alt="" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="contact-animated-img-holder desktop-img animate-on-scroll">
                    <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/contact-img.png"
                        alt="" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>


<?php
get_footer();
