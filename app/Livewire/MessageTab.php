<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageTab extends Component
{
    public $activeTab = 'messages'; // Default active tab
    public $threads = []; // Stores the threads involving the current user

    public function mount()
    {
        $this->loadThreads();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadThreads(); // Reload threads whenever the active tab changes, if needed
    }

    public function loadThreads()
    {
        $currentUserId = Auth::id(); // Get the current logged-in user's ID

        $this->threads = Message::query()
            ->select('thread_id', 'body', 'created_at', 'sender_id')
            ->where(function ($query) use ($currentUserId) {
                $query->where('sender_id', $currentUserId)
                    ->orWhere('receiver_id', $currentUserId);
            })
            ->groupBy('thread_id')
            ->orderByRaw('MAX(created_at) DESC') // Get the latest message per thread
            ->with('sender') // Assuming you have a relationship to fetch the sender details
            ->get();

    }

    public function render()
    {
        return view('livewire.message-tab', [
            'threads' => $this->threads,
        ]);
    }
}
