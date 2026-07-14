<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnchorResource\Pages;
use App\Models\Anchor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AnchorResource extends Resource
{
    protected static ?string $model = Anchor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '錨點管理';
    protected static ?int $navigationSort = 11;    
    protected static ?string $modelLabel = '錨點管理';
    
    protected static ?string $pluralModelLabel = '錨點管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('name')->label('名稱')->maxLength(255)->required(),
                Forms\Components\TextInput::make('url')->label('網址')->maxLength(255)->required(),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('name')->label('名稱')->searchable(),
            Tables\Columns\TextColumn::make('url')->label('網址')->searchable(),
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
            'index' => Pages\ListAnchors::route('/'),
            'create' => Pages\CreateAnchor::route('/create'),
            'edit' => Pages\EditAnchor::route('/{record}/edit'),
        ];
    }
}