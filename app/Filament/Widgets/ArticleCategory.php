<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Category;
class ArticleCategory extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 2;

    protected string|int| array $columnSpan = 'full';

    protected function getData(): array
    {

        $articles =[];
        $categories =[];
        $cats = Category::all();
        foreach($cats as $category)
{
    $categories[]=$category->eng_title;
    $articles[]=$category->articles()->count();
}
        return [
          'datasets' => [
                [
                    'label' => 'Articles Count',
                    'data' => $articles,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                ],
            ],
            'labels' => $categories,
        ];
    
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
