<?php

namespace App\Http\Controllers\Web;

use App\Models\TrackingEvent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ObserverController extends BaseController
{
    protected array $metadataAllowlist = [
        'field', 'action', 'product_id', 'href', 'element', 'error_code',
        'depth_percent', 'milestone', 'duration_sec', 'duration_seconds',
        'visibility_ratio_peak', 'section_label', 'order_no', 'calc_type',
        'slide_index', 'percent', 'engagement_type', 'blocks_seen',
        'last_section_id', 'duration_before_click_sec',
        'max_scroll_before_click_percent', 'checkout_duration_sec',
        'checkout_outcome', 'last_field', 'fields_touched', 'submit_clicked',
        'status', 'step', 'filled', 'changed', 'value', 'exit_type',
        'next_uri', 'cms_uri', 'article_id',
    ];

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $metadata = $this->parseMetadata($request->input('metadata'));
            $data = [
                'host'        => $request->getHost(),
                'uri'         => $request->input('uri') ?? $request->input('page') ?? '/',
                'event_type'  => $request->input('event_type'),
                'event_name'  => $request->input('event_name'),
                'event'       => $request->input('event'),
                'explain'     => $request->input('explain'),
                'label'       => $request->input('label'),
                'section'     => $request->input('section'),
                'page_type'   => $request->input('page_type'),
                'device'      => $request->input('device', 'web'),
                'visitor_id'  => $request->input('visitor_id'),
                'session_id'  => $request->input('session_id'),
                'page_view_id'=> $request->input('page_view_id'),
                'referer'     => $request->input('referer'),
                'utm_source'  => $request->input('utm_source'),
                'utm_medium'  => $request->input('utm_medium'),
                'utm_campaign'=> $request->input('utm_campaign'),
                'metadata'    => $metadata ? json_encode($metadata) : null,
                'ip'          => $request->ip(),
                'ipcountry'   => $request->input('ipcountry'),
                'user_agent'  => $request->userAgent(),
                'occurred_at' => $request->input('occurred_at'),
            ];

            TrackingEvent::create($data);
        } catch (\Throwable $e) {
            // Silently fail - don't block the frontend
            logger()->warning('Observer/store failed: ' . $e->getMessage());
        }

        return response()->json(['ok' => true]);
    }

    protected function parseMetadata(mixed $raw): ?array
    {
        if (empty($raw)) return null;

        $decoded = null;
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
        } elseif (is_array($raw)) {
            $decoded = $raw;
        }

        if (!is_array($decoded)) return null;

        // Only keep allowlist fields
        return array_intersect_key($decoded, array_flip($this->metadataAllowlist));
    }
}
