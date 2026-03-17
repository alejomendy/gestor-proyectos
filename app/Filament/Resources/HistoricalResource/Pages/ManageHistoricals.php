<?php

namespace App\Filament\Resources\HistoricalResource\Pages;

use App\Filament\Resources\HistoricalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHistoricals extends ManageRecords
{
    protected static string $resource = HistoricalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
