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
use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;
use App\Enums\EnvironmentType;
use App\Enums\ProjectTechnology;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $label = 'Proyectos';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Gestión';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('server_id')
                    ->relationship('server', 'name')
                    ->label('Servidor de Despliegue')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Proyecto')
                    ->required(),
                Forms\Components\Select::make('users')
                    ->multiple()
                    ->relationship('users', 'name')
                    ->label('Usuarios asignados')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->options(ProjectStatus::class)
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->label('Prioridad')
                    ->options(ProjectPriority::class)
                    ->required(),
                Forms\Components\Select::make('technology')
                    ->label('Tecnología')
                    ->options(ProjectTechnology::class)
                    ->default('php'),

                Forms\Components\TextInput::make('repository_url')
                    ->label('URL del Repositorio')
                    ->url(),
                Forms\Components\TextInput::make('domain')
                    ->label('Dominio del Proyecto')
                    ->url(),
                Forms\Components\Select::make('environment_type')
                    ->label('Entorno de Despliegue')
                    ->options(EnvironmentType::class)
                    ->required(),
                Forms\Components\TextInput::make('framework')
                    ->label('Framework')
                    ->default('Laravel'),
                Forms\Components\TextInput::make('app_url_or_note')
                    ->label('URL de la App o Notas Rápidas'),
                Forms\Components\Textarea::make('notes')
                    ->label('Notas/detalles del proyecto')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('users.name')
                    ->label('Usuarios asignados')
                    ->badge()
                    ->separator(',')
                    ->sortable(),
                // Columna simple
                TextColumn::make('name')
                    ->label('Proyecto')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('server.name')
                    ->label('Servidor')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge(),

                TextColumn::make('priority')
                    ->label('Prioridad')
                    ->badge(),

                TextColumn::make('technology')
                    ->label('Tec.')
                    ->badge()
                    ->color(fn($state) => \App\Enums\ProjectTechnology::tryFrom($state)?->getColor() ?? 'gray')
                    ->formatStateUsing(fn($state) => \App\Enums\ProjectTechnology::tryFrom($state)?->getLabel() ?? $state),

                TextColumn::make('repository_url')
                    ->label('Repositorio')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('environment_type')
                    ->label('Entorno')
                    ->badge(),

                TextColumn::make('milestones_count')
                    ->counts('milestones')
                    ->label('Hitos')
                    ->badge()
                    ->color('info'),

                TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->label('Tickets')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('framework')
                    ->label('Frame.')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-code-bracket'),
                TextColumn::make('app_url_or_note')
                    ->label('Notas')
                    ->limit(30),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options(ProjectStatus::class),
                Tables\Filters\SelectFilter::make('technology')
                    ->options(ProjectTechnology::class),
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
            RelationManagers\MilestonesRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
            RelationManagers\TicketsRelationManager::class,
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
