(function () {
    'use strict';

    if (window.XenicalTracker) {
        window.XenicalTracker.track('calc_interaction', 'calc_plugin_ready', {
            calculators_found: document.querySelectorAll('[data-calculator],.calculator').length
        });
    }
})();
