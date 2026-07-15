<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_events', function (Blueprint $table) {
            $table->id();
            $table->string('host', 191)->nullable();
            $table->string('uri', 500)->nullable();
            $table->string('event_type', 64)->nullable();
            $table->string('event_name', 191)->nullable();
            $table->string('event', 64)->nullable();
            $table->string('explain', 191)->nullable();
            $table->string('label', 191)->nullable();
            $table->string('section', 191)->nullable();
            $table->string('page_type', 64)->nullable();
            $table->string('device', 32)->nullable();
            $table->string('visitor_id', 80)->nullable();
            $table->string('session_id', 80)->nullable();
            $table->string('page_view_id', 80)->nullable();
            $table->string('referer', 500)->nullable();
            $table->string('utm_source', 191)->nullable();
            $table->string('utm_medium', 191)->nullable();
            $table->string('utm_campaign', 191)->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip', 64)->nullable();
            $table->string('ipcountry', 16)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamp('occurred_at')->nullable();
            $table->timestamps();

            $table->index(['page_type', 'created_at'], 'idx_tracking_page_type_created');
            $table->index(['event_type', 'created_at'], 'idx_tracking_event_created');
            $table->index('visitor_id', 'idx_tracking_visitor');
            $table->index('session_id', 'idx_tracking_session');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_events');
    }
};
