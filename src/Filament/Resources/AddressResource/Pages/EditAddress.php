<?php

namespace Azzarip\Teavel\Filament\Resources\AddressResource\Pages;

use Azzarip\Teavel\Filament\Resources\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddress extends EditRecord
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
