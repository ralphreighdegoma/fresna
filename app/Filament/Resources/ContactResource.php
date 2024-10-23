<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// use Filament\Forms\Components\Modal;
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

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Contacts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Grid::make(['default' => 1])->Schema([
                Tabs::make('Tabs')
                ->tabs([
                  Tab::make('Contact Details')
                      ->schema([
                        Grid::make(['default' => 2]) // Create a grid with two columns
                        ->schema([
                            // Column 1
                            Group::make() // Group for Column 1
                            ->schema([
                              TextInput::make('first_name')
                              ->required()
                              ->maxLength(255)
                              ->label('First Name'),

                              TextInput::make('last_name')
                              ->required()
                              ->maxLength(255)
                              ->label('Last Name'),

                              TextInput::make('email')
                              ->required()
                              ->maxLength(255)
                              ->email()
                              ->label('Email Address'),

                              TextInput::make('mobile_number')
                              ->required()
                              ->maxLength(255)
                              ->label('Mobile Number'),

                              TextInput::make('work_number')
                              ->required()
                              ->maxLength(255)
                              ->label('Work Number'),

                              TextInput::make('organisation_name')
                              ->required()
                              ->maxLength(255)
                              ->label('Organisation Name'),

                              FileUpload::make('photo')
                              ->image()
                              ->label('Photo Upload (Optional)'),
                            ]),

                            // Column 2
                            Group::make() // Group for Column 2
                            ->schema([

                              TextInput::make('asic_code')
                              ->required()
                              ->maxLength(255)
                              ->label('ASIC Code'),

                              TextInput::make('suburb')
                                  ->required()
                                  ->maxLength(255)
                                  ->label('Suburb'),

                              Grid::make(['default' => 2]) // Create a grid with two columns
                              ->schema([
                                  Group::make() // Group for Column 1
                                  ->schema([
                                    TextInput::make('post_code')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Postcode'),
                                  ]),

                                  Group::make() // Group for Column 1
                                  ->schema([
                                    TextInput::make('state')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('State'),
                                  ])
                                ]),

                              TextInput::make('region')
                                ->required()
                                ->maxLength(255)
                                ->label('Region'),



                              Select::make('company_structure')
                              ->label('Company Structure')
                              ->options([
                                  'sole_trader' => 'Sole Trader',
                              ])
                              ->default('sole_trader')
                              ->required(),

                              Select::make('organisation_type')
                              ->label('Organisation Type')
                              ->options([
                                  'tourism' => 'Tourism',
                                  'marketing_sales' => 'Marketing, Sales',
                              ])
                              ->default('tourism')
                              ->required(),

                              Checkbox::make('indigenous_organization')
                                ->inline()
                                ->default(false)
                                ->label('Indigenous Organisation (Must be 5% indigenous owned)'),

                              Select::make('status')
                              ->label('Status')
                              ->options([
                                  'active' => 'Active',
                                  'inactive' => 'Inactive',
                                  'banned' => 'Banned',
                              ])
                              ->default('active')
                              ->required(),

                            ]),
                        ])
                      ]),
                  Tab::make('Assigned to')
                      ->schema([
                        Grid::make(['default' => 2])
                        ->schema([
                          Group::make()
                          ->schema([
                            Select::make('business_advisor_id')
                            ->label('Assigned to Business Adviser')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),

                            Select::make('business_advisor_id')
                            ->label('Assigned to Groups')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),

                            Select::make('business_advisor_id')
                            ->label('Assigned Resources (Optional)')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),

                            Checkbox::make('referred')
                                ->inline()
                                ->default(false)
                                ->label('Reffered?')
                                ->live(),

                            TextInput::make('refer_name')
                                ->required()
                                ->maxLength(255)
                                ->label('Name')
                                // ->disabled(fn (callable $get) => $get('referred')),
                                ->disabled(fn (Get $get): bool => ! $get('referred')),

                              TextInput::make('refer_organisation')
                                ->required()
                                ->maxLength(255)
                                ->label('Organisation')
                                // ->disabled(fn (callable $get) => $get('referred')),
                                ->disabled(fn (Get $get): bool => ! $get('referred')),

                          ]),

                          Group::make()
                          ->schema([
                            Select::make('business_advisor_id')
                            ->label('Assigned to Program Type (Optional)')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),

                            Select::make('business_advisor_id')
                            ->label('Assigned Courses (Optional)')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable(),

                            Select::make('level_access')
                              ->label('Level of Access')
                              ->options([
                                  'super_user' => 'Super User',
                                  'businesss_advisor' => 'Business Advisor',
                                  'member' => 'Member',
                                  'supplier' => 'Supplier',
                                  'lead' => 'Lead',
                              ])
                              ->default('active')
                              ->required(),
                          ])
                        ])

                      ]),
                  Tab::make('Notes')
                      ->schema([

                      ]),
                ])
              ])



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              TextColumn::make('first_name')
              ->label('Name')
              ->getStateUsing(function (Contact $record) {
                  return "{$record->first_name} {$record->last_name}";
              }),

              TextColumn::make('organisation_name')
              ->label('Organisation'),

              TextColumn::make('organisation_type')
              ->label('Program Type')
              ->getStateUsing(function (Contact $record) {
                return match ($record->organisation_type) { // Display correct label based on value
                    'tourism' => 'Tourism',
                    'marketing_sales' => 'Marketing and Sales',
                    default => 'N/A', // Default case if no match found
                };
              }),

              TextColumn::make('status')
              ->label('Status')
              ->getStateUsing(function (Contact $record) {
                return match ($record->status) { // Display correct label based on value
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                    'banned' => 'Banned',
                    default => 'N/A', // Default case if no match found
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
