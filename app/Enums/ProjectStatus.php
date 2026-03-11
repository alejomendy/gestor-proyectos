<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: string implements HasLabel, HasColor
{
    case Active = 'Activo';
    case Maintenance = 'Mantenimiento';
    case NotDeployed = 'No Desplegado';
    case Down = 'Caido';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Maintenance => 'warning',
            self::NotDeployed => 'gray',
            self::Down => 'danger',
        };
    }
}
