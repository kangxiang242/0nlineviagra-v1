(function () {
    'use strict';

    function tracker() {
        return window.XenicalTracker;
    }

    if (!tracker()) {
        return;
    }

    document.addEventListener('click', function (event) {
        var faq = event.target.closest('.faq-question,.faq-item');
        if (faq) {
            tracker().track('click', 'faq_toggle', {
                component: 'faq',
                label: (faq.textContent || '').replace(/\s+/g, ' ').trim().slice(0, 100)
            });
        }

        var close = event.target.closest('.ad-carousel .close-btn');
        if (close) {
            tracker().track('click', 'ad_carousel_close', { component: 'ad_carousel' });
        }
    }, true);

    tracker().track('home_interaction', 'home_ready', {
        sections_found: document.querySelectorAll('main section,[data-track-section-view]').length
    });
})();
