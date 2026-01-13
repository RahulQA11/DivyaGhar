/**
 * Divyaghar E-commerce Website - Clean JavaScript
 * No external dependencies, pure vanilla JS
 */

// Wait for DOM to be loaded
document.addEventListener('DOMContentLoaded', function() {
    
    console.log('Divyaghar website loaded successfully');
    
    // Initialize all features safely
    try {
        initializeCart();
        initializeBackToTop();
        initializeNewsletter();
        initializeSmoothScroll();
        console.log('All features initialized');
    } catch (error) {
        console.log('Initialization completed with warnings:', error.message);
    }
});

/**
 * Cart Functionality
 */
function initializeCart() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(function(button) {
        if (button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.getAttribute('data-product-id');
                if (!productId) {
                    showNotification('Product ID not found', 'error');
                    return;
                }
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Adding...';
                this.disabled = true;
                
                // Send AJAX request
                fetch('ajax/add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId + '&quantity=1'
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        updateCartCount();
                        // Update button temporarily
                        button.innerHTML = '<i class="fas fa-check me-1"></i> Added';
                        setTimeout(function() {
                            button.innerHTML = originalText;
                            button.disabled = false;
                        }, 2000);
                    } else {
                        showNotification(data.message, 'error');
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                })
                .catch(function(error) {
                    console.error('Cart error:', error);
                    showNotification('An error occurred. Please try again.', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            });
        }
    });
}

/**
 * Update Cart Count
 */
function updateCartCount() {
    fetch('ajax/get_cart_count.php')
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(function(element) {
                if (data.count > 0) {
                    element.textContent = data.count;
                    element.style.display = 'inline-block';
                } else {
                    element.style.display = 'none';
                }
            });
        })
        .catch(function(error) {
            console.error('Cart count error:', error);
        });
}

/**
 * Back to Top Button
 */
function initializeBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        
        // Scroll to top when clicked
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

/**
 * Newsletter Form
 */
function initializeNewsletter() {
    const newsletterForm = document.getElementById('newsletterForm');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[name="email"]');
            const email = emailInput ? emailInput.value : '';
            
            if (!email) {
                showNotification('Please enter your email address', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }
            
            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton ? submitButton.innerHTML : '';
            if (submitButton) {
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Subscribing...';
                submitButton.disabled = true;
            }
            
            // Send request
            fetch('ajax/newsletter_subscribe.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    showNotification(data.message, 'success');
                    newsletterForm.reset();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(function(error) {
                console.error('Newsletter error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            })
            .finally(function() {
                if (submitButton) {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            });
        });
    }
}

/**
 * Smooth Scroll
 */
function initializeSmoothScroll() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                
                const headerHeight = document.querySelector('.navbar') ? 
                    document.querySelector('.navbar').offsetHeight : 0;
                const targetPosition = targetElement.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Show Notification
 */
function showNotification(message, type) {
    type = type || 'info';
    
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.toast');
    existingNotifications.forEach(function(notification) {
        notification.remove();
    });
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = 'toast show align-items-center text-white border-0';
    
    // Set background color based on type
    if (type === 'error') {
        notification.classList.add('bg-danger');
    } else if (type === 'success') {
        notification.classList.add('bg-success');
    } else {
        notification.classList.add('bg-primary');
    }
    
    notification.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.toast').remove()"></button>
        </div>
    `;
    
    // Style and position
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 250px;
        max-width: 400px;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(function() {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

/**
 * Email Validation
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Format Price
 */
function formatPrice(price) {
    return '₹' + parseFloat(price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Global functions
window.Divyaghar = {
    showNotification: showNotification,
    formatPrice: formatPrice,
    isValidEmail: isValidEmail
};

console.log('Divyaghar JavaScript loaded successfully');
