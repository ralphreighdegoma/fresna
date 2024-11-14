<?php

namespace App\Livewire;

use Livewire\Component;

class MessageSideHolder extends Component
{
    public $name;
    public $date;
    public $message;
    public $is_active;

    // public function setActiveThread()
    // {
    //     // Emit an event to call the parent's method
    //     $this->emit('setActiveThread', $this->thread);
    // }


    public function mount($name,$date,$message)
    {
        $this->name = $name;
        $this->date = $date;
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.message-side-holder');
    }
}
