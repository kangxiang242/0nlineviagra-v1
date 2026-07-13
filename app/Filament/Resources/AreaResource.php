<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AreaResource\Pages;
use App\Models\Area;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AreaResource extends Resource
{
    protected static ?string $model = Area::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '地區管理';
    
    protected static ?string $modelLabel = '地區管理';
    
    protected static ?string $pluralModelLabel = '地區管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('parent_id')->label('上層')->numeric(),
                Forms\Components\TextInput::make('name')->label('名稱')->maxLength(255),
                Forms\Components\TextInput::make('level')->label('level')->numeric(),
                Forms\Components\TextInput::make('is_grab')->label('is grab')->numeric(),
                Forms\Components\TextInput::make('is_special')->label('is special')->numeric(),
                Forms\Components\TextInput::make('code')->label('代碼')->maxLength(255),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('parent_id')->label('上層')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('名稱')->searchable(),
            Tables\Columns\TextColumn::make('level')->label('level')->searchable(),
            Tables\Columns\TextColumn::make('is_grab')->label('is grab')->searchable(),
            Tables\Columns\TextColumn::make('is_special')->label('is special')->searchable(),
            Tables\Columns\TextColumn::make('code')->label('代碼')->searchable(),
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
            'index' => Pages\ListAreas::route('/'),
            'create' => Pages\CreateArea::route('/create'),
            'edit' => Pages\EditArea::route('/{record}/edit'),
        ];
    }
}