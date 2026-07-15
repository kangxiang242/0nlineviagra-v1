(function () {
    'use strict';

    function tracker() {
        return window.XenicalTracker;
    }

    if (!tracker()) {
        return;
    }

    tracker().track('checkout_step', 'begin_checkout', {
        form_id: document.getElementById('order-form') ? 'order-form' : null
    });

    document.addEventListener('change', function (event) {
        var field = event.target;
        if (!field || !field.matches('input[name="order_type"],input[name="pay_type"],select[name="city"],select[name="county"],select[name="street"]')) {
            return;
        }

        tracker().track('checkout_step', 'checkout_option_change', {
            field: field.name,
            option: field.name === 'order_type' ? (field.value === '1' ? 'store_pickup' : 'home_delivery') : null,
            selected: !!field.value
        });
    }, true);

    document.addEventListener('click', function (event) {
        var button = event.target.closest('#order-form button,.btn.form-btn');
        if (button) {
            tracker().track('checkout_step', 'checkout_submit_click', {
                form_id: 'order-form'
            });
        }
    }, true);
})();
