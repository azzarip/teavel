<?php

namespace Azzarip\Teavel\Filament\Resources\TagResource\Pages;

use Filament\Actions\CreateAction;
use Azzarip\Teavel\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
