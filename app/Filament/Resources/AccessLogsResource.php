<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccessLogsResource\Pages;
use App\Models\AccessLogs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccessLogsResource extends Resource
{
    protected static ?string $model = AccessLogs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'access logs';
    
    protected static ?string $modelLabel = 'access logs';
    
    protected static ?string $pluralModelLabel = 'access logs';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('url')->label('網址')->maxLength(255)->required(),
                Forms\Components\TextInput::make('method')->label('方法')->maxLength(255)->required(),
                Forms\Components\TextInput::make('host')->label('主機')->maxLength(255)->required(),
                Forms\Components\TextInput::make('referer')->label('來源')->maxLength(255),
                Forms\Components\TextInput::make('ip')->label('IP')->maxLength(255)->required(),
                Forms\Components\Textarea::make('user_agent')->label('瀏覽器')->required(),
                Forms\Components\TextInput::make('device')->label('設備')->maxLength(255)->required(),
                Forms\Components\TextInput::make('crawler')->label('爬蟲')->maxLength(255),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('url')->label('網址')->searchable(),
            Tables\Columns\TextColumn::make('method')->label('方法')->searchable(),
            Tables\Columns\TextColumn::make('host')->label('主機')->searchable(),
            Tables\Columns\TextColumn::make('referer')->label('來源')->searchable(),
            Tables\Columns\TextColumn::make('ip')->label('IP')->searchable(),
            Tables\Columns\TextColumn::make('user_agent')->label('瀏覽器')->searchable(),
            Tables\Columns\TextColumn::make('device')->label('設備')->searchable(),
            Tables\Columns\TextColumn::make('crawler')->label('爬蟲')->searchable(),
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
            'index' => Pages\ListAccessLogss::route('/'),
            'create' => Pages\CreateAccessLogs::route('/create'),
            'edit' => Pages\EditAccessLogs::route('/{record}/edit'),
        ];
    }
}