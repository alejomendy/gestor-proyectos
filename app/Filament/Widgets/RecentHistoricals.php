<?php

namespace App\Filament\Widgets;

use App\Models\Historical;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentHistoricals extends BaseWidget
{
    protected static ?string $heading = 'Historial Reciente';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn () => Historical::with(['project', 'users'])
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Proyecto')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Evento')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('body')
                    ->label('Detalle')
                    ->limit(80)
                    ->wrap(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Involucrados')
                    ->badge()
                    ->separator(','),
            ])
            ->paginated(false);
    }
}
