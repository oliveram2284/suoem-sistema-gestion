<?php

namespace App\Filament\Resources\Afiliados\Pages;

use App\Filament\Resources\Afiliados\AfiliadoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAfiliado extends EditRecord
{
    protected static string $resource = AfiliadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
