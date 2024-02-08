<?php

namespace Azzarip\Teavel\Filament\ContactPanel\Resources;

use Azzarip\Teavel\Filament\ContactPanel\ContactResource\Pages\CreateContact;
use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource\Pages\CreateContact;
use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource\Pages\EditContact;
use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource\Pages\ListContacts;
use Azzarip\Teavel\Filament\ContactPanel\Resources\ContactResource\Pages\ViewContact;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset as ILFieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Label')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('First Name'),
                        TextInput::make('surname')
                            ->label('Last Name'),
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('phone'),
                    ])->columnSpan(2),
            ])
            ->columns(3);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ILFieldset::make('Label')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('surname'),
                    TextEntry::make('email')
                        ->icon('heroicon-m-envelope')
                        ->iconColor('primary')
                        ->copyable()
                        ->copyMessage('Copied!')
                        ->copyMessageDuration(1500),
                    TextEntry::make('phone'),
                ])->columnSpan(2),
                ILFieldset::make('Label')->schema([
                    TextEntry::make('created_at')->dateTime('d M Y, H:i:s'),
                    TextEntry::make('privacy_at')->dateTime('d M Y, H:i:s'),
                    TextEntry::make('marketing_at')->dateTime('d M Y, H:i:s'),
                    TextEntry::make('updated_at')->dateTime('d M Y, H:i:s'),
                ])->columnSpan(1)->columns(2),
            ])->columns(3);
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
                    ->sortable()
                    ->dateTime('M d, Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'view' => ViewContact::route('/{record}'),
            'edit' => EditContact::route('/{record}/edit'),
        ];
    }
}
