<?php

namespace Azzarip\Teavel\Filament\Resources;

use Azzarip\Teavel\Filament\Items\ContactSelect;
use Azzarip\Teavel\Filament\Resources\AddressResource\Pages;
use Azzarip\Teavel\Models\Address;
use Azzarip\Teavel\Models\Contact;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextInput::make('city')->required(),
                TextInput::make('zip')
                    ->required()
                    ->numeric()
                    ->minValue(1000)
                    ->maxValue(9999),
                Grid::make()->columns(4)->schema([
                    Toggle::make('shipping'),
                    Toggle::make('billing'),
                    \Filament\Forms\Components\Textarea::make('info')
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
            ->actions([
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
