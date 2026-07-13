<?php

namespace App\Filament\Resources\AccessLogsResource\Pages;

use App\Filament\Resources\AccessLogsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccessLogs extends EditRecord
{
    protected static string $resource = AccessLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}