(function () {
    'use strict';

    function tracker() {
        return window.XenicalTracker;
    }

    if (!tracker()) {
        return;
    }

    var content = document.querySelector('.news-content,.page-content,article.news-container,main article,main section');
    if (!content) {
        return;
    }

    var milestones = {};
    tracker().track('reading', 'content_enter', {
        content_selector: content.className || content.tagName.toLowerCase()
    });

    function progress() {
        var rect = content.getBoundingClientRect();
        var total = Math.max(1, content.offsetHeight - window.innerHeight);
        var read = Math.max(0, Math.min(total, -rect.top));
        var percent = Math.round(read / total * 100);
        [25, 50, 75, 100].forEach(function (point) {
            if (percent >= point && !milestones[point]) {
                milestones[point] = true;
                tracker().track('reading', 'read_progress_' + point, {
                    progress_percent: point
                });
            }
        });
    }

    progress();
    window.addEventListener('scroll', progress, { passive: true });
})();
