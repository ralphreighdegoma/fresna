<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeSheetResource\Pages;
use App\Filament\Resources\TimeSheetResource\RelationManagers;
use App\Models\TimeSheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Checkbox;

use Filament\Forms\Get;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Actions\Action;

class TimeSheetResource extends Resource
{
    protected static ?string $model = TimeSheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $user_id = Auth::id();

        return $form
            ->schema([
                Grid::make(['default' => 1])
                ->schema([
                    Tabs::make('Tabs')
                    ->schema([
                        Tab::make('Setup')
                        ->schema([
                            Grid::make(['default' => 2])
                            ->schema([
                                Group::make()
                                ->schema([
                                    Select::make('client_id')
                                    ->label('Client Name')
                                    ->required()
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable(),

                                    Select::make('category')
                                    ->label('Category')
                                    ->options([
                                        'task' => 'Task',
                                    ])
                                    ->default('task')
                                    ->required(),

                                    Select::make('item_id')
                                    ->label('Item')
                                    ->required()
                                    ->options(Task::all()->pluck('title', 'id'))
                                    ->searchable(),

                                    Grid::make(['default' => 2])
                                    ->schema([
                                        Group::make()
                                        ->schema([
                                            TextInput::make('hours')
                                            ->required()
                                            ->numeric()
                                            ->label('Time Spent Hours'),
                                        ]),
                                        Group::make()
                                        ->schema([
                                            TextInput::make('minutes')
                                            ->required()
                                            ->numeric()
                                            ->label('Time Spent Minutes'),
                                        ])
                                    ]),

                                    TextArea::make('comment')
                                    ->required()
                                    ->rows(5)
                                    ->label('Comments'),
                                ])
                            ])
                        ]),

                        // Tab::make('Comments')
                        // ->schema([
                        //     Repeater::make('timeSheetComments')
                        //         ->label('Comments')
                        //         ->relationship('timeSheetComments') // This links to the comments relationship
                        //         ->schema([
                        //             TextInput::make('content')
                        //         //   ->label('Comment Content')
                        //             ->label(fn ($record) => $record?->user?->name ?? 'Comment')
                        //             ->disabled() // Make it read-only when editing existing comments
                        //             ->visible(fn ($record, $get) => !$get('is_editing')), // Only show as text if the comment is already saved


                        //             Checkbox::make('is_editing')
                        //             ->label('Edit Comment')
                        //             ->default(fn ($record) => $record?->is_editing ?? true)
                        //             ->live()
                        //             ->visible(fn ($record, $get) => $record !== null && $record->user_id == $user_id),

                        //             // Show MarkdownEditor for new comments
                        //             MarkdownEditor::make('content')
                        //             ->label('Comment Content')
                        //             ->toolbarButtons([
                        //                 'blockquote',
                        //                 'bold',
                        //                 'bulletList',
                        //                 'codeBlock',
                        //                 'h2',
                        //                 'h3',
                        //                 'italic',
                        //                 'link',
                        //                 'orderedList',
                        //                 'redo',
                        //                 'strike',
                        //                 'underline',
                        //                 'undo',
                        //             ])
                        //         ])
                        //         ->createItemButtonLabel('Add Comment')
                        // ])
                    ])
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                ->label('Client Name'),

                TextColumn::make('category')
                ->getStateUsing(function (TimeSheet $record) {
                    return match ($record->category) { // Display correct label based on value
                        'task' => 'Task',
                        default => 'task', // Default case if no match found
                    };
                })
                ->label('Category'),

                TextColumn::make('comment')
                ->label('Comment'),

                TextColumn::make('time_spent')
                ->getStateUsing(function (TimeSheet $record) {
                    return $record->hours . ' hours' . ($record->minutes > 0 ? ' and '.$record->minutes . ' minutes ' : '');
                })
                ->label('Time Spent'),

                TextColumn::make('created_at')
                ->dateTime()
                ->label('Date Submitted'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTimeSheets::route('/'),
            'create' => Pages\CreateTimeSheet::route('/create'),
            'edit' => Pages\EditTimeSheet::route('/{record}/edit'),
        ];
    }
}
