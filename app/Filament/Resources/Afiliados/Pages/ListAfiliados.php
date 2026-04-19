<?php

namespace App\Filament\Resources\Afiliados\Pages;

use App\Filament\Resources\Afiliados\AfiliadoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAfiliados extends ListRecords
{
    protected static string $resource = AfiliadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
