<div class="grid grid-cols-2 gap-4 p-4">
    {{-- 左列：訂單信息 + 商品 --}}
    <div class="space-y-4">
        {{-- 訂單信息 --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">訂單信息</h4>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs text-gray-400">訂單號</label>
                    <div class="text-sm font-medium">{{ $order->no }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">內部訂單號</label>
                    <div class="text-sm font-medium">{{ $order->inside_no }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">訂單總價</label>
                    <div class="text-sm font-medium">NT$ {{ number_format($order->total_price) }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">運費</label>
                    <div class="text-sm font-medium">NT$ {{ number_format($order->freight) }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">商品金額</label>
                    <div class="text-sm font-medium">NT$ {{ number_format($order->product_price) }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">訂單狀態</label>
                    <div class="text-sm font-medium">{{ \App\Models\Order::STATUS_TXT[$order->status] ?? $order->status }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">下單時間</label>
                    <div class="text-sm">{{ $order->created_at }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">配送方式</label>
                    <div class="text-sm font-medium">{{ \App\Models\Order::DELIVERY_TYPE_TXT[$order->delivery_type] ?? '宅配到府' }}</div>
                </div>
            </div>
            @if ($order->is_test)
                <div class="mt-2"><span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">測試訂單</span></div>
            @endif
        </div>

        {{-- 商品信息 --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">商品明細</h4>
            @forelse ($order->products as $item)
                <div class="border-b border-gray-200 pb-2 mb-2 last:border-0 last:pb-0 last:mb-0">
                    <div class="flex items-start justify-between">
                        <strong class="text-sm">{{ $item->product_name }}</strong>
                        @if (!empty($item->is_added))
                            <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700">加購</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-1 text-sm text-gray-600">
                        <div>數量：<span class="font-medium">{{ $item->number }}</span></div>
                        <div>單價：<span class="font-medium">NT$ {{ number_format($item->unit_price) }}</span></div>
                        <div>小計：<span class="font-medium">NT$ {{ number_format($item->total_price) }}</span></div>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-sm">無商品記錄</div>
            @endforelse
        </div>
    </div>

    {{-- 右列：收貨人 + 地址 + 設備 --}}
    <div class="space-y-4">
        {{-- 收貨人信息 --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">收貨人信息</h4>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs text-gray-400">姓名</label>
                    <div class="text-sm font-medium">{{ $order->name }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">電話</label>
                    <div class="text-sm font-medium">{{ $order->phone }}</div>
                </div>
                <div class="col-span-2">
                    <label class="text-xs text-gray-400">電子郵箱</label>
                    <div class="text-sm font-medium break-all">{{ $order->email }}</div>
                </div>
            </div>
            @if ($order->delivery_time)
                <div class="mt-2 pt-2 border-t border-gray-200">
                    <label class="text-xs text-gray-400">配送時段</label>
                    <div class="text-sm mt-1">{{ \App\Models\Order::DELIVERY_TIME[$order->delivery_time] ?? $order->delivery_time }}</div>
                </div>
            @endif
        </div>

        {{-- 地址信息 --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">地址信息</h4>
            @if ($order->delivery_type > 0)
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-400">超商類型</label>
                        <div class="text-sm font-medium">{{ \App\Models\Order::SHOP_TYPE_TXT[$order->shop_type] ?? '超商' }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400">門市名稱</label>
                        <div class="text-sm font-medium">{{ $order->shop_name ?? '未知' }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400">門市編號</label>
                        <div class="text-sm font-medium">{{ $order->shop_no ?? '未知' }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400">門市地址</label>
                        <div class="text-sm font-medium">{{ $order->address ?? '未知' }}</div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-3 gap-3">
                    <div><label class="text-xs text-gray-400">城市</label><div class="text-sm font-medium">{{ $order->city }}</div></div>
                    <div><label class="text-xs text-gray-400">區</label><div class="text-sm font-medium">{{ $order->county }}</div></div>
                    <div><label class="text-xs text-gray-400">路段</label><div class="text-sm font-medium">{{ $order->street }}</div></div>
                </div>
                <div class="mt-2">
                    <label class="text-xs text-gray-400">詳細地址</label>
                    <div class="text-sm mt-1">{{ $order->address ?? '無' }}</div>
                </div>
            @endif
        </div>

        {{-- 設備信息 --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">設備信息</h4>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs text-gray-400">IP 地址</label>
                    <div class="text-sm font-medium font-mono">{{ $order->ip }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">IP 國家</label>
                    <div class="text-sm font-medium">{{ $order->ipcountry ?? '未知' }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">設備</label>
                    <div class="text-sm font-medium">{{ \App\Handlers\DeviceTypeHandlers::getDevice($order->user_agent ?? '') }}</div>
                </div>
                <div>
                    <label class="text-xs text-gray-400">瀏覽器</label>
                    <div class="text-sm font-medium">{{ \App\Handlers\DeviceTypeHandlers::getBrowser($order->user_agent ?? '') ?: '未知' }}</div>
                </div>
            </div>
            @if ($order->user_agent)
                <div class="mt-2 pt-2 border-t border-gray-200">
                    <label class="text-xs text-gray-400">User Agent</label>
                    <div class="text-xs bg-white rounded p-2 mt-1 break-all font-mono">{{ $order->user_agent }}</div>
                </div>
            @endif
        </div>

        {{-- 備注 --}}
        @if ($order->remarks || $order->admin_remarks)
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">備注</h4>
                @if ($order->remarks)
                    <div class="mb-2">
                        <label class="text-xs text-gray-400">客戶備注</label>
                        <div class="text-sm bg-white rounded p-2 mt-1">{{ $order->remarks }}</div>
                    </div>
                @endif
                @if ($order->admin_remarks)
                    <div>
                        <label class="text-xs text-gray-400">管理員備注</label>
                        <div class="text-sm bg-yellow-50 rounded p-2 mt-1">{{ $order->admin_remarks }}</div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>