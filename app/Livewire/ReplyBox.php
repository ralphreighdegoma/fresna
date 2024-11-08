<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ReplyBox extends Component
{
    public $message;
    public $thread_id;

    public $receiver_id;

    public function mount($thread_id, $receiver_id)
    {
        $this->thread_id = $thread_id;
        $this->receiver_id = $receiver_id;
    }


    public function render()
    {
        return view('livewire.reply-box');
    }

    public function sendMessage()
    {
        $currentUserId = Auth::id(); // Get the current logged-in user's ID

        // Handle sending the message logic here
        // You can also validate and process the message
        Message::create([
            'sender_id' => $currentUserId,
            'receiver_id' => $this->receiver_id,
            'thread_id' => $this->thread_id,
            'body' => $this->message,
        ]);
        $this->reset('message'); // Reset the message input after sending
    }
}
