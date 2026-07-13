<?php

namespace App\Filament\Resources\DisableIpResource\Pages;

use App\Filament\Resources\DisableIpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDisableIp extends EditRecord
{
    protected static string $resource = DisableIpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}