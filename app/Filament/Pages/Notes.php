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
    public array $notes = [];

    public array $selectedNote;

    // Method to initialize any properties when the page is loaded
    public function mount(): void
    {
        $this->notes = Note::all()->toArray();
        $this->selectedNote = count($this->notes) ? $this->notes[0] : null;
    }
}
