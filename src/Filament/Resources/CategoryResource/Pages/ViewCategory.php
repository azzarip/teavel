<?php

namespace Azzarip\Teavel\Filament\Resources\CategoryResource\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions\EditAction;
use Azzarip\Teavel\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $infolist
            ->schema([
                Flex::make([
                    Section::make([
                        TextEntry::make('description')
                            ->markdown()
                            ->prose(),
                    ])->grow(true),
                    Section::make([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])->grow(false),
                ])->from('md')->columnSpan(2),
            ]);
    }

    public function getTitle(): string | Htmlable
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
