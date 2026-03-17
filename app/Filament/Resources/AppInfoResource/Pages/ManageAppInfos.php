<?php

namespace App\Filament\Resources\AppInfoResource\Pages;

use App\Filament\Resources\AppInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAppInfos extends ManageRecords
{
    protected static string $resource = AppInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
