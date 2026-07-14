<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExceptionResource\Pages;
use App\Models\Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExceptionResource extends Resource
{
    protected static ?string $model = Exception::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '異常日誌';
    protected static ?int $navigationSort = 20;    
    protected static ?string $modelLabel = '異常日誌';
    
    protected static ?string $pluralModelLabel = '異常日誌';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('ip')->label('IP')->maxLength(255),
                Forms\Components\TextInput::make('ip_country')->label('IP 國家')->maxLength(255),
                Forms\Components\TextInput::make('status_code')->label('status code')->numeric()->required(),
                Forms\Components\Textarea::make('message')->label('message'),
                Forms\Components\TextInput::make('uri')->label('uri')->maxLength(255),
                Forms\Components\TextInput::make('method')->label('方法')->maxLength(255),
                Forms\Components\TextInput::make('referer')->label('來源')->maxLength(255),
                Forms\Components\Textarea::make('user_agent')->label('瀏覽器'),
                Forms\Components\Textarea::make('parameters')->label('參數')->required(),
                Forms\Components\Textarea::make('headers')->label('標頭')->required(),
                Forms\Components\Textarea::make('trace')->label('追蹤')->required(),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('ip')->label('IP')->searchable(),
            Tables\Columns\TextColumn::make('ip_country')->label('IP 國家')->searchable(),
            Tables\Columns\TextColumn::make('status_code')->label('status code')->searchable(),
            Tables\Columns\TextColumn::make('message')->label('message')->searchable(),
            Tables\Columns\TextColumn::make('uri')->label('uri')->searchable(),
            Tables\Columns\TextColumn::make('method')->label('方法')->searchable(),
            Tables\Columns\TextColumn::make('referer')->label('來源')->searchable(),
            Tables\Columns\TextColumn::make('user_agent')->label('瀏覽器')->searchable(),
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
            'index' => Pages\ListExceptions::route('/'),
            'create' => Pages\CreateException::route('/create'),
            'edit' => Pages\EditException::route('/{record}/edit'),
        ];
    }
}