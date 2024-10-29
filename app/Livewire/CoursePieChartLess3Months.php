<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class CoursePieChartLess3Months extends ChartWidget
{
    protected static ?string $heading = 'Completion Rate < 3 months';

    protected function getData(): array
    {
        return [
            'labels' => ['Lorem Ipsum'],
            'datasets' => [
                [
                    'data' => [60],
                    'backgroundColor' => [
                        '#FACC15', // Purple
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
