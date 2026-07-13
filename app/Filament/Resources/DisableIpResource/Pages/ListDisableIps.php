<?php

namespace App\Filament\Resources\DisableIpResource\Pages;

use App\Filament\Resources\DisableIpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDisableIps extends ListRecords
{
    protected static string $resource = DisableIpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}