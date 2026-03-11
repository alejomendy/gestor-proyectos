<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TicketStatus: string implements HasLabel, HasColor
{
    case Backlog = 'Por asignar';
    case Doing = 'en proceso';
    case Review = 'En revision';
    case Production = 'Produccion';
    case Paused = 'Parado';
    case Done = 'Terminado';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Backlog => 'BACKLOG',
            self::Doing => 'DOING',
            self::Review => 'REVIEW',
            self::Production => 'TO PRODUCTION',
            self::Paused => 'PAUSED',
            self::Done => 'DONE',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Backlog => 'gray',
            self::Doing => 'warning',
            self::Review => 'orange',
            self::Production => 'success',
            self::Paused => 'danger',
            self::Done => 'success',
        };
    }
}
