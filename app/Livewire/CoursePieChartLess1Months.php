<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class CoursePieChartLess1Months extends ChartWidget
{
    protected static ?string $heading = 'Completion Rate < 1 month';

    protected function getData(): array
    {
        return [
            'labels' => ['Lorem Ipsum'],
            'datasets' => [
                [
                    'data' => [20],
                    'backgroundColor' => [
                        '#A855F7', // Purple
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
