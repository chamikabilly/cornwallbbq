<?php

/**
 * inc/drawer.php
 *
 * Drawer HTML (no handle) + AJAX handlers for add/remove cart.
 *
 * Place: wp-content/themes/your-theme/inc/drawer.php
 * Include from functions.php: require_once get_template_directory() . '/inc/drawer.php';
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render mini cart HTML and return as string.
 */
function miheli_get_mini_cart_html()
{
    ob_start();

    if (!class_exists('WooCommerce')) {
        ?>
        <div class="miheli-mini-cart-empty">
            <p><?php echo esc_html__('WooCommerce is not active', 'miheli-solutions'); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }

    $cart = WC()->cart;

    if (!$cart || !method_exists($cart, 'get_cart')) {
        ?>
        <div class="miheli-mini-cart-empty">
            <p><?php echo esc_html__('Cart not available', 'miheli-solutions'); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }

    if ($cart->is_empty()) {
        ?>
        <div class="miheli-mini-cart-empty">
            <img src="<?php echo home_url() . '/wp-content/themes/miheli-solutions/assets/images/empty-cart.png' ?>"
                alt="empty-cart" loading="lazy">
            <p><?php echo esc_html__('Your cart is empty', 'miheli-solutions'); ?></p>
        </div>
        <?php
        return ob_get_clean();
    }

    echo '<div class="miheli-mini-cart-list">';
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        /** @var WC_Product $product */
        $product = isset($cart_item['data']) ? $cart_item['data'] : false;
        if (!$product) {
            continue;
        }
        $product_name = $product->get_name();
        $qty = isset($cart_item['quantity']) ? intval($cart_item['quantity']) : 1;
        $subtotal = wc_price($product->get_price() * $qty);
        $thumb = $product->get_image('thumbnail');
        ?>
        <div class="miheli-cart-item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
            <div class="miheli-item-thumb"><?php echo $thumb; ?></div>
            <div class="miheli-item-meta">
                <div class="miheli-item-title"><?php echo esc_html($product_name); ?></div>
                <div class="miheli-item-qty-price">
                    <span class="miheli-item-qty"><?php echo sprintf(esc_html__('Qty: %d', 'miheli-solutions'), $qty); ?></span>
                    <span class="miheli-item-subtotal"><?php echo wp_kses_post($subtotal); ?></span>
                </div>
            </div>
            <button class="miheli-remove-cart-item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>"
                aria-label="<?php echo esc_attr__('Remove item', 'miheli-solutions'); ?>">×</button>
        </div>
        <?php
    }
    echo '</div>'; // .miheli-mini-cart-list

    // Footer
    ?>
    <div class="miheli-mini-cart-footer">
        <div class="miheli-cart-total">
            <span><?php echo esc_html__('Subtotal', 'miheli-solutions'); ?>:</span>
            <strong><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></strong>
        </div>
        <div class="miheli-cart-actions">
            <a class="button view-cart"
                href="<?php echo esc_url(wc_get_cart_url()); ?>"><?php echo esc_html__('View Cart', 'miheli-solutions'); ?></a>
            <a class="button checkout"
                href="<?php echo esc_url(wc_get_checkout_url()); ?>"><?php echo esc_html__('Checkout', 'miheli-solutions'); ?></a>
        </div>
    </div>
    <?php

    return ob_get_clean();
}

/**
 * AJAX: add to cart
 */
function miheli_ajax_add_to_cart()
{
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'miheli_cart_nonce')) {
        wp_send_json_error(array('message' => __('Invalid nonce', 'miheli-solutions')), 403);
    }

    if (!class_exists('WooCommerce')) {
        wp_send_json_error(array('message' => __('WooCommerce not active', 'miheli-solutions')), 500);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $variation = array();

    if (isset($_POST['variation'])) {
        $raw = wp_unslash($_POST['variation']);
        $maybe_json = json_decode($raw, true);
        if (is_array($maybe_json)) {
            $variation = $maybe_json;
        } else {
            $maybe_unser = maybe_unserialize($raw);
            if (is_array($maybe_unser)) {
                $variation = $maybe_unser;
            }
        }
    }

    if ($product_id <= 0) {
        wp_send_json_error(array('message' => __('Invalid product ID', 'miheli-solutions')));
    }

    $added = WC()->cart->add_to_cart($product_id, $quantity, 0, $variation);

    if (!$added) {
        wp_send_json_error(array('message' => __('Could not add to cart. Choose options if product requires it.', 'miheli-solutions')));
    }

    $count = WC()->cart->get_cart_contents_count();
    $mini_html = miheli_get_mini_cart_html();

    wp_send_json_success(array('count' => intval($count), 'mini_cart' => $mini_html));
}
add_action('wp_ajax_miheli_add_to_cart', 'miheli_ajax_add_to_cart');
add_action('wp_ajax_nopriv_miheli_add_to_cart', 'miheli_ajax_add_to_cart');

/**
 * AJAX: remove item
 */
function miheli_ajax_remove_cart_item()
{
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'miheli_cart_nonce')) {
        wp_send_json_error(array('message' => __('Invalid nonce', 'miheli-solutions')), 403);
    }

    $cart_item_key = isset($_POST['cart_item_key']) ? wc_clean(wp_unslash($_POST['cart_item_key'])) : '';

    if (empty($cart_item_key)) {
        wp_send_json_error(array('message' => __('Missing cart item key', 'miheli-solutions')));
    }

    $removed = WC()->cart->remove_cart_item($cart_item_key);

    if ($removed) {
        $count = WC()->cart->get_cart_contents_count();
        $mini_html = miheli_get_mini_cart_html();
        wp_send_json_success(array('count' => intval($count), 'mini_cart' => $mini_html));
    } else {
        wp_send_json_error(array('message' => __('Could not remove item', 'miheli-solutions')));
    }
}
add_action('wp_ajax_miheli_remove_cart_item', 'miheli_ajax_remove_cart_item');
add_action('wp_ajax_nopriv_miheli_remove_cart_item', 'miheli_ajax_remove_cart_item');

/**
 * Output drawer HTML in footer (no handle).
 */
function miheli_output_cart_drawer()
{
    if (is_admin()) {
        return;
    }

    $count = 0;
    if (class_exists('WooCommerce') && WC()->cart) {
        $count = intval(WC()->cart->get_cart_contents_count());
    }

    ?>
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
                        <div class="flame flame-1"></div>
                        <div class="flame flame-2"></div>
                        <div class="flame flame-3"></div>
                    </div>
                    <div class="miheli-smoke"></div>
                </div>
                <h3 class="miheli-cart-title"><?php esc_html_e('Shopping Cart', 'miheli-solutions'); ?></h3>
            </div>

            <div id="miheli-mini-cart-content" class="miheli-mini-cart-content">
                <?php echo miheli_get_mini_cart_html(); ?>
            </div>
        </div>
    </div>
    <!-- miheli-cart-drawer (end) -->
    <?php
}
//add_action('wp_footer', 'miheli_output_cart_drawer', 100);