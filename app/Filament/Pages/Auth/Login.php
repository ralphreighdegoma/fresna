<?php
 
namespace App\Filament\Pages\Auth;
 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\LoginPage as BaseEditProfile;
use Filament\Pages\Auth\Login as LoginProfile;

class LoginPage extends LoginProfile
{

    //chnage login view
    protected static string $view = 'filament.pages.auth.login';
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
            ]);
    }
}