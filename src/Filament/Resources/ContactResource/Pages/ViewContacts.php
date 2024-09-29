<?php

namespace Azzarip\Teavel\Filament\Resources\ContactResource\Pages;

use Azzarip\Teavel\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Split::make([
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

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
