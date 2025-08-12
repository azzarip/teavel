<?php

namespace Azzarip\Teavel\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Azzarip\Teavel\Filament\Resources\AddressResource\Pages\ListAddresses;
use Azzarip\Teavel\Filament\Resources\AddressResource\Pages\CreateAddress;
use Azzarip\Teavel\Filament\Resources\AddressResource\Pages\EditAddress;
use Azzarip\Teavel\Filament\Items\ContactSelect;
use Azzarip\Teavel\Filament\Resources\AddressResource\Pages;
use Azzarip\Teavel\Models\Address;
use Azzarip\Teavel\Models\Contact;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ContactSelect::make()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $state ? $set('name', Contact::find($state)->full_name) : $set('name', '')),
                TextInput::make('name')
                    ->required(),
                TextInput::make('line1')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('co'),
                TextInput::make('line2'),
                TextInput::make('zip')
                    ->required()
                    ->numeric()
                    ->minValue(1000)
                    ->maxValue(9999),
                TextInput::make('city')->required(),
                Grid::make()->columns(4)->schema([
                    Toggle::make('shipping')->default(true),
                    Toggle::make('billing')->default(true),
                    Textarea::make('info')
                        ->rows(3)
                        ->columnSpan(2),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('one_line')->label('Address'),
                TextColumn::make('contact.name_email')->label('Contact'),
                IconColumn::make('is_shipping')
                    ->label('Shipping')
                    ->boolean()
                    ->falseColor('gray'),
                IconColumn::make('is_billing')
                    ->label('Billing')
                    ->boolean()
                    ->falseColor('gray'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Tables\Actions\EditAction::make(),
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
            'index' => ListAddresses::route('/'),
            'create' => CreateAddress::route('/create'),
            'edit' => EditAddress::route('/{record}/edit'),
        ];
    }
}
