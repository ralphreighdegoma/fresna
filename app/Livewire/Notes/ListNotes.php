<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
class ListNotes extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Note::query())
            ->columns([
                TextColumn::make('content')
                ->label('Description'),

                TextColumn::make('user.name')
                ->label('From'),

                TextColumn::make('created_at')
                ->label('Date and Time'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                ->form([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('content')
                        ->required()
                        ->maxLength(255),
                    // ...
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.notes.list-notes');
    }
}
