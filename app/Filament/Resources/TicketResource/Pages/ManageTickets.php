<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTickets extends ManageRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\Action::make('kanban')
            //     ->label('Vista Tablero')
            //     ->icon('heroicon-o-view-columns')
            //     ->color('warning')
            //     ->url(TicketResource::getUrl('kanban')),
            // Actions\CreateAction::make(),
        ];
    }
}
