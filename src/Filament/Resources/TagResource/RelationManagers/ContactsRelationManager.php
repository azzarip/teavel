<?php

namespace Azzarip\Teavel\Filament\Resources\TagResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';


    public function isReadOnly(): bool
    {
        return false;
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('contact_id')
                    ->relationship('contacts', 'email')
                    ->searchable()
                    ->required(),

            ]);
    }

    public function table(Table $table): Table
    {

        return $table
            ->heading($this->getContactCount())
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('tagged_at')
                ->dateTime('j F Y, H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->color('info')
                ->preloadRecordSelect()
                ->after(function (){
                   $this->getTable()->heading($this->getContactCount());
                }),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\DetachAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }

    protected function getContactCount(): string
    {
        return 'Contacts: ' . DB::table('contact_tag')->where('tag_id', $this->ownerRecord->id)->count();
    }
}
