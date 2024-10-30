<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TimeSheet as TimeSheetModel;

class Timesheet extends Component
{

    public $time_sheets = [];
    public $entries = [];
    public $week_entries = [];

    public function mount()
    {
        // Load timesheet entries from the database or set default data
        $this->entries = [
            [
                'day' => 'Monday',
                'hours' => '0:00'
            ],
            [
                'day' => 'Tuesday',
                'hours' => '0:00'
            ],
            [
                'day' => 'Wednesday',
                'hours' => '0:00'
            ],
            [
                'day' => 'Thursday',
                'hours' => '0:00'
            ],
            [
                'day' => 'Friday',
                'hours' => '0:00'
            ],
            [
                'day' => 'Saturday',
                'hours' => '0:00'
            ],
            [
                'day' => 'Sunday',
                'hours' => '0:00'
            ],
            // Repeat for each day of the week
        ];

        $this->time_sheets = TimeSheetModel::with(['client','task'])->get();

        $this->week_entries = [
            [
                'client' => 'Laksa Festival',
                'task' => 'Courses',
                'hours' => array_fill(0, 7, ''),

                // [
                //     ['day' => 'Monday', 'hours' => '0:00'],
                //     ['day' => 'Tuesday', 'hours' => '0:00'],
                //     ['day' => 'Wednesday', 'hours' => '0:00'],
                //     ['day' => 'Thursday', 'hours' => '0:00'],
                //     ['day' => 'Friday', 'hours' => '0:00'],
                //     ['day' => 'Saturday', 'hours' => '0:00'],
                //     ['day' => 'Sunday', 'hours' => '0:00']
                // ]
            ],
            // Repeat as needed for other entries
        ];

    }
    public function render()
    {
        return view('livewire.timesheet');
    }
}
