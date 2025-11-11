// Function to load products via AJAX
function loadProducts(category) {
    const productGrid = document.getElementById('product-grid');
    productGrid.innerHTML = '<div class="col-12 text-center w-100 h-100 d-flex align-items-center justify-content-center text-light"><p>Loading products...</p></div>';

    // Create AJAX request
    const xhr = new XMLHttpRequest();
    const ajaxUrl = wpAdminData.ajax_url;
    const nonce = wpAdminData.nonce;
    xhr.open('POST', ajaxUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status === 200) {
            try {
                const response = JSON.parse(this.responseText);
                if (response.success) {
                    productGrid.innerHTML = response.data;
                    // Re-initialize event listeners for new products
                    initializeProductActions();
                } else {
                    productGrid.innerHTML = '<div class="col-12 text-center  w-100 h-100 d-flex align-items-center justify-content-center text-light"><p>Error loading products</p></div>';
                }
            } catch (e) {
                productGrid.innerHTML = '<div class="col-12 text-center  w-100 h-100 d-flex align-items-center justify-content-center text-light"><p>Error parsing response</p></div>';
            }
        } else {
            productGrid.innerHTML = '<div class="col-12 text-center  w-100 h-100 d-flex align-items-center justify-content-center text-light"><p>Error loading products</p></div>';
        }
    };

    xhr.onerror = function () {
        productGrid.innerHTML = '<div class="col-12 text-center w-100 h-100 d-flex align-items-center justify-content-center text-light"><p>Network error</p></div>';
    };

    // Send the request
    const data = 'action=load_products_by_category&category=' + encodeURIComponent(category) + '&nonce=' + nonce;
    xhr.send(data);
}

// Modal functionality
function initializeProductActions() {
    const modal = document.getElementById('variants-modal');
    const closeModal = document.querySelector('.close-modal');
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    // Close modal when clicking X
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Add to cart button click handlers
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const isVariable = this.getAttribute('data-is-variable') === 'true';

            if (isVariable) {
                if (typeof window.openVariantsModal === 'function') {
                    window.openVariantsModal(productId);
                } else {
                    alert('Product options loading failed. Please refresh the page.');
                }
            } else {
                // Add simple product directly to cart
                addToCart(productId, 1);
            }
        });
    });
}
function addToCart(productId, quantity, variationId = 0) {
    // AJAX call to add to cart
    const xhr = new XMLHttpRequest();
    const ajaxUrl = wpAdminData.ajax_url;
    const nonce = wpAdminData.nonce;
    xhr.open('POST', ajaxUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status === 200) {
            try {
                const response = JSON.parse(this.responseText);
                if (response.success) {
                    // Close modal and show success message
                    document.getElementById('variants-modal').style.display = 'none';
                } else {
                    alert('Error adding product to cart.');
                }
            } catch (e) {
                alert('Error adding product to cart.');
            }
        }
    };

    let data = 'action=add_to_cart&product_id=' + productId + '&quantity=' + quantity;
    if (variationId > 0) {
        data += '&variation_id=' + variationId;
    }
    data += '&nonce=' + nonce;

    xhr.send(data);
}

// Tab click event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Initialize product actions
    initializeProductActions();

    // Add click event to tabs
    const tabs = document.querySelectorAll('.ss-tab-section li');
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Get category from data attribute
            const category = this.getAttribute('data-category');

            // Load products for this category
            loadProducts(category);
        });
    });

    // Animation on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    animateElements.forEach(el => observer.observe(el));
});