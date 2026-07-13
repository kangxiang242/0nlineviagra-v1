<?php

namespace App\Filament\Resources\BackdropResource\Pages;

use App\Filament\Resources\BackdropResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBackdrop extends EditRecord
{
    protected static string $resource = BackdropResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}