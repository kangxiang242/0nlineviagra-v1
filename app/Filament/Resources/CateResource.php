<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CateResource\Pages;
use App\Models\Cate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CateResource extends Resource
{
    protected static ?string $model = Cate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '分類管理';
    
    protected static ?string $modelLabel = '分類管理';
    
    protected static ?string $pluralModelLabel = '分類管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('pid')->label('pid')->numeric()->required(),
                Forms\Components\TextInput::make('name')->label('名稱')->maxLength(255)->required(),
                Forms\Components\Toggle::make('status')->label('狀態')->required(),
                Forms\Components\TextInput::make('sort')->label('排序')->numeric()->required(),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('pid')->label('pid')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('名稱')->searchable(),
            Tables\Columns\BooleanColumn::make('status')->label('狀態'),
            Tables\Columns\TextColumn::make('sort')->label('排序')->searchable(),
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
            'index' => Pages\ListCates::route('/'),
            'create' => Pages\CreateCate::route('/create'),
            'edit' => Pages\EditCate::route('/{record}/edit'),
        ];
    }
}