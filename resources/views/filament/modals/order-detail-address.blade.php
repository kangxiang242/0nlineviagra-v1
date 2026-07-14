<div>
    @if ($order->delivery_type > 0)
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">超商類型：</span><span class="font-medium">{{ \App\Models\Order::SHOP_TYPE_TXT[$order->shop_type] ?? '超商' }}</span></div>
            <div><span class="text-gray-500">門市名稱：</span><span class="font-medium">{{ $order->shop_name ?? '未知' }}</span></div>
            <div><span class="text-gray-500">門市編號：</span><span class="font-medium">{{ $order->shop_no ?? '未知' }}</span></div>
            <div><span class="text-gray-500">門市地址：</span><span class="font-medium">{{ $order->address ?? '未知' }}</span></div>
        </div>
    @else
        <div class="text-sm">
            <span class="text-gray-500">地址：</span>
            <span class="font-medium">{{ $order->city }}{{ $order->county }}{{ $order->street }}{{ $order->address }}</span>
        </div>
    @endif
</div>