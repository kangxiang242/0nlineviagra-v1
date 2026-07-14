<?php

namespace App\Filament\Support;

use App\Handlers\DeviceTypeHandlers;

class DeviceInfo
{
    public static function device(?string $ua): string
    {
        return DeviceTypeHandlers::getDevice($ua ?? '') ?? '';
    }

    public static function browser(?string $ua): string
    {
        return DeviceTypeHandlers::getBrowser($ua ?? '') ?? '';
    }
}
