<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackdropResource\Pages;
use App\Models\Backdrop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BackdropResource extends Resource
{
    protected static ?string $model = Backdrop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '背景管理';
    
    protected static ?string $modelLabel = '背景管理';
    
    protected static ?string $pluralModelLabel = '背景管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\FileUpload::make('img')->label('圖片')->image()->disk('public'),
                Forms\Components\FileUpload::make('m_img')->label('手機圖片')->image()->disk('public'),
                Forms\Components\TextInput::make('page')->label('頁面')->maxLength(255)->required(),
                Forms\Components\TextInput::make('text')->label('text')->maxLength(255),
                Forms\Components\Textarea::make('video')->label('影片'),
                Forms\Components\FileUpload::make('card_img')->label('card img')->image()->disk('public'),
                Forms\Components\TextInput::make('card_title')->label('card title')->maxLength(255),
                Forms\Components\Textarea::make('card_desc')->label('card desc'),
                Forms\Components\Textarea::make('card_href')->label('card href'),
                Forms\Components\TextInput::make('card_desc_color')->label('card desc color')->maxLength(255),
                Forms\Components\Textarea::make('desc')->label('desc'),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\ImageColumn::make('img')->label('圖片')->width(80),
            Tables\Columns\ImageColumn::make('m_img')->label('手機圖片')->width(80),
            Tables\Columns\TextColumn::make('page')->label('頁面')->searchable(),
            Tables\Columns\TextColumn::make('text')->label('text')->searchable(),
            Tables\Columns\TextColumn::make('video')->label('影片')->searchable(),
            Tables\Columns\ImageColumn::make('card_img')->label('card img')->width(80),
            Tables\Columns\TextColumn::make('card_title')->label('card title')->searchable(),
            Tables\Columns\TextColumn::make('card_desc')->label('card desc')->searchable(),
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
            'index' => Pages\ListBackdrops::route('/'),
            'create' => Pages\CreateBackdrop::route('/create'),
            'edit' => Pages\EditBackdrop::route('/{record}/edit'),
        ];
    }
}