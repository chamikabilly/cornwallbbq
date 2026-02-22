<?php
/**
 * Template Name: About Us
 * Description: Custom template for the About Us page
 */
?>

<?php
get_header();
$home = home_url();

$who_we_are = get_field('who_we_are');
$services = get_field('services');
$testimonial = get_field('testimonial');
$contact_us = get_field('contact_us');
?>

<!-- Section About us  -->
<section class="section-about-us">
    <div class="container">
        <div class="about-bg">
            <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/about-bg-img.png"
                alt="about-bg-img" class="about-bg-img" loading="lazy">
        </div>
        <div class="row">
            <div class="col-xl-5 col-lg-6 col-12">
                <?php if (!empty($who_we_are['image'])) : ?>
                    <img src="<?php echo esc_url($who_we_are['image']); ?>" alt="<?php echo esc_attr($who_we_are['section_title']); ?>"
                        class="about-side-img" loading="lazy">
                <?php endif; ?>
            </div>
            <div class="col-xl-7 col-lg-6 col-12">
                <div class="sau-content-holder">
                    <h3 class="aus-title animate-on-scroll">
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png"
                            alt="text-bg" class="text-bg" loading="lazy">
                        <?php echo esc_html($who_we_are['section_title']); ?>
                    </h3>
                    <div class="aus-text animate-on-scroll">
                        <?php echo wp_kses_post($who_we_are['description']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Services Section -->
<section class="our-services-section">
    <h3 class="oss-title animate-on-scroll">
        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png" alt="text-bg"
            class="text-bg" loading="lazy">
        <?php echo esc_html($services['section_title']); ?>
    </h3>
    <h6 class="oss-sub-title animate-on-scroll"><?php echo esc_html($services['sub_title']); ?></h6>
    <div class="container g-0">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="oss-content-holder row g-3">
                    <?php 
                    // Card Item Repeater for Services Section
                    if (!empty($services['card_item'])) :
                        foreach ($services['card_item'] as $card) :
                            $card_title = isset($card['title']) ? $card['title'] : '';
                            $card_description = isset($card['discription']) ? $card['discription'] : '';
                            /*
                            Background Image Select Values :
                                launch : Launch - ab-bg-small-1.png
                                dinner : Dinner - ab-bg-small-2.png
                                late_night : Late Night - ab-bg-small-3.png
                                delivery : Delivery - ab-bg-small-4.png
                            */
                            $card_image = isset($card['background_image']) ? $card['background_image'] : '';
                            switch ($card_image) {
                                case 'launch':
                                    $card_image_url = $home . '/wp-content/themes/miheli-solutions/assets/images/ab-bg-small-1.png';
                                    break;
                                case 'dinner':
                                    $card_image_url = $home . '/wp-content/themes/miheli-solutions/assets/images/ab-bg-small-2.png';
                                    break;
                                case 'late_night':
                                    $card_image_url = $home . '/wp-content/themes/miheli-solutions/assets/images/ab-bg-small-3.png';
                                    break;
                                case 'delivery':
                                    $card_image_url = $home . '/wp-content/themes/miheli-solutions/assets/images/ab-bg-small-4.png';
                                    break;
                                default:
                                    $card_image_url = '';
                            }
                            $background_color = (isset($card['background_color']) && $card['background_color'] == 'orange') ? 'bg-light-color' : 'bg-dark-color';
                    ?>
                    <div class="col-md-6 col-12">
                        <div class="inner-content <?php echo esc_attr($background_color); ?> h-100">
                            <h6 class="oss-inner-title">
                                <?php echo esc_html($card_title); ?>
                            </h6>
                            <p class="oss-inner-text">
                                <?php echo wp_kses_post($card_description); ?>
                            </p>
                            <?php if ($card_image_url) : ?>
                                <img src="<?php echo esc_url($card_image_url); ?>"
                                    alt="bg-small-image" loading="lazy">
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="oss-img-holder animate-on-scroll">
                    <?php if (!empty($services['image'])) : ?>
                        <img src="<?php echo esc_url($services['image']); ?>" alt="our-services-img"
                            loading="lazy">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
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
                        <?php echo !empty($testimonial['section_title']) ? esc_html($testimonial['section_title']) : 'What our Customer say'; ?>
                    </h3>
                    <h6 class="ts-sub-title animate-on-scroll">
                        <?php echo !empty($testimonial['sub_title']) ? esc_html($testimonial['sub_title']) : 'TESTIMONIALS'; ?>
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
                            <?php echo !empty($contact_us['section_title']) ? esc_html($contact_us['section_title']) : 'Feel Free To Contact Us'; ?>
                        </h3>
                    </div>
                    <div class="contact-form-container">
                        <?php 
                        $contact_shortcode = !empty($contact_us['contact_shortcode']) ? $contact_us['contact_shortcode'] : '';
                        echo $contact_shortcode ? do_shortcode($contact_shortcode) : '<p class="text-light">Please add a contact form shortcode in the ACF fields.</p>';
                        ?>
                    </div>

                    <div class="contact-animated-img-holder mobile-img">
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/contact-img.png"
                            alt="contact-img" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="contact-animated-img-holder desktop-img animate-on-scroll">
                    <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/contact-img.png"
                        alt="contact-img" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>



<?php get_footer(); ?>
