<?php

namespace App\Filament\Widgets;

use Spatie\Activitylog\Models\Activity;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestActivity extends BaseWidget
{
    protected static ?string $heading = 'Actividad Reciente del Sistema';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn () => Activity::with('causer')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('event')
                    ->label('Acción')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default   => 'gray',
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Usuario')
                    ->default('Sistema')
                    ->badge()
                    ->color('info'),
            ])
            ->paginated(false);
    }
}
