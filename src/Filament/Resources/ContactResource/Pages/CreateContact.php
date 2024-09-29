<?php

namespace Azzarip\Teavel\Filament\Resources\ContactResource\Pages;

use Azzarip\Teavel\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use Azzarip\Teavel\Filament\Resources\ContactResource;

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
