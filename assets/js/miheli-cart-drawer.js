/**
 * miheli-cart-drawer.js — open drawer from header/mobile, update counts & content.
 * Place: assets/js/miheli-cart-drawer.js
 *
 * Requires localization: window.miheliCartData = { ajax_url, nonce }
 */

(function () {
    'use strict';

    var local = window.miheliCartData || window.wpAdminData || {};
    var ajaxUrl = local.ajax_url || (window.wp && window.wp.ajax_url) || '/wp-admin/admin-ajax.php';
    var nonce = local.nonce || '';

    var drawer = document.getElementById('miheli-cart-drawer');
    var overlay = document.querySelector('.miheli-cart-drawer-overlay');
    var drawerInner = drawer ? drawer.querySelector('.miheli-cart-drawer-inner') : null;
    var miniCartContent = document.getElementById('miheli-mini-cart-content');

    if (!drawer) {
        console.warn('miheli cart drawer: #miheli-cart-drawer not found in DOM. Ensure inc/drawer.php is included.');
    }
    if (!miniCartContent) {
        console.warn('miheli cart drawer: #miheli-mini-cart-content not found in DOM. Drawer may not render initial content.');
    }

    function openDrawer() {
        if (!drawer || !overlay) return;

        // Prevent body scroll
        // document.body.style.overflow = 'hidden';

        // Show overlay and drawer
        overlay.classList.add('miheli-open');
        drawer.classList.add('miheli-open');
        drawer.setAttribute('aria-hidden', 'false');

        // Focus the close button for accessibility
        var closeBtn = drawer.querySelector('.miheli-drawer-close');
        if (closeBtn && typeof closeBtn.focus === 'function') {
            closeBtn.focus();
        }
    }

    function closeDrawer() {
        if (!drawer || !overlay) return;

        // Hide overlay and drawer
        overlay.classList.remove('miheli-open');
        drawer.classList.remove('miheli-open');
        drawer.setAttribute('aria-hidden', 'true');

    }


    // Robust counts update (create span if missing)
    function updateCounts(count) {
        var num = parseInt(count, 10) || 0;
        var mappings = [
            { sel: '.cart-count', parent: '.site-cart' },
            { sel: '.mobile-cart-count', parent: '.mobile-cart-icon' },
            { sel: '.miheli-mini-count', parent: '.miheli-drawer-handle' }
        ];
        mappings.forEach(function (m) {
            var el = document.querySelector(m.sel);
            if (!el) {
                var parent = document.querySelector(m.parent);
                if (parent) {
                    el = document.createElement('span');
                    el.className = m.sel.replace('.', '');
                    el.setAttribute('aria-hidden', 'true');
                    parent.appendChild(el);
                }
            }
            if (el) {
                el.textContent = String(num);
                el.setAttribute('data-count', String(num));
                if (num > 0) el.classList.add('has-count'); else el.classList.remove('has-count');
            }
        });
    }

    function updateMiniCartHtml(html) {
        if (!miniCartContent) return;
        miniCartContent.innerHTML = html || '<div class="miheli-mini-cart-empty"><p>No items</p></div>';
    }

    function postFormData(action, fields) {
        var fd = new FormData();
        fd.append('action', action);
        if (nonce) fd.append('nonce', nonce);
        for (var k in fields) {
            if (fields.hasOwnProperty(k)) fd.append(k, fields[k]);
        }
        return fetch(ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: fd
        }).then(function (res) {
            if (!res.ok) {
                throw new Error('Network error: ' + res.status);
            }
            return res.json();
        });
    }

    // Handle add to cart response
    function handleAddResponse(json) {
        if (!json) return;
        if (json.success) {
            if (json.data && json.data.mini_cart) updateMiniCartHtml(json.data.mini_cart);
            updateCounts(json.data ? json.data.count : 0);
            openDrawer();
        } else {
            console.error('Add to cart error: ', json);
        }
    }

    // Handle remove response
    function handleRemoveResponse(json) {
        if (!json) return;
        if (json.success) {
            if (json.data && json.data.mini_cart) updateMiniCartHtml(json.data.mini_cart);
            updateCounts(json.data ? json.data.count : 0);
        } else {
            console.error('Remove error: ', json);
        }
    }

    // Global click delegation
    document.addEventListener('click', function (e) {
        // Open drawer when header/mobile cart clicked (elements must have .open-cart-drawer)
        var trigger = e.target.closest && e.target.closest('.open-cart-drawer');
        if (trigger) {
            e.preventDefault();
            openDrawer();
            return;
        }

        // Close drawer via close button
        if (e.target.closest && e.target.closest('.miheli-drawer-close')) {
            e.preventDefault();
            closeDrawer();
            return;
        }

        // Close drawer via overlay click
        if (e.target === overlay) {
            closeDrawer();
            return;
        }


        // Remove item inside drawer
        var removeBtn = e.target.closest && e.target.closest('.miheli-remove-cart-item');
        if (removeBtn) {
            e.preventDefault();
            var key = removeBtn.getAttribute('data-cart-key');
            if (!key) return;
            postFormData('miheli_remove_cart_item', { cart_item_key: key }).then(handleRemoveResponse).catch(function (err) { console.error(err); });
            return;
        }

        // Add to cart (buttons in product grid use .add-to-cart-btn)
        var addBtn = e.target.closest && e.target.closest('.add-to-cart-btn');
        if (addBtn) {
            e.preventDefault();
            var pid = addBtn.getAttribute('data-product-id') || addBtn.getAttribute('data-product_id');
            var qty = addBtn.getAttribute('data-quantity') || 1;
            var isVar = addBtn.getAttribute('data-is-variable') === 'true';

            if (!isVar) {
                // Direct add for simple products
                postFormData('miheli_add_to_cart', { product_id: pid, quantity: qty }).then(handleAddResponse).catch(function (err) { console.error(err); });
            }
            return;
        }

    }, false);


    // On load, initialize counts from server markup if present
    window.addEventListener('load', function () {
        var initial = document.querySelector('.cart-count') && document.querySelector('.cart-count').getAttribute('data-count');
        if (initial !== null) {
            updateCounts(parseInt(initial, 10) || 0);
        }
    });

})();


