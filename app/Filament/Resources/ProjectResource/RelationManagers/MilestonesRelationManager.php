<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MilestonesRelationManager extends RelationManager
{
    protected static string $relationship = 'milestones';

    protected static ?string $title = 'Hitos';

    protected static ?string $label = 'Hito';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('due_date'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Progreso',
                        'completed' => 'Completado',
                        'delayed' => 'Retrasado',
                    ])
                    ->default('pending')
                    ->required(),
                Forms\Components\TextInput::make('progress')
                    ->numeric()
                    ->default(0)
                    ->suffix('%'),
                Forms\Components\Select::make('users')
                    ->multiple()
                    ->relationship('users', 'name')
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'delayed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('progress')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state . '%'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
