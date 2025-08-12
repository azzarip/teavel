<?php

namespace Azzarip\Teavel\Filament\Resources\TagResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\AttachAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachBulkAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([Select::make('contact_id')->relationship('contacts', 'email')->searchable()->required()]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading($this->getContactCount())
            ->recordTitleAttribute('full_name')
            ->columns([TextColumn::make('full_name'), TextColumn::make('email'), TextColumn::make('created_at')->dateTime('j F Y, H:i')])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make('add_contact')
                    ->label('Tag Contact')
                    ->modalHeading('Tag Contact')
                    ->recordSelectSearchColumns(['first_name', 'last_name', 'email'])
                    ->button()
                    ->color('info')
                    ->recordTitle(function ($record) {
                        return $record->name_email;
                    })
                    ->after(function () {
                        $this->getTable()->heading($this->getContactCount());
                    }),
            ])
                ->recordActions([ActionGroup::make([DetachAction::make()])])
                ->toolbarActions([BulkActionGroup::make([DetachBulkAction::make()])]);
    }

    protected function getContactCount(): string
    {
        return 'Contacts: ' . DB::table('contact_tag')->where('tag_id', $this->ownerRecord->id)->count();
    }
}
