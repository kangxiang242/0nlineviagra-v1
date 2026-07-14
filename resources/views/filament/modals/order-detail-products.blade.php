<div class="space-y-2">
    @forelse ($order->products as $item)
        <div class="flex items-center justify-between border-b border-gray-100 pb-2 last:border-0">
            <div class="flex-1">
                <span class="text-sm font-medium">{{ $item->product_name }}</span>
                @if (!empty($item->is_added))
                    <span class="ml-1 text-xs text-red-600">(加購)</span>
                @endif
            </div>
            <div class="flex gap-4 text-sm text-gray-600">
                <span>數量: {{ $item->number }}</span>
                <span>單價: NT$ {{ number_format($item->unit_price) }}</span>
                <span class="font-medium">小計: NT$ {{ number_format($item->total_price) }}</span>
            </div>
        </div>
    @empty
        <div class="text-gray-400 text-sm">無商品記錄</div>
    @endforelse
</div>