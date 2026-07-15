(function () {
    'use strict';

    function tracker() {
        return window.XenicalTracker;
    }

    if (!tracker()) {
        return;
    }

    tracker().track('product_interaction', 'product_page_ready', {
        product_buttons: document.querySelectorAll('.go-checkout,.ad-btn').length
    });

    document.addEventListener('click', function (event) {
        var button = event.target.closest('.go-checkout,.ad-btn');
        if (!button) {
            return;
        }

        tracker().track('product_interaction', 'product_order_click', {
            product_id: button.getAttribute('data-id') || null,
            href: button.getAttribute('href') || null
        });
    }, true);
})();
