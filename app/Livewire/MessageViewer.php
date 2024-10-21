<?php

namespace App\Livewire;

use Livewire\Component;

class MessageViewer extends Component
{
    public $senderName;
    public $date;
    public $message;

    public function render()
    {
        return view('livewire.message-viewer');
    }
}
