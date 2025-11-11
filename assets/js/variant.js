/* miheli-variants.js */
(function () {
    function ajaxPost(data) {
        return fetch(miheli_ajax.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: new URLSearchParams(data)
        }).then(async (res) => {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (err) {
                return { __raw: text, __status: res.status };
            }
        }).catch(err => {
            return { __network_error: true, error: err };
        });
    }

    // Update the openVariantsModal function to ensure it always shows the modal
    window.openVariantsModal = function (productId) {
        console.log('Opening modal for product:', productId);
        const modal = document.getElementById('variants-modal');
        if (!modal) {
            console.error('Variants modal element (#variants-modal) not found.');
            return;
        }

        // Remove any inline display styles and ensure modal is visible
        modal.style.display = 'flex';
        modal.classList.add('active');

        const body = modal.querySelector('.modal-body');
        body.innerHTML = '<p style="opacity:.9">Loading options…</p>';

        ajaxPost({
            action: 'miheli_get_product_variants',
            product_id: productId,
            security: miheli_ajax.nonce
        }).then(resp => {
            if (resp && resp.__network_error) {
                body.innerHTML = '<p class="error">Network error loading variants.</p>';
                console.error('Network error:', resp.error);
                return;
            }

            if (resp && resp.__raw) {
                console.error('Raw response from server:', resp.__raw);
                body.innerHTML = '<p class="error">Unable to load product variants. Check console for details.</p>';
                return;
            }

            if (!resp || !resp.success) {
                console.error('Variant handler returned error:', resp);
                const message = (resp && resp.data) ? resp.data : 'Unable to load product variants.';
                body.innerHTML = '<p class="error">' + escapeHtml(String(message)) + '</p>';
                return;
            }

            body.innerHTML = resp.data.html || '';
            initVariantForm(body.querySelector('#variant-form'));
        }).catch(err => {
            body.innerHTML = '<p class="error">Network error loading variants.</p>';
            console.error(err);
        });
    };

    // Proper close function that resets the modal state
    function closeVariantsModal() {
        const modal = document.getElementById('variants-modal');
        if (modal) {
            // Use CSS class to hide instead of inline style
            modal.classList.remove('active');
            // Don't set display: none inline, let CSS handle it
            modal.style.display = '';

            // Reset any form state if needed
            const form = modal.querySelector('#variant-form');
            if (form) {
                form.reset();
            }
        }
    }

    // Initialize the variant form
    function initVariantForm(form) {
        if (!form) return;

        let variations = [];
        try {
            const raw = form.getAttribute('data-variations') || '[]';
            variations = JSON.parse(raw);
            console.log('Loaded variations:', variations);
        } catch (e) {
            console.warn('Could not parse variations JSON:', e);
            variations = [];
        }

        const variantDesc = form.querySelector('.variant-description');
        const variationIdInput = form.querySelector('input[name="variation_id"]');

        // Store original content
        const originalContent = variantDesc.innerHTML;
        variantDesc.dataset.originalContent = originalContent;

        // Find matching variation
        function findMatchingVariation() {
            const selects = Array.from(form.querySelectorAll('select[name^="attribute_"]'));
            const chosen = {};

            // Build chosen attributes object
            for (const select of selects) {
                if (!select.value) {
                    return null; // Not all attributes selected
                }
                chosen[select.name] = select.value;
            }

            console.log('Looking for variation with attributes:', chosen);
            console.log('Available variations:', variations);

            // Find matching variation
            for (const variation of variations) {
                let match = true;

                // Check if this variation matches all chosen attributes
                for (const attrName in chosen) {
                    const variationAttrValue = variation.attributes[attrName];
                    const chosenValue = chosen[attrName];

                    console.log(`Comparing ${attrName}: variation="${variationAttrValue}" vs chosen="${chosenValue}"`);

                    // Check if the attribute matches
                    if (variationAttrValue !== chosenValue) {
                        match = false;
                        break;
                    }
                }

                if (match) {
                    console.log('Found matching variation:', variation);
                    return variation;
                }
            }

            console.log('No matching variation found for attributes:', chosen);
            return null;
        }

        // Render variation preview
        function renderVariationPreview() {
            const variation = findMatchingVariation();

            if (!variation) {
                // Show default product description
                variantDesc.innerHTML = variantDesc.dataset.originalContent;
                if (variationIdInput) variationIdInput.value = '0';

                // Disable add to cart button
                const submitBtn = form.querySelector('.add-variant-to-cart');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Select Options';
                }
                return;
            }

            // Update variation ID for form submission
            if (variationIdInput) variationIdInput.value = variation.variation_id;

            // Build preview HTML
            let html = '<div class="miheli-variant-preview">';

            if (variation.image) {
                html += '<div class="miheli-variant-image"><img src="' + escapeHtml(variation.image) + '" alt=""></div>';
            }

            html += '<div class="miheli-variant-info">';

            // Variation name/attributes
            if (variation.name) {
                html += '<div class="miheli-variant-name">' + escapeHtml(variation.name) + '</div>';
            }

            // Price
            if (variation.price_html) {
                html += '<div class="miheli-variant-price">' + variation.price_html + '</div>';
            }

            // Weight
            if (variation.weight) {
                html += '<div class="miheli-variant-weight">Weight: ' + escapeHtml(variation.weight) + '</div>';
            }

            // Stock status
            if (!variation.is_in_stock) {
                html += '<div class="miheli-variant-stock" style="color:#dc3545;">Out of stock</div>';
            } else if (!variation.is_purchasable) {
                html += '<div class="miheli-variant-stock" style="color:#ffc107;">Not available</div>';
            }

            html += '</div></div>';

            variantDesc.innerHTML = html;

            // Enable add to cart button
            const submitBtn = form.querySelector('.add-variant-to-cart');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Add to Cart';
            }
        }

        // Event listeners for attribute changes
        form.addEventListener('change', function (e) {
            if (e.target && e.target.name && e.target.name.indexOf('attribute_') === 0) {
                renderVariationPreview();
            }
        });

        // Form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const variationId = form.querySelector('input[name="variation_id"]').value;
            if (variationId === '0') {
                alert('Please select all product options before adding to cart.');
                return;
            }

            const formData = new FormData(form);
            const payload = {
                action: 'miheli_add_variant_to_cart',
                security: miheli_ajax.nonce
            };

            // Add all form data to payload
            for (const [key, val] of formData.entries()) {
                payload[key] = val;
            }

            console.log('Submitting variant to cart:', payload);

            const submitBtn = form.querySelector('.add-variant-to-cart');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Adding…';
            }

            ajaxPost(payload).then(resp => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Add to Cart';
                }

                if (!resp) {
                    alert('Unable to add to cart (no response).');
                    console.error('No response from add-to-cart AJAX.');
                    return;
                }

                if (resp.__network_error) {
                    alert('Network error when adding to cart.');
                    console.error('Network error', resp.error);
                    return;
                }

                if (resp.__raw) {
                    console.error('Unexpected server response:', resp.__raw);
                    alert('Server returned unexpected response. Check console for details.');
                    return;
                }

                if (!resp.success) {
                    const err = resp.data || resp || 'Unable to add to cart';
                    const errorMessage = typeof err === 'string' ? err : (err.message || 'Unable to add to cart');
                    alert(errorMessage);
                    console.error('Add to cart error:', resp);
                    return;
                }

                // Success - update cart display
                updateCartDisplay(resp.data);

                // Close variants modal using our proper close function
                closeVariantsModal();

            }).catch(err => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Add to Cart';
                }
                alert('Network error when adding to cart');
                console.error(err);
            });
        });

        // Initialize preview
        renderVariationPreview();
    }

    // Update cart display
    function updateCartDisplay(data) {
        // Update mini cart content
        const miniCartContent = document.getElementById('miheli-mini-cart-content');
        if (miniCartContent && data.mini_cart) {
            miniCartContent.innerHTML = data.mini_cart;
            initializeRemoveButtons();
        }

        // Update count badge
        const badge = document.querySelector('.miheli-mini-count');
        if (badge && typeof data.count !== 'undefined') {
            badge.setAttribute('data-count', data.count);
            badge.textContent = data.count;
            badge.classList.remove('bump');
            void badge.offsetWidth;
            badge.classList.add('bump');
        }

        // Open cart drawer
        openCartDrawer();
    }

    // Initialize remove buttons in cart
    function initializeRemoveButtons() {
        const removeButtons = document.querySelectorAll('.miheli-remove-cart-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const cartKey = this.getAttribute('data-cart-key');
                if (cartKey) {
                    removeCartItem(cartKey);
                }
            });
        });
    }

    // Remove cart item function
    function removeCartItem(cartKey) {
        const payload = {
            action: 'miheli_remove_cart_item',
            cart_item_key: cartKey,
            nonce: miheliCartData.nonce
        };

        ajaxPost(payload).then(resp => {
            if (resp && resp.success) {
                updateCartDisplay(resp.data);
            } else {
                const error = resp && resp.data ? resp.data : 'Failed to remove item';
                alert(typeof error === 'string' ? error : error.message);
            }
        }).catch(err => {
            console.error('Error removing cart item:', err);
            alert('Error removing item from cart');
        });
    }

    // Open cart drawer
    function openCartDrawer() {
        const drawer = document.getElementById('miheli-cart-drawer');
        const overlay = document.querySelector('.miheli-cart-drawer-overlay');

        if (drawer && overlay) {
            drawer.classList.add('miheli-open');
            overlay.classList.add('miheli-open');
        }

        const openBtn = document.querySelector('.miheli-cart-open-btn');
        if (openBtn) {
            openBtn.click();
        }
    }

    // Utility function
    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Event delegation for variant buttons
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.open-variants-modal');
        if (!btn) return;
        e.preventDefault();
        const pid = btn.getAttribute('data-product-id') || btn.dataset.productId || btn.getAttribute('data-id');
        if (!pid) {
            console.error('open-variants-modal missing data-product-id');
            return;
        }
        openVariantsModal(pid);
    });

    // Close modal handlers
    const variantModal = document.getElementById('variants-modal');
    if (variantModal) {
        // Close when clicking overlay or close button
        variantModal.addEventListener('click', function (ev) {
            if (ev.target === variantModal) {
                closeVariantsModal();
            }
        });

        const closeBtn = variantModal.querySelector('.close-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                closeVariantsModal();
            });
        }

        // Add ESC key support
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && variantModal.classList.contains('active')) {
                closeVariantsModal();
            }
        });
    }

})();