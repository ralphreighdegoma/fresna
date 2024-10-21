<?php
 
namespace App\Filament\Pages\Auth;
 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\LoginPage as BaseEditProfile;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Components;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Forms\Components\Grid;

class RegisterPage extends BaseRegister
{   
    //model
    protected static string $model = \App\Models\User::class;

    //chnage login view
    protected static string $view = 'filament.pages.auth.register';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Group 1: Personal Information
                Fieldset::make('Personal Information')
                    ->schema([
                        Grid::make(2) // This creates a 2-column layout
                            ->schema([
                                TextInput::make('first_name')->label('First Name'),
                                TextInput::make('last_name')->label('Last Name'),
                                TextInput::make('email')->label('Email Address'),
                                PhoneInput::make('mobile_number')->label('Mobile Number'),
                                PhoneInput::make('work_number')->label('Work Number (Optional)'),
                                $this->getPasswordFormComponent(),  // Password fields
                                // confirm password component
                                TextInput::make('password_confirmation')
                                    ->password()
                                    ->required()
                                    ->maxLength(255)
                                    ->same('password')
                                    ->label('Confirm Password'),
                            ]),
                    ]),

                // Group 2: Organisation Details
                Fieldset::make('More Details')
                    ->schema([
                        Grid::make(2) // Another 2-column layout for this section
                            ->schema([
                                TextInput::make('organisation_name')->label('Organisation Name'),
                                TextInput::make('search_address')->label('Search Address'),
                                TextInput::make('suburb')->label('Suburb'),
                                TextInput::make('region')->label('Region'),
                                TextInput::make('postcode')->label('Postcode'),
                                TextInput::make('state')->label('State'),
                                Checkbox::make('is_indigenous_organisation')
                                    ->label('Indigenous Organisation? Must be 51% Indigenous Owned'),
                            ]),
                    ]),
            ]);


    }
}