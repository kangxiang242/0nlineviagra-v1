<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    protected $fillable = [
        'host', 'uri', 'event_type', 'event_name', 'event', 'explain', 'label',
        'section', 'page_type', 'device', 'visitor_id', 'session_id', 'page_view_id',
        'referer', 'utm_source', 'utm_medium', 'utm_campaign', 'metadata',
        'ip', 'ipcountry', 'user_agent', 'occurred_at',
    ];

    protected $casts = [
        'metadata' => 'json',
        'occurred_at' => 'datetime',
    ];
}