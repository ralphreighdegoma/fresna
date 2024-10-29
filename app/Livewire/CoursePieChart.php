<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class CoursePieChart extends ChartWidget
{
    protected static ?string $heading = 'Course Stats';

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }

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
