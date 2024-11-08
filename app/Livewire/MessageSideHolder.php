<?php

namespace App\Livewire;

use Livewire\Component;

class MessageSideHolder extends Component
{
    public $thread;
    public $name;
    public $date;
    public $message;
    public $is_active;

    // public function setActiveThread()
    // {
    //     // Emit an event to call the parent's method
    //     $this->emit('setActiveThread', $this->thread);
    // }


    public function mount($thread, $is_active)
    {
        $this->thread = $thread;
        $this->name = $thread->name;
        $this->date = $thread->date;
        $this->message = $thread->message;
        $this->is_active = $is_active;
    }

    public function render()
    {
        return view('livewire.message-side-holder');
    }
}
