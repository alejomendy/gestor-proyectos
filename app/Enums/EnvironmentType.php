<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EnvironmentType: string implements HasLabel, HasColor
{
    case Development = 'Desarrollo - Test';
    case Production = 'Produccion';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Development => 'primary',
            self::Production => 'success',
        };
    }
}
