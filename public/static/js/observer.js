(function () {
    'use strict';

    function track(eventType, eventName, metadata, extra) {
        if (window.XenicalTracker && typeof window.XenicalTracker.track === 'function') {
            window.XenicalTracker.track(eventType, eventName, metadata, extra);
        }
    }

    window.ObserverTracker = {
        track: track
    };
})();
