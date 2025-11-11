<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Miheli_Solutions
 */

?>

<section class="footer">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-6 col-lg-3">
                <div class="footer-contianer">
                    <div class="footer-logo-holder">
                        <?php the_custom_logo(); ?>
                    </div>
                    <div class="footer-information">
                        <ul class="fi-ul">
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"><i class="fa-solid fa-location-dot"></i></div>
                                    <div class="fi-desc">436 Second St W, Cornwall, ON K6J 1H1, Canada</div>
                                </div>
                            </li>
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"><i class="fa-solid fa-at"></i></div>
                                    <div class="fi-desc">info@cornwallbbq.ca</div>
                                </div>
                            </li>
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"><i class="fa-solid fa-phone"></i></div>
                                    <div class="fi-desc">+1 613-933-1000</div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-container">
                    <div class="footer-section-title">
                        Opening Hours
                    </div>
                    <div class="footer-oh">
                        <table class="table">
                            <tr>
                                <td class="week-day">Monday </td>
                                <td class="time">10:30 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="week-day">Tuesday </td>
                                <td class="time">10:30 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="week-day">Wednesday </td>
                                <td class="time">10:30 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="week-day">Thursday </td>
                                <td class="time">10:30 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="week-day">Friday </td>
                                <td class="time">10:30 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="week-day">Saturday </td>
                                <td class="time">10:30 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="week-day">Sunday </td>
                                <td class="time">9 AM–8 PM</td>
                            </tr>
                            <tr>
                                <td class="labor-day" colspan="2">(Labor Day) Hours might differ </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-container">
                    <div class="footer-section-title">
                        Quick Links
                    </div>
                    <nav class="footer-ql" id="quick-navigation">

                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-2',
                                'menu_id' => 'quicklink-menu',
                                'menu_class' => 'quicklink-menu',
                            )
                        );
                        ?>

                    </nav>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-container">
                    <div class="footer-section-title">
                        My Account
                    </div>
                    <nav class="footer-ql" id="quick-navigation">

                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-3',
                                'menu_id' => 'myaccount-menu',
                                'menu_class' => 'myaccount-menu',
                            )
                        );
                        ?>

                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="footer-middle">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-6">
                <p class="copyright-text"> © Copyright 2025 Cornwall B.B.Q , All Rights Reserved.</p>
            </div>
            <div class="col-md-6">
                <ul class="footer-socials">
                    <li class="list-item"><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li class="list-item"><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                    <li class="list-item"><a href="#"><i class="fa-brands fa-snapchat"></i></a></li>
                    <li class="list-item"><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>

                </ul>
            </div>
        </div>
    </div>
</section>

<section class="footer-bottom">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-12">
                <p class="company-text text-center"> Designed & Developed by Miheli Tech inc</p>
            </div>
        </div>
    </div>
</section>


</div><!-- #page -->

<!-- miheli-cart-drawer (start) -->
<div id="miheli-cart-drawer" class="miheli-cart-drawer" aria-hidden="true">
    <div class="miheli-cart-drawer-overlay"></div>
    <div class="miheli-cart-drawer-inner" role="dialog"
        aria-label="<?php esc_attr_e('Mini cart', 'miheli-solutions'); ?>">
        <button class="miheli-drawer-close"
            aria-label="<?php esc_attr_e('Close cart', 'miheli-solutions'); ?>">✕</button>

        <div class="miheli-bbq-top">
            <div class="miheli-grill" aria-hidden="true">
                <div class="miheli-flames">
                    <img src="<?php echo home_url() . '/wp-content/themes/miheli-solutions/assets/images/shopping cart.gif' ?>"
                        alt="shopping cart.gif">
                </div>
            </div>
            <h3 class="miheli-cart-title"><?php esc_html_e('Shopping Cart', 'miheli-solutions'); ?></h3>
        </div>

        <div id="miheli-mini-cart-content" class="miheli-mini-cart-content">
            <?php echo miheli_get_mini_cart_html(); ?>
        </div>
    </div>
</div>
<!-- miheli-cart-drawer (end) -->

<!-- Variants Modal -->
<div id="variants-modal" class="variants-modal">
    <div class="variants-modal-content">
        <span class="close-modal">&times;</span>
        <h4 class="modal-title">Select Options</h4>
        <div class="modal-body">
            <!-- Content will be loaded via AJAX -->
        </div>
    </div>
</div>

<?php
wp_footer();
?>


</body>

</html>