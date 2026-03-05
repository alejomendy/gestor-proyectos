<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\Page;

class KanbanTickets extends Page
{
    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket-resource.pages.kanban-tickets';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('list')
                ->label('Vista Lista')
                ->icon('heroicon-o-list-bullet')
                ->color('gray')
                ->url(TicketResource::getUrl('index')),
        ];
    }
}
