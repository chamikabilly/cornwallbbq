<?php
// Get product variant form + structured variations data
add_action('wp_ajax_miheli_get_product_variants', 'miheli_get_product_variants');
add_action('wp_ajax_nopriv_miheli_get_product_variants', 'miheli_get_product_variants');
add_action('wp_ajax_get_product_variations', 'miheli_get_product_variants');
add_action('wp_ajax_nopriv_get_product_variations', 'miheli_get_product_variants');

function miheli_get_product_variants()
{
    // Handle both security field names
    $nonce = isset($_POST['security']) ? $_POST['security'] : (isset($_POST['nonce']) ? $_POST['nonce'] : '');

    if (empty($nonce)) {
        wp_send_json_error('Security nonce missing');
    }

    if (!wp_verify_nonce($nonce, 'miheli_variant_nonce')) {
        wp_send_json_error('Security verification failed');
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    if (!$product_id) {
        wp_send_json_error('Missing product ID');
    }

    $product = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error('Invalid or non-variable product');
    }

    // Use WooCommerce's built-in method to get variations
    $variations = $product->get_available_variations();

    // Build structured variations data
    $variations_data = array();

    foreach ($variations as $variation_data) {
        $variation_id = $variation_data['variation_id'];
        $variation = wc_get_product($variation_id);

        if (!$variation) continue;

        // Get attributes from the variation data (this is the correct format)
        $variation_attributes = $variation_data['attributes'];

        // Build variation name from attributes
        $variation_name_parts = array();
        foreach ($variation_attributes as $attribute_name => $attribute_value) {
            if ($attribute_value) {
                // Convert attribute name to readable format
                $taxonomy = str_replace('attribute_', '', $attribute_name);
                $attribute_label = wc_attribute_label($taxonomy);
                $variation_name_parts[] = $attribute_label . ': ' . $attribute_value;
            }
        }
        $variation_name = implode(', ', $variation_name_parts);

        $variations_data[] = array(
            'variation_id' => $variation_id,
            'attributes'   => $variation_attributes, // This uses the correct format from get_available_variations()
            'image'        => $variation_data['image']['src'] ?? '',
            'price_html'   => $variation->get_price_html(),
            'weight'       => $variation->get_weight() ? $variation->get_weight() . ' ' . get_option('woocommerce_weight_unit') : '',
            'name'         => $variation_name,
            'is_purchasable' => $variation->is_purchasable(),
            'is_in_stock'    => $variation->is_in_stock(),
        );
    }

    // Build form HTML
    ob_start();
?>
    <form id="variant-form" method="post" data-product-id="<?php echo esc_attr($product_id); ?>" data-variations='<?php echo esc_attr(wp_json_encode($variations_data)); ?>'>
        <?php wp_nonce_field('miheli_variant_nonce', 'miheli_variant_nonce_field'); ?>

        <div class="variant-options">
            <?php
            $attributes = $product->get_variation_attributes();
            foreach ($attributes as $attribute_name => $options) {
                $attribute_label = wc_attribute_label($attribute_name);
                // Use the exact attribute name as WooCommerce expects
                $select_name = 'attribute_' . sanitize_title($attribute_name);
            ?>
                <div class="variant-option mb-3">
                    <label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>" class="form-label">
                        <?php echo esc_html($attribute_label); ?>
                    </label>
                    <select id="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"
                        name="<?php echo esc_attr($select_name); ?>"
                        class="form-select variation-select"
                        data-attribute="<?php echo esc_attr($attribute_name); ?>"
                        required>
                        <option value=""><?php printf(esc_html__('Choose %s', 'miheli-solutions'), $attribute_label); ?></option>
                        <?php
                        foreach ($options as $option) {
                            echo '<option value="' . esc_attr($option) . '">' . esc_html(ucfirst($option)) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>
        </div>

        <div class="variant-preview mb-3">
            <div class="variant-description">
                <?php echo apply_filters('the_content', $product->get_description()); ?>
            </div>
        </div>

        <!-- Hidden fields for form submission -->
        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
        <input type="hidden" name="variation_id" value="0">

        <label for="quantity" class="form-label">
            Quantity
        </label>
        <input type="number" name="quantity" value="1" min="1" class="form-control mb-3">

        <button type="submit" class="btn btn-primary add-variant-to-cart w-100">
            <?php esc_html_e('Add to Cart', 'miheli-solutions'); ?>
        </button>
    </form>
<?php
    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html));
}

// Add to cart via AJAX (variation) - UPDATED to match existing drawer format
add_action('wp_ajax_miheli_add_variant_to_cart', 'miheli_add_variant_to_cart');
add_action('wp_ajax_nopriv_miheli_add_variant_to_cart', 'miheli_add_variant_to_cart');

function miheli_add_variant_to_cart()
{
    // Use the same nonce handling as your existing drawer
    if (!isset($_POST['security']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'miheli_variant_nonce')) {
        wp_send_json_error(array('message' => __('Security verification failed', 'miheli-solutions')), 403);
    }

    if (!class_exists('WooCommerce')) {
        wp_send_json_error(array('message' => __('WooCommerce not active', 'miheli-solutions')), 500);
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

    if (!$product_id) {
        wp_send_json_error(array('message' => __('Missing product ID', 'miheli-solutions')));
    }

    if (!$variation_id) {
        wp_send_json_error(array('message' => __('Please select product options', 'miheli-solutions')));
    }

    // Collect attributes for variation
    $variation_data = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'attribute_') === 0) {
            $variation_data[$key] = sanitize_text_field($value);
        }
    }

    // Add to cart using the same method as your existing drawer
    $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation_data);

    if (!$added) {
        wp_send_json_error(array('message' => __('Could not add to cart. Please try again.', 'miheli-solutions')));
    }

    // Return the same response format as your existing drawer
    $count = WC()->cart->get_cart_contents_count();
    $mini_html = miheli_get_mini_cart_html();

    wp_send_json_success(array(
        'count' => intval($count),
        'mini_cart' => $mini_html
    ));
}
