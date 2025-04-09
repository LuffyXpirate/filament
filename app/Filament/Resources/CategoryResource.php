<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort= 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nep_title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('eng_title')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 2000)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if ($state) {
                            $slug = Str::slug($state);
                            $set('slug', $slug);
                        }
                    }),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->readOnly(),
                  
                Forms\Components\Textarea::make('meta_keywords')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('meta_description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nep_title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('eng_title')
                    ->sortable()
                    ->searchable(),

                // Replace in your table() method
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->color('success'), // Temporary styling to verify column rendering

                Tables\Columns\TextColumn::make('meta_keywords')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('meta_description')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Add any filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
              
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
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
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
