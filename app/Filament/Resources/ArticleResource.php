<?php

namespace App\Filament\Resources;
use App\Filament\Components\WangEditor;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = '文章管理';
    
    protected static ?string $modelLabel = '文章管理';
    
    protected static ?string $pluralModelLabel = '文章管理';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([                Forms\Components\TextInput::make('id')->label('ID')->numeric()->required(),
                Forms\Components\TextInput::make('article_cate_id')->label('article cate id')->numeric()->required(),
                Forms\Components\TextInput::make('title')->label('標題')->maxLength(255)->required(),
                Forms\Components\Textarea::make('brief')->label('brief'),
                Forms\Components\FileUpload::make('img')->label('圖片')->image()->disk('public'),
                Forms\Components\FileUpload::make('img_alt')->label('img alt')->image()->disk('public'),
                Forms\Components\TextInput::make('read_num')->label('read num')->numeric()->required(),
                Forms\Components\TextInput::make('real_read_num')->label('real read num')->numeric()->required(),
                Forms\Components\WangEditor::make('content')->label('內容'),
                Forms\Components\TextInput::make('sort')->label('排序')->numeric()->required(),
                Forms\Components\Toggle::make('status')->label('狀態')->required(),
                Forms\Components\Textarea::make('seo_title')->label('seo title'),
                Forms\Components\Textarea::make('seo_keyword')->label('seo keyword'),
                Forms\Components\WangEditor::make('seo_description')->label('seo description'),
                Forms\Components\TextInput::make('release_at')->label('release at')->maxLength(255)->required(),
                Forms\Components\TextInput::make('deleted_at')->label('deleted at')->maxLength(255),
                Forms\Components\TextInput::make('created_at')->label('建立時間')->maxLength(255),
                Forms\Components\TextInput::make('updated_at')->label('更新時間')->maxLength(255),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([            Tables\Columns\TextColumn::make('article_cate_id')->label('article cate id')->searchable(),
            Tables\Columns\TextColumn::make('title')->label('標題')->searchable(),
            Tables\Columns\TextColumn::make('brief')->label('brief')->searchable(),
            Tables\Columns\ImageColumn::make('img')->label('圖片')->width(80),
            Tables\Columns\ImageColumn::make('img_alt')->label('img alt')->width(80),
            Tables\Columns\TextColumn::make('read_num')->label('read num')->searchable(),
            Tables\Columns\TextColumn::make('real_read_num')->label('real read num')->searchable(),
            Tables\Columns\TextColumn::make('content')->label('內容')->limit(50),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}