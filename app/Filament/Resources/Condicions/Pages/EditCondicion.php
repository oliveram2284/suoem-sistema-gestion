<?php

namespace App\Filament\Resources\Condicions\Pages;

use App\Filament\Resources\Condicions\CondicionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCondicion extends EditRecord
{
    protected static string $resource = CondicionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
