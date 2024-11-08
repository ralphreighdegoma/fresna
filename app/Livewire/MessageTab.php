<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class MessageTab extends Component
{
    public $activeTab = 'messages'; // Default active tab
    public $threads = []; // Stores the threads involving the current user

    public $active_thread;
    public $currentUserId;

    protected $listeners = ['setActiveThread' => 'setActiveThread'];

    public function mount()
    {
        $this->loadThreads();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadThreads(); // Reload threads whenever the active tab changes, if needed
    }

    public function setActiveThread($id)
    {
        $currentUserId = Auth::id(); // Get the current logged-in user's ID
        $this->currentUserId = $currentUserId;

        $threads = Thread::with('participants.user')
        ->with(['messages.sender', 'messages.receiver'])
        ->with(['last_message.sender', 'last_message.receiver'])
        ->get()
        ->map(function ($thread) use($currentUserId) {
            $other_user =  $thread->participants->filter(function ($item) use ($currentUserId) {
                return $item->user_id !== $currentUserId;
            })->values();

            $thread->name = $other_user[0]->user->name;
            $thread->message = isset($thread->last_message) ? $thread->last_message->body : 'Empty';
            $thread->date = $thread->created_at;
            $thread->other_user_id = $other_user[0]->id;
            $thread->last_message_user_id = isset($thread->last_message) ? $thread->last_message->user_id : null;

            return $thread;
        });

        if(count($threads) > 0 && $this->active_thread == null) {
            $this->active_thread = $threads[0];
        }
    }


    public function loadThreads()
    {
        $currentUserId = Auth::id(); // Get the current logged-in user's ID
        $this->currentUserId = $currentUserId;

        $this->threads = Thread::whereHas('participants', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId);
        })
        ->with('participants.user')
        ->with(['messages.sender', 'messages.receiver'])
        ->with(['last_message.sender', 'last_message.receiver'])
        ->get()
        ->map(function ($thread) use($currentUserId) {
            $other_user =  $thread->participants->filter(function ($item) use ($currentUserId) {
                return $item->user_id !== $currentUserId;
            })->values();

            $thread->name = $other_user[0]->user->name;
            $thread->message = isset($thread->last_message) ? $thread->last_message->body : 'Empty';
            $thread->date = $thread->created_at;
            $thread->other_user_id = $other_user[0]->id;
            $thread->last_message_user_id = isset($thread->last_message) ? $thread->last_message->user_id : null;

            return $thread;
        });

        if(count($this->threads) > 0 && $this->active_thread == null) {
            $this->active_thread = $this->threads[0];
        }
    }

    public function render()
    {
        return view('livewire.message-tab', [
            'threads' => $this->threads,
            'active_thread' => $this->active_thread,
        ]);
    }
}
