<?php

namespace Azzarip\Teavel\Filament\Resources\AddressResource\Pages;

use Filament\Actions\CreateAction;
use Azzarip\Teavel\Filament\Resources\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddresses extends ListRecords
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
