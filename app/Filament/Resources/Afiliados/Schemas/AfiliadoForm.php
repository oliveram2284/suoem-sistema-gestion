<?php

namespace App\Filament\Resources\Afiliados\Schemas;

use App\Models\Condicion;
use App\Models\Zona;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AfiliadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos personales')
                    ->columns(2)
                    ->schema([
                        TextInput::make('legajo')
                            ->label('Legajo')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),
                        TextInput::make('cuil')
                            ->label('CUIL')
                            ->required()
                            ->maxLength(11)
                            ->unique(ignoreRecord: true),
                        TextInput::make('apellido')
                            ->label('Apellido')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(100),
                    ]),

                Section::make('Clasificación')
                    ->columns(2)
                    ->schema([
                        Select::make('zona_id')
                            ->label('Zona')
                            ->options(fn () => Zona::where('activo', true)->orderBy('nombre')->pluck('nombre', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('condicion_id')
                            ->label('Condición')
                            ->options(fn () => Condicion::where('activo', true)->orderBy('nombre')->pluck('nombre', 'id'))
                            ->required(),
                    ]),

                Section::make('Contacto y pago')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cbu')
                            ->label('CBU')
                            ->maxLength(30),
                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(30),
                    ]),

                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true),
            ]);
    }
}
