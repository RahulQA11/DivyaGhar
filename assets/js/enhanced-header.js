/**
 * Enhanced Header JavaScript
 * Divyaghar E-commerce Website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sticky Header with Scroll Effect
    const header = document.getElementById('mainHeader');
    let lastScrollY = window.scrollY;
    
    function handleScroll() {
        const currentScrollY = window.scrollY;
        
        if (currentScrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScrollY = currentScrollY;
    }
    
    window.addEventListener('scroll', handleScroll);
    
    // User Dropdown Toggle
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    if (userDropdownToggle && userDropdownMenu) {
        userDropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = userDropdownMenu.classList.contains('show');
            
            // Close all other dropdowns
            closeAllDropdowns();
            
            if (!isOpen) {
                userDropdownMenu.classList.add('show');
                userDropdownToggle.classList.add('active');
            }
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.enhanced-user-menu')) {
            closeAllDropdowns();
        }
    });
    
    function closeAllDropdowns() {
        document.querySelectorAll('.user-dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        document.querySelectorAll('.user-dropdown-toggle').forEach(toggle => {
            toggle.classList.remove('active');
        });
    }
    
    // Search Suggestions
    const searchInput = document.querySelector('.search-input');
    const searchSuggestions = document.getElementById('searchSuggestions');
    let searchTimeout;
    
    if (searchInput && searchSuggestions) {
        searchInput.addEventListener('focus', function() {
            if (this.value.length === 0) {
                showSearchSuggestions();
            }
        });
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    fetchSearchSuggestions(query);
                }, 300);
            } else if (query.length === 0) {
                showSearchSuggestions();
            } else {
                hideSearchSuggestions();
            }
        });
        
        searchInput.addEventListener('blur', function() {
            setTimeout(() => {
                hideSearchSuggestions();
            }, 200);
        });
        
        // Click on suggestion items
        searchSuggestions.addEventListener('click', function(e) {
            if (e.target.classList.contains('suggestion-item')) {
                e.preventDefault();
                searchInput.value = e.target.textContent.trim();
                hideSearchSuggestions();
                searchInput.closest('form').submit();
            }
        });
    }
    
    function showSearchSuggestions() {
        if (searchSuggestions) {
            searchSuggestions.style.display = 'block';
            setTimeout(() => {
                searchSuggestions.style.opacity = '1';
                searchSuggestions.style.transform = 'translateY(0)';
            }, 10);
        }
    }
    
    function hideSearchSuggestions() {
        if (searchSuggestions) {
            searchSuggestions.style.opacity = '0';
            searchSuggestions.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                searchSuggestions.style.display = 'none';
            }, 300);
        }
    }
    
    function fetchSearchSuggestions(query) {
        // This would typically make an AJAX call to the server
        // For now, we'll show some mock suggestions
        const mockSuggestions = [
            { name: 'Ganesh Idol', url: 'search.php?q=ganesh+idol' },
            { name: 'Shiv Ling', url: 'search.php?q=shiv+ling' },
            { name: 'Diya Set', url: 'search.php?q=diya+set' },
            { name: 'Rudraksha Mala', url: 'search.php?q=rudraksha+mala' },
            { name: 'Pooja Thali', url: 'search.php?q=pooja+thali' }
        ];
        
        const filteredSuggestions = mockSuggestions.filter(item => 
            item.name.toLowerCase().includes(query.toLowerCase())
        );
        
        updateSearchSuggestions(filteredSuggestions);
    }
    
    function updateSearchSuggestions(suggestions) {
        if (!searchSuggestions) return;
        
        const suggestionsList = searchSuggestions.querySelector('.suggestions-list');
        
        if (suggestions.length > 0) {
            suggestionsList.innerHTML = suggestions.map(item => `
                <a href="${item.url}" class="suggestion-item">
                    <i class="fas fa-search"></i> ${item.name}
                </a>
            `).join('');
            showSearchSuggestions();
        } else {
            suggestionsList.innerHTML = `
                <div class="suggestion-item" style="color: var(--text-muted); cursor: default;">
                    <i class="fas fa-search"></i> No suggestions found
                </div>
            `;
            showSearchSuggestions();
        }
    }
    
    // Voice Search (Mock Implementation)
    const voiceSearchBtn = document.getElementById('voiceSearchBtn');
    
    if (voiceSearchBtn) {
        voiceSearchBtn.addEventListener('click', function() {
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                startVoiceSearch();
            } else {
                alert('Voice search is not supported in your browser. Please try a modern browser like Chrome.');
            }
        });
    }
    
    function startVoiceSearch() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();
        
        recognition.continuous = false;
        recognition.interimResults = false;
        recognition.lang = 'en-US';
        
        voiceSearchBtn.classList.add('active');
        
        recognition.onstart = function() {
            console.log('Voice recognition started');
        };
        
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            searchInput.value = transcript;
            hideSearchSuggestions();
            searchInput.closest('form').submit();
        };
        
        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
            voiceSearchBtn.classList.remove('active');
            
            if (event.error === 'no-speech') {
                alert('No speech detected. Please try again.');
            } else if (event.error === 'not-allowed') {
                alert('Microphone access denied. Please allow microphone access to use voice search.');
            } else {
                alert('Voice search failed. Please try again.');
            }
        };
        
        recognition.onend = function() {
            voiceSearchBtn.classList.remove('active');
        };
        
        recognition.start();
    }
    
    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileNav = document.querySelector('.mobile-nav');
    
    if (mobileMenuToggle && mobileNav) {
        mobileMenuToggle.addEventListener('click', function() {
            const isOpen = mobileNav.style.display !== 'none';
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        // Close mobile menu when clicking on close button
        const mobileMenuClose = document.querySelector('.mobile-menu-close');
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', closeMobileMenu);
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.mobile-nav') && !e.target.closest('.mobile-menu-toggle')) {
                closeMobileMenu();
            }
        });
        
        // Close mobile menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileNav.style.display !== 'none') {
                closeMobileMenu();
            }
        });
    }
    
    function openMobileMenu() {
        if (mobileNav) {
            mobileNav.style.display = 'block';
            setTimeout(() => {
                mobileNav.classList.add('show');
                document.body.style.overflow = 'hidden';
            }, 10);
        }
    }
    
    function closeMobileMenu() {
        if (mobileNav) {
            mobileNav.classList.remove('show');
            setTimeout(() => {
                mobileNav.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
    }
    
    // Cart Animation
    const cartLinks = document.querySelectorAll('.cart-link');
    
    cartLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            const cartCount = this.querySelector('.cart-count');
            if (cartCount) {
                cartCount.style.animation = 'cartBounce 0.3s ease';
            }
        });
        
        link.addEventListener('animationend', function(e) {
            if (e.target.classList.contains('cart-count')) {
                e.target.style.animation = '';
            }
        });
    });
    
    // Search Input Animation
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    }
    
    // Keyboard Navigation
    document.addEventListener('keydown', function(e) {
        // Escape key closes dropdowns
        if (e.key === 'Escape') {
            closeAllDropdowns();
            hideSearchSuggestions();
            closeMobileMenu();
        }
        
        // Ctrl/Cmd + K focuses search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
    });
    
    // Initialize tooltips and other micro-interactions
    initializeTooltips();
});

function initializeTooltips() {
    // Add tooltips for better UX
    const tooltipElements = document.querySelectorAll('[title]');
    
    tooltipElements.forEach(element => {
        const title = element.getAttribute('title');
        element.removeAttribute('title');
        
        element.addEventListener('mouseenter', function(e) {
            showTooltip(e.target, title);
        });
        
        element.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    });
}

function showTooltip(element, text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: var(--text-color);
        color: var(--white);
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: 4px;
        font-size: 0.8rem;
        z-index: 10000;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    `;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
    
    setTimeout(() => {
        tooltip.style.opacity = '1';
    }, 10);
}

function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.style.opacity = '0';
        setTimeout(() => {
            tooltip.remove();
        }, 300);
    }
}
