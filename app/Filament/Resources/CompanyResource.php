<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?int $navigationSort= 1;
    protected static ?String $modelLabel= "Company";
    protected static ?String $pluralModelLabel= "Company";


    public static function canCreate():bool
    {
        return Company::count()==0;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('company details')
                
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
    
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->directory('company-logos')
                    ->preserveFilenames(),
    
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
    
                Forms\Components\TextInput::make('contact')
                    ->required(),
    
                Forms\Components\Textarea::make('address')
                    ->rows(3),
    
                Forms\Components\TextInput::make('facebook')
                    ->label('Facebook URL'),
    
                Forms\Components\TextInput::make('youtube')
                    ->label('YouTube URL'),
            ])
                ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
    
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->size(50),
    
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('contact')
                    ->sortable()
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('address')
                    ->limit(50)
                    ->wrap()
                    ->sortable()
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])->filters([
                //
           
            ])->actions([
                //
            ])->bulkActions([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
