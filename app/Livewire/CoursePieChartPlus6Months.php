<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class CoursePieChartPlus6Months extends ChartWidget
{
    protected static ?string $heading = 'Completion Rate 6+ months';

    protected function getData(): array
    {
        return [
            'labels' => ['Lorem Ipsum'],
            'datasets' => [
                [
                    'data' => [20],
                    'backgroundColor' => [
                        '#34D399', // Purple
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
