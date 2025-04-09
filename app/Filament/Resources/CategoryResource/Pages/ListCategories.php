<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoryImport;
use Illuminate\Support\Facades\Storage;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('Import')
            ->color('success')
            ->form([
               FileUpload::make('file')
                ->label("upload Csv")
                ->required(),
            ])
            ->action(function($data){
                $path = Storage::disk('public')->path($data['file']);
                Excel::import(new CategoryImport, $path);
                // Optional: notification or redirect
            })
            
            ->icon('heroicon-o-arrow-down-tray'),
            Actions\CreateAction::make(),
        ];
    }
}
