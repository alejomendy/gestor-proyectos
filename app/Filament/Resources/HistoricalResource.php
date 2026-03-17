<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoricalResource\Pages;
use App\Models\Historical;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HistoricalResource extends Resource
{
    protected static ?string $model = Historical::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Historial';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Gestión';

    protected static ?string $pluralModelLabel = 'Historiales';
    protected static ?string $modelLabel = 'Historial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('icon')
                    ->label('Icono')
                    ->maxLength(255)
                    ->placeholder('e.g., heroicon-o-check'),
                Forms\Components\FileUpload::make('img')
                    ->label('Imagen')
                    ->disk('s3')
                    ->image()
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
                    ->helperText('Marcar si este evento es un hito importante para mostrar en la web.')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Proyecto')
                    ->sortable()
                    ->searchable(),
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
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHistoricals::route('/'),
        ];
    }
}
