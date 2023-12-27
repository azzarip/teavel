<?php

namespace Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages;

use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
