<?php

namespace Azzarip\Teavel\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Azzarip\Teavel\Models\Address;
use Azzarip\Teavel\Models\Contact;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Azzarip\Teavel\Filament\Resources\AddressResource\Pages;
use Azzarip\Teavel\Filament\Resources\AddressResource\RelationManagers;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('contact_id')
                    ->relationship('contact')
                    ->required()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $state ? $set('name', Contact::find($state)->full_name) : $set('name', ''))
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->name_email)
                    ->searchable(['first_name', 'last_name', 'email']),
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
                ])



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
                //Tables\Actions\EditAction::make(),
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
