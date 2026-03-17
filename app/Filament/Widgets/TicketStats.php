<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketStats extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Tickets Abiertos', Ticket::where('status', TicketStatus::Backlog->value)->count())
                ->description('Sin asignar')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('gray'),
            Stat::make('En Proceso', Ticket::where('status', TicketStatus::Doing->value)->count())
                ->description('Tickets en desarrollo activo')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
            Stat::make('En Revisión', Ticket::where('status', TicketStatus::Review->value)->count())
                ->description('Pendientes de aprobación')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('info'),
            Stat::make('Terminados', Ticket::where('status', TicketStatus::Done->value)->count())
                ->description('Cerrados exitosamente')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
