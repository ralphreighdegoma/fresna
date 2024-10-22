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
use Filament\Events\Auth\Registered;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;


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
                                TextInput::make('first_name')->label('First Name')->required(),
                                TextInput::make('last_name')->label('Last Name')->required(),
                                TextInput::make('email')->label('Email Address')->required(),
                                PhoneInput::make('mobile_number')->label('Mobile Number'),
                                PhoneInput::make('work_number')->label('Work Number (Optional)'),
                                $this->getPasswordFormComponent(),  // Password fields
                                $this->getPasswordConfirmationFormComponent(),
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


    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function () {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            //handle name if blank
            if (!isset($data['name']) || empty($data['name'])) {
                $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
            }

            $user = $this->handleRegistration($data);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        $data = $this->form->getState();

        //create profile
        $profile = \App\Models\Profile::create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'mobile_number' => $data['mobile_number'],
            'work_number' => $data['work_number'],
            'organisation_name' => $data['organisation_name'],
            'search_address' => $data['search_address'],
            'suburb' => $data['suburb'],
            'region' => $data['region'],
            'postcode' => $data['postcode'],
            'state' => $data['state'],
            'is_indigenous_organisation' => $data['is_indigenous_organisation'],
        ]);

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }
}