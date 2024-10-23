<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralResource\Pages;
use App\Filament\Resources\ReferralResource\RelationManagers;
use App\Models\Referral;
use App\Models\User;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tasks';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(['default' => 1])
                ->schema([
                    Tabs::make('Tabs')
                    ->schema([
                        Tab::make('Referral Information')
                        ->schema([
                            Grid::make(['default' => 2]) // Create a grid with two columns
                            ->schema([
                                // Column 1
                                Group::make() // Group for Column 1
                                ->schema([
                                    TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Referral Title'),

                                    Select::make('client_id')
                                    ->label('Client Name')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable(),

                                    TextInput::make('organisation')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Organisation'),

                                    Select::make('referral_reason')
                                    ->label('Referral Reason')
                                    ->options([
                                        'reason1' => 'Reason 1',
                                        'reason2' => 'Reason 2',
                                    ])
                                    ->required(),

                                    Textarea::make('referral_description')
                                    ->required()
                                    ->maxLength(255)
                                    ->rows(4)
                                    ->label('Referral Description'),
                                ]),

                                // Column 2
                                Group::make() // Group for Column 2
                                ->schema([

                                    Textarea::make('expected_outcome')
                                    ->required()
                                    ->maxLength(255)
                                    ->rows(4)
                                    ->label('Expected Outcome'),

                                    Select::make('referred_to_id')
                                    ->label('Reffered To')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable(),

                                    TextInput::make('max_hours')
                                    ->required()
                                    ->maxLength(255)
                                    ->numeric()
                                    ->label('Max Hours'),

                                    TextInput::make('max_cost')
                                    ->required()
                                    ->maxLength(255)
                                    ->numeric()
                                    ->label('Max Cost'),

                                ]),
                            ])
                        ]),

                        Tab::make('Outcome')
                        ->schema([
                            Grid::make(['default' => 2]) // Create a grid with two columns
                            ->schema([
                                // Column 1
                                Group::make() // Group for Column 1
                                ->schema([
                                    Select::make('business_advisor_id')
                                    ->label('Business Advisor')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable(),

                                    Select::make('approver_id')
                                    ->label('Approver')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable(),

                                    Textarea::make('comment')
                                    ->required()
                                    ->maxLength(255)
                                    ->rows(4)
                                    ->label('Comments'),

                                    Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'return' => 'Return',
                                        'approve' => 'Approve',
                                        'reject' => 'Reject',
                                        'draft' => 'Draft',
                                    ])
                                    ->required(),


                                ]),

                                // Column 2
                                Group::make() // Group for Column 2
                                ->schema([

                                    Textarea::make('member_feedback')
                                    ->required()
                                    ->maxLength(255)
                                    ->rows(4)
                                    ->label('Member Feedback'),

                                    TextInput::make('total_rating')
                                    ->required()
                                    ->maxLength(255)
                                    ->numeric()
                                    ->label('Total Rating'),

                                    TextInput::make('rating_average_score')
                                    ->required()
                                    ->maxLength(255)
                                    ->numeric()
                                    ->label('Rating Average Score'),

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
                TextColumn::make('status')->label('Status'),
                TextColumn::make('title')->label('Referral Title'),
                TextColumn::make('client.name')->label('Client Name'),
                TextColumn::make('organisation')->label('Organisation'),
                TextColumn::make('referral_reason')->label('Referral Reason'),
                TextColumn::make('referredTo.name')->label('Referred to'),
                TextColumn::make('max_hours')->label('Max Hours'),
                TextColumn::make('max_cost')->label('Max Cost'),
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
            'index' => Pages\ListReferrals::route('/'),
            'create' => Pages\CreateReferral::route('/create'),
            'edit' => Pages\EditReferral::route('/{record}/edit'),
        ];
    }
}
