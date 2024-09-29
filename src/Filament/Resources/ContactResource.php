<?php

namespace Azzarip\Teavel\Filament\Resources;

use Azzarip\Teavel\Filament\Resources\CategoryResource\Pages;
use Azzarip\Teavel\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('last_name'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('phone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->sortable()
                    ->searchable(),

            ])->defaultSort('name', 'asc')
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
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
            'index' => Pages\ListContactss::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
