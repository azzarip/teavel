<?php

namespace Azzarip\Teavel\Filament\Resources\TagResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Azzarip\Teavel\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
