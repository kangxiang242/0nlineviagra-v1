<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '橫幅管理';
    protected static ?int $navigationSort = 5;    
    protected static ?string $modelLabel = '橫幅管理';
    
    protected static ?string $pluralModelLabel = '橫幅管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\FileUpload::make('img')->label('圖片')->image()->disk('public'),
                Forms\Components\FileUpload::make('back_img')->label('back img')->image()->disk('public'),
                Forms\Components\TextInput::make('href')->label('href')->maxLength(255)->required(),
                Forms\Components\TextInput::make('page')->label('頁面')->maxLength(255)->required(),
                Forms\Components\TextInput::make('alt')->label('alt')->maxLength(255),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
                Forms\Components\TextInput::make('type')->label('類型')->numeric()->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\ImageColumn::make('img')->label('圖片')->width(80),
            Tables\Columns\ImageColumn::make('back_img')->label('back img')->width(80),
            Tables\Columns\TextColumn::make('href')->label('href')->searchable(),
            Tables\Columns\TextColumn::make('page')->label('頁面')->searchable(),
            Tables\Columns\TextColumn::make('alt')->label('alt')->searchable(),
            Tables\Columns\TextColumn::make('type')->label('類型')->searchable(),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}