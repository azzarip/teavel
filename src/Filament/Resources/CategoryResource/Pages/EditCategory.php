<?php

namespace Azzarip\Teavel\Filament\Resources\TagCategoryResource\Pages;

use App\Filament\Resources\TagCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTagCategory extends EditRecord
{
    protected static string $resource = TagCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
