<?php

namespace App\Filament\Resources\CateResource\Pages;

use App\Filament\Resources\CateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCates extends ListRecords
{
    protected static string $resource = CateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}