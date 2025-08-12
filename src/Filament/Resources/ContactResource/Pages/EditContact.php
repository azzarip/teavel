<?php

namespace Azzarip\Teavel\Filament\Resources\ContactResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Azzarip\Teavel\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
