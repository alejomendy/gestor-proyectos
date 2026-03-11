<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectPriority: string implements HasLabel, HasColor
{
    case Low = 'Baja';
    case Normal = 'Normal';
    case High = 'Alta';
    case Critical = 'Critica';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Critical => 'danger',
            self::High => 'warning',
            self::Normal => 'info',
            self::Low => 'gray',
        };
    }
}
