<?php

namespace Azzarip\Teavel\Filament\Resources\TagCategoryResource\Pages;

use App\Filament\Resources\TagCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = TagCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
