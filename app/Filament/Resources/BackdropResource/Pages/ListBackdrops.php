<?php

namespace App\Filament\Resources\BackdropResource\Pages;

use App\Filament\Resources\BackdropResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBackdrops extends ListRecords
{
    protected static string $resource = BackdropResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}