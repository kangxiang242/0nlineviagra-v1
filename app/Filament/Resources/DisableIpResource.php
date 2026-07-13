<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisableIpResource\Pages;
use App\Models\DisableIp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DisableIpResource extends Resource
{
    protected static ?string $model = DisableIp::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'IP 封鎖';
    
    protected static ?string $modelLabel = 'IP 封鎖';
    
    protected static ?string $pluralModelLabel = 'IP 封鎖';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('ip')->label('IP')->maxLength(255)->required(),
                Forms\Components\TextInput::make('uri')->label('uri')->maxLength(255),
                Forms\Components\TextInput::make('method')->label('方法')->maxLength(255),
                Forms\Components\Textarea::make('input')->label('input'),
                Forms\Components\Textarea::make('header')->label('頁首'),
                Forms\Components\TextInput::make('number')->label('數量')->numeric()->required(),
                Forms\Components\Toggle::make('status')->label('狀態')->required(),
                Forms\Components\TextInput::make('ban_at')->label('ban at')->maxLength(255),
                Forms\Components\TextInput::make('expire_at')->label('expire at')->maxLength(255),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('ip')->label('IP')->searchable(),
            Tables\Columns\TextColumn::make('uri')->label('uri')->searchable(),
            Tables\Columns\TextColumn::make('method')->label('方法')->searchable(),
            Tables\Columns\TextColumn::make('input')->label('input')->searchable(),
            Tables\Columns\TextColumn::make('header')->label('頁首')->searchable(),
            Tables\Columns\TextColumn::make('number')->label('數量')->searchable(),
            Tables\Columns\BooleanColumn::make('status')->label('狀態'),
            Tables\Columns\TextColumn::make('ban_at')->label('ban at')->searchable(),
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
            'index' => Pages\ListDisableIps::route('/'),
            'create' => Pages\CreateDisableIp::route('/create'),
            'edit' => Pages\EditDisableIp::route('/{record}/edit'),
        ];
    }
}