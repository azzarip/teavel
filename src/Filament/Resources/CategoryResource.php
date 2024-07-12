<?php

namespace Azzarip\Teavel\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Azzarip\Teavel\Models\TagCategory;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Azzarip\Teavel\Filament\Resources\TagCategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Azzarip\Teavel\Filament\Resources\TagCategoryResource\RelationManagers;

class CategoryResource extends Resource
{
    protected static ?string $model = TagCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required()
                ->columnSpan(2),
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
                TextColumn::make('tags_count')
                    ->label('Tags')
                    ->counts('tags')
                    ->sortable(),


            ])->defaultSort('name', 'asc')
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
