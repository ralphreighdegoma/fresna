<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
class Notes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.notes';

    protected static ?string $slug = 'my-notes';
    public $notes = [];

    public $selectedNote;

    // Method to initialize any properties when the page is loaded
    public function mount(): void
    {
        $this->notes = Note::all();
        $this->selectedNote = count($this->notes) ? $this->notes[0] : [];
    }

    public function saveNote($noteData)
    {
        $selectedNote = Note::where('id', $noteData['id'])->first();
        $selectedNote->title = $noteData['title'];
        $selectedNote->content = $noteData['content'];
        $selectedNote->save();
        $this->selectedNote = $selectedNote;
    }
}
