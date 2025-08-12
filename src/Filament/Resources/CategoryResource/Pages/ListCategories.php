<?php

namespace Azzarip\Teavel\Filament\Resources\CategoryResource\Pages;

use Filament\Actions\CreateAction;
use Azzarip\Teavel\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
