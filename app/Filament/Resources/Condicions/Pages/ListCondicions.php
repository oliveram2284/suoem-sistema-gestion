<?php

namespace App\Filament\Resources\Condicions\Pages;

use App\Filament\Resources\Condicions\CondicionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCondicions extends ListRecords
{
    protected static string $resource = CondicionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
