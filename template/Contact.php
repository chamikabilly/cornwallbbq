<?php

/**
 * Template Name: Contact
 * Description: Custom template for the Contact_page
 */
get_header();
$home = home_url();
$theme_url = get_template_directory_uri();
?>

<section class="page-banner">
</section>
<div class="contact-page-wrapper">
    <section class="contact-form-section-con">
        <div class="container">
            <div class="contact-form-holder-con"> <!-- This must be position relative  -->
                <div class="text-center mb-4">

                    <div class="text-center mb-5 contact-title-wrapper">
                        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.png"
                            alt="text-bg-con" class="text-bg-con" loading="lazy">

                        <h3 class="script-title-con">Get In Touch With Us</h3>
                    </div>

                    <div class="contact-form-container-con">
                        <?php echo do_shortcode('[contact-form-7 id="f0a2f79" title="Home Contact Form"]') ?>
                    </div>
                </div>
            </div>
    </section>

    <div class="contact-animated-img-holder-con desktop-img">
        <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/contact-img.png" alt="contact-img" loading="lazy">
    </div>
    

    <section class="contact-details-section">
        <div class="container">

            <div class="text-center mb-5 contact-title-wrapper">
                <img src="<?php echo $home ?>/wp-content/themes/miheli-solutions/assets/images/text-bg-img.p 
                            <img src="<?php echo $theme_url ?>/assets/images/mobile.svg" alt="Phone">
                        </div>
                        <p><a href="tel:+16139331000">+1 613-933-1000</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    </div>

    <section class="contact-map-section">
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2809.0!2d-74.7!3d45.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDXCsDAwJzAwLjAiTiA3NMKwNDInMDAuMCJX!5e0!3m2!1sen!2sca!4v1600000000000!5m2!1sen!2sca"
                width="100%"
                height="450"
                style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </section>
    <?php get_footer(); ?>