/**
 * Enhanced Products JavaScript
 * Divyaghar E-commerce Website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all product card interactions
    initializeProductCards();
    initializeQuickActions();
    initializeWishlistButtons();
    initializeAddToCart();
    initializeQuickView();
    initializeCompareFeature();
    initializeShareFeature();
});

function initializeProductCards() {
    // Add hover effects and animations
    const productCards = document.querySelectorAll('.enhanced-product-card');
    
    productCards.forEach(card => {
        // Add entrance animation
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
        
        // Add hover sound effect (optional)
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '';
        });
    });
}

function initializeQuickActions() {
    // Quick view buttons
    const quickViewBtns = document.querySelectorAll('.quick-view-btn');
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            openQuickView(productId);
        });
    });
    
    // Compare buttons
    const compareBtns = document.querySelectorAll('.compare-btn');
    compareBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            addToCompare(productId);
        });
    });
    
    // Share buttons
    const shareBtns = document.querySelectorAll('.share-btn');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            shareProduct(productId);
        });
    });
}

function initializeWishlistButtons() {
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    
    wishlistBtns.forEach(btn => {
        // Check if product is already in wishlist
        const productId = btn.dataset.productId;
        if (isInWishlist(productId)) {
            btn.classList.add('active');
            btn.querySelector('i').classList.remove('far');
            btn.querySelector('i').classList.add('fas');
        }
        
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            toggleWishlist(productId, this);
        });
    });
}

function initializeAddToCart() {
    const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (this.disabled) return;
            
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = this.dataset.productPrice;
            
            addToCart(productId, productName, productPrice, this);
        });
    });
}

function initializeQuickView() {
    // Quick view modal functionality
    const modal = document.getElementById('quickViewModal');
    const closeBtn = modal?.querySelector('.close-modal');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeQuickView);
    }
    
    // Close modal when clicking outside
    modal?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeQuickView();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal?.style.display === 'block') {
            closeQuickView();
        }
    });
}

function initializeCompareFeature() {
    // Initialize compare counter
    updateCompareCounter();
}

function initializeShareFeature() {
    // Initialize share functionality
    // This can be expanded to include actual sharing APIs
}

function openQuickView(productId) {
    // Show loading state
    const modal = document.getElementById('quickViewModal');
    const content = modal?.querySelector('.quick-view-content');
    
    if (modal && content) {
        modal.style.display = 'block';
        content.innerHTML = '<div class="quick-view-loading"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
        
        // Simulate loading product data
        setTimeout(() => {
            loadQuickViewContent(productId);
        }, 500);
    }
}

function loadQuickViewContent(productId) {
    // This would typically make an AJAX call to get product data
    // For now, we'll show a mock quick view
    const modal = document.getElementById('quickViewModal');
    const content = modal?.querySelector('.quick-view-content');
    
    if (content) {
        content.innerHTML = `
            <button class="close-modal">&times;</button>
            <div class="quick-view-body">
                <div class="quick-view-image">
                    <img src="assets/images/products/product-${productId}.jpg" alt="Product">
                </div>
                <div class="quick-view-details">
                    <h2>Product Name ${productId}</h2>
                    <div class="quick-view-rating">
                        <div class="stars">
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span>(150 reviews)</span>
                    </div>
                    <div class="quick-view-price">
                        <span class="price-current">₹1,299</span>
                        <span class="price-original">₹1,999</span>
                    </div>
                    <p class="quick-view-description">
                        Beautiful handcrafted product perfect for your spiritual needs.
                    </p>
                    <div class="quick-view-actions">
                        <button class="btn btn-primary add-to-cart-quick" data-product-id="${productId}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline wishlist-quick" data-product-id="${productId}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Reinitialize buttons in quick view
        initializeQuickViewButtons();
    }
}

function initializeQuickViewButtons() {
    // Add to cart button in quick view
    const quickAddBtn = document.querySelector('.add-to-cart-quick');
    if (quickAddBtn) {
        quickAddBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            addToCart(productId, 'Quick View Product', 1299, this);
        });
    }
    
    // Wishlist button in quick view
    const quickWishlistBtn = document.querySelector('.wishlist-quick');
    if (quickWishlistBtn) {
        quickWishlistBtn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            toggleWishlist(productId, this);
        });
    }
    
    // Close button
    const closeBtn = document.querySelector('.close-modal');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeQuickView);
    }
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function addToCart(productId, productName, productPrice, button) {
    // Show loading state
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    button.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Update cart count
        updateCartCount(1);
        
        // Show success state
        button.innerHTML = '<i class="fas fa-check"></i> Added!';
        button.classList.add('success');
        
        // Show toast notification
        showToast(`${productName} added to cart!`, 'success');
        
        // Reset button after delay
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.disabled = false;
            button.classList.remove('success');
        }, 2000);
        
        // Update cart in header
        updateHeaderCart();
    }, 800);
}

function toggleWishlist(productId, button) {
    const isActive = button.classList.contains('active');
    const icon = button.querySelector('i');
    
    if (isActive) {
        // Remove from wishlist
        button.classList.remove('active');
        icon.classList.remove('fas');
        icon.classList.add('far');
        showToast('Removed from wishlist', 'info');
    } else {
        // Add to wishlist
        button.classList.add('active');
        icon.classList.remove('far');
        icon.classList.add('fas');
        showToast('Added to wishlist!', 'success');
    }
    
    // Update wishlist count
    updateWishlistCount(isActive ? -1 : 1);
}

function addToCompare(productId) {
    // Get current compare list
    let compareList = JSON.parse(localStorage.getItem('compareList') || '[]');
    
    if (compareList.includes(productId)) {
        showToast('Product already in compare list', 'warning');
        return;
    }
    
    if (compareList.length >= 4) {
        showToast('You can compare up to 4 products at a time', 'warning');
        return;
    }
    
    compareList.push(productId);
    localStorage.setItem('compareList', JSON.stringify(compareList));
    
    showToast('Added to compare list', 'success');
    updateCompareCounter();
}

function shareProduct(productId) {
    // Create share modal or use native share API
    if (navigator.share) {
        navigator.share({
            title: 'Check out this product on Divyaghar',
            text: 'I found this amazing product on Divyaghar!',
            url: `${window.location.origin}/product.php?id=${productId}`
        }).catch(err => console.log('Share failed:', err));
    } else {
        // Fallback - copy link to clipboard
        const url = `${window.location.origin}/product.php?id=${productId}`;
        navigator.clipboard.writeText(url).then(() => {
            showToast('Product link copied to clipboard!', 'success');
        }).catch(() => {
            showToast('Failed to copy link', 'error');
        });
    }
}

function isInWishlist(productId) {
    // Check if product is in wishlist (would typically check with server)
    const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
    return wishlist.includes(productId);
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        const currentCount = parseInt(element.textContent) || 0;
        element.textContent = currentCount + count;
        
        // Add bounce animation
        element.style.animation = 'cartBounce 0.3s ease';
        setTimeout(() => {
            element.style.animation = '';
        }, 300);
    });
}

function updateWishlistCount(count) {
    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
    wishlistCountElements.forEach(element => {
        const currentCount = parseInt(element.textContent) || 0;
        const newCount = Math.max(0, currentCount + count);
        element.textContent = newCount;
        
        if (newCount === 0) {
            element.style.display = 'none';
        } else {
            element.style.display = 'inline-block';
        }
    });
}

function updateCompareCounter() {
    const compareList = JSON.parse(localStorage.getItem('compareList') || '[]');
    const compareCountElements = document.querySelectorAll('.compare-count');
    
    compareCountElements.forEach(element => {
        element.textContent = compareList.length;
        
        if (compareList.length === 0) {
            element.style.display = 'none';
        } else {
            element.style.display = 'inline-block';
        }
    });
}

function updateHeaderCart() {
    // This would typically fetch updated cart data from server
    // For now, we'll just update the count
    const cartCount = document.querySelector('.header .cart-count');
    if (cartCount) {
        const currentCount = parseInt(cartCount.textContent) || 0;
        cartCount.textContent = currentCount + 1;
    }
}

function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${getToastIcon(type)}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close">&times;</button>
    `;
    
    // Add to page
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
    
    // Close button
    const closeBtn = toast.querySelector('.toast-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        });
    }
}

function getToastIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'times-circle',
        warning: 'exclamation-triangle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Add CSS for toast notifications
const toastStyles = `
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        padding: 16px;
        min-width: 300px;
        max-width: 400px;
        z-index: 10000;
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    
    .toast.toast-success {
        border-left-color: #27ae60;
    }
    
    .toast.toast-error {
        border-left-color: #dc3545;
    }
    
    .toast.toast-warning {
        border-left-color: #ffc107;
    }
    
    .toast.toast-info {
        border-left-color: #17a2b8;
    }
    
    .toast.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .toast-content i {
        font-size: 1.2rem;
    }
    
    .toast-success .toast-content i {
        color: #27ae60;
    }
    
    .toast-error .toast-content i {
        color: #dc3545;
    }
    
    .toast-warning .toast-content i {
        color: #ffc107;
    }
    
    .toast-info .toast-content i {
        color: #17a2b8;
    }
    
    .toast-close {
        position: absolute;
        top: 8px;
        right: 8px;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: #999;
        padding: 4px;
    }
    
    .toast-close:hover {
        color: #333;
    }
`;

// Add toast styles to head
if (!document.querySelector('#toast-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'toast-styles';
    styleSheet.textContent = toastStyles;
    document.head.appendChild(styleSheet);
}
