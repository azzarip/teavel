<?php

namespace Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages;

use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
