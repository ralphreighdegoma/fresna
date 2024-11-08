<?php

namespace App\Livewire;

use Livewire\Component;

class MessageViewer extends Component
{
    public $senderName;
    public $date;
    public $message;
    public $is_sender = false;

    // public function mount($is_sender)
    // {
    //     $this->is_sender = $is_sender;
    // }

    public function render()
    {
        return view('livewire.message-viewer');
    }
}
