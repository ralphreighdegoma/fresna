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
use Filament\Tables\Columns\Layout\Split;
use Filament\Support\Enums\FontWeight;
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
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
//import Storage
use Illuminate\Support\Facades\Storage;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    //group label
    protected static ?string $navigationGroup = 'Tasks';

    //label
    protected static ?string $navigationLabel = 'My Tasks';

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

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->label('Task Number')
                    ->grow(false)
                    ->sortable()->searchable()->sortable(),
                TextColumn::make('title')->sortable()->searchable()->sortable(),
                TextColumn::make('mini_description')->width('30%')->grow(),
                ImageColumn::make('user.avatar_url')
                    ->label('Avatar')
                    ->disk('s3')
                    ->defaultImageUrl(url('/assets/images/placeholder.jpg'))
                    ->grow(false)
                    ->circular(),
                TextColumn::make('user.name')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->grow(true)
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->colors([
                        'primary',
                        'secondary' => 'open',
                        'warning' => 'closed',
                    ])
                    ->getStateUsing(function (Task $record) {
                        return match ($record->status) { // Display correct label based on value
                            'open' => 'Open',
                            'closed' => 'Closed',
                            default => 'Open', // Default case if no match found
                        };
                    }),
                //duedate
                TextColumn::make('due_date')
                    ->label('Due Date'),
                //status

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
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
