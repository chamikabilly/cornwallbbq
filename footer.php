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
    <div class="conaitner-fluid g-0">
        <div class="row">
            <div class="col-md-3">
                <div class="footer-contianer">
                    <div class="footer-logo-holder">
                        <?php the_custom_logo(); ?>
                    </div>
                    <div class="footer-information">
                        <ul class="fi-ul">
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"></div>
                                    <div class="fi-desc"></div>
                                </div>
                            </li>
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"></div>
                                    <div class="fi-desc"></div>
                                </div>
                            </li>
                            <li class="fi-li">
                                <div class="fi-li-item">
                                    <div class="fi-icon-wrapper"></div>
                                    <div class="fi-desc"></div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-3">

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