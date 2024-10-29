<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;

class ListCourses extends Component
{
    public $items = [];

    public function mount(): void
    {
        $this->items = Note::all();
    }
    public function render()
    {
        return view('livewire.list-courses');
    }
}
