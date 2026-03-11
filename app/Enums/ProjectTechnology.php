<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ProjectTechnology: string implements HasLabel, HasColor
{
    case PHP = 'php';
    case Laravel = 'laravel';
    case JavaScript = 'javascript';
    case ReactNative = 'react_native';
    case NextJs = 'next_js';
    case NodeJs = 'node_js';
    case Python = 'python';
    case Flutter = 'flutter';
    case Unity = 'unity';
    case Other = 'otro';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PHP => 'php',
            self::Laravel => 'Laravel',
            self::JavaScript => 'JavaScript',
            self::ReactNative => 'React Native',
            self::NextJs => 'Next.js',
            self::NodeJs => 'Node.js',
            self::Python => 'Python',
            self::Flutter => 'Flutter',
            self::Unity => 'Unity',
            self::Other => 'Otro',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PHP, self::Laravel => 'primary',
            self::JavaScript, self::ReactNative, self::NextJs, self::NodeJs => 'warning',
            self::Python => 'info',
            self::Flutter => 'danger',
            self::Unity => 'success',
            self::Other => 'gray',
        };
    }
}
