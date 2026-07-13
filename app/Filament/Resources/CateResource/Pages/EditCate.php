<?php

namespace App\Filament\Resources\CateResource\Pages;

use App\Filament\Resources\CateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCate extends EditRecord
{
    protected static string $resource = CateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}