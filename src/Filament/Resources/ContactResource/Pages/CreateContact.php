<?php

namespace Azzarip\Teavel\Filament\Resources\ContactResource\Pages;

use Azzarip\Teavel\Filament\Resources\ContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function afterCreate(): 
    {
        
    }
}
