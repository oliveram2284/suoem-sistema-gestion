<?php

namespace App\Filament\Resources\Condicions;

use App\Filament\Resources\Condicions\Pages\CreateCondicion;
use App\Filament\Resources\Condicions\Pages\EditCondicion;
use App\Filament\Resources\Condicions\Pages\ListCondicions;
use App\Filament\Resources\Condicions\Schemas\CondicionForm;
use App\Filament\Resources\Condicions\Tables\CondicionsTable;
use App\Models\Condicion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CondicionResource extends Resource
{
    protected static ?string $model = Condicion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $modelLabel = 'Condición';

    protected static ?string $pluralModelLabel = 'Condiciones';

    protected static \UnitEnum|string|null $navigationGroup = 'Configuración';

    public static function form(Schema $schema): Schema
    {
        return CondicionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CondicionsTable::configure($table);
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
            'index' => ListCondicions::route('/'),
            'create' => CreateCondicion::route('/create'),
            'edit' => EditCondicion::route('/{record}/edit'),
        ];
    }
}
