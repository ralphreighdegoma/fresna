<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Modal;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Checkbox;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Grid::make(1) // Create a 2-column grid
              ->schema([
                  TextInput::make('title')
                      ->required()
                      ->maxLength(255)
                      ->label('Title'),
                  
                  Textarea::make('description')
                      ->required()
                      ->maxLength(5000)
                      ->rows(4)
                      ->label('Description'),

                  DatePicker::make('due_date')
                    ->required()
                    ->label('Due date'),

                  FileUpload::make('attachments')
                    ->multiple(),
                  // TextInput::make('attachments')
                  //   ->required()
                  //   ->label('Attachments'),

                  Select::make('user_id')
                  ->label('Assigned To')
                  ->options(User::all()->pluck('name', 'id'))
                  ->searchable(),

                  DateTimePicker::make('reminder')
                    ->required()
                    ->label('Reminder'),

                  Select::make('reminder_repeat')
                  ->label('Repeat')
                  ->options([
                      'disable' => 'Disable',
                      'weekly' => 'Weekly',
                      'daily' => 'Daily',
                      'monthly' => 'Monthly',
                  ])
                  ->default('disable')
                  ->required(),

                  // MarkdownEditor::make('comments')
                  // ->nullable()
                  // ->default('')
                  // ->toolbarButtons([
                  //     'blockquote',
                  //     'bold',
                  //     'bulletList',
                  //     'codeBlock',
                  //     'h2',
                  //     'h3',
                  //     'italic',
                  //     'link',
                  //     'orderedList',
                  //     'redo',
                  //     'strike',
                  //     'underline',
                  //     'undo',
                  // ]),
                  
                  Repeater::make('comments')
                    ->label('Comments')
                    ->relationship('comments') // This links to the comments relationship
                    ->schema([
                      TextInput::make('content')
                      ->label('Comment Content')
                      ->disabled() // Make it read-only when editing existing comments
                      ->visible(fn ($record, $get) => $record !== null && !$get('is_editing')), // Only show as text if the comment is already saved

                      Checkbox::make('is_editing')
                      ->label('Edit Comment')
                      ->visible(fn ($record) => $record !== null)
                      ->live(),
                      // Show MarkdownEditor for new comments
                      MarkdownEditor::make('content')
                      ->label('Comment Content')
                      ->toolbarButtons([
                          'blockquote',
                          'bold',
                          'bulletList',
                          'codeBlock',
                          'h2',
                          'h3',
                          'italic',
                          'link',
                          'orderedList',
                          'redo',
                          'strike',
                          'underline',
                          'undo',
                      ])
                      ->required()
                      ->visible(fn ($record, $get) => $record === null && $get('is_editing')), // Only show MarkdownEditor for new comments
                    ])
                    ->createItemButtonLabel('Add Comment')
                    // ->disableItemDeletion(),


              ]),
          ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('title')->sortable()->searchable(),
              TextColumn::make('description'),
              TextColumn::make('user.name')
                    ->label('Assigned to')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ])
            ->bulkActions([
              Tables\Actions\BulkActionGroup::make([
                  Tables\Actions\DeleteBulkAction::make(),
              ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            // 'create' => Pages\CreateTask::route('/create'),
            // 'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
