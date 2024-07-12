<?php

namespace Azzarip\Teavel\Filament\Resources;

use Azzarip\Teavel\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use Azzarip\Teavel\Models\TagCategory;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Azzarip\Teavel\Filament\Resources\TagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Azzarip\Teavel\Filament\Resources\TagResource\RelationManagers;
use Azzarip\Teavel\Filament\Resources\TagResource\RelationManagers\ContactsRelationManager;

class TagResource extends Resource
    {
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        //dd(TagCategory::all()->pluck('name', 'id'));
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Select::make('category_id')
                    ->label('TagCategory')
                    ->options(TagCategory::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\MarkdownEditor::make('description')
                ->toolbarButtons([
                    'blockquote',
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'heading',
                    'italic',
                    'link',
                    'orderedList',
                ])
                    ->label('Description')
                    ->columnSpan(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->sortable(),
                TextColumn::make('contacts_count')
                ->label('Contacts')
                ->counts('contacts'),

            ])->defaultSort('name', 'asc')
            ->filters([
                SelectFilter::make('category')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'view' => Pages\ViewTag::route('/{record}'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }



}
