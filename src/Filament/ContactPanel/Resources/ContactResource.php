<?php

namespace Azzarip\Teavel\Filament\ContactPanel\Resources;

use Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages\CreateContact;
use Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages\EditContact;
use Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages\ListContacts;
use Azzarip\Teavel\Models\Contact;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Contact Name')
                    ->sortable()
                    ->searchable(['name', 'surname', 'email']),
                TextColumn::make('email')
                    ->label('Email Address'),
                TextColumn::make('phone')
                    ->label('Telephone Number'),
                TextColumn::make('created_at')
                    ->label('Added at')
                    ->dateTime('M d, Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession();

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContacts::route('/'),
            'create' => CreateContact::route('/create'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }
}
