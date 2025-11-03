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

// Hero Section 
$hero_slides = get_field('hero_slides');

if ($hero_slides) {
    $slide_count = count($hero_slides);

    for ($i = 1; $i <= $slide_count; $i++) {
        $slide_key = 'hero_section_' . $i;

        if (isset($hero_slides[$slide_key])) {
            $slide = $hero_slides[$slide_key];

            ${'hero_img_' . $i} = $slide['background_image'];
            ${'hero_large_' . $i} = $slide['large_text'];
            ${'hero_small_' . $i} = $slide['small_text'];
        }
    }
}

// Our Category Section 
$pop_categories = get_field('popular_categories');
$cat_title = $pop_categories['section_title'];
$cat_list = $pop_categories['category_list'];
$cat_1 = $cat_list['cat_1'];
$cat_2 = $cat_list['cat_2'];
$cat_3 = $cat_list['cat_3'];
$cat_4 = $cat_list['cat_4'];

// Our Story Section 
$our_story_section = get_field('our_story');

?>


<!-- Hero Section  -->
<section>
    <?php
    $hero_slides = get_field('hero_slides');

    if ($hero_slides) {
        // If it's a repeater field, it returns a numerically indexed array
        $slide_count = count($hero_slides);
    ?>
        <!-- Slider main container -->
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <?php
                foreach ($hero_slides as $index => $slide) {
                    $background_image = $slide['background_image'];
                    $large_text = $slide['large_text'];
                    $small_text = $slide['small_text'];

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
                }
                ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
    <?php } ?>
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
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png" alt="text-bg" class="text-bg">
                        <?php echo $cat_title; ?>
                    </h3>

                    <div class="pop-cat-list">
                        <?php if ($cat_list):
                            $cat_count = count($cat_list);
                            for ($i = 1; $i <= $cat_count; $i++) {
                        ?>
                                <div class="cat-container animate-on-scroll">
                                    <a href="<?php echo ${'cat_' . $i}['category_page'] ?>">
                                        <img src="<?php echo ${'cat_' . $i}['category_image'] ?>" alt="cat-img-<?php echo $i ?>" class="img-fluid">
                                        <div class="cat-name-container">
                                            <?php echo ${'cat_' . $i}['product_category'] ?>
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }
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
                        <img src="<?php echo $our_story_section['about_image'] ?>" alt="<?php echo $our_story_section['section_title'] ?>-img" class="img-fluid animate-on-scroll">
                    </div>
                    <div class="col-lg-8">
                        <div class="os-content-holder animate-on-scroll">
                            <div class="os-para">
                                <?php echo $our_story_section['about_us_description'] ?>
                            </div>
                            <a href="<?php echo $our_story_section['read_more_link'] ?>" class="readmore-btn">Read More <i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Our Story Section End -->





</section>


<?php
get_footer();
