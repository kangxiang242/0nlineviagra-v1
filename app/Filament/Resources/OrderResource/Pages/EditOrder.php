<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string
    {
        return '訂單資訊 - ' . ($this->record->no ?? '');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('訂單信息')
                ->columns(4)
                ->schema([
                    Forms\Components\TextInput::make('no')->label('訂單號')->disabled()->columnSpan(1),
                    Forms\Components\TextInput::make('inside_no')->label('內部訂單號')->disabled()->columnSpan(1),
                    Forms\Components\TextInput::make('total_price')->label('訂單總價')->disabled()->prefix('NT$')->columnSpan(1),
                    Forms\Components\TextInput::make('freight')->label('運費')->disabled()->prefix('NT$')->columnSpan(1),
                    Forms\Components\TextInput::make('product_price')->label('商品金額')->disabled()->prefix('NT$')->columnSpan(1),
                    Forms\Components\Select::make('status')->label('訂單狀態')
                        ->options(Order::STATUS_TXT)
                        ->required()->columnSpan(1),
                    Forms\Components\TextInput::make('created_at')->label('下單時間')->disabled()->columnSpan(1),
                    Forms\Components\TextInput::make('delivery_type')->label('配送方式')
                        ->formatStateUsing(fn ($state) => Order::DELIVERY_TYPE_TXT[$state] ?? '宅配到府')
                        ->disabled()->columnSpan(1),
                ]),

            Forms\Components\Section::make('商品明細')
                ->schema([
                    Forms\Components\Placeholder::make('products')
                        ->label('')
                        ->content(fn ($record) => view('filament.modals.order-detail-products', ['order' => $record])),
                ]),

            Forms\Components\Section::make('收貨人信息')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('name')->label('姓名')->disabled()->columnSpan(1),
                    Forms\Components\TextInput::make('phone')->label('電話')->disabled()->columnSpan(1),
                    Forms\Components\TextInput::make('email')->label('電子郵箱')->disabled()->columnSpan(1),
                ]),

            Forms\Components\Section::make('地址信息')
                ->columns(2)
                ->schema([
                    Forms\Components\Placeholder::make('address_detail')
                        ->label('')
                        ->content(fn ($record) => view('filament.modals.order-detail-address', ['order' => $record])),
                ]),

            Forms\Components\Section::make('設備信息')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('ip')->label('IP 地址')->disabled()->columnSpan(1),
                    Forms\Components\TextInput::make('ipcountry')->label('IP 國家')->disabled()->columnSpan(1),
                    Forms\Components\Placeholder::make('device')
                        ->label('')
                        ->content(fn ($record) => \App\Handlers\DeviceTypeHandlers::getDevice($record->user_agent ?? '') . ' / ' . (\App\Handlers\DeviceTypeHandlers::getBrowser($record->user_agent ?? '') ?: '未知'))
                        ->columnSpan(1),
                    Forms\Components\Placeholder::make('user_agent')
                        ->label('User Agent')
                        ->content(fn ($record) => $record->user_agent ?? '無')
                        ->columnSpan(2),
                ]),
        ];
    }
}
