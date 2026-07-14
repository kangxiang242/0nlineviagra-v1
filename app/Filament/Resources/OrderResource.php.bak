<?php

namespace App\Filament\Resources;
use App\Filament\Components\WangEditor;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '訂單管理';
    
    protected static ?string $modelLabel = '訂單管理';
    
    protected static ?string $pluralModelLabel = '訂單管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('no')->label('編號')->maxLength(255)->required(),
                Forms\Components\TextInput::make('inside_no')->label('内部編號')->maxLength(255)->required(),
                Forms\Components\TextInput::make('total_price')->label('total price')->numeric()->required(),
                Forms\Components\TextInput::make('product_price')->label('product price')->numeric()->required(),
                Forms\Components\TextInput::make('freight')->label('運費')->numeric()->required(),
                Forms\Components\TextInput::make('delivery_type')->label('配送方式')->numeric()->required(),
                Forms\Components\TextInput::make('payment_type')->label('payment type')->numeric()->required(),
                Forms\Components\TextInput::make('name')->label('名稱')->maxLength(255)->required(),
                Forms\Components\TextInput::make('phone')->label('電話')->maxLength(255)->required(),
                Forms\Components\TextInput::make('email')->label('郵箱')->maxLength(255)->required(),
                Forms\Components\TextInput::make('country')->label('country')->maxLength(255)->required(),
                Forms\Components\TextInput::make('province')->label('province')->maxLength(255)->required(),
                Forms\Components\TextInput::make('city')->label('城市')->maxLength(255)->required(),
                Forms\Components\TextInput::make('county')->label('區縣')->maxLength(255)->required(),
                Forms\Components\TextInput::make('street')->label('街道')->maxLength(255),
                Forms\Components\TextInput::make('address')->label('地址')->maxLength(255)->required(),
                Forms\Components\TextInput::make('delivery_time')->label('配送時段')->numeric(),
                Forms\Components\Toggle::make('status')->label('狀態')->required(),
                Forms\Components\WangEditor::make('remarks')->label('備註'),
                Forms\Components\WangEditor::make('admin_remarks')->label('管理員備註'),
                Forms\Components\TextInput::make('ip')->label('IP')->maxLength(255)->required(),
                Forms\Components\TextInput::make('ipcountry')->label('ipcountry')->maxLength(255),
                Forms\Components\Textarea::make('user_agent')->label('瀏覽器'),
                Forms\Components\TextInput::make('shop_no')->label('店號')->maxLength(255),
                Forms\Components\TextInput::make('shop_name')->label('店名')->maxLength(255),
                Forms\Components\TextInput::make('shop_type')->label('超商類型')->numeric()->required(),
                Forms\Components\Textarea::make('shop_data')->label('shop data'),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('no')->label('編號')->searchable(),
            Tables\Columns\TextColumn::make('inside_no')->label('内部編號')->searchable(),
            Tables\Columns\TextColumn::make('total_price')->label('total price')->money('TWD'),
            Tables\Columns\TextColumn::make('product_price')->label('product price')->money('TWD'),
            Tables\Columns\TextColumn::make('freight')->label('運費')->searchable(),
            Tables\Columns\TextColumn::make('delivery_type')->label('配送方式')->searchable(),
            Tables\Columns\TextColumn::make('payment_type')->label('payment type')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('名稱')->searchable(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}