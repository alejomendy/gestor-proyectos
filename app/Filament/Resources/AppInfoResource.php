<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppInfoResource\Pages;
use App\Models\AppInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppInfoResource extends Resource
{
    protected static ?string $model = AppInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Contenido Web';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationGroup = 'Configuración';

    protected static ?string $pluralModelLabel = 'Contenido Web';
    protected static ?string $modelLabel = 'Sección';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identificación')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->label('Identificador (slug)')
                            ->helperText('Clave única usada por Next.js para consumir este contenido. Ej: hero, about, services')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->alphaDash(),
                        Forms\Components\Toggle::make('active')
                            ->label('Activo')
                            ->default(true),
                        Forms\Components\TextInput::make('order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
                    ])->columns(3),

                Forms\Components\Section::make('Contenido')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('img_head')
                            ->label('Imagen de Encabezado')
                            ->image()
                            ->disk('s3')
                            ->directory('app-info')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Extracto (resumen corto)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('body')
                            ->label('Cuerpo / Contenido completo')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3',
                                'bulletList', 'orderedList',
                                'link',
                                'blockquote',
                                'undo', 'redo',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label('Identificador')
                    ->badge()
                    ->color('info')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('img_head')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('excerpt')
                    ->label('Extracto')
                    ->limit(60),
                Tables\Columns\IconColumn::make('active')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Orden')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
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
            'index' => Pages\ManageAppInfos::route('/'),
        ];
    }
}
