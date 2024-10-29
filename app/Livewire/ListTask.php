<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class ListTask extends Component
{
    public $items = [];

    public function mount(): void
    {
        $this->items = Task::all();
    }

    public function render()
    {
        return view('livewire.list-task');
    }
}
