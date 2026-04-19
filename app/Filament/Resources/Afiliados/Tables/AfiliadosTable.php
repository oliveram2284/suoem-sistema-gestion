<?php

namespace App\Filament\Resources\Afiliados\Tables;

use App\Models\Condicion;
use App\Models\Zona;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AfiliadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('legajo')
                    ->label('Legajo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellido')
                    ->label('Apellido')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('cuil')
                    ->label('CUIL')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('zona.nombre')
                    ->label('Zona')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('condicion.nombre')
                    ->label('Condición')
                    ->sortable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cbu')
                    ->label('CBU')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('zona_id')
                    ->label('Zona')
                    ->options(fn () => Zona::orderBy('nombre')->pluck('nombre', 'id')),
                SelectFilter::make('condicion_id')
                    ->label('Condición')
                    ->options(fn () => Condicion::orderBy('nombre')->pluck('nombre', 'id')),
                TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('apellido');
    }
}
