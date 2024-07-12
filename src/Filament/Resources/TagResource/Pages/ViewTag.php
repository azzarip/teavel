<?php

namespace Azzarip\Teavel\Filament\Resources\TagResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Azzarip\Teavel\Filament\Resources\TagResource;
use Filament\Infolists\Components\Split;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewTag extends ViewRecord
{
    protected static string $resource = TagResource::class;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Split::make([
                Section::make([
                    TextEntry::make('name')->columnSpan(1),
                    TextEntry::make('category.name')->columnSpan(1),
                    TextEntry::make('description')
                        ->markdown()
                        ->prose()
                        ->columnSpan(2),
                ])->grow(true)->columns(2),
                Section::make([
                    TextEntry::make('created_at')
                        ->dateTime(),
                    TextEntry::make('updated_at')
                        ->dateTime(),
                ])->grow(false),
            ])->from('md')->columnSpan(2)
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
