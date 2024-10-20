<?php

namespace App\Livewire;

use Livewire\Component;

class Compose extends Component
{

    public $to = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'to' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    public function sendMessage()
    {
        $this->validate();

        // Handle the sending logic here (e.g., saving to DB or sending via email)

        session()->flash('success', 'Message sent successfully!');
        
        // Reset the form fields
        $this->reset(['to', 'subject', 'message']);
    }
    public function render()
    {
        return view('livewire.compose');
    }
}
