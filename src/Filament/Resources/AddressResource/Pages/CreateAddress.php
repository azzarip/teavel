<?php

namespace Azzarip\Teavel\Filament\Resources\AddressResource\Pages;

use Azzarip\Teavel\Filament\Resources\AddressResource;
use Azzarip\Teavel\Models\Contact;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAddress extends CreateRecord
{
    protected static string $resource = AddressResource::class;

    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        $updates = [];
        if ($data['shipping']) {
            $updates[] = 'shipping';
        }
        if ($data['billing']) {
            $updates[] = 'billing';
        }

        unset($data['billing'], $data['shipping']);

        $contact = Contact::find($data['contact_id']);

        return $contact->createAddress($data, $updates);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
