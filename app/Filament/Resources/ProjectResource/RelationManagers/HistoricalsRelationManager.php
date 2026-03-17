<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class HistoricalsRelationManager extends RelationManager
{
    protected static string $relationship = 'historicals';

    protected static ?string $title = 'Historial';

    protected static ?string $label = 'Historial';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('icon')
                    ->label('Icono')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('img')
                    ->label('Imagen')
                    ->image()
                    ->disk('s3')
                    ->directory('historicals'),
                Forms\Components\Select::make('users')
                    ->label('Usuarios involucrados')
                    ->multiple()
                    ->relationship('users', 'name')
                    ->preload(),
                Forms\Components\DatePicker::make('event_date')
                    ->label('Fecha del suceso')
                    ->default(now()),
                Forms\Components\Textarea::make('body')
                    ->label('Cuerpo / Detalle')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_milestone')
                    ->label('¿Es un Hito?')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('img')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Fecha del suceso')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Usuarios involucrados')
                    ->badge()
                    ->separator(','),
                Tables\Columns\IconColumn::make('is_milestone')
                    ->label('Hito')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
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
