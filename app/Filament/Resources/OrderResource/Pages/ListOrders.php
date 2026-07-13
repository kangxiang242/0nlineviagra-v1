<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Exports\OrderXlsxExport;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\Action::make('export_all')
                    ->label('匯出全部')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn () => $this->exportAll()),
                Actions\Action::make('export_selected')
                    ->label('匯出選中')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->accessSelectedRecords()
                    ->action(function ($livewire) {
                        return $livewire->exportSelected();
                    }),
            ])->label('匯出')->button()->color('gray'),
        ];
    }

    protected function acquireExportLock(): bool
    {
        $key = 'order_export_lock_' . (auth()->id() ?? 'guest');
        return Cache::add($key, true, 8);
    }

    public function exportAll()
    {
        if (! $this->acquireExportLock()) {
            Notification::make()->warning()->title('匯出進行中')
                ->body('請稍候，避免連續點擊')->send();
            return;
        }
        $query = Order::with('products')->orderBy('created_at', 'desc');
        return static::exportOrdersToXlsx($query, 'orders-all-'.now()->format('Ymd-His').'.xlsx');
    }

    public function exportSelected()
    {
        $records = $this->getSelectedTableRecords();
        if ($records->isEmpty()) {
            Notification::make()->warning()->title('請選擇訂單')->send();
            return;
        }
        if (! $this->acquireExportLock()) {
            Notification::make()->warning()->title('匯出進行中')
                ->body('請稍候，避免連續點擊')->send();
            return;
        }
        return static::exportOrdersToXlsx($records, 'orders-selected-'.now()->format('Ymd-His').'.xlsx');
    }

    public static function exportOrdersToXlsx($recordsOrQuery, string $fileName)
    {
        if ($recordsOrQuery instanceof \Illuminate\Database\Eloquent\Collection) {
            $ids = $recordsOrQuery->pluck('id');
            $query = Order::with('products')->whereIn('id', $ids);
        } else {
            $query = $recordsOrQuery->with('products');
        }
        $orders = $query->orderBy('created_at', 'desc')->get();

        $data[] = ['訂單號', '内單號', '商品', '總價', '名字', '電話', '郵箱', '地址', '收貨方式', '配送時間', '備注', '訂單狀態'];

        foreach ($orders as $item) {
            $productTxt = '';
            foreach ($item->products as $k => $vv) {
                $productTxt .= $vv->product_name . "({$vv->unit_price}/件)*{$vv->number}";
                if (($k+1) < count($item->products)) $productTxt .= PHP_EOL;
            }
            $addr = $item->delivery_type > 0
                ? $item->address . "（超商{$item->shop_name}門市{$item->shop_no}自取件）電話通知到店取貨"
                : "{$item->city}{$item->county}{$item->street}{$item->address}";
            $data[] = [
                $item->no, $item->inside_no, $productTxt, $item->total_price,
                $item->name, $item->phone, $item->email, $addr,
                '本人收貨', \App\Models\Order::DELIVERY_TIME[$item->delivery_time] ?? '09:00~12:00',
                $item->remarks, \App\Models\Order::STATUS_TXT[$item->status] ?? '未知',
            ];
        }
        return Excel::download(new OrderXlsxExport($data), $fileName);
    }
}
