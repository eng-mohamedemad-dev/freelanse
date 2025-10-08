// Website JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Cart functionality
    var addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var productId = this.getAttribute('data-product-id');
            var quantity = this.getAttribute('data-quantity') || 1;
            
            addToCart(productId, quantity);
        });
    });

    // Wishlist functionality
    var wishlistButtons = document.querySelectorAll('.add-to-wishlist');
    wishlistButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var productId = this.getAttribute('data-product-id');
            toggleWishlist(productId);
        });
    });

    // Quantity controls
    var quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(function(input) {
        var decreaseBtn = input.parentNode.querySelector('.quantity-decrease');
        var increaseBtn = input.parentNode.querySelector('.quantity-increase');
        
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function() {
                var currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
        }
        
        if (increaseBtn) {
            increaseBtn.addEventListener('click', function() {
                var currentValue = parseInt(input.value);
                input.value = currentValue + 1;
            });
        }
    });

    // Search functionality
    var searchInput = document.querySelector('#search-input');
    if (searchInput) {
        var searchResults = document.querySelector('#search-results');
        
        searchInput.addEventListener('input', function() {
            var searchTerm = this.value;
            if (searchTerm.length > 2) {
                performSearch(searchTerm);
            } else {
                hideSearchResults();
            }
        });
    }

    // Product filtering
    var filterForm = document.querySelector('#filter-form');
    if (filterForm) {
        filterForm.addEventListener('change', function() {
            this.submit();
        });
    }

    // Image gallery
    var productImages = document.querySelectorAll('.product-image');
    productImages.forEach(function(image) {
        image.addEventListener('click', function() {
            showImageModal(this.src, this.alt);
        });
    });

    // Form validation
    var forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Mobile menu toggle
    var mobileMenuToggle = document.querySelector('#mobile-menu-toggle');
    var mobileMenu = document.querySelector('#mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('show');
        });
    }

    // Smooth scrolling for anchor links
    var anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Lazy loading for images
    var lazyImages = document.querySelectorAll('img[data-src]');
    if ('IntersectionObserver' in window) {
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    }
});

// Cart functions
function addToCart(productId, quantity = 1) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cart_count);
            showAlert('Product added to cart successfully!', 'success');
        } else {
            showAlert(data.message || 'Error adding product to cart', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error adding product to cart', 'danger');
    });
}

function removeFromCart(productId) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cart_count);
            location.reload(); // Refresh cart page
        } else {
            showAlert(data.message || 'Error removing product from cart', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error removing product from cart', 'danger');
    });
}

function updateCartCount(count) {
    var cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = count;
    }
}

// Wishlist functions
function toggleWishlist(productId) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var button = document.querySelector('[data-product-id="' + productId + '"]');
            if (button) {
                button.classList.toggle('active');
                button.innerHTML = data.in_wishlist ? 
                    '<i class="fa fa-heart"></i> Remove from Wishlist' : 
                    '<i class="fa fa-heart-o"></i> Add to Wishlist';
            }
            showAlert(data.message, 'success');
        } else {
            showAlert(data.message || 'Error updating wishlist', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error updating wishlist', 'danger');
    });
}

// Search functions
function performSearch(searchTerm) {
    fetch('/search?q=' + encodeURIComponent(searchTerm))
    .then(response => response.json())
    .then(data => {
        displaySearchResults(data.results);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displaySearchResults(results) {
    var searchResults = document.querySelector('#search-results');
    if (searchResults) {
        if (results.length > 0) {
            var html = '<div class="search-results-dropdown">';
            results.forEach(function(result) {
                html += '<a href="' + result.url + '" class="search-result-item">';
                html += '<img src="' + result.image + '" alt="' + result.title + '">';
                html += '<div class="search-result-info">';
                html += '<h6>' + result.title + '</h6>';
                html += '<p class="text-muted">' + result.price + '</p>';
                html += '</div></a>';
            });
            html += '</div>';
            searchResults.innerHTML = html;
            searchResults.style.display = 'block';
        } else {
            searchResults.innerHTML = '<div class="search-results-dropdown"><p class="text-muted">No results found</p></div>';
            searchResults.style.display = 'block';
        }
    }
}

function hideSearchResults() {
    var searchResults = document.querySelector('#search-results');
    if (searchResults) {
        searchResults.style.display = 'none';
    }
}

// Image modal
function showImageModal(src, alt) {
    var modal = document.createElement('div');
    modal.className = 'image-modal';
    modal.innerHTML = '<div class="modal-content"><span class="close">&times;</span><img src="' + src + '" alt="' + alt + '"></div>';
    
    document.body.appendChild(modal);
    
    modal.querySelector('.close').addEventListener('click', function() {
        document.body.removeChild(modal);
    });
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            document.body.removeChild(modal);
        }
    });
}

// Utility functions
function showAlert(message, type = 'success') {
    var alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-' + type + ' alert-dismissible fade show';
    alertDiv.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    
    var container = document.querySelector('.website-main');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            var bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }
}

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
