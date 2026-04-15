jQuery(document).ready(function($) {
    
    // Mobile menu toggle
    $('.menu-toggle').on('click', function(e) {
        e.preventDefault();
        var menu = $('.main-menu');
        var button = $(this);
        
        menu.toggleClass('active');
        button.toggleClass('active');
        
        // Update ARIA attributes
        var isExpanded = menu.hasClass('active');
        button.attr('aria-expanded', isExpanded);
        button.html(isExpanded ? '✕' : '☰');
    });
    
    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation, .menu-toggle').length) {
            $('.main-menu').removeClass('active');
            $('.menu-toggle').removeClass('active').attr('aria-expanded', 'false').html('☰');
        }
    });
    
    // Touch-friendly: prevent double-tap zoom on buttons
    $('.btn, button, a').on('touchstart', function() {
        // Fast click simulation
    });
    
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Form validation
    $('.contact-form').on('submit', function(e) {
        var form = $(this);
        var hasError = false;
        
        form.find('input[required], textarea[required]').each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('error');
                hasError = true;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (hasError) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });
    
    // Phone mask
    $('input[type="tel"]').on('input', function() {
        var value = $(this).val().replace(/\D/g, '');
        var formatted = '';
        
        if (value.length > 0) {
            formatted = '+380';
            if (value.length > 3) {
                formatted += ' ' + value.substring(3, 6);
            } else {
                formatted += ' ' + value.substring(3);
            }
            if (value.length > 6) {
                formatted += ' ' + value.substring(6, 9);
            }
            if (value.length > 9) {
                formatted += ' ' + value.substring(9, 11);
            }
            if (value.length > 11) {
                formatted += ' ' + value.substring(11, 13);
            }
        }
        
        $(this).val(formatted);
    });
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        let imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let image = entry.target;
                    image.src = image.dataset.src;
                    image.classList.remove('lazy');
                    imageObserver.unobserve(image);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    // Cookie consent
    function checkCookieConsent() {
        if (!localStorage.getItem('cookieConsent')) {
            setTimeout(function() {
                showCookieConsent();
            }, 2000);
        }
    }
    
    function showCookieConsent() {
        var consentHtml = '<div id="cookie-consent" style="position: fixed; bottom: 0; left: 0; right: 0; background: #333; color: white; padding: 15px; text-align: center; z-index: 9999;">' +
            '<p>' + gorizont_vars.cookie_message + '</p>' +
            '<button id="accept-cookies" style="background: #007cba; color: white; border: none; padding: 8px 16px; margin-left: 10px; cursor: pointer;">Accept</button>' +
            '</div>';
        
        $('body').append(consentHtml);
        
        $('#accept-cookies').on('click', function() {
            localStorage.setItem('cookieConsent', 'true');
            $('#cookie-consent').fadeOut();
        });
    }
    
    checkCookieConsent();
    
});
