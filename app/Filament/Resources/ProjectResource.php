<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Estado del Proyecto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Proyecto'),
                Forms\Components\TextInput::make('organization')
                    ->label('Entorno / Organización'),

                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Mantenimiento' => 'Mantenimiento',
                        'No Desplegado' => 'No Desplegado',
                        'Caido' => 'Caido',
                    ]),
                Forms\Components\Select::make('priority')
                    ->label('Prioridad')
                    ->options([
                        'Baja' => 'Baja',
                        'Normal' => 'Normal',
                        'Alta' => 'Alta',
                        'Critica' => 'Critica',
                    ]),
                Forms\Components\TextInput::make('technology')
                    ->label('Tecnología')
                    ->default('php'),

                Forms\Components\TextInput::make('repository_url')
                    ->label('URL del Repositorio')
                    ->url(),
                Forms\Components\Select::make('environment_type')
                    ->label('Entorno de Despliegue')
                    ->options([
                        'Desarrollo - Test' => 'Desarrollo - Test',
                        'Produccion' => 'Produccion',
                    ]),
                Forms\Components\TextInput::make('framework')
                    ->label('Framework')
                    ->default('Laravel'),
                Forms\Components\TextInput::make('app_url_or_note')
                    ->label('URL / Nota / Error'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna simple
                TextColumn::make('name')
                    ->label('Proyecto')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('organization')
                    ->label('Entorno')
                    ->sortable(),

                // Columna con Badges de estado (como en la imagen)
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge() // Convierte a badge
                    ->color(fn(string $state): string => match ($state) {
                        'Activo' => 'success', // Verde
                        'Mantenimiento' => 'warning', // Naranja
                        'No Desplegado' => 'gray', // Gris
                        'Caido' => 'danger', // Rojo
                        default => 'gray',
                    }),

                // Columna con Badges de prioridad
                TextColumn::make('priority')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Critica' => 'danger', // Rojo fuerte
                        'Alta' => 'warning', // Naranja
                        'Normal' => 'info', // Azul
                        'Baja' => 'gray', // Gris
                        default => 'gray',
                    }),

                TextColumn::make('technology')
                    ->label('Tec.')
                    ->default('php'),

                TextColumn::make('repository_url')
                    ->label('Repositorio')
                    ->limit(30), // Limita el texto

                // Columna con Badges para el entorno
                TextColumn::make('environment_type')
                    ->label('Entorno')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Produccion' => 'primary', // Azul principal
                        'Desarrollo - Test' => 'secondary', // Color secundario
                        default => 'gray',
                    }),

                TextColumn::make('framework')
                    ->label('Frame.')
                    ->badge()
                    ->color('info') // Azul claro,
                    ->icon('heroicon-m-code-bracket'), // Icono opcional

                TextColumn::make('app_url_or_note')
                    ->label('URL / Nota')
                    ->limit(30),
            ])
            ->filters([
                // Puedes añadir filtros aquí, ej:
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Activo' => 'Activo',
                        'Caido' => 'Caido',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
