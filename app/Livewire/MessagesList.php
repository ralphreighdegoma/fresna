<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class MessagesList extends Component
{

    use WithPagination;

    public $starredMessages = [];

    

    public function toggleStar($messageId)
    {
        if (in_array($messageId, $this->starredMessages)) {
            $this->starredMessages = array_diff($this->starredMessages, [$messageId]);
        } else {
            $this->starredMessages[] = $messageId;
        }
    }

    public function render()
    {
        //create a dummy messages
        $messages = [];
        $messages = array(
            array(
                'id' => 1,
                'from' => 'John Doe',
                'subject' => 'Hello',
                'message' => 'Hello, how are you? I am fine. What about you? I am doing well. How about you?....',
                'starred' => false
            ),
            array(
                'id' => 2,
                'from' => 'Jane Smith',
                'subject' => 'Hi',
                'message' => 'Hi, I am Hello, how are you? I am fine. What about you? I am doing well. How about you?.... fine. What about you?',
                'starred' => true
            ),
            array(
                'id' => 3,
                'from' => 'Bob Johnson',
                'subject' => 'Hey',
                'message' => 'Hey, Hello, how are you? I am fine. What about you? I am doing well. How about you?.... what are you up to today?',
                'starred' => false
            ),
            array(
                'id' => 4,
                'from' => 'Sarah Lee',
                'subject' => 'Good Morning',
                'message' => 'Good morning, how are you  Hello, how are you? I am fine. What about you? I am doing well. How about you?....today?',
                'starred' => true
            )
        );

        //convert to std class
        $messages = collect($messages)->map(function ($message) {
            return (object) $message;
        });
     
        return view('livewire.messages-list', [
            'messages' => $messages // Assuming you have messages in your DB
        ]);
    }
}
