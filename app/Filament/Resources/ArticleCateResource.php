<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleCateResource\Pages;
use App\Models\ArticleCate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticleCateResource extends Resource
{
    protected static ?string $model = ArticleCate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '文章分類';
    
    protected static ?string $modelLabel = '文章分類';
    
    protected static ?string $pluralModelLabel = '文章分類';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('name')->label('名稱')->maxLength(255)->required(),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('name')->label('名稱')->searchable(),
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
            'index' => Pages\ListArticleCates::route('/'),
            'create' => Pages\CreateArticleCate::route('/create'),
            'edit' => Pages\EditArticleCate::route('/{record}/edit'),
        ];
    }
}