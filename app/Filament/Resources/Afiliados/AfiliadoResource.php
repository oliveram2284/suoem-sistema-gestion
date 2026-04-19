<?php

namespace App\Filament\Resources\Afiliados;

use App\Filament\Resources\Afiliados\Pages\CreateAfiliado;
use App\Filament\Resources\Afiliados\Pages\EditAfiliado;
use App\Filament\Resources\Afiliados\Pages\ListAfiliados;
use App\Filament\Resources\Afiliados\Schemas\AfiliadoForm;
use App\Filament\Resources\Afiliados\Tables\AfiliadosTable;
use App\Models\Afiliado;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AfiliadoResource extends Resource
{
    protected static ?string $model = Afiliado::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $modelLabel = 'Afiliado';

    protected static ?string $pluralModelLabel = 'Afiliados';

    protected static \UnitEnum|string|null $navigationGroup = 'Afiliados';

    public static function form(Schema $schema): Schema
    {
        return AfiliadoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AfiliadosTable::configure($table);
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
            'index' => ListAfiliados::route('/'),
            'create' => CreateAfiliado::route('/create'),
            'edit' => EditAfiliado::route('/{record}/edit'),
        ];
    }
}
