<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class CourseBarChart extends ChartWidget
{
    protected static ?string $heading = 'Course Completion';

    protected function getData(): array
    {
        return [
            'labels' => [''],
            'datasets' => [
                [
                    'label' => 'Not Started',
                    'data' => [13],
                    'backgroundColor' => '#808080',
                ],
                [
                    'label' => 'In Progress',
                    'data' => [13],
                    'backgroundColor' => '#A037FF',
                ],
                [
                    'label' => 'Completed',
                    'data' => [32],
                    'backgroundColor' => '#00F0A4',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
