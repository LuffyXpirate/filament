<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
    
                Forms\Components\Section::make('Article details')
                    ->schema([
    
                        Forms\Components\Select::make('categories')
                            ->relationship('categories', 'eng_title')
                            ->multiple()
                            ->preload()
                            ->createOptionForm([
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
                            ])
                            ->required(),
    
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
    
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
    
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                "active" => "Active",
                                "inactive" => "Inactive",
                                "pending" => "Pending",
                            ])
                            ->default('pending'),
    
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                    ]),
    
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\Textarea::make('meta_keywords')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('meta_description')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),

                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        "active" => "Active",
                        "inactive" => "Inactive",
                        "pending" => "pending",
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->tooltip('Edit')
                ->label(''),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
