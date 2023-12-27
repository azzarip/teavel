<?php

namespace Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages;

use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
