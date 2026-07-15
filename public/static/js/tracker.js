(function () {
    'use strict';

    var config = window.__TRACKING_CONFIG__ || {};
    var page = window.__TRACKING_PAGE__ || {};

    if (config.enabled === false) {
        return;
    }

    var endpoint = config.endpoint || '/observer/store';
    var storagePrefix = 'vcl_tracker_' + (location.hostname || 'local') + '_';
    var startTime = Date.now();
    var maxScrollPercent = 0;
    var sentScrollDepths = {};
    var sentExit = false;
    var blocksSeen = [];
    var lastSectionId = null;
    var sectionTimers = {};
    var sectionSeenAt = {};
    var pageViewId = makeId();
    var visitorId = readStoredId(localStorage, storagePrefix + 'visitor_id');
    var sessionId = readStoredId(sessionStorage, storagePrefix + 'session_id');
    var traffic = captureTraffic();

    function makeId() {
        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
            return window.crypto.randomUUID();
        }
        return String(Date.now()) + '-' + Math.random().toString(16).slice(2);
    }

    function readStoredId(store, key) {
        try {
            var value = store.getItem(key);
            if (!value) {
                value = makeId();
                store.setItem(key, value);
            }
            return value;
        } catch (error) {
            return makeId();
        }
    }

    function captureTraffic() {
        var params = new URLSearchParams(location.search);
        var data = {};
        ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'].forEach(function (key) {
            if (params.get(key)) {
                data[key] = params.get(key);
            }
        });

        try {
            if (Object.keys(data).length) {
                localStorage.setItem(storagePrefix + 'traffic', JSON.stringify(data));
                return data;
            }
            return JSON.parse(localStorage.getItem(storagePrefix + 'traffic') || '{}');
        } catch (error) {
            return data;
        }
    }

    function durationSec() {
        return Math.round((Date.now() - startTime) / 1000);
    }

    function getScrollPercent() {
        var doc = document.documentElement;
        var body = document.body;
        var scrollTop = window.pageYOffset || doc.scrollTop || body.scrollTop || 0;
        var height = Math.max(body.scrollHeight, doc.scrollHeight) - window.innerHeight;
        if (height <= 0) {
            return 100;
        }
        return Math.max(0, Math.min(100, Math.round(scrollTop / height * 100)));
    }

    function normalizeHref(href) {
        if (!href) {
            return null;
        }
        try {
            var url = new URL(href, location.href);
            return url.origin === location.origin ? url.pathname + url.search + url.hash : url.origin;
        } catch (error) {
            return href.split('?')[0].slice(0, 160);
        }
    }

    function cleanUrl(value) {
        if (!value) {
            return null;
        }
        try {
            var url = new URL(value, location.href);
            return url.origin + url.pathname;
        } catch (error) {
            return String(value).split('?')[0].split('#')[0].slice(0, 200);
        }
    }

    function textOf(element) {
        if (!element) {
            return '';
        }
        return (element.getAttribute('data-track-name') ||
            element.getAttribute('data-observer') ||
            element.getAttribute('aria-label') ||
            element.getAttribute('title') ||
            element.textContent ||
            '').replace(/\s+/g, ' ').trim().slice(0, 120);
    }

    function basePayload(eventType, eventName, metadata) {
        return {
            event_type: eventType,
            event_name: eventName || eventType,
            visitor_id: visitorId,
            session_id: sessionId,
            page_view_id: pageViewId,
            web_host: config.webHost || location.hostname,
            site: config.site || null,
            page_type: page.page_type || 'unknown',
            page_url: cleanUrl(location.href),
            page_path: location.pathname,
            page_title: document.title,
            referrer: cleanUrl(document.referrer),
            goods_id: page.goods_id || null,
            article_id: page.article_id || null,
            category_id: page.category_id || null,
            cms_uri: page.cms_uri || null,
            scroll_percent: maxScrollPercent,
            duration_sec: durationSec(),
            occurred_at: new Date().toISOString(),
            metadata: metadata || {}
        };
    }

    function send(payload) {
        var body = JSON.stringify(payload);
        try {
            if (navigator.sendBeacon) {
                var blob = new Blob([body], { type: 'application/json' });
                if (navigator.sendBeacon(endpoint, blob)) {
                    return;
                }
            }
        } catch (error) {}

        try {
            fetch(endpoint, {
                method: 'POST',
                credentials: 'same-origin',
                keepalive: true,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: body
            }).catch(function () {});
        } catch (error) {}
    }

    function track(eventType, eventName, metadata, extra) {
        var payload = basePayload(eventType, eventName, metadata);
        if (extra && typeof extra === 'object') {
            Object.keys(extra).forEach(function (key) {
                payload[key] = extra[key];
            });
        }
        send(payload);
    }

    function markSections() {
        var selectors = [
            '[data-track-section-view]',
            '.ad-carousel',
            '.page-head',
            'main > section',
            'main > article',
            '.form-container .card',
            '.news-container',
            '.message-container',
            'footer'
        ];
        var nodes = Array.prototype.slice.call(document.querySelectorAll(selectors.join(',')));
        var unique = [];
        nodes.forEach(function (node) {
            if (unique.indexOf(node) === -1) {
                unique.push(node);
            }
        });

        unique.forEach(function (node, index) {
            if (!node.hasAttribute('data-track-section-view')) {
                node.setAttribute('data-track-section-view', '1');
            }
            if (!node.getAttribute('data-track-section')) {
                node.setAttribute('data-track-section', (page.page_type || 'page') + '.section_' + (index + 1));
            }
            if (!node.getAttribute('data-track-section-label')) {
                var heading = node.querySelector('h1,h2,h3,.title,.hero-title');
                node.setAttribute('data-track-section-label', textOf(heading) || node.className || node.tagName.toLowerCase());
            }
        });
    }

    function setupSections() {
        markSections();
        var nodes = document.querySelectorAll('[data-track-section-view]');
        if (!('IntersectionObserver' in window) || !nodes.length) {
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                var node = entry.target;
                var sectionId = node.getAttribute('data-track-section');
                var label = node.getAttribute('data-track-section-label');

                if (entry.isIntersecting) {
                    lastSectionId = sectionId;
                    if (blocksSeen.indexOf(sectionId) === -1) {
                        blocksSeen.push(sectionId);
                        track('section_view', sectionId, {
                            section_id: sectionId,
                            section_label: label,
                            section_index: blocksSeen.length
                        });
                    }
                    sectionSeenAt[sectionId] = Date.now();
                } else if (sectionSeenAt[sectionId]) {
                    var dwell = Math.round((Date.now() - sectionSeenAt[sectionId]) / 1000);
                    delete sectionSeenAt[sectionId];
                    sectionTimers[sectionId] = (sectionTimers[sectionId] || 0) + dwell;
                    if (dwell >= 2) {
                        track('section_dwell', sectionId, {
                            section_id: sectionId,
                            section_label: label,
                            dwell_sec: dwell
                        });
                    }
                }
            });
        }, { threshold: 0.35 });

        nodes.forEach(function (node) {
            observer.observe(node);
        });
    }

    function setupScrollDepth() {
        function handleScroll() {
            maxScrollPercent = Math.max(maxScrollPercent, getScrollPercent());
            [25, 50, 75, 100].forEach(function (depth) {
                if (maxScrollPercent >= depth && !sentScrollDepths[depth]) {
                    sentScrollDepths[depth] = true;
                    track('scroll_depth', 'scroll_' + depth, {
                        depth_percent: depth,
                        blocks_seen: blocksSeen.length,
                        last_section_id: lastSectionId
                    });
                }
            });
        }
        handleScroll();
        window.addEventListener('scroll', throttle(handleScroll, 500), { passive: true });
    }

    function setupClicks() {
        document.addEventListener('click', function (event) {
            var target = event.target.closest('[data-observer],[data-track-name],a,button,input[type="submit"],input[type="button"],.go-checkout,.ad-btn,.form-btn');
            if (!target) {
                return;
            }

            track('click', textOf(target) || 'click', {
                element: target.tagName.toLowerCase(),
                href: normalizeHref(target.getAttribute('href')),
                target_id: target.id || null,
                target_class: (target.className || '').toString().slice(0, 120),
                product_id: target.getAttribute('data-id') || target.getAttribute('data-product-id') || null,
                duration_before_click_sec: durationSec(),
                max_scroll_before_click_percent: maxScrollPercent,
                blocks_seen: blocksSeen.length,
                last_section_id: lastSectionId
            });
        }, true);
    }

    function setupForms() {
        injectTrackingFields();

        document.addEventListener('focusin', function (event) {
            var field = event.target.closest('input,select,textarea');
            if (field && field.form) {
                trackFormField(field, 'focus');
            }
        });

        document.addEventListener('change', function (event) {
            var field = event.target.closest('input,select,textarea');
            if (field && field.form) {
                trackFormField(field, 'change');
            }
        });

        document.addEventListener('submit', function (event) {
            var form = event.target;
            if (!form || !form.matches('form')) {
                return;
            }
            var formId = form.getAttribute('id') || form.getAttribute('name') || 'form';
            track('form_interaction', formId + '.submit', {
                form_id: formId,
                action: 'submit',
                fields_count: form.querySelectorAll('input,select,textarea').length
            });
            if (formId === 'order-form') {
                track('conversion', 'checkout_submit', { form_id: formId, goods_id: page.goods_id || null });
            }
            if (formId === 'message-form') {
                track('conversion', 'message_submit', { form_id: formId });
            }
        }, true);
    }

    function injectTrackingFields() {
        document.querySelectorAll('form').forEach(function (form) {
            [
                ['tracking_visitor_id', visitorId],
                ['tracking_session_id', sessionId],
                ['tracking_page_view_id', pageViewId]
            ].forEach(function (item) {
                if (form.querySelector('input[name="' + item[0] + '"]')) {
                    return;
                }
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = item[0];
                input.value = item[1];
                form.appendChild(input);
            });
        });
    }

    function trackFormField(field, action) {
        var formId = field.form.getAttribute('id') || field.form.getAttribute('name') || 'form';
        var type = field.getAttribute('type') || field.tagName.toLowerCase();
        var filled = false;

        if (type === 'checkbox' || type === 'radio') {
            filled = !!field.checked;
        } else {
            filled = !!field.value;
        }

        track('form_interaction', formId + '.' + (field.name || field.id || field.tagName.toLowerCase()) + '.' + action, {
            form_id: formId,
            field: field.name || field.id || null,
            field_type: type,
            action: action,
            filled: filled,
            goods_id: page.goods_id || null
        });
    }

    function sendExit() {
        if (sentExit) {
            return;
        }
        sentExit = true;
        Object.keys(sectionSeenAt).forEach(function (sectionId) {
            var dwell = Math.round((Date.now() - sectionSeenAt[sectionId]) / 1000);
            sectionTimers[sectionId] = (sectionTimers[sectionId] || 0) + dwell;
        });

        track('page_exit', 'page_exit', {
            duration_sec: durationSec(),
            max_scroll_percent: maxScrollPercent,
            engagement_type: durationSec() >= 10 || maxScrollPercent >= 50 ? 'engaged' : 'bounce',
            blocks_seen: blocksSeen.length,
            last_section_id: lastSectionId,
            section_dwell: sectionTimers
        });
    }

    function throttle(callback, delay) {
        var last = 0;
        var timer = null;
        return function () {
            var now = Date.now();
            var args = arguments;
            if (now - last >= delay) {
                last = now;
                callback.apply(null, args);
                return;
            }
            clearTimeout(timer);
            timer = setTimeout(function () {
                last = Date.now();
                callback.apply(null, args);
            }, delay - (now - last));
        };
    }

    function loadPlugin(name) {
        if (!name) {
            return;
        }
        var script = document.createElement('script');
        script.src = (config.assetBase || '/static/js/') + 'tracker-plugins/' + name + '.js';
        script.defer = true;
        document.head.appendChild(script);
    }

    function loadPagePlugin() {
        var type = page.page_type || '';
        var pluginMap = {
            home: 'home',
            checkout: 'checkout',
            product_list: 'product',
            product_detail: 'product',
            news_detail: 'reading',
            cms: 'reading'
        };
        loadPlugin(pluginMap[type]);
    }

    function ready(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    }

    window.XenicalTracker = {
        track: track,
        getContext: function () {
            return {
                visitor_id: visitorId,
                session_id: sessionId,
                page_view_id: pageViewId,
                page_type: page.page_type || 'unknown',
                duration_sec: durationSec(),
                max_scroll_percent: maxScrollPercent,
                blocks_seen: blocksSeen.slice(),
                last_section_id: lastSectionId
            };
        }
    };

    ready(function () {
        maxScrollPercent = getScrollPercent();
        setupSections();
        setupScrollDepth();
        setupClicks();
        setupForms();
        loadPagePlugin();
        track('page_view', 'page_view', {
            traffic: traffic,
            viewport: {
                width: window.innerWidth,
                height: window.innerHeight
            }
        });
    });

    window.addEventListener('pagehide', sendExit);
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            sendExit();
        }
    });
})();
