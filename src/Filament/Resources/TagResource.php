<?php

namespace Azzarip\Teavel\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Azzarip\Teavel\Filament\Resources\TagResource\Pages\ListTags;
use Azzarip\Teavel\Filament\Resources\TagResource\Pages\CreateTag;
use Azzarip\Teavel\Filament\Resources\TagResource\Pages\ViewTag;
use Azzarip\Teavel\Filament\Resources\TagResource\Pages\EditTag;
use Azzarip\Teavel\Filament\Resources\TagResource\Pages;
use Azzarip\Teavel\Filament\Resources\TagResource\RelationManagers\ContactsRelationManager;
use Azzarip\Teavel\Models\Tag;
use Azzarip\Teavel\Models\TagCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?int $navigationSort = -99;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static string | \UnitEnum | null $navigationGroup = 'Tags';
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->columnSpan(1),
                Select::make('category_id')
                    ->label('TagCategory')
                    ->options(TagCategory::all()->pluck('name', 'id'))
                    ->searchable(),
                MarkdownEditor::make('description')
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
                    ->columnSpan(2),
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
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'view' => ViewTag::route('/{record}'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
