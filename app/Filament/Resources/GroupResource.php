<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Models\Group;
use App\Models\User;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Support\Enums\FontWeight;
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
use Filament\Forms\Components\Group as GroupComponent;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(['default' => 1])
                ->schema([
                    Tabs::make('Tabs')
                    ->schema([
                        Tab::make('Setup')
                        ->schema([
                            Grid::make(['default' => 2]) // Create a grid with two columns
                            ->schema([
                                // Column 1
                                GroupComponent::make() // Group for Column 1
                                ->schema([
                                    TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Group Name'),

                                    TextInput::make('company')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Company'),

                                    Select::make('program_type')
                                    ->label('Program Type')
                                    ->options([
                                        'sales' => 'Sales',
                                        'marketing' => 'Marketing',
                                    ])
                                    ->required(),
                                ]),

                                // Column 2
                                GroupComponent::make() // Group for Column 2
                                ->schema([

                                    Select::make('business_advisor_id')
                                    ->label('Business Advisor')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable(),

                                    Textarea::make('description')
                                    ->required()
                                    ->maxLength(255)
                                    ->rows(4)
                                    ->label('Description'),

                                    Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'active' => 'Active',
                                        'pending' => 'Pending',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->required(),

                                ]),
                            ])
                        ]),

                        Tab::make('Add Members')
                        ->schema([
                            Grid::make(columns: ['default' => 2])
                            ->schema([
                                GroupComponent::make()
                                ->schema([
                                    Repeater::make('groupMembers')
                                    ->relationship('groupMembers')
                                    ->schema([
                                        Select::make('user_id')
                                        ->label('User')
                                        ->required()
                                        ->options(User::all()->pluck('name', 'id'))
                                        ->searchable(),
                                    ])
                                    ->defaultItems(0)
                                    ->addActionLabel('Add member'),
                                ]),
                            ])
                        ])
                    ])

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('Name')
                ->weight(FontWeight::Bold)
                ->searchable(),
                TextColumn::make('company')->label('Company'),
                TextColumn::make('name')->label('Group Name'),
                TextColumn::make('program_type')
                ->label('Program Type')
                ->getStateUsing(function (Group $record) {
                    return match ($record->status) { // Display correct label based on value
                        'sales' => 'Sales',
                        'marketing' => 'Marketing',
                        default => 'Sales', // Default case if no match found
                    };
                }),
                TextColumn::make('businessAdvisor.name')
                ->label('Business Advisor')
                ->weight(FontWeight::Bold)
                ->searchable(),
                TextColumn::make('status')
                ->badge()
                ->label('Status')
                ->colors([
                    'primary',
                    'secondary' => 'open',
                    'warning' => 'closed',
                ])
                ->getStateUsing(function (Group $record) {
                    return match ($record->status) { // Display correct label based on value
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'inactive' => 'Inactive',
                        default => 'Active', // Default case if no match found
                    };
                }),
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
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
