<?php

namespace Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages;

use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
