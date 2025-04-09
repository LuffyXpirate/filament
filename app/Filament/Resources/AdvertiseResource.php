<?php
namespace App\Filament\Resources;

use App\Filament\Resources\AdvertiseResource\Pages;
use App\Models\Advertise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdvertiseResource extends Resource
{
    protected static ?string $model = Advertise::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('contact')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('expire_date')
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('advertises')
                    ->preserveFilenames()
                    ->required(),

                Forms\Components\TextInput::make('redirect_url')
                    ->url()
                    ->required(),

                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('contact')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('expire_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image')
                    ->disk('public') // Optional, depending on your config
                    ->sortable(),

                Tables\Columns\TextColumn::make('redirect_url')
                    
                    ->label('Link')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdvertises::route('/'),
            'create' => Pages\CreateAdvertise::route('/create'),
            'edit' => Pages\EditAdvertise::route('/{record}/edit'),
        ];
    }
}
