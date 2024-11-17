<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

class MessageTab extends Component implements HasForms
{
    use InteractsWithForms;

    public $activeTab = 'messages'; // Default active tab
    public $threads = []; // Stores the threads involving the current user

    public $selectedThread;
    public $currentUserId;

    public $message;

    protected $listeners = ['setActiveThread' => 'setActiveThread'];

    public function mount()
    {
        $this->loadThreads();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('message')
                ->label('')
            ]);

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

        $threads = Thread::where('id', intval($id))
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
            $thread->other_user_id = $other_user[0]->user_id;
            $thread->last_message_user_id = isset($thread->last_message) ? $thread->last_message->user_id : null;
            $thread->messages = $thread->messages->map(function ($message): mixed {
                $message->date = \Carbon\Carbon::parse($message->created_at)->format('m/d/Y h:i A');
                return $message;
            });
            return $thread;
        })
        ->toArray();

        if(count($threads) > 0 && $this->selectedThread == null) {
            $this->selectedThread = $threads[0];
        }
    }


    public function loadThreads()
    {
        $currentUserId = Auth::id(); // Get the current logged-in user's ID
        $this->currentUserId = $currentUserId;
        // $this->threads = Message::where('receiver_id', $currentUserId)
        // ->with(['thread','sender', 'receiver'])
        // ->get()
        // ->map(function($message) use ($currentUserId) {
        //     $message->name = $message->sender->name;
        //     $message->message = $message->body;
        //     $message->date = \Carbon\Carbon::parse($message->created_at)->format('m/d/Y h:i A');
        //     // $message->last_message = $message;
        //     return $message;
        // });

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
            $thread->date = \Carbon\Carbon::parse($thread->created_at)->format('m/d/Y h:i A');
            $thread->other_user_id = $other_user[0]->user_id;
            $thread->last_message_user_id = isset($thread->last_message) ? $thread->last_message->user_id : null;
            $thread->messages = $thread->messages->map(function ($message): mixed {
                $message->date = \Carbon\Carbon::parse($message->created_at)->format('m/d/Y h:i A');
                return $message;
            });
            return $thread;
        })
        ->toArray();

        if(count($this->threads) > 0 && $this->selectedThread == null) {
            $this->selectedThread = $this->threads[0];
        }
    }

    public function render()
    {
        return view('livewire.message-tab', [
            'threads' => $this->threads,
            'selectedThread' => $this->selectedThread,
        ]);
    }

    public function sendMessage($receiver_id,$thread_id,$message)
    {
        $currentUserId = Auth::id(); // Get the current logged-in user's ID

        // Handle sending the message logic here
        // You can also validate and process the message
        Message::create([
            'sender_id' => intval($currentUserId),
            'receiver_id' => intval($receiver_id),
            'thread_id' => intval($thread_id),
            'body' => $message,
        ]);
        // Reset the message input after sending
        $this->message = '';
        $this->loadThreads();
        $this->selectedThread = null;
        $this->setActiveThread($thread_id);
    }
}
