<?php

namespace Azzarip\Teavel\Filament\Resources\ContactResource\Pages;

use Azzarip\Teavel\Filament\Resources\ContactResource;
use Azzarip\Teavel\Models\Contact;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['marketing'] = true;

        return Contact::get($data);
    }
}
