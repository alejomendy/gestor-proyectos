<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Enums\ProjectStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Proyectos', Project::count())
                ->description('Total de proyectos registrados')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('info'),
            Stat::make('Proyectos Activos', Project::where('status', ProjectStatus::Active)->count())
                ->description('Proyectos actualmente en ejecución')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Proyectos Inactivos', Project::whereIn('status', [ProjectStatus::Down, ProjectStatus::NotDeployed])->count())
                ->description('Proyectos caídos o no desplegados')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
