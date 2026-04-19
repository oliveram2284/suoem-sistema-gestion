<?php

namespace App\Filament\Resources\Condicions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CondicionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),
                Toggle::make('activo')
                    ->label('Activo')
                    ->default(true),
            ]);
    }
}
