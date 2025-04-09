<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
class Stats extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
       

        return [
            Stat::make('Total Articles', Article::count()),
            stat::make('Total Categories', Category::Count()),
            stat::make('Total Users', User::count()),
        ];
    }
}
