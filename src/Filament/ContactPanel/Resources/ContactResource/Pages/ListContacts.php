<?php

namespace Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource;

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
