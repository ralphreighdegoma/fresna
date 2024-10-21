<?php

namespace App\Livewire;

use Livewire\Component;

class ReplyBox extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.reply-box');
    }

    public function sendMessage()
    {
        // Handle sending the message logic here
        // You can also validate and process the message
        $this->reset('message'); // Reset the message input after sending
    }
}
