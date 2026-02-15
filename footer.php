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

// Get contact details from global settings (Options Page)
$footer_top_group = get_field('footer_top', 'option');
$footer_middle = get_field('footer_middle', 'option');
$designer_text = get_field('designer_text', 'option');
$designer_url = get_field('designer_url', 'option');

$footer_logo = $footer_top_group['footer_logo'] ?? '';
$contact_details = $footer_top_group['contact_details'] ?? [];
$opening_hours = $footer_top_group['opening_hours']['list_item'] ?? [];

$copyright_text = $footer_middle['copyright_text'] ?? '';
$social_media = $footer_middle['social_media'] ?? [];

?>

<section class="footer">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-6 col-lg-3">
                <div class="footer-contianer">
                    <div class="footer-logo-holder">
                        <?php if (!empty($footer_logo)) : ?>
                            <img src="<?php echo esc_url($footer_logo); ?>" alt="Footer Logo" loading="lazy" class="img-fluid">
                        <?php else : ?>
                            <?php the_custom_logo(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="footer-information">
                        <ul class="fi-ul">
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"><i class="fa-solid fa-location-dot"></i></div>
                                    <div class="fi-desc"><?php echo !empty($contact_details['address']) ? nl2br(esc_html($contact_details['address'])) : 'Address isn\'t available'; ?></div>
                                </div>
                            </li>
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"><i class="fa-solid fa-at"></i></div>
                                    <div class="fi-desc"><?php echo !empty($contact_details['email']) ? esc_html($contact_details['email']) : 'Email isn\'t available'; ?></div>
                                </div>
                            </li>
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"><i class="fa-solid fa-phone"></i></div>
                                    <div class="fi-desc"><?php echo !empty($contact_details['phone_number']) ? esc_html($contact_details['phone_number']) : 'Phone isn\'t available'; ?></div>
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
                            <?php if (!empty($opening_hours)) : ?>
                                <?php foreach ($opening_hours as $item) : ?>
                                    <?php
                                    $day = $item['day'] ?? '';
                                    $opening_time = $item['opening_time'] ?? '';
                                    $closing_time = $item['closing_time'] ?? '';
                                    $time_range = trim($opening_time . (!empty($closing_time) ? '–' . $closing_time : ''));
                                    if (empty($day) && empty($time_range)) {
                                        continue;
                                    }
                                    ?>
                                    <tr>
                                        <td class="week-day"><?php echo esc_html($day); ?></td>
                                        <td class="time"><?php echo esc_html($time_range); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td class="week-day">Hours</td>
                                    <td class="time">Not available</td>
                                </tr>
                            <?php endif; ?>
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
                <!-- Copyright Text  -->
                <p class="copyright-text"> <?php echo !empty($copyright_text) ? esc_html($copyright_text) : 'Add a Copyright Text'; ?></p>
            </div>
            <div class="col-md-6">
                <ul class="footer-socials">
                    <!-- Social Media Links -->
                    <?php
                    $icon_map = array(
                        'facebook' => 'fa-facebook-f',
                        'instagram' => 'fa-instagram',
                        'tiktok' => 'fa-tiktok',
                        'snapchat' => 'fa-snapchat'
                    );
                    ?>
                    <?php if (!empty($social_media)) : ?>
                        <?php foreach ($social_media as $social) : ?>
                            <?php
                            $url = $social['social_url'] ?? '';
                            $icon_key = $social['social_icon'] ?? '';
                            $icon_class = $icon_map[$icon_key] ?? 'fa-link';
                            if (empty($url)) {
                                continue;
                            }
                            ?>
                            <li class="list-item">
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands <?php echo esc_attr($icon_class); ?>"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="footer-bottom">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-12">
                <!-- Designer Text  -->
                <p class="company-text text-center">
                    <?php if (!empty($designer_url) && !empty($designer_text)) : ?>
                        <a href="<?php echo esc_url($designer_url); ?>" target="_blank" rel="noopener noreferrer" class="link-light"><?php echo esc_html($designer_text); ?></a>
                    <?php else : ?>
                        <?php echo !empty($designer_text) ? esc_html($designer_text) : 'Add a designer text'; ?>
                    <?php endif; ?>
                </p>
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
